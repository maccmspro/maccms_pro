<?php
namespace app\admin\controller;

class App extends Base
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $param = input();
        $param['page'] = intval($param['page']) < 1 ? 1 : $param['page'];
        $param['limit'] = intval($param['limit']) < 1 ? $this->_pagesize : $param['limit'];

        $order='id desc';
        $res = model('App')->listData([],$order,$param['page'],$param['limit']);


        $this->assign('list', $res['list']);
        $this->assign('total', $res['total']);
        $this->assign('page', $res['page']);
        $this->assign('limit', $res['limit']);

        $param['page'] = '{page}';
        $param['limit'] = '{limit}';
        $this->assign('param', $param);

        $this->assign('title', lang('admin/app/title'));
        return $this->fetch('admin@app/index');
    }

    /**
     * 添加视图
     */
    public function add(){
        return $this->fetch('admin@app/add');
    }

    public function doadd(){
        $param = input('post.');
        $res = model('App')->saveData($param);
        if($res['code']>1){
            return $this->error($res['msg']);
        }
        return $this->success(lang('save_ok'));
    }

    public function edit(){
        $param = input();
        if(empty($param["id"])){
            return $this->error(lang('param_err'));
        }

        $info = model("App")->where(["id"=>["eq",$param["id"]]])->find();
        $this->assign('info', $info);

        return $this->fetch('admin@app/edit');
    }

    public function doedit(){
        $param = input('post.');
        $res = model('App')->saveData($param);
        if($res['code']>1){
            return $this->error($res['msg']);
        }
        return $this->success(lang('save_ok'));
    }

    public function del(){
        $param = input();
        if(empty($param["id"])){
            return $this->error(lang('param_err'));
        }

        $res = model("App")->where(["id"=>["eq",$param["id"]]])->delete();
        return $this->success("删除成功");
    }
}