<?php
namespace app\install\controller;
use think\Controller;
use think\Db;
use think\Lang;
use think\Request;

class Index extends Controller
{

    /**
     * 构造方法
     * @access public
     * @param Request $request Request 对象
     */
    public function __construct(Request $request = null)
    {
        // 仅安装脚本可进入
        if (!defined('BIND_MODULE') || BIND_MODULE != 'install') {
            header('HTTP/1.1 403 Forbidden');
            exit();
        }
        parent::__construct($request);
    }

    public function index($step = 0)
    {
        $langs = get_supported_lang_list();
        $this->assign('langs', $langs);
        $lang = $this->getInstallLang();
        if (in_array($lang, $langs)) {
            Lang::range($lang);
            Lang::load(APP_PATH . 'lang/' . $lang . '.php', $lang);
        }

        switch ($step) {
            case 2:
                session('install_error', false);
                return self::step2();
                break;
            case 3:
                if (session('install_error')) {
                    return $this->error(lang('install/environment_failed'));
                }
                return self::step3();
                break;
            case 4:
                if (session('install_error')) {
                    return $this->error(lang('install/environment_failed'));
                }
                return self::step4();
                break;
            case 5:
                if (session('install_error')) {
                    return $this->error(lang('install/init_err'));
                }
                return self::step5();
                break;
            default:
                $param = input();
                $lang = in_array($param['lang'], $langs) ? $param['lang'] : 'zh-cn';
                Lang::range($lang);
                Lang::load(APP_PATH . 'lang/' . $lang . '.php', $lang);
                session('lang', $lang);
                $this->assign('lang', $lang);

                session('install_error', false);
                return $this->fetch('install@/index/index');
                break;
        }
    }

    /**
     * 第二步：环境检测
     * @return mixed
     */
    private function step2()
    {
        $data = [];
        $data['env'] = self::checkNnv();
        $data['dir'] = self::checkDir();
        $data['func'] = self::checkFunc();
        $this->assign('data', $data);
        return $this->fetch('install@index/step2');
    }
    
    /**
     * 第三步：初始化配置
     * @return mixed
     */
    private function step3()
    {
        $this->assign('install_dir', MAC_BASE_PATH . '/');
        return $this->fetch('install@index/step3');
    }
    
    /**
     * 第四步：执行安装
     * @return mixed
     */
    private function step4()
    {
        if ($this->request->isPost()) {
            if (!is_writable(APP_PATH . 'database.php')) {
                return $this->error('[app/database.php]'.lang('install/write_read_err'));
            }
            $data = input('post.');
            $data['type'] = 'mysql';
            $rule = [
                'hostname|'.lang('install/server_address') => 'require',
                'hostport|'.lang('install/database_port') => 'require|number',
                'database|'.lang('install/database_name') => 'require',
                'username|'.lang('install/database_username') => 'require',
                'prefix|'.lang('install/database_pre') => 'require|regex:^[a-z0-9]{1,20}[_]{1}',
                'cover|'.lang('install/overwrite_database') => 'require|in:0,1',
            ];
            $validate = $this->validate($data, $rule);
            if (true !== $validate) {
                return $this->error($validate);
            }
            $cover = $data['cover'];
            unset($data['cover']);
            $config = include APP_PATH . 'database.php';
            foreach ($data as $k => $v) {
                if (array_key_exists($k, $config) === false) {
                    return $this->error(lang('param') . '' . $k . '' . lang('install/not_found'));
                }
            }
            // 不存在的数据库会导致连接失败
            $database = $data['database'];
            unset($data['database']);
            // 创建数据库连接
            $db_connect = Db::connect($data);
            // 检测数据库连接
            try{
                $db_connect->execute('select version()');
            }catch(\Exception $e){
                $this->error(lang('install/database_connect_err'));
            }

            // 生成数据库配置文件
            $data['database'] = $database;
            self::mkDatabase($data);


            // 不覆盖检测是否已存在数据库
            if (!$cover) {
                if ($db_connect->execute('SELECT * FROM information_schema.schemata WHERE schema_name="'.$database.'"')) {
                    $this->success(lang('install/database_name_haved'),'');
                }
            }
            // 创建数据库
            if (!$db_connect->execute("CREATE DATABASE IF NOT EXISTS `{$database}` DEFAULT CHARACTER SET utf8")) {
                return $this->error($db_connect->getError());
            }

            return $this->success(lang('install/database_connect_ok'), '');
        } else {
            return $this->error(lang('install/access_denied'));
        }
    }
    
