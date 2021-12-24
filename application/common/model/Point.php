<?php
namespace app\common\model;
use think\Db;

class Point extends Base {
    // 设置数据表（不含前缀）
    protected $name = 'point';

    public function createTableIfNotExists() {
        if ($this->lockTableUpdate(1) === true) {
            return true;
        }
        if (!Db::execute("SHOW TABLES LIKE '". config('database.prefix') . $this->name ."'")) {
            $sql = "CREATE TABLE `". config('database.prefix') . $this->name ."` (
                `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '主键自增',
                `type_id` int(11) NULL DEFAULT NULL COMMENT '类型',
                `score` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL COMMENT '分数',
                `create_time` int(11) NULL DEFAULT NULL COMMENT '创建时间',
                `detail_id` int(11) NULL DEFAULT NULL COMMENT '默认ID',
                PRIMARY KEY (`id`) USING BTREE,
                INDEX `type_id`(`type_id`) USING BTREE
                ) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '视频评分' ROW_FORMAT = COMPACT;";
            Db::execute($sql);
        }
    }

}