<?php
namespace app\admin\controller;
use app\common\util\PclZip;
use think\Db;
use think\addons\AddonException;
use think\addons\Service;
use think\Cache;
use think\Config;
use think\Exception;
use app\common\util\Dir;

class Addon extends Base
{
    public $data_api_host = '';         //数据来源的域名,不同环境的域名不同
    public $data_list_api_url = '/api/market/center';    //列表页数据来源:来源官网api
    public $data_info_api_url = '/api/market_theme/detail';    //详情页数据来源:来源官网api
    public $data_info_p_api_url = '/api/market_plugins/detail';    //详情页数据来源:来源官网api
    public $verify_code_api_url = '/api/market_theme/verify_auth_code';    //兑换码验证api
    public $verify_code_p_api_url = '/api/market_plugins/verify_auth_code';    //兑换码验证api
    public $get_downurl_api_url = '/api/market_theme/theme_download';    //获取应用或模板的下载地址
    public $get_downurl_p_api_url = '/api/market_plugins/plugins_download';    //获取应用或模板的下载地址
    public $api_upload_url = '/api/upload_file/upload_file';    //文件上传api
    public $api_feedback_url = '/api/market/feedback';    //问题反馈提交

    public function __construct()
    {
        parent::__construct();
        $this->data_api_host = env('url_prefix_official_api', 'https://www.maccms.pro');
    }

    public function index()
    {
        $param = input();

        $this->assign('title',lang('admin/addon/title'));

        $this->assign('param',$param);
        return $this->fetch('admin@addon/index');
    }

    public function config()
    {
        $param = input();
        $name = $param['name'];
        if(empty($name)){
            return $this->error(lang('param_err'));
        }

        if (!is_dir(ADDON_PATH . $name)) {
            return $this->error(lang('get_dir_err'));
        }

        $info = get_addon_info($name);
        $config = get_addon_fullconfig($name);
        if (!$info){
            return $this->error(lang('get_addon_info_err'));
        }
        if ($this->request->isPost()) {
            $params = $this->request->post("row/a");
            if(empty($params)){
                return $this->error(lang('param_err'));
            }
            foreach ($config as $k => &$v) {
                if (isset($params[$v['name']])) {
                    if ($v['type'] == 'array') {
                        $params[$v['name']] = is_array($params[$v['name']]) ? $params[$v['name']] : (array)json_decode($params[$v['name']], true);
                        $value = $params[$v['name']];
                    } else {
                        $value = is_array($params[$v['name']]) ? implode(',', $params[$v['name']]) : $params[$v['name']];
                    }
                    $v['value'] = $value;
                }
            }

            try {
                //更新配置文件
                set_addon_fullconfig($name, $config);
                Service::refresh();
                return $this->success(lang('save_ok'));
            } catch (Exception $e) {
                return $this->error($e->getMessage());
            }
        }

        $this->assign('info',$info);
        $this->assign('config',$config);

        return $this->fetch('admin@addon/config');
    }

    public function info()
    {

    }

