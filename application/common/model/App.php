<?php
namespace app\common\model;
use think\Db;
use think\Cache;
use app\common\util\Pinyin;

class App extends Base {
    // 设置数据表（不含前缀）
    protected $name = 'app';

    // 定义时间戳字段名
    protected $createTime = 'create_time';
    protected $updateTime = 'update_time';
    protected $autoWriteTimestamp = true;

    // 自动完成
    protected $auto       = [];
    protected $insert     = [];
    protected $update     = [];

    /**
     * 根据条件查询记录个数   作者:walle
     * @param $where
     * @return int|string
     * @throws \think\Exception
     */
    public function countData($where)
    {
        $total = $this->where($where)->count();
        return $total;
    }

    /**
     * 根据条件查询记录列表     作者:walle
     * @param $where
     * @param $order
     * @param int $page
     * @param int $limit
     * @param int $start
     * @param string $field
     * @param int $totalshow
     * @return array
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function listData($where,$order,$page=1,$limit=20,$start=0,$field='*',$totalshow=1)
    {
        if(!is_array($where)){
            $where = json_decode($where,true);
        }
        $limit_str = ($limit * ($page-1) + $start) .",".$limit;
        if($totalshow==1) {
            if ($where){
                $total = $this->where($where)->count();
            }else{
                $total = $this->count();
            }

        }
        $list = [];
        if ($where){
            $list = $this->where($where)->order($order)->limit($limit_str)->select();
        }else{
            $list = $this->order($order)->limit($limit_str)->select();
        }

        return ['code'=>1,'msg'=>'数据列表','page'=>$page,'pagecount'=>ceil($total/$limit),'limit'=>$limit,'total'=>$total,'list'=>$list];
    }

    public function saveData($data)
    {
        $user = model('Admin')->checkLogin();
        $data['user_id'] = $user['info']['admin_id'];
        if($data['id']){
            $data['update_time'] = time();
            return $this->save($data,["id"=>["eq",$data['id']]]);
        }else{
            $data['create_time'] = time();
            $data['update_time'] = time();
            return $this->insert($data);
        }
    }

    /**
     * 测试过程中没有安装表结构的话,自动创建表结构
     * @return bool
     */
    public function createTableIfNotExists() {
        if ($this->lockTableUpdate(1) === true) {
            return true;
        }
        if (!Db::execute("SHOW TABLES LIKE '". config('database.prefix') . $this->name ."'")) {
            $sql = "CREATE TABLE `". config('database.prefix') . $this->name ."` (
                `id` int(13) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键自增',
                `name` varchar(255) DEFAULT NULL COMMENT 'app名称',
                `ver_num` varchar(255) DEFAULT NULL COMMENT '版本号',
                `type` tinyint(1) unsigned NOT NULL COMMENT '类别,1:ios,2:Android',
                `is_force_update` tinyint(1) unsigned DEFAULT NULL COMMENT '是否强制更新,0:不强制,1:强制',
                `down_type` tinyint(1) unsigned DEFAULT NULL COMMENT '下载类型,1:应用商店,2:url地址',
                `down_url` varchar(2000) DEFAULT NULL COMMENT '下载地址,或应用商店地址',
                `content` varchar(2000) DEFAULT NULL COMMENT 'app版本说明,升级说明',
                `user_id` int(13) unsigned DEFAULT NULL COMMENT '后台操作员',
                `create_time` int(13) unsigned DEFAULT NULL COMMENT '添加时间',
                `update_time` int(13) unsigned DEFAULT NULL COMMENT '更新时间',
                PRIMARY KEY (`id`)
              ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='App版本管理';";
            Db::execute($sql);
        }
    }
}