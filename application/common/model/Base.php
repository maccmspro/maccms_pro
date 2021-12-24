<?php
namespace app\common\model;
use think\Model;
use think\Db;
use think\Cache;

class Base extends Model {
    protected $primaryId;
    protected $readFromMaster;

    //自定义初始化
    protected function initialize()
    {
        //需要调用`Model`的`initialize`方法
        parent::initialize();
        // 自定义的初始化
        $this->primaryId = $this->primaryId ?? $this->name . '_id';
        $this->readFromMaster = $this->readFromMaster ?? false;
        // 表创建或修改
        if (method_exists($this, 'createTableIfNotExists')) {
            $this->createTableIfNotExists();
        }
    }

    public function getOne($id, $fields = "*")
    {
        $query_object = $this;
        if ($this->readFromMaster === true) {
            $query_object = $query_object->master();
        }
        $object = $query_object->where($this->primaryId, $id)->field($fields)->find();
        if (!$object) {
            return [];
        }
        return $object->getData();
    }

    public function getOneByCond($cond, $orderby = '', $fields = '*')
    {
        $orderby = $orderby ?: ($this->primaryId . " DESC");
        $query_object = $this;
        if ($this->readFromMaster === true) {
            $query_object = $query_object->master();
        }
        $object = $query_object->where($cond)->field($fields)->order($orderby)->find();
        if (!$object) {
            return [];
        }
        return $object->getData();
    }

    public function getValueByCond($cond, $field, $orderby = '') {
        $query_object = $this;
        if ($this->readFromMaster === true) {
            $query_object = $query_object->master();
        }
        $object = $query_object->getOneByCond($cond, $orderby, $field);
        return $object[$field] ?? '';
    }

    public function updateByCond($cond, $data)
    {
        $res = $this->allowField(true)->where($cond)->update($data);
        if (false === $res) {
            return ['code' => 1004, 'msg' => '更新失败：' . $this->getError()];
        }
        return ['code' => 1, 'msg' => '更新成功'];
    }

    public function getSumByCond($cond, $field)
    {
        $query_object = $this;
        if ($this->readFromMaster === true) {
            $query_object = $query_object->master();
        }
        return $query_object->where($cond)->sum($field);
    }

    public function getListByCond($offset, $limit, $cond, $orderby = '', $fields = "*", $transform = false)
    {
        $orderby = $orderby ?: ($this->primaryId . " DESC");
        $query_object = $this;
        if ($this->readFromMaster === true) {
            $query_object = $query_object->master();
        }
        $list = $query_object->where($cond)->field($fields)->order($orderby)->limit($offset . ',' . $limit)->select();
        if (!$list) {
            return [];
        }
        $final = [];
        foreach ($list as $row) {
            $row_array = $row->getData();
            if ($transform !== false) {
                $row_array = $this->transformRow($row_array, $transform);
            }
            $final[] = $row_array;
        }
        return $final;
    }

    public function getAllByCond($cond, $orderby = '', $fields = "*", $transform = false)
    {
        $orderby = $orderby ?: ($this->primaryId . " DESC");
        return $this->getListByCond(0, 999999, $cond, $orderby, $fields, $transform);
    }

    public function getCountByCond($cond) {
        $query_object = $this;
        if ($this->readFromMaster === true) {
            $query_object = $query_object->master();
        }
        return (int)$query_object->where($cond)->count();
    }

    public function transformRow($row, $extends = []) {
        return $row;
    }

    public function rawUpdate($primary_id, $data)
    {
        $res = $this->allowField(true)->where([$this->primaryId => $primary_id])->update($data);
        if ($res === false) {
            return ['code' => 1002, 'msg' => '更新失败' . $this->getError()];
        }
        return ['code' => 1, 'msg' => '更新成功'];
    }

    public function rawInsert($data) {
        $res = $this->allowField(true)->insert($data);
        if(false === $res){
            return ['code' => 1004, 'msg'=>'保存失败：' . $this->getError() ];
        }
        return ['code' => 1,'msg' => '保存成功'];
    }

    public function delData($where)
    {
        $res = $this->where($where)->delete();
        if($res===false){
            return ['code'=>1001,'msg'=>lang('del_err').'：'.$this->getError() ];
        }
        return ['code'=>1,'msg'=>lang('del_ok')];
    }

    /**
     * 锁定表更新（通过缓存）
     * 
     * @param  int $version 
     */
    protected function lockTableUpdate($version) {
        $cache_key = 'tbl:lock:' . config('database.prefix') . $this->name . ':v1:' . $version;
        if (Cache::get($cache_key)) {
            return true;
        }
        Cache::set($cache_key, 'locked', 50 * 365 * 86400);
        return false;
    }

    /**
     * 检查更新字段，确认后执行更新
     */
    protected function checkAndAlterTableField($field, $alter, $is_add = true) {
        $has_field = !empty(Db::execute("DESCRIBE " . config('database.prefix') . $this->name . " `{$field}`"));
        if (($is_add && !$has_field) || (!$is_add && $has_field)) {
            $sql = "ALTER TABLE " . config('database.prefix') . $this->name . " {$alter}";
            Db::execute($sql);
        }
    }
}
