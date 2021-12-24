<?php
namespace app\admin\controller;

class Sitesend extends Base
{
    public function __construct()
    {
        parent::__construct();
        $this->_param = input();
    }

    /**
     * 获取curl反应头信息数组
     * @param $curl
     * @param $headerLine
     * @return int
     */
    static public function headerHandler($curl,$headerLine){
        $len = strlen($headerLine);
        $split = explode(':',$headerLine,2);
        if (count($split)>1){
            $key = trim($split[0]);
            $value = trim($split[1]);
            $GLOBALS['G_HEADER'][$key] = $value;
        }
        return $len;
    }

    public function index(){

        $config = config('maccms');
        $this->assign('config', $config);

        $this->get360verditycode();
        $this->getsougouverfitycode();

        return $this->fetch('admin@sitesend/index');
    }

    public function getsougouverfitycode(){
        $ch = curl_init();
        $cul = 'https://zhanzhang.sogou.com/api/user/generateVerifCode?timer='.time().rand(1,999);
        list($msec, $sec) = explode(' ', microtime());
        $msectime = (float)sprintf('%.0f', (floatval($msec) + floatval($sec)) * 1000);
        $file_name = '/tmp/'.$msectime.'_'.rand(1000,9999).'.tmp';
        curl_setopt($ch,CURLOPT_URL,$cul);
        //curl_setopt($ch,CURLOPT_HEADER,1);
        //curl_setopt($ch,CURLOPT_HEADERFUNCTION,"self::headerHandler");
        curl_setopt($ch,CURLOPT_COOKIEJAR,$file_name);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        $content = curl_exec($ch);
        curl_close($ch);
        //list($header,$body) = explode("\r\n\r\n",$content);
        //preg_match_all("/Set-Cookie:(.*);/iU",$header,$matches);
        //$cookie = $matches[1];
        $this->assign('sougou_cooke_name',$file_name);
        $this->assign('sougou_content',$content);
    }

    public function get360verditycode(){
        $ch = curl_init();
        $cul = 'https://zhanzhang.so.com/index.php?a=checkcode&m=Utils&t='.time().rand(1,999);
        list($msec, $sec) = explode(' ', microtime());
        $msectime = (float)sprintf('%.0f', (floatval($msec) + floatval($sec)) * 1000);
        $file_name = '/tmp/'.$msectime.'_'.rand(1000,9999).'.tmp';
        curl_setopt($ch,CURLOPT_URL,$cul);
        curl_setopt($ch,CURLOPT_COOKIEJAR,$file_name);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        $content = curl_exec($ch);
        curl_close($ch);
        $this->assign('so360_cooke_name',$file_name);
        $this->assign('so360_content',base64_encode($content));
    }