    /**
     * 第五步：数据库安装
     * @return mixed
     */
    private function step5()
    {
        $account = input('post.account');
        $password = input('post.password');
        $install_dir = input('post.install_dir');
        $initdata = input('post.initdata');

        $config = include APP_PATH.'database.php';
        if (empty($config['hostname']) || empty($config['database']) || empty($config['username'])) {
            return $this->error(lang('install/please_test_connect'));
        }
        if (empty($account) || empty($password)) {
            return $this->error(lang('install/please_input_admin_name_pass'));
        }

        $rule = [
            'account|'.lang('install/admin_name') => 'require|alphaNum',
            'password|'.lang('install/admin_pass') => 'require|length:6,20',
        ];
        $validate = $this->validate(['account' => $account, 'password' => $password], $rule);
        if (true !== $validate) {
            return $this->error($validate);
        }
        if(empty($install_dir)) {
            $install_dir='/';
        }

        // 更新程序配置
        $config_new = config('maccms');
        $cofnig_new['app']['cache_flag'] = substr(md5(time()),0,10);
        $cofnig_new['app']['lang'] = $this->getInstallLang();
        $config_new['api']['vod']['status'] = 0;
        $config_new['api']['art']['status'] = 0;
        $config_new['interface']['status'] = 0;
        $config_new['interface']['pass'] = mac_get_rndstr(16);
        $config_new['site']['install_dir'] = $install_dir;
        $res = mac_save_config_data(APP_PATH . 'extra/maccms.php', $config_new);
        if ($res === false) {
            return $this->error(lang('write_err_config'));
        }

        // 导入系统初始数据库结构
        // 导入SQL
        $sql_file = APP_PATH.'install/sql/install.sql';
        if (file_exists($sql_file)) {
            $sql = file_get_contents($sql_file);
            $sql_list = mac_parse_sql($sql, 0, ['mac_' => $config['prefix']]);
            if ($sql_list) {
                $sql_list = array_filter($sql_list);
                foreach ($sql_list as $v) {
                    try {
                        Db::execute($v);
                    } catch(\Exception $e) {
                        return $this->error(lang('install/sql_err'). $e);
                    }
                }
            }
        }
        //初始化数据
        if($initdata=='1'){
            $sql_file = APP_PATH.'install/sql/initdata.sql';
            if (file_exists($sql_file)) {
                $sql = file_get_contents($sql_file);
                $sql_list = mac_parse_sql($sql, 0, ['mac_' => $config['prefix']]);
                if ($sql_list) {
                    $sql_list = array_filter($sql_list);
                    foreach ($sql_list as $v) {
                        try {
                            Db::execute($v);
                        } catch(\Exception $e) {
                            return $this->error(lang('install/init_data_err'). $e);
                        }
                    }
                }
            }
        }

        // 注册管理员账号
        $data = [
            'admin_name' => $account,
            'admin_pwd' => $password,
            'admin_status' =>1,
        ];
        $res = model('Admin')->saveData($data);
        if (!$res['code']>1) {
            return $this->error(lang('install/admin_name_err').'：'.$res['msg']);
        }
        file_put_contents(APP_PATH.'data/install/install.lock', date('Y-m-d H:i:s'));

        // 关闭调试、配置保存到数据库
        $env_path = ROOT_PATH . '.env';
        $env_string = str_replace([
            'app_debug=true',
            'app_trace=true',
            'config_save_in_db=false',
        ], [
            'app_debug=false',
            'app_trace=false',
            'config_save_in_db=true',
        ], file_get_contents($env_path));
        file_put_contents($env_path, $env_string);

        // 获取站点根目录
        $root_dir = request()->baseFile();
        $root_dir  = preg_replace(['/install.php$/'], [''], $root_dir);
        return $this->success(lang('install/is_ok'), $root_dir.'admin.php');
    }
    
