<?php
namespace app\common\extend\urlsend;

use think\Cache;

class Baidufast {

    public $name = '百度推送快速';
    public $ver = '1.0';

    public function submit($data)
    {
        $token = $GLOBALS['config']['urlsend']['baidufast']['token'];
        $site = $GLOBALS['http_type'] . $GLOBALS['config']['site']['site_url'];
        $api = 'http://data.zz.baidu.com/urls?site='.$site.'&token='.$token.'&type=daily';

        $head = ['Content-Type: text/plain'];
        $post = implode("\n", $data['urls']);

        $r = mac_curl_post($api, $post, $head);
        $json = json_decode($r,true);
        if(!$json){
            return ['code'=>101,'msg'=>lang_web('request_failed')];
        }
        elseif($json['error']){
            return ['code'=>102,'msg'=>lang_web('error_occurred'). $json['message'] ];
        }
        elseif($json['remain'] ==0 && $json['success']>0){
            $data = array_slice($data['urls'], 0, $json['success'],true );
            $keys = array_keys($data);
            $this->_lastid = end($keys);

            $data = implode("\n", $data);
            $r = mac_curl_post($api, $data, $head);
            $json = json_decode($r,true);
            if(!$json){
                return ['code'=>103,'msg'=>lang_web('request_failed')];
            }
            elseif($json['error']){
                return ['code'=>104,'msg'=>lang_web('error_occurred'). $json['message'] ];
            }
        }

        return ['code'=>1,'msg'=>lang_web('push_successfully').$json['remain'].lang_web('be_pushed').$json['success'].lang_web('string_gbook_t').'.' ];
    }

}
