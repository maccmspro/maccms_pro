<?php

namespace app\admin\controller;

class Others extends Base
{

    public function botlist(){
        $day_arr =[];
        //列出最近10天的日期
        for($i=0;$i<10;$i++){
            $day_arr[$i] = date('Y-m-d',time()-$i*60*60*24);
        }
        foreach ($day_arr as $day_vo){
            if (file_exists(ROOT_PATH . 'runtime/log/bot/'.$day_vo.'.txt')){
                $bot_content = file_get_contents(ROOT_PATH . 'runtime/log/bot/'.$day_vo.'.txt');
            }else{
                $bot_content = '';
            }
            $bot_list[$day_vo] = [
                'Google'=>substr_count($bot_content,'Google'),
                //'Google Adsense'=>substr_count($bot_content,'Google Adsense'),
                'Baidu'=>substr_count($bot_content,'Baidu'),
                'Sogou'=>substr_count($bot_content,'Sogou'),
                //'Sogou web'=>substr_count($bot_content,'Sogou web'),
                'SOSO'=>substr_count($bot_content,'SOSO'),
                'Yahoo'=>substr_count($bot_content,'Yahoo'),
                'MSN'=>substr_count($bot_content,'MSN'),
                'msnbot'=>substr_count($bot_content,'msnbot'),
                'Sohu'=>substr_count($bot_content,'Sohu'),
                'Yodao'=>substr_count($bot_content,'Yodao'),
                'Twiceler'=>substr_count($bot_content,'Twiceler'),
                //'Alexa_'=>substr_count($bot_content,'Alexa_'),
                'Alexa'=>substr_count($bot_content,'Alexa'),
                //'雅虎'=>substr_count($bot_content,'雅虎'),
            ];

        }
        //$bot_content = file_get_contents('bot.txt');
        //$bot_list = array_slice(array_reverse(explode("\r\n",trim($bot_content))),0,20);
        $this->assign('bot_list',$bot_list);
        return $this->fetch('admin@others/botlist');
    }

    public function botlog(){
        $parm = input();
        $data = $parm['data'];
        $bot_content = file_get_contents(ROOT_PATH . 'runtime/log/bot/'.$data.'.txt');
        $bot_list = array_slice(array_reverse(explode("\r\n",trim($bot_content))),0,20);
        $this->assign('bot_list',$bot_list);
        return $this->fetch('admin@others/botlog');
    }

}
