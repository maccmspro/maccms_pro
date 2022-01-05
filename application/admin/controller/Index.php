<?php
namespace app\admin\controller;
use think\Hook;
use think\Lang;

class Index extends Base
{

    public function login()
    {
        // 多语言
        $param = request()->param();
        $config = config('maccms');
        $langs = get_supported_lang_list();
        $lang = !empty($param['lang']) && in_array($param['lang'], $langs) ? $param['lang'] : $config['app']['lang'];
        // 导入多语言包
        Lang::range($lang);
        Lang::load(APP_PATH . 'lang/' . $lang . '.php', $lang);
        if(request()->isPost()) {
            $data = input('post.');
            $res = model('Admin')->login($data);
            if ($res['code'] > 1) {
                return $this->error($res['msg']);
            }
            // 登录成功时，如果提交的和现有的不同，切换
            if ($config['app']['lang'] != $lang) {
                $config['app']['lang'] = $lang;
                mac_save_config_data(APP_PATH . 'extra/maccms.php', $config);
            }
            // 返回
            return $this->success($res['msg']);
        }
        Hook::listen("admin_login_init", $this->request);
        // 验证码，兼容未配置伪静态模式
        $verify_img_src = MAC_BASE_URL_FULL . '?s=verify/index';
        return $this->fetch('admin@index/login', [
            'verify_img_src' => $verify_img_src,
            'langs'          => $langs,
            'lang'           => $lang,
        ]);
    }

    public function logout()
    {
        $res = model('Admin')->logout();
        $this->redirect('index/login');
    }

    public function lang()
    {
        if (!request()->isGet()) {
            return json(['msg' => '请求方式错误','code' => 500], 500);
        }
        $param = request()->param();
        $langs = get_supported_lang_list();
        $lang = !empty($param['lang']) && in_array($param['lang'], $langs) ? $param['lang'] : $langs[0];
        $config = config('maccms');
        if ($config['app']['lang'] == $lang) {
            return json(['select' => $config['app']['lang'], 'msg' => '语言切换，未作出改变','code' => 403], 403);
        }
        $config['app']['lang'] = $lang;
        mac_save_config_data(APP_PATH . 'extra/maccms.php', $config);
        return json(['select' => $config['app']['lang'], 'msg' => '语言切换成功', 'code' => 1], 200);
    }

    public function index()
    {
        $menus = @include MAC_ADMIN_COMM . 'auth.php';

        foreach($menus as $k1=>$v1){
            foreach($v1['sub'] as $k2=>$v2){
                if($v2['show'] == 1) {
                    if(strpos($v2['action'],'javascript')!==false){
                        $url = $v2['action'];
                    }
                    else {
                        $url = url('admin/' . $v2['controller'] . '/' . $v2['action']);
                    }
                    if (!empty($v2['param'])) {
                        $url .= '?' . $v2['param'];
                    }
                    if ($this->check_auth($v2['controller'], $v2['action'])) {
                        $menus[$k1]['sub'][$k2]['url'] = $url;
                    } else {
                        unset($menus[$k1]['sub'][$k2]);
                    }
                }
                else{
                    unset($menus[$k1]['sub'][$k2]);
                }
            }

            if(empty($menus[$k1]['sub'])){
                unset($menus[$k1]);
            }
        }

        $quickmenu = config('quickmenu');
        if(empty($quickmenu)){
            $quickmenu = mac_read_file( APP_PATH.'data/config/quickmenu.txt');
            $quickmenu = explode(chr(13),$quickmenu);
        }
        if(!empty($quickmenu)){
            // $menus[1]['sub'][13] = ['name'=>lang('admin/index/quick_tit'), 'url'=>'javascript:void(0);return false;','controller'=>'', 'action'=>'' ];

            foreach($quickmenu as $k=>$v){
                if(empty($v)){
                    continue;
                }
                $one = explode(',',trim($v));
                if(substr($one[1],0,4)=='http' || substr($one[1],0,2)=='//'){

                }
                elseif(substr($one[1],0,1) =='/'){

                }
                elseif(strpos($one[1],'###')!==false || strpos($one[1],'javascript:')!==false){

                }
                else{
                    $one[1] = url($one[1]);
                }
                $menus[1]['sub'][14 + $k] = ['name'=>$one[0], 'url'=>$one[1],'controller'=>'', 'action'=>'' ];
            }
        }
        $this->assign('menus',$menus);
        $this->assign('title',lang('admin/index/title'));
        // 多语言
        $config_maccms = config('maccms');
        $this->assign('language_current', $config_maccms['app']['lang']);
        $this->assign('language_list', get_supported_lang_list());
        return $this->fetch('admin@index/index');
    }

