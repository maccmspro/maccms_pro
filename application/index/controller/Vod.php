<?php
namespace app\index\controller;

use think\Request;
use think\Cache;

class Vod extends Base
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        return $this->label_fetch('vod/index');
    }

    public function type(Request $request)
    {
        $param = $request->param();

        $encode = md5(json_encode($param));

        $cache_for_id_data = Cache::get('index_vod_type_' . $encode);

        if (empty($cache_for_id_data)) {
            $vod_class = model('type')->where(['type_id' => isset($param['id']) ? $param['id'] : 1])->column('type_extend');
            $vod_class = explode(',', json_decode($vod_class[0])->class);
            $info = $this->label_type();
            $cache_data = ['info' => $info, 'vod_class' => $vod_class];
            Cache::set('index_vod_type_' . $encode, $cache_data, 60);
        }else{
            $info = $cache_for_id_data['info'];
            $vod_class = $cache_for_id_data['vod_class'];
        }

        return $this->label_fetch( mac_tpl_fetch('vod',$info['type_tpl'],'type') , 1 , 'html', [
            'vod_class' => $vod_class,
            'info' => $info,
        ]);

    }

    public function show()
    {
//        $this->check_show(1);
        $info = $this->label_type();
        return $this->label_fetch( mac_tpl_fetch('vod',$info['type_tpl_list'],'show') );
    }

    public function ajax_show()
    {
        $this->check_ajax();
//        $this->check_show(1);
        $info = $this->label_type();
        return $this->label_fetch('vod/ajax_show');
    }

    public function search()
    {
        $param = mac_param_url();
        $this->check_search($param);
        $this->label_search($param);
        return $this->label_fetch('vod/search');
    }

    public function search_content()
    {
        $param = mac_param_url();
        $this->label_search($param);
        return $this->label_fetch('vod/search');
    }

    public function ajax_search()
    {
        $param = mac_param_url();
        $this->check_ajax();
        $this->check_search($param,1);
        $this->label_search($param);
        return $this->label_fetch('vod/ajax_search');
    }

    public function detail()
    {
        $info = $this->label_vod_detail();
        if($info['vod_copyright']==1 && !empty($info['vod_jumpurl']) && $GLOBALS['config']['app']['copyright_status']==2){
            return $this->label_fetch('vod/copyright');
        }
        if(!empty($info['vod_pwd']) && session('1-1-'.$info['vod_id'])!='1'){
            return $this->label_fetch('vod/detail_pwd');
        }

        $return = [];
        $res = model('Point')->where(['type_id' => 1,'detail_id' => $info['vod_id']])->column('score');
        $count = model('Point')->where(['type_id' => 1,'detail_id' => $info['vod_id']])->count();
        $return['count'] = $count;
        $total = 0;

        foreach ($res as $index => $value) {
            $total += (float) $value;
        }

        $return['vod_score_num'] = $count;

        if($count){
            $return['vod_score'] = round($total/$count,2);

            $_1 = model('Point')->where(['type_id' => 1,'detail_id' => $info['vod_id']])->where('score','between',[0,2])->count();
            $_2 = model('Point')->where(['type_id' => 1,'detail_id' => $info['vod_id']])->where('score','between',[2,4])->count();
            $_3 = model('Point')->where(['type_id' => 1,'detail_id' => $info['vod_id']])->where('score','between',[4,6])->count();
            $_4 = model('Point')->where(['type_id' => 1,'detail_id' => $info['vod_id']])->where('score','between',[6,8])->count();
            $_5 = model('Point')->where(['type_id' => 1,'detail_id' => $info['vod_id']])->where('score','between',[8,10])->count();

            $return['0-2'] = (round($_1/$count,2)*100).'%';
            $return['2-4'] = (round($_2/$count,2)*100).'%';
            $return['4-6'] = (round($_3/$count,2)*100).'%';
            $return['6-8'] = (round($_4/$count,2)*100).'%';
            $return['8-10'] = (round($_5/$count,2)*100).'%';
        }else{
            $return['vod_score'] = 0;
            $return['0-2'] = 0;
            $return['2-4'] = 0;
            $return['4-6'] = 0;
            $return['6-8'] = 0;
            $return['8-10'] = 0;
        }

        $param = mac_param_url();

        $trysee = $GLOBALS['config']['user']['trysee'];

        if($info['vod_is_trysee'] >0){
            $trysee = $info['vod_is_trysee'];
        }

        $popedom = $this->check_user_popedom($info['type_id'], 3,$param,'player',$info,$trysee);

        return $this->label_fetch(mac_tpl_fetch('vod',$info['vod_tpl'],'detail') , 1 ,'html', ['res' => $return,'popedom' => $popedom]);
    }

    public function ajax_detail()
    {
        $this->check_ajax();
        $info = $this->label_vod_detail();
        return $this->label_fetch('vod/ajax_detail');
    }

    public function copyright()
    {
        $info = $this->label_vod_detail();
        return $this->label_fetch('vod/copyright');
    }

    public function role()
    {
        $info = $this->label_vod_role();
        return $this->label_fetch('vod/role');
    }

    public function play()
    {
        $info = $this->label_vod_play('play');
        if ($info['vod_copyright'] == 1 && $GLOBALS['config']['app']['copyright_status'] == 3) {
            return $this->label_fetch('vod/copyright');
        }
        $param = mac_param_url();
        if ($GLOBALS['user']['user_id']) {
            $where['ulog_rid'] = $param['id'];
            $where['ulog_nid'] = $param['nid'];
            $where['ulog_sid'] = $param['sid'];
            $where['user_id'] = $GLOBALS['user']['user_id'];
            $where['ulog_type'] = 4;
            $res = model('Ulog')->infoData($where);
            if ($res['code'] > 1) {
                $data['ulog_mid'] = intval($info['type']['type_mid']);
                $data['ulog_rid'] = intval($param['id']);
                $data['ulog_sid'] = intval($param['sid']);
                $data['ulog_nid'] = intval($param['nid']);
                $data['user_id'] = $GLOBALS['user']['user_id'];
                $data['ulog_type'] = 4;
                $data['ulog_point'] = $info['vod_point'];
                model('Ulog')->saveData($data);
            }
        }
        return $this->label_fetch( mac_tpl_fetch('vod',$info['vod_tpl_play'],'play') );
    }

    public function player()
    {
        $info = $this->label_vod_play('play',[],0,1);
        // 试看权限补充 START
        $param = mac_param_url();
        $trysee = $GLOBALS['config']['user']['trysee'];
        if($info['vod_is_trysee'] >0){
            $trysee = $info['vod_is_trysee'];
        }
        $popedom = $this->check_user_popedom($info['type_id'], 3,$param,'player',$info,$trysee);
        if ($popedom['code'] != 3002) {
            echo $this->error($popedom['msg'], mac_url('user/index') );
            die;
        }
        // 试看权限补充 END
        if($info['vod_copyright']==1 && $GLOBALS['config']['app']['copyright_status']==4){
            return $this->label_fetch('vod/copyright');
        }
        if(!empty($info['vod_pwd_play']) && session('1-4-'.$info['vod_id'])!='1'){
            return $this->label_fetch('vod/player_pwd');
        }
        return $this->label_fetch('vod/player');
    }

    public function down()
    {
        $info = $this->label_vod_play('down');
        if ($GLOBALS['user']['user_id']) {
            $param = mac_param_url();
            $where['ulog_rid'] = (int) $param['id'];
            $where['ulog_nid'] = (int) $param['nid'];
            $where['ulog_sid'] = (int) $param['sid'];
            $where['user_id'] = $GLOBALS['user']['user_id'];
            $where['ulog_type'] = 5;
            $res = model('Ulog')->infoData($where);
            if ($res['code'] > 1) {
                $data['ulog_mid'] = intval($info['type']['type_mid']);
                $data['ulog_rid'] = intval($param['id']);
                $data['ulog_sid'] = intval($param['sid']);
                $data['ulog_nid'] = intval($param['nid']);
                $data['user_id'] = $GLOBALS['user']['user_id'];
                $data['ulog_type'] = 5;
                $data['ulog_point'] = $info['vod_point'];
                model('Ulog')->saveData($data);
            }
        }
        return $this->label_fetch( mac_tpl_fetch('vod',$info['vod_tpl_down'],'down'));
    }

    public function downer()
    {
        $info = $this->label_vod_play('down');
        if(!empty($info['vod_pwd_down']) && session('1-5-'.$info['vod_id'])!='1'){
            return $this->label_fetch('vod/downer_pwd');
        }
        return $this->label_fetch('vod/downer');
    }

    public function rss()
    {
        $info = $this->label_vod_detail();
        return $this->label_fetch('vod/rss');
    }

    public function plot()
    {
        $info = $this->label_vod_detail();
        return $this->label_fetch('vod/plot');
    }

    public function last_vod()
    {
        cookie('is_last_vod',true);
        $info = $this->label_type();
        return $this->label_fetch('map/index');
    }

}
