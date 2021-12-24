<?php

namespace app\api\controller;

use think\Db;
use think\Request;

class Banner extends Base
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {

    }

    /**
     *  获取列表
     *
     * @param Request $request
     * @return \think\response\Json
     */
    public function get_list(Request $request)
    {
        // 参数校验
        $param = $request->param();
        $validate = validate($request->controller());
        if (!$validate->scene($request->action())->check($param)) {
            return json([
                'code' => 1001,
                'msg'  => '参数错误: ' . $validate->getError(),
            ]);
        }
        $offset = isset($param['offset']) ? (int)$param['offset'] : 0;
        $limit = isset($param['limit']) ? (int)$param['limit'] : 20;
        // 查询条件组装
        $where = [];

        if (isset($param['id'])) {
            $where['banner_id'] = (int)$param['id'];
        }

        if (isset($param['pic'])) {
            $where['banner_pic'] = (int)$param['pic'];
        }

        if (isset($param['type'])) {
            $where['banner_type'] = (int)$param['type'];
        }

        if (isset($param['status'])) {
            $where['banner_status'] = (int)$param['status'];
        }

        if (isset($param['title']) && strlen($param['title']) > 0) {
            $where['banner_title'] = ['like', '%' . format_sql_string($param['title']) . '%'];
        }

        if (isset($param['link']) && strlen($param['link']) > 0) {
            $where['banner_link'] = ['like', '%' . format_sql_string($param['link']) . '%'];
        }

        if (isset($param['cat']) && strlen($param['cat']) > 0) {
            $where['banner_cat'] = ['like', '%' . format_sql_string($param['cat']) . '%'];
        }

        if (isset($param['banner_stime_end']) && isset($param['banner_stime_start'])) {
            $where['banner_stime'] = ['between', [(int)$param['banner_stime_start'], (int)$param['banner_stime_end']]];
        }elseif (isset($param['banner_stime_end'])) {
            $where['banner_stime'] = ['<', (int)$param['banner_stime_end']];
        }elseif (isset($param['banner_stime_start'])) {
            $where['banner_stime'] = ['>', (int)$param['banner_stime_start']];
        }

        if (isset($param['banner_etime_end']) && isset($param['banner_etime_start'])) {
            $where['banner_etime'] = ['between', [(int)$param['banner_etime_start'], (int)$param['banner_etime_end']]];
        }elseif (isset($param['banner_etime_end'])) {
            $where['banner_etime'] = ['<', (int)$param['banner_etime_end']];
        }elseif (isset($param['banner_etime_start'])) {
            $where['banner_etime'] = ['>', (int)$param['banner_etime_start']];
        }

        // 数据获取
        $total = model('Banner')->getCountByCond($where);
        $list = [];
        if ($total > 0) {
            // 排序
            $order = "banner_id DESC";
            if (strlen($param['orderby']) > 0) {
                $order = 'banner_' . $param['orderby'] . " DESC";
            }
            $field = '*';
            $list = model('Banner')->getListByCond($offset, $limit, $where, $order, $field, []);
        }
        // 返回
        return json([
            'code' => 1,
            'msg'  => '获取成功',
            'info' => [
                'offset' => $offset,
                'limit'  => $limit,
                'total'  => $total,
                'rows'   => $list,
            ],
        ]);
    }

    /**
     * 查询详情
     *
     * @return \think\response\Json
     */
    public function get_detail(Request $request)
    {
        $param = $request->param();
        $validate = validate($request->controller());
        if (!$validate->scene($request->action())->check($param)) {
            return json([
                'code' => 1001,
                'msg'  => '参数错误: ' . $validate->getError(),
            ]);
        }

        $res = Db::table('mac_banner')->where(['banner_id' => $param['banner_id']])->select();

        // 返回
        return json([
            'code' => 1,
            'msg'  => '获取成功',
            'info' => $res
        ]);
    }
}