    public function welcome()
    {
        $version = config('version');
        $update_sql = file_exists('./application/data/update/database.php');

        $this->assign('version',$version);
        $this->assign('update_sql',$update_sql);
        $this->assign('mac_lang',config('default_lang'));

        $this->assign('admin',$this->_admin);
        $this->assign('title',lang('admin/index/welcome/title'));

        $this->assign('serverU', $this->getServerUsedStatus());

        return $this->fetch('admin@index/welcome');
    }

    /**
     * 获取服务器运行状态
     */
    private function getServerUsedStatus(){
        return [
            'cpu_nums'       => '-',
            'cpu_usage'      => '-',
            'mem_total'      => '-',
            'mem_usage'      => '-',
            'hd_avail'       => '-',
            'hd_usage'       => '-',
            'tast_running'   => '-',
            'detection_time' => date('Y-m-d H:i:s'),
        ];

        $fp = popen('top -b -n 2 | grep -E "^(Cpu|Mem|Tasks)"',"r");//获取某一时刻系统cpu和内存使用情况
        $rs = "";
        while(!feof($fp)){
            $rs .= fread($fp,1024);
        }
        pclose($fp);
        $sys_info = $rs;
        $tast_info = explode(":",$sys_info);//进程 数组
        //$cpu_info = explode(",",$sys_info[4]); //CPU占有量 数组

        if (is_readable("/proc/stat")) {
            $stats = @file_get_contents("/proc/stat");
            $stats = preg_replace("/[[:blank:]]+/", " ", $stats);
            $stats = str_replace(array("\r\n", "\n\r", "\r"), "\n", $stats);
            $stats = explode("\n", $stats);
            $cpu_nums = 0;
            foreach ($stats as $statLine) {
                if ( strpos($statLine,"cpu") === 0 ){     //以cpu开头
                    $cpu_nums++;
                }
            }
            $cpu_nums--;    //减去第一个cpu开头的,第一个为总的cpu,其他以cpu0,cpu1,cpu2等开头
        }else{
            $cpu_nums =1;    //没有权限默认1个
        }
        // window平台判断       walle      2021-12-17
        if (stristr(PHP_OS,'WINNT')) {
            if (class_exists('\COM')) {
                $wmi = new \COM("Winmgmts://");
                $wmi_server = $wmi->execquery("SELECT LoadPercentage FROM Win32_Processor");
                $cpu_num_tmp = 0;
                $load_total_tmp = 0;
                foreach($wmi_server as $cpu_s_tmp){
                    $cpu_num_tmp++;
                    $load_total_tmp += $cpu_s_tmp->loadpercentage;
                }
                $cpu_info[0] = $load_total_tmp;
            }else{
                $cpu_info[0] = NULL;
            }
            $tast_running = isset($tast_info[1]) ? $tast_info[1] : lang('admin/system/php_com_dotnet');
        } else {
            $cpu_info = sys_getloadavg();
            $tast_running = isset($tast_info[1]) ? $tast_info[1] : '-';
        }
        $fp = popen('cat /proc/meminfo |grep MemTotal',"r");
        $rs = "";
        while(!feof($fp)){
            $rs .= fread($fp,1024);
        }
        pclose($fp);
        $mem_info = explode(":",$rs); //内存大小 数组
        //$cpu_usage = $cpu_info[0]*100 . '%'; //CPU占有量//百分比
        $cpu_usage = $cpu_info[0] ? round($cpu_info[0]/$cpu_nums * 100,2) . '%' : '-'; //CPU占有量//百分比        除以cpu个数   walle    2021-09-09
        $mem_total = isset($mem_info[1]) ? $mem_info[1] : 0;//内存大小
        $mem_used = memory_get_usage();
        $mem_usage = $mem_total > 0 ? round(100*intval($mem_used)/intval($mem_total),2) : '-'; //百分比
        /*硬盘使用率 begin*/
        $fp = popen('df -lh | grep -E "^(/)"',"r");
        $rs = fread($fp,1024);
        pclose($fp);
        $rs = preg_replace("/\s{2,}/",' ',$rs); //把多个空格换成 “_”
        $hd = explode(" ",$rs);
        $hd_avail = $hd[3] ? trim($hd[3],'G') : NULL;
        $hd_avail = $hd_avail ? trim($hd_avail,'Gi') : '-';//磁盘可用空间大小 单位G
        $hd_usage = $hd[4] ? trim($hd[4],'%') : '-'; //挂载点 百分比
        /*硬盘使用率 end*/
        $detection_time = date('Y-m-d H:i:s');
        $mem_total = $mem_total > 0 ? to_byte_string(intval($mem_total) * 1024, 0) : '-';
        return ['cpu_nums'=>$cpu_nums, 'cpu_usage'=>$cpu_usage, 'mem_total'=>$mem_total, 'mem_usage'=>$mem_usage, 'hd_avail'=>$hd_avail, 'hd_usage'=>$hd_usage, 'tast_running'=>$tast_running, 'detection_time'=>$detection_time];
    }