    /**
     * 环境检测
     * @return array
     */
    private function checkNnv()
    {
        $items = [
            'os'      => [lang('install/os'), lang('install/not_limited'), 'Windows/Unix', PHP_OS, 'ok'],
            'php'     => [lang('install/php'), '5.5', lang('install/php_version'), PHP_VERSION, 'ok'],
        ];
        if ($items['php'][3] < $items['php'][1]) {
            $items['php'][4] = 'no';
            session('install_error', true);
        }
        /*
        $tmp = function_exists('gd_info') ? gd_info() : [];
        if (empty($tmp['GD Version'])) {
            $items['gd'][3] = lang('install/not_installed');
            $items['gd'][4] = 'no';
            session('install_error', true);
        } else {
            $items['gd'][3] = $tmp['GD Version'];
        }
        */
        return $items;
    }
    
    /**
     * 目录权限检查
     * @return array
     */
    private function checkDir()
    {
        $items = [
            ['file', './application/database.php', lang('install/read_and_write'), lang('install/read_and_write'), 'ok'],
            ['file', './application/route.php', lang('install/read_and_write'), lang('install/read_and_write'), 'ok'],
            ['dir', './application/extra', lang('install/read_and_write'), lang('install/read_and_write'), 'ok'],
            ['dir', './application/data/backup', lang('install/read_and_write'), lang('install/read_and_write'), 'ok'],
            ['dir', './application/data/update', lang('install/read_and_write'), lang('install/read_and_write'), 'ok'],
            ['dir', './runtime', lang('install/read_and_write'), lang('install/read_and_write'), 'ok'],
            ['dir', './upload', lang('install/read_and_write'), lang('install/read_and_write'), 'ok'],
        ];
        foreach ($items as &$v) {
            if ($v[0] == 'dir') {// 文件夹
                if(!is_writable($v[1])) {
                    if(is_dir($v[1])) {
                        $v[3] = lang('install/not_writable');
                        $v[4] = 'no';
                    } else {
                        $v[3] = lang('install/not_found');
                        $v[4] = 'no';
                    }
                    session('install_error', true);
                }
            } else {// 文件
                if(!is_writable($v[1])) {
                    $v[3] = lang('install/not_writable');
                    $v[4] = 'no';
                    session('install_error', true);
                }
            }
        }
        return $items;
    }
    
    /**
     * 函数及扩展检查
     * @return array
     */
    private function checkFunc()
    {
        $items = [
            ['pdo', lang('install/support'), 'yes',lang('install/class')],
            ['pdo_mysql', lang('install/support'), 'yes', lang('install/model')],
            ['zip', lang('install/support'), 'yes', lang('install/model')],
            ['fileinfo', lang('install/support'), 'yes', lang('install/model')],
            ['curl', lang('install/support'), 'yes', lang('install/model')],
            ['xml', lang('install/support'), 'yes', lang('install/function')],
            ['file_get_contents', lang('install/support'), 'yes', lang('install/function')],
            ['mb_strlen', lang('install/support'), 'yes', lang('install/function')],
            ['putenv', lang('install/support'), 'yes', lang('install/function')],
        ];

        if(version_compare(PHP_VERSION,'5.6.0','ge') && version_compare(PHP_VERSION,'5.7.0','lt')){
            $items[] = ['always_populate_raw_post_data',lang('install/support'),'yes',lang('install/config')];
        }

        foreach ($items as &$v) {
            if((lang('install/class')==$v[3] && !class_exists($v[0])) || (lang('install/model')==$v[3] && !extension_loaded($v[0])) || (lang('install/function')==$v[3] && !function_exists($v[0])) || (lang('install/config')==$v[3] && ini_get('always_populate_raw_post_data')!=-1)) {
                $v[1] = lang('install/not_support');
                $v[2] = 'no';
                session('install_error', true);
            }
        }

        return $items;
    }
    