    public function downloaded()
    {
        $offset = (int)$this->request->get("offset");
        $limit = (int)$this->request->get("limit");
        $filter = $this->request->get("filter");
        $search = $this->request->param("wd");
        $search = htmlspecialchars(strip_tags($search));
        $key = $GLOBALS['config']['app']['cache_flag']. '_'. 'onlineaddons';
        $onlineaddons = Cache::get($key);
        if (!is_array($onlineaddons)) {
            $onlineaddons = [];
            $result = mac_curl_get(base64_decode('aHR0cDovL2FwaS5tYWNjbXMucHJv') . '/addon/index');
            if ($result['ret']) {
                $json = json_decode($result['msg'], TRUE);
                $rows = isset($json['rows']) ? $json['rows'] : [];
                foreach ($rows as $index => $row) {
                    $onlineaddons[$row['name']] = $row;
                }
            }
            Cache::set($key, $onlineaddons, 600);
        }
        $filter = (array)json_decode($filter, true);
        $addons = get_addon_list();
        $list = [];
        foreach ($addons as $k => $v) {
            if ($search && stripos($v['name'], $search) === FALSE && stripos($v['intro'], $search) === FALSE)
                continue;

            if (isset($onlineaddons[$v['name']])) {
                $v = array_merge($onlineaddons[$v['name']], $v);
            } else {
                if(!isset($v['category_id'])) {
                    $v['category_id'] = 0;
                }
                if(!isset($v['flag'])) {
                    $v['flag'] = '';
                }
                if(!isset($v['banner'])) {
                    $v['banner'] = '';
                }
                if(!isset($v['image'])) {
                    $v['image'] = '';
                }
                if(!isset($v['donateimage'])) {
                    $v['donateimage'] = '';
                }
                if(!isset($v['demourl'])) {
                    $v['demourl'] = '';
                }
                if(!isset($v['price'])) {
                    $v['price'] = '0.00';
                }
            }
            $v['url'] = addon_url($v['name']);
            $v['createtime'] = filemtime(ADDON_PATH . $v['name']);
            $v['install'] = '1';
            if ($filter && isset($filter['category_id']) && is_numeric($filter['category_id']) && $filter['category_id'] != $v['category_id']) {
                continue;
            }
            $list[] = $v;
        }
        $total = count($list);
        if ($limit) {
            $list = array_slice($list, $offset, $limit);
        }
        $result = array("total" => $total, "rows" => $list, "wd"=>$search);

        $callback = $this->request->get('callback') ? "jsonp" : "json";
        return $callback($result);
    }

    /**
     * 安装
     */
    public function install()
    {
        $param = input();
        $name = $param['name'];
        $force = (int)$param['force'];
        if (!$name) {
            return $this->error(lang('param_err'));
        }
        try {
            $uid = $this->request->post("uid");
            $token = $this->request->post("token");
            $version = $this->request->post("version");
            $faversion = $this->request->post("faversion");
            $extend = [
                'uid'       => $uid,
                'token'     => $token,
                'version'   => $version,
                'faversion' => $faversion
            ];
            Service::install($name, $force, $extend);
            $info = get_addon_info($name);
            $info['config'] = get_addon_config($name) ? 1 : 0;
            $info['state'] = 1;
            return $this->success(lang('install_err'));
        } catch (AddonException $e) {
            return $this->result($e->getData(), $e->getCode(), $e->getMessage());
        } catch (Exception $e) {
            return $this->error($e->getMessage(), $e->getCode());
        }
    }