    public function quickmenu()
    {
        if(request()->isPost()){
            $param = input();
            $validate = \think\Loader::validate('Token');
            if(!$validate->check($param)){
                return $this->error($validate->getError());
            }
            $quickmenu = input('post.quickmenu');
            $quickmenu = str_replace(chr(10),'',$quickmenu);
            $menu_arr = explode(chr(13),$quickmenu);
            $res = mac_save_config_data(APP_PATH . 'extra/quickmenu.php', $menu_arr);
            if ($res === false) {
                return $this->error(lang('save_err'));
            }
            return $this->success(lang('save_ok'));
        }
        else{
            $config_menu = config('quickmenu');
            if(empty($config_menu)){
                $quickmenu = mac_read_file(APP_PATH.'data/config/quickmenu.txt');
            }
            else{
                $quickmenu = array_values($config_menu);
                $quickmenu = join(chr(13),$quickmenu);
            }
            $this->assign('quickmenu',$quickmenu);
            $this->assign('title',lang('admin/index/quickmenu/title'));
            return $this->fetch('admin@index/quickmenu');
        }
    }

    public function checkcache()
    {
        $res = 'no';
        $r = cache('cache_data');
        if($r=='1'){
            $res = 'haved';
        }
        echo $res;
    }

    public function clear()
    {
        $res = $this->_cache_clear();
        //运行缓存
        if(!$res) {
            $this->error(lang('admin/index/clear_err'));
        }
        return $this->success(lang('admin/index/clear_ok'));
    }

    public function iframe()
    {
        $val = input('post.val', 0);
        if ($val != 0 && $val != 1) {
            return $this->error(lang('admin/index/clear_ok'));
        }
        if ($val == 1) {
            cookie('is_iframe', 'yes');
        } else {
            cookie('is_iframe', null);
        }
        return $this->success(lang('admin/index/iframe'));
    }

    public function unlocked()
    {
        $param = input();
        $password = $param['password'];

        if($this->_admin['admin_pwd'] != md5($password)){
            return $this->error(lang('admin/index/pass_err'));
        }

        return $this->success(lang('admin/index/unlock_ok'));
    }

    public function check_back_link()
    {
        $param = input();
        $res = mac_check_back_link($param['url']);
        return json($res);
    }

    public function select()
    {
        $param = input();
        $tpl = $param['tpl'];
        $tab = $param['tab'];
        $col = $param['col'];
        $ids = $param['ids'];
        $url = $param['url'];
        $val = $param['val'];

        $refresh = $param['refresh'];

        if(empty($tpl) || empty($tab) || empty($col) || empty($ids) || empty($url)){
            return $this->error(lang('param_err'));
        }

        if(is_array($ids)){
            $ids = join(',',$ids);
        }

        if(empty($refresh)){
            $refresh = 'yes';
        }

        $url = url($url);
        $mid = 1;
        if($tab=='art'){
            $mid = 2;
        }
        elseif($tab=='actor'){
            $mid=8;
        }
        elseif($tab=='website'){
            $mid=11;
        }
        $this->assign('mid',$mid);

        if($tpl=='select_type'){
            $type_tree = model('Type')->getCache('type_tree');
            $this->assign('type_tree',$type_tree);
        }
        elseif($tpl =='select_level'){
            $level_list = [1,2,3,4,5,6,7,8,9];
            $this->assign('level_list',$level_list);
        }

        $this->assign('refresh',$refresh);
        $this->assign('url',$url);
        $this->assign('tab',$tab);
        $this->assign('col',$col);
        $this->assign('ids',$ids);
        $this->assign('val',$val);
        return $this->fetch( 'admin@public/'.$tpl);
    }

}