    /**
     * 生成数据库配置文件
     * @return array
     */
    private function mkDatabase(array $data)
    {
        $env_code = <<<INFO
; app
app_debug=true
app_trace=true
app_environment=production
config_save_in_db=false
INFO;
        // 数据库配置单独写入php文件，防止.env被直接访问
        $db_code = <<<INFO
<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
return [
    // 数据库类型
    'type'            => 'mysql',
    // 服务器地址
    'hostname'        => '{$data['hostname']}',
    // 数据库名
    'database'        => '{$data['database']}',
    // 用户名
    'username'        => '{$data['username']}',
    // 密码
    'password'        => '{$data['password']}',
    // 端口
    'hostport'        => '{$data['hostport']}',
    // 连接dsn
    'dsn'             => '',
    // 数据库连接参数
    'params'          => [],
    // 数据库编码默认采用utf8
    'charset'         => 'utf8',
    // 数据库表前缀
    'prefix'          => '{$data['prefix']}',
    // 数据库调试模式
    'debug'           => false,
    // 数据库部署方式:0 集中式(单一服务器),1 分布式(主从服务器)
    'deploy'          => 0,
    // 数据库读写是否分离 主从式有效
    'rw_separate'     => false,
    // 读写分离后 主服务器数量
    'master_num'      => 1,
    // 指定从服务器序号
    'slave_no'        => '',
    // 是否严格检查字段是否存在
    'fields_strict'   => false,
    // 数据集返回类型
    'resultset_type'  => 'array',
    // 自动写入时间戳字段
    'auto_timestamp'  => false,
    // 时间字段取出后的默认时间格式
    'datetime_format' => 'Y-m-d H:i:s',
    // 是否需要进行SQL性能分析
    'sql_explain'     => false,
    // Builder类
    'builder'         => '',
    // Query类
    'query'           => '\\think\\db\\Query',
];
INFO;
        $env_path = ROOT_PATH . '.env';
        $db_path = APP_PATH . 'database.php';
        file_put_contents($env_path, $env_code);
        file_put_contents($db_path, $db_code);
        // 判断写入是否成功（如有opcache手动清理一次）
        if (function_exists('opcache_invalidate')) {
            opcache_invalidate($env_path, true);
            opcache_invalidate($db_path, true);
        }
        $this->rePutEnv();
        $config = include $db_path;
        if (empty($config['database']) || $config['database'] != $data['database']) {
            return $this->error('[application/database.php]' . lang('write_err_database'));
            exit;
        }
    }

    /**
     * 获取安装语言
     * @return string
     */
    private function getInstallLang()
    {
        $langs = get_supported_lang_list();
        // 依次为参数传入、前端cookie写入、后端session（session可能不生效，放在最后）
        $lang_parsed = [input('lang'), cookie('install_lang_cookie'), session('lang')];
        foreach ($lang_parsed as $lang) {
            if (empty($lang)) {
                continue;
            }
            if (in_array($lang, $langs)) {
                return $lang;
            }
        }
        // 未匹配到，默认中文
        return 'zh-cn';
    }

    /**
     * 重新更新env
     */
    private function rePutEnv() {
        $env = parse_ini_file(ROOT_PATH . '.env', true);
        foreach ($env as $key => $val) {
            $name = ENV_PREFIX . strtoupper($key);
            if (is_array($val)) {
                foreach ($val as $k => $v) {
                    $item = $name . '_' . strtoupper($k);
                    putenv("$item=$v");
                }
            } else {
                putenv("$name=$val");
            }
        }
    }
}