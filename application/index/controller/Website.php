<?php
namespace app\index\controller;
use think\Controller;
use think\Db;

class Website extends Base
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        return $this->label_fetch('website/index');
    }

    public function type()
    {
        $info = $this->label_type();
        return $this->label_fetch( mac_tpl_fetch('website',$info['type_tpl'],'type') );
    }

    public function show()
    {
        $this->check_show();
        return $this->label_fetch('website/show');
    }

    public function ajax_show()
    {
        $this->check_ajax();
        $this->check_show(1);
        $info = $this->label_type();
        return $this->label_fetch('website/ajax_show');
    }

    public function search()
    {
        $param = mac_param_url();
        $this->check_search($param);
        $this->label_search($param);
        return $this->label_fetch('website/search');
    }

    public function ajax_search()
    {
        $param = mac_param_url();
        $this->check_ajax();
        $this->check_search($param,1);
        $this->label_search($param);
        return $this->label_fetch('website/ajax_search');
    }

    public function detail()
    {
        $info = $this->label_website_detail();
        $return = [];

        $res = model('Point')->where(['type_id' => 11,'detail_id' => $info['website_id']])->column('score');
        $count = model('Point')->where(['type_id' => 11,'detail_id' => $info['website_id']])->count();
        $return['count'] = $count;
        $total = 0;

        foreach ($res as $index => $value) {
            $total += (float) $value;
        }

        $return['vod_score_num'] = $count;

        if($count){
            $return['vod_score'] = round($total/$count,2);

            $_1 = Db::table('mac_point')->where(['type_id' => 11,'detail_id' => $info['website_id']])->where('score','between',[0,2])->count();
            $_2 = Db::table('mac_point')->where(['type_id' => 11,'detail_id' => $info['website_id']])->where('score','between',[2,4])->count();
            $_3 = Db::table('mac_point')->where(['type_id' => 11,'detail_id' => $info['website_id']])->where('score','between',[4,6])->count();
            $_4 = Db::table('mac_point')->where(['type_id' => 11,'detail_id' => $info['website_id']])->where('score','between',[6,8])->count();
            $_5 = Db::table('mac_point')->where(['type_id' => 11,'detail_id' => $info['website_id']])->where('score','between',[8,10])->count();

            $return['0-2'] = (round($_1/$count,2)*100).'%';
            $return['2-4'] = (round($_2/$count,2)*100).'%';
            $return['4-6'] = (round($_3/$count,2)*100).'%';
            $return['6-8'] = (round($_4/$count,2)*100).'%';
            $return['8-10'] = (round($_5/$count,2)*100).'%';
        }else{
            $return['website_score'] = 0;
            $return['0-2'] = 0;
            $return['2-4'] = 0;
            $return['4-6'] = 0;
            $return['6-8'] = 0;
            $return['8-10'] = 0;
        }

        return $this->label_fetch( mac_tpl_fetch('website',$info['website_tpl'],'detail') ,1 ,'html',['res' => $return]);
    }

    public function ajax_detail()
    {
        $this->check_ajax();
        $info = $this->label_website_detail();
        return $this->label_fetch('website/ajax_detail');
    }

    public function rss()
    {
        $info = $this->label_website_detail();
        return $this->label_fetch('website/rss');
    }

    public function saveData()
    {

    }

}
