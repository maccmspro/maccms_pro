<?php

namespace app\common\model;

use think\Db;
use think\Config as ThinkConfig;

class Config extends Base {
    // 设置数据表（不含前缀）
    protected $name = 'config';

    //自定义初始化
    protected function initialize()
    {
        parent::initialize();
    }

    public function createTableIfNotExists() {
        if ($this->lockTableUpdate(0) === true) {
            return true;
        }
        if (!Db::execute("SHOW TABLES LIKE '". config('database.prefix') . $this->name ."'")) {
            $sql = "CREATE TABLE `". config('database.prefix') . $this->name ."` (
                `config_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
                `config_key` varchar(200) DEFAULT NULL,
                `config_value` longtext DEFAULT NULL,
                PRIMARY KEY (`config_id`),
                UNIQUE KEY `config_key` (`config_key`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=1 COMMENT='配置表';";
            Db::execute($sql);
        }
    }
}