    /**
     * 获取要推送的url地址
     */
    public function getpushlist(){
        $list = [];
        $mid = $this->_param['mid'];
        $this->_param['page'] = intval($this->_param['page']) <1 ? 1 : $this->_param['page'];
        $this->_param['limit'] = intval($this->_param['limit']) <1 ? 50 : $this->_param['limit'];
        $ids = $this->_param['ids'];
        $ac2 = $this->_param['ac2'];

        $today = strtotime(date('Y-m-d'));
        $where = [];
        $col = '';
        switch($mid)
        {
            case 1:
                $where['vod_status'] = ['eq',1];

                if($ac2=='today'){
                    $where['vod_time'] = ['gt',$today];
                }
                if(!empty($ids)){
                    $where['vod_id'] = ['in',$ids];
                }
                elseif(!empty($data)){
                    $where['vod_id'] = ['gt', $data];
                }

                $col = 'vod';
                $order = 'vod_id asc';
                $fun = 'mac_url_vod_detail';
                $res = model('Vod')->listData($where,$order,$this->_param['page'],$this->_param['limit']);
                break;
            case 2:
                $where['art_status'] = ['eq',1];

                if($ac2=='today'){
                    $where['art_time'] = ['gt',$today];

                }
                if(!empty($ids)){
                    $where['art_id'] = ['in',$ids];
                }
                elseif(!empty($data)){
                    $where['art_id'] = ['gt', $data];
                }

                $col = 'art';
                $order = 'art_id asc';
                $fun = 'mac_url_art_detail';
                $res = model('Art')->listData($where,$order,$this->_param['page'],$this->_param['limit']);
                break;
            case 3:
                $where['topic_status'] = ['eq',1];

                if($ac2=='today'){
                    $where['topic_time'] = ['gt',$today];

                }
                if(!empty($ids)){
                    $where['topic_id'] = ['in',$ids];
                }
                elseif(!empty($data)){
                    $where['topic_id'] = ['gt', $data];
                }

                $col = 'topic';
                $order = 'topic_id asc';
                $fun = 'mac_url_topic_detail';
                $res = model('Topic')->listData($where,$order,$this->_param['page'],$this->_param['limit']);
                break;
            case 8:
                $where['actor_status'] = ['eq',1];

                if($ac2=='today'){
                    $where['actor_time'] = ['gt',$today];

                }
                if(!empty($ids)){
                    $where['actor_id'] = ['in',$ids];
                }
                elseif(!empty($data)){
                    $where['actor_id'] = ['gt', $data];
                }
                $col = 'actor';
                $order = 'actor_id asc';
                $fun = 'mac_url_actor_detail';
                $res = model('Actor')->listData($where,$order,$this->_param['page'],$this->_param['limit']);
                break;
            case 9:
                $where['role_status'] = ['eq',1];

                if($ac2=='today'){
                    $where['role_time'] = ['gt',$today];

                }
                if(!empty($ids)){
                    $where['role_id'] = ['in',$ids];
                }
                elseif(!empty($data)){
                    $where['role_id'] = ['gt', $data];
                }
                $col = 'role';
                $order = 'role_id asc';
                $fun = 'mac_url_role_detail';
                $res = model('Role')->listData($where,$order,$this->_param['page'],$this->_param['limit']);
                break;
            case 11:
                $where['website_status'] = ['eq',1];

                if($ac2=='today'){
                    $where['website_time'] = ['gt',$today];

                }
                if(!empty($ids)){
                    $where['website_id'] = ['in',$ids];
                }
                elseif(!empty($data)){
                    $where['website_id'] = ['gt', $data];
                }
                $col = 'website';
                $order = 'website_id asc';
                $fun = 'mac_url_website_detail';
                $res = model('Website')->listData($where,$order,$this->_param['page'],$this->_param['limit']);
                break;
        }

        if(empty($res['list'])){
            exit(json_encode(array('urls'=>'')));
        }
        //mac_echo(lang('admin/urlsend/tip',[$res['total'],$res['pagecount'],$res['page']]));
        $urls = [];
        foreach($res['list'] as $k=>$v){
            $urls[$v[$col.'_id']] =  $GLOBALS['http_type'] . trim($GLOBALS['config']['site']['site_url'],'/') . $fun($v);
            $this->_lastid = $v[$col.'_id'];
            //mac_echo($v[$col.'_id'] . '、'. $v[$col . '_name'] . '&nbsp;<a href="'.$urls[$v[$col.'_id']].'">'.$urls[$v[$col.'_id']].'</a>');
        }
        $urls_str = implode(',',$urls);
        $res['urls'] = $urls_str;
        exit(json_encode($res));
    }




    /**
     * 百度推送       walle
     */
    public function baidusend(){
        $param = input();

        if ( empty($param["site_baidu_site"]) || empty($param["site_baidu_token"]) || empty($param["site_baidu_send_url"]) || empty($param["send_urls"])){
            return $this->error(lang('param_err'));
        }
        $send_urls = trim(trim($param["send_urls_s"]),',').','.trim(trim($param["send_urls"]),',').',';
        $send_urls = trim(trim($send_urls),',');
        $urls = explode(",",$send_urls);
        if (empty($urls)){
            return $this->error(lang('param_err'));
        }

        $api = $param["site_baidu_send_url"];
        $ch = curl_init();
        $options = array(
            CURLOPT_URL => $api,
            CURLOPT_POST => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POSTFIELDS => implode("\n", trim($urls)),
            CURLOPT_HTTPHEADER => array('Content-Type: text/plain'),
        );
        curl_setopt_array($ch, $options);
        $result = curl_exec($ch);
        curl_close($ch);
        $res = json_decode($result,true);
        if ($res["success"]){
            $this->success('推送成功,共推送('.$res["success"].')条记录');
        }else{
            $this->error($res["message"]);
        }
    }