    /**
     * 卸载
     */
    public function uninstall()
    {
        $param = input();
        $name = $param['name'];
        $force = (int)$param['force'];
        if (!$name) {
            return $this->error(lang('param_err'));
        }
        try {
            if( strpos($name,".")!==false ||  strpos($name,"/")!==false ||  strpos($name,"\\")!==false  ) {
                $this->error(lang('admin/addon/path_err'));
                return;
            }


            Service::uninstall($name, $force);
            return $this->success(lang('uninstall_ok'));
        } catch (AddonException $e) {
            return $this->result($e->getData(), $e->getCode(), $e->getMessage());
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    /**
     * 禁用启用
     * MOFIFY BY WALLE     2021-9-23     在一键安装时调用以便直接启用
     */
    public function state($dd=NULL)
    {
        if($dd == NULL){
            $param = input();
        }else{
            $param = $dd;
        }
        $name = $param['name'];
        $action = $param['action'];
        $force = (int)$param['force'];
        if (!$name) {
            return $this->error(lang('param_err'));
        }
        try {
            $action = $action == 'enable' ? $action : 'disable';
            //调用启用、禁用的方法
            Service::$action($name, $force);
            Cache::rm('__menu__');
            return $this->success(lang('opt_ok'));
        } catch (AddonException $e) {
            return $this->result($e->getData(), $e->getCode(), $e->getMessage());
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    /**
     * 本地上传
     */
    public function local()
    {
        $param = input();
        $validate = \think\Loader::validate('Token');
        if(!$validate->check($param)){
            return $this->error($validate->getError());
        }
        echo 'closed';exit;
        $file = $this->request->file('file');
        $addonTmpDir = RUNTIME_PATH . 'addons' . DS;
        if (!is_dir($addonTmpDir)) {
            @mkdir($addonTmpDir, 0755, true);
        }
        $info = $file->rule('uniqid')->validate(['size' => 10240000, 'ext' => 'zip'])->move($addonTmpDir);
        if ($info) {
            $tmpName = substr($info->getFilename(), 0, stripos($info->getFilename(), '.'));
            $tmpAddonDir = ADDON_PATH . $tmpName . DS;
            $tmpFile = $addonTmpDir . $info->getSaveName();
            try {
                Service::unzip($tmpName);
                @unlink($tmpFile);
                $infoFile = $tmpAddonDir . 'info.ini';
                if (!is_file($infoFile)) {
                    throw new Exception(lang('admin/addon/lack_config_err'));
                }

                $config = Config::parse($infoFile, '', $tmpName);
                $name = isset($config['name']) ? $config['name'] : '';
                if (!$name) {
                    throw new Exception(lang('admin/addon/name_empty_err'));
                }

                $newAddonDir = ADDON_PATH . $name . DS;
                if (is_dir($newAddonDir)) {
                    throw new Exception(lang('admin/addon/haved_err'));
                }

                //重命名插件文件夹
                rename($tmpAddonDir, $newAddonDir);
                try {
                    //默认禁用该插件
                    $info = get_addon_info($name);
                    if ($info['state']) {
                        $info['state'] = 0;
                        set_addon_info($name, $info);
                    }

                    //执行插件的安装方法
                    $class = get_addon_class($name);
                    if (class_exists($class)) {
                        $addon = new $class();
                        $addon->install();
                    }

                    //导入SQL
                    Service::importsql($name);

                    $info['config'] = get_addon_config($name) ? 1 : 0;
                    return $this->success(lang('install_ok'));
                } catch (Exception $e) {
                    if (Dir::delDir($newAddonDir) === false) {

                    }
                    throw new Exception($e->getMessage());
                }
            } catch (Exception $e) {
                @unlink($tmpFile);
                if (Dir::delDir($tmpAddonDir) === false) {

                }
                return $this->error($e->getMessage());
            }
        } else {
            // 上传失败获取错误信息
            return $this->error($file->getError());
        }
    }

    public function add()
    {
        return $this->fetch('admin@addon/add');
    }
    /**
     * 更新插件
     */
    public function upgrade()
    {
        $name = $this->request->post("name");
        if (!$name) {
            return $this->error(lang('param_err'));
        }
        try {
            $uid = $this->request->post("uid");
            $token = $this->request->post("token");
            $version = $this->request->post("version");
            $faversion = $this->request->post("faversion");
            $extend = [
                'uid'       => $uid,
                'token'     => $token,
                'version'   => $version,
                'faversion' => $faversion
            ];
            //调用更新的方法
            Service::upgrade($name, $extend);
            Cache::rm('__menu__');
            return $this->success(lang('update_ok'));
        } catch (AddonException $e) {
            return $this->result($e->getData(), $e->getCode(), $e->getMessage());
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    /**
     * 应用市场管理列表     作者:walle
     * 废弃
     */
    /**
    public function market()
    {
        $param = input();
        $param['page'] = intval($param['page']) < 1 ? 1 : $param['page'];
        $param['limit'] = intval($param['limit']) < 1 ? $this->_pagesize : $param['limit'];

        $where = [];
        if (!empty($param['title'])) {
            $where['title'] = ['like', '%'.$param['type'].'%'];
        }
        if (!empty($param['user_name'])) {
            $info = model('User')->where('user_name',array('like','%'.$param['user_name'].'%'))->find();
            if ($info){
                $where['user_id'] = ['eq', $info['id']];
            }else{
                $where['user_id'] = ['eq', -1];
            }
        }
        if (in_array($param['is_free'], ['0', '1'])) {
            $where['is_free'] = ['eq', $param['status']];
        }
        if (!empty($param['status'])){
            if (in_array($param['status'], ['0', '1','-1'])) {
                $where['status'] = ['eq', $param['status']];
            }
        }else{
            $where['status'] = ['eq', 0];   //默认审核中
        }

        $res = model('AddonMarket')->listData($where,'id desc',$param['page'],$param['limit']);

        $this->assign('list', $res['list']);
        $this->assign('total', $res['total']);
        $this->assign('page', $res['page']);
        $this->assign('limit', $res['limit']);

        $param['page'] = '{page}';
        $param['limit'] = '{limit}';
        $this->assign('param', $param);

        $this->assign('title', lang('admin/addon/market'));
        return $this->fetch('admin@addon/market');
    }
    **/

    /**
     * 应用市场列表     作者:walle
     */
    public function market()
    {
        return $this->market_list_data();
    }

    /**
     * 模板市场列表     作者:walle
     */
    public function markettheme()
    {
        return $this->market_list_data('theme');
    }

    public function market_list_data($type = 'plugins'){
        $param = input();
        $param['page'] = intval($param['page']) < 1 ? 1 : $param['page'];
        $param['limit'] = intval($param['limit']) < 1 ? $this->_pagesize : $param['limit'];

        if (!empty($param['title'])) {
            $data["name"] = $param['title'];
        }else{
            $data["name"] ="";
        }
        if (!empty($param['page'])) {
            $data["page"] = $param['page'];
        }else{
            $data["page"] = 1;
        }
        if (!empty($param['limit'])) {
            $data["limit"] = $param['limit'];
        }else{
            $data["limit"] = 20;
        }
        $data["sortBy"] = $param['sortBy'] ? $param['sortBy'] : '';
        $data["type"] = $type;
        $res = self::post($this->data_api_host .$this->data_list_api_url,$data);
        if (false === $res){
            return $this->error("API error");
        }
        if (!is_array($res)){
            $res = json_decode($res,true);
        }
        if ($res["code"] !=1 ){
            $this->assign('list', []);
            $this->assign('total',0);
        }else{
            $this->assign('list', $res["info"]['list']);
            $this->assign('total',$res["info"]['search_count']);
        }
        $this->assign('page', $param['page']);
        $this->assign('limit',$param['limit']);

        $param['page'] = '{page}';
        $param['limit'] = '{limit}';
        $this->assign('param', $param);

        if ( $type == 'plugins'){
            $this->assign('title', lang('admin/addon/market'));
            return $this->fetch('admin@addon/market');
        }else{
            $this->assign('title', lang('admin/addon/market_theme'));
            return $this->fetch('admin@addon/markettheme');
        }
    }

    public function curl_test(){
        return [
            "code"=>1,
            "msg"=>"成功",
            "info"=>[
                "list"=>[
                    [
                        "id"=>11,
                        "name"=>"应用名称",
                        "pc_preview"=>"https://pimg.macvideojs.com/images/8c68ac501a1203d8f356486feba89405.jpg",],
                    [
                        "id"=>11,
                        "name"=>"应用名称2",
                        "pc_preview"=>"https://pimg.macvideojs.com/images/8c68ac501a1203d8f356486feba89405.jpg",],
                    [
                        "id"=>11,
                        "name"=>"应用名称3",
                        "pc_preview"=>"https://pimg.macvideojs.com/images/8c68ac501a1203d8f356486feba89405.jpg",],
                    [
                        "id"=>11,
                        "name"=>"应用名称4",
                        "pc_preview"=>"https://pimg.macvideojs.com/images/8c68ac501a1203d8f356486feba89405.jpg",]
                ],
                "count"=>6,
                "search_number"=>4,
                "type"=>"plugins"
            ]
        ];
    }

    /**
     * 应用市场管理详情页
     */
    public function marketinfo()
    {
        return $this->marketinfo_data();
    }

    /**
     * 模板市场管理详情页
     */
    public function marketthemeinfo()
    {
        return $this->marketinfo_data('theme');
    }

    public function marketinfo_data($type = 'plugins'){
        $param = input();
        if (empty($param['id'])){
            return $this->error(lang('param_err'));
        }
        if ($type == 'plugins'){
            $re_url = $this->data_api_host.$this->data_info_p_api_url;
        }else{
            $re_url = $this->data_api_host.$this->data_info_api_url;
        }
        $res = self::post($re_url,$param);
        if (false === $res){
            return $this->error("API error");
        }
        if (!is_array($res)){
            $res = json_decode($res,true);
        }
        if (!$res["info"]["detail"]['langs']){
            $res["info"]["detail"]['langs'] = '无';
        }

        $this->assign('info',$res["info"]["detail"]);
        $level = $res["info"]["version_history"][count($res["info"]["version_history"])-1];
        $level = $level ? $level :'无';
        $this->assign('level',$level);
        if ($type == 'plugins'){
            return $this->fetch('admin@addon/marketinfo');
        }else{
            return $this->fetch('admin@addon/marketthemeinfo');
        }
    }

    /**
     * 授权码兑换
     */
    public function marketlicense(){
        $param = input();
        if (empty($param['id'])){
            return $this->error(lang('param_err'));
        }

        $this->assign('id',$param['id']);
        $this->assign('type',$param['type']);
        return $this->fetch('admin@addon/marketlicense');
    }

    /**
     * 授权码兑换验证
     */
    public function licenseconvert(){
        $param = input();
        if (empty($param['id']) || empty($param['license']) || empty($param['type'])){
            return $this->error(lang('param_err'));
        }
        $param["code"] = $param['license'];
        if ($param['type'] == "theme"){
            $url = $this->data_api_host.$this->verify_code_api_url;
        }
        if ($param['type'] == "plugins"){
            $url = $this->data_api_host.$this->verify_code_p_api_url;
        }
        $res = self::post($url,$param);
        if (!is_array($res)){
            $res = json_decode($res,true);
        }
        if ( ($res["code"] > 1)  || ($res["code"] == 0) ){
            return ["code"=>$res["code"],"message"=>"API:".$res["msg"],"data"=>""];
        }
        if ($param['type'] == "theme"){
            $url2 = $this->data_api_host.$this->get_downurl_api_url;
        }
        if ($param['type'] == "plugins"){
            $url2 = $this->data_api_host.$this->get_downurl_p_api_url;
        }
        $res = self::post($url2,$param);
        if (!is_array($res)){
            $res = json_decode($res,true);
        }
        if ( ($res["code"] > 1)  || ($res["code"] == 0) ){
            return $this->error("APP:".$res["msg"]);
        }
        if ($res["code"] == 1){
            return ["code"=>200,"message"=>"","data"=>["down_url"=>$res["info"]["source"],"type"=>$param["type"],"file_name"=>$res["info"]["file_name"]]];
        }
        return ["code"=>$res["code"],"message"=>$res["msg"],"data"=>""];
    }

    /**
     * 直接下载
     */
    public function ondown(){
        $param = input();
        if (empty($param['id']) || empty($param['down_url']) || empty($param['type'])){
            return $this->error(lang('param_err'));
        }
        if ($param['type'] == "theme"){
            $url2 = $this->data_api_host.$this->get_downurl_api_url;
        }
        if ($param['type'] == "plugins"){
            $url2 = $this->data_api_host.$this->get_downurl_p_api_url;
        }
        self::post($url2,$param);    //访问下载接口,使下载量+1
        return ["data"=>$param['down_url']];
    }

    /**
     * 应用问题反馈   walle
     */
    public function marketfeedback(){
        $param = input();
        if (empty($param['id'])){
            return $this->error(lang('param_err'));
        }
        $this->assign('id',$param['id']);
        $this->assign('type',$param['type']);

        $res = self::post($this->data_api_host.$this->data_info_api_url,$param);
        if (!is_array($res)){
            $res = json_decode($res,true);
        }
        if ( ($res["code"] > 1)  || ($res["code"] == 0) ){
            return $this->error("APP:".$res["msg"]);
        }


        $this->assign('info',$res["info"]["detail"]);
        $this->assign('version_history',$res["info"]["version_history"]);
        return $this->fetch('admin@addon/marketfeedback');
    }

    /**
     * 处理问题反馈   walle
     */
    public function domarketfeedback(){
        $param = input();
        if (empty($param['bind_id']) ){
            return $this->error(lang('param_err').'-id不能为空');
        }
        if (empty($param['version']) ){
            return $this->error(lang('param_err').'-版本号必填');
        }
        if (empty($param['content']) ){
            return $this->error(lang('param_err').'-内容必填');
        }
        if (empty($_FILES['images']['tmp_name']) ){
            return $this->error(lang('param_err').'-截图必填');
        }
        if (empty($_FILES['videos']['tmp_name']) ){
            return $this->error(lang('param_err').'-视频必填');
        }
        $data["bind_id"] = $param['bind_id'];
        $data["name"] = $param['name'];
        $data["version"] = $param["version"];
        $data["content"] = $param["content"];
        $data["type"] = $param["type"];
        $data["images[]"] = new \CURLFile($_FILES["images"]['tmp_name']);
        $data["videos[]"] = new \CURLFile($_FILES["videos"]['tmp_name']);
        $res = self::post($this->data_api_host.$this->api_feedback_url,$data);
        $res = json_decode($res,true);
        if ($res['code'] == 1){
            return $this->success("反馈成功");
        }else{
            return $this->error($res['msg']);
        }
    }

    /**
     * 下载并且一键安装应用
     */
    public function downandinstalladdon(){
        //下载zip文件到Addon目录
        $param = input();
        if ('zip' != pathinfo($param["down_url"], PATHINFO_EXTENSION)){
            $this->error("应用扩展名必须是zip");
        }
        if (!$param["file_name"]){
            $this->error("file_name参数丢失");
        }
        $file_name = $this->_getFile($param["down_url"],$param["file_name"],1);
        if (false === $file_name){
            $this->error("下载失败");
        }

        //解压zip文件
        $zip = new \ZipArchive();
        $zip->open($file_name);
        if (!$zip){
            $this->error("请先安装zip扩展");
        }
        $dir_name = substr(basename($file_name),0,strlen(basename($file_name))-4);
        if (is_dir(dirname($file_name).DS.$dir_name)){
            //删除zip
            unlink($file_name);
            return $this->error('该应用已存在,请勿重复安装');
        }
        $res = $zip->extractTo(dirname($file_name).DS.$dir_name);
        if (!$res){
            $this->error("解压失败");
        }

        //删除zip
        unlink($file_name);

        //$bouniqid_name = substr(basename($param["down_url"]),0,strlen(basename($param["down_url"]))-4);
        //判断插件的规则,,:插件目录里面要有与插件目录名一致的首字母大写的.php文件
        if(!is_file(ADDON_PATH.$dir_name.DS.ucfirst($dir_name).'.php')){
            $this->error("应用目录结构异常,不能正常使用");return;
        }
        //重新命硬一个新的与目录一致的首字母大写的.php文件
        //rename(ADDON_PATH.$dir_name.DS.ucfirst($bouniqid_name),ADDON_PATH.$dir_name.DS.ucfirst($dir_name).'.php');

        //直接启用
        //$this->state(["name"=>$dir_name,"action"=>"enable","force"=>0]);

        if ($param['type'] == "theme"){
            $url2 = $this->data_api_host.$this->get_downurl_api_url;
        }
        if ($param['type'] == "plugins"){
            $url2 = $this->data_api_host.$this->get_downurl_p_api_url;
        }
        self::post($url2,$param);    //访问下载接口,使下载量+1

        $this->success("安装成功");
    }

    /**
     * 下载并且一键安装模板
     */
    public function downandinstalltheme(){
        //下载zip文件到Addon目录
        $param = input();
        if ('zip' != pathinfo($param["down_url"], PATHINFO_EXTENSION)){
            return $this->error("应用扩展名必须是zip");
        }
        if (!$param["file_name"]){
            return $this->error("file_name参数丢失");
        }
        $file_name = $this->_getFile($param["down_url"],$param["file_name"],1,"./template/");
        if (false === $file_name){
            return $this->error("下载失败");
        }

        //判断是否有重名
        $dir_name = substr(basename($file_name),0,strlen(basename($file_name))-4);
        /**      改为下面的直接覆盖
        if (is_dir("./template/".$dir_name)){
            unlink($file_name);
            return $this->error("模板已存在,请在本地模板管理菜单中操作");
        }**/
        //解压zip文件
        $zip = new \ZipArchive();
        $zip->open($file_name);
        if (!$zip){
            return $this->error("请先安装zip扩展");
        }
        $dir_name_tmp = $dir_name.'_tmp';
        $res = $zip->extractTo(dirname($file_name).DS.$dir_name_tmp);
        if (!$res){
            //删除zip
            unlink($file_name);
            return $this->error("解压失败");
        }
        //删除zip
        unlink($file_name);

        //$dir_name = substr(basename($file_name),0,strlen(basename($file_name))-4);

        if ($param['type'] == "theme"){
            $url2 = $this->data_api_host.$this->get_downurl_api_url;
        }
        if ($param['type'] == "plugins"){
            $url2 = $this->data_api_host.$this->get_downurl_p_api_url;
        }
        self::post($url2,$param);    //访问下载接口,使下载量+1

        if (is_dir("./template/".$dir_name)){
            self::deldir("./template/".$dir_name);
            rename(dirname($file_name).DS.$dir_name_tmp,dirname($file_name).DS.$dir_name);
            return $this->success('模板已自动更新');
        }else{
            rename(dirname($file_name).DS.$dir_name_tmp,dirname($file_name).DS.$dir_name);
            return $this->success('模板已安装,请前往系统-网站参数配置中设置');
        }


        //直接设置新的的模板
        /**$config = config('maccms');
        $config["site"]["template_dir"] = $dir_name;
        $res = mac_save_config_data(APP_PATH . 'extra/maccms.php', $config);
        if ($res === false) {
            return $this->error(lang('安装失败'));
        }**/     //walle  取消直接应用要用户自己去设置里启用
        return $this->success(lang('安装成功'));
    }

    /**
     * walle
     * 删除一个不为空的目录
     * @param $path
     * @return bool
     */
    static function deldir($path){
        //如果是目录则继续
        if(is_dir($path)){
            //扫描一个文件夹内的所有文件夹和文件并返回数组
            $p = scandir($path);
            //如果 $p 中有两个以上的元素则说明当前 $path 不为空
            if(count($p)>2){
                foreach($p as $val){
                    //排除目录中的.和..
                    if($val !="." && $val !=".."){
                        //如果是目录则递归子目录，继续操作
                        if(is_dir($path.DS.$val)){
                            //子目录中操作删除文件夹和文件
                            self::deldir($path.DS.$val);
                        }else{
                            //如果是文件直接删除
                            unlink($path.DS.$val);
                        }
                    }
                }
            }
        }
        //删除目录
        return rmdir($path);
    }

    protected function _getFile($url, $filename,$type = 0, $path ='') {
        if (trim($url) == '') {
            return false;
        }
        //获取远程文件所采用的方法
        if ($type) {
            $ch = curl_init();
            $timeout = 20;
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
            $curl_info = curl_getinfo($ch);
            if ($curl_info["http_code"] == 404 ){
                return false;
            }
            $content = curl_exec($ch);
            curl_close($ch);
        } else {
            ob_start();
            if(readfile($url)){
                $content = ob_get_contents();
                ob_end_clean();
            }else{
                ob_end_clean();
                return false;
            }
        }
        if (!$content){
            //$this->error("下载失败");
            return false;
        }
        //$filename = uniqid() .'_' . basename($url);
        //$filename = basename($url);
        if ($path =='') {
            $path = ADDON_PATH;
        }
        $fp2 = @fopen($path . $filename, 'a');
        fwrite($fp2, $content);
        fclose($fp2);
        unset($content, $url);
        return $path . $filename;
    }
}