    /**
     * 360推送       walle
     */
    public function do360send(){
        $param = input();

        if ( empty($param["site_360_email"]) || empty($param["site_360_verfity"]) || (empty($param["send_urls"])&&empty($param["send_urls_s"])) ){
            return $this->error(lang('param_err'));
        }

        $send_urls = trim(trim($param["send_urls_s"]),',').','.trim(trim($param["send_urls"]),',').',';
        $send_urls = trim(trim($send_urls),',');
        $urls = explode(",",$send_urls);
        if (empty($urls)){
            return $this->error(lang('param_err'));
        }

        $ch = curl_init();
        $options = array(
            CURLOPT_URL => "https://zhanzhang.so.com/?m=PageInclude&a=upload",
            CURLOPT_POST => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POSTFIELDS => http_build_query(array(
                "url[0]"=>$urls[0] ? $urls[0] :"",
                "url[1]"=>$urls[1] ? $urls[1] :"",
                "url[2]"=>$urls[2] ? $urls[2] :"",
                "url[3]"=>$urls[3] ? $urls[3] :"",
                "url[4]"=>$urls[4] ? $urls[4] :"",
                "checkcode"=>$param["site_360_verfity"]
            )),
            CURLOPT_HTTPHEADER => array('Content-Type: application/x-www-form-urlencoded'),
            CURLOPT_COOKIEFILE=> $param["so360_cooke_name"],
        );
        curl_setopt_array($ch, $options);
        //var_dump(curl_getinfo($ch));
        $result = curl_exec($ch);
        $res = json_decode($result,true)?$res['success']=true:$res['message']='推送失败';
        curl_close($ch);
        //var_dump($result);
        if ($res["success"]){
            /**  360推送有限制,最多5条  **/
            if (count($urls)>5) {
                $send_sucess_count = 5;
            }else{
                $send_sucess_count = count($urls);
            }
            $this->success('推送成功,共推送('.$send_sucess_count.')条记录');
        }else{
            $this->error($res["message"]);
        }
    }

    /**
     * 搜狗推送       walle
     */
    public function sougousend(){
        $param = input();

        if ( empty($param["site_sougou_username"]) || empty($param["site_sougou_mail"]) || empty($param["site_sougou_verfity"]) || empty($param["send_urls"])){
            return $this->error(lang('param_err'));
        }

        $send_urls = trim(trim($param["send_urls_s"]),',').','.trim(trim($param["send_urls"]),',').',';
        $send_urls = trim(trim($send_urls),',');
        $urls = explode(",",$send_urls);
        if (empty($urls)){
            return $this->error(lang('param_err'));
        }
        $post["site_type"] =1;
        $post["sites"] = $urls;
        $post["urls"] = implode("\n",$urls);
        $post["code"] =$param["site_sougou_verfity"];
        $post["email"] =$param["site_sougou_mail"];
        $ch = curl_init();
        $options = array(
            CURLOPT_URL => "https://zhanzhang.sogou.com/api/feedback/addMultiShensu",
            CURLOPT_POST => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POSTFIELDS => http_build_query($post),
            CURLOPT_COOKIEFILE=> $param["sougou_cooke_name"],
            CURLOPT_HTTPHEADER => array('Content-Type: application/json;charset=UTF-8'),
        );
        curl_setopt_array($ch, $options);
        $result = curl_exec($ch);
        //var_dump(curl_getinfo($ch));
        $res = json_decode($result,true);
        curl_close($ch);
        if ($res["code"] == 0){
            $this->success('推送成功,共推送('.count($post["sites"]).')条记录');
        }else{
            $this->error($res["message"]);
        }
    }

    /**
     * shenma推送       walle
     */
    public function shenmasend(){
        $param = input();

        if ( empty($param["site_shenma_username"]) || empty($param["site_shenma_domain"]) || empty($param["site_shenma_token"]) || empty($param["site_shenma_send_url"]) || empty($param["send_urls"])){
            return $this->error(lang('param_err'));
        }

        $send_urls = trim(trim($param["send_urls_s"]),',').','.trim(trim($param["send_urls"]),',').',';
        $send_urls = trim(trim($send_urls),',');
        $urls = explode(",",$send_urls);
        if (empty($urls)){
            return $this->error(lang('param_err'));
        }

        $api = $param["site_shenma_send_url"];
        $ch = curl_init();
        $options = array(
            CURLOPT_URL => $api,
            CURLOPT_POST => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POSTFIELDS => implode("\n", trim($urls)),
            CURLOPT_HTTPHEADER => array('Content-Type: text/plain'),
        );
        curl_setopt_array($ch, $options);
        $result = curl_exec($ch);
        curl_close($ch);
        $res = json_decode($result,true);
        if ($res["success"]){
            $this->success('推送成功,共推送('.$res["success"].')条记录');
        }else{
            $this->error($res["message"]);
        }
    }
}