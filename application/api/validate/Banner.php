<?php

namespace app\api\validate;

use think\Validate;

class Banner extends Validate
{
    protected $rule = [
        'offset'      => 'number|between:0,' . PHP_INT_MAX,
        'limit'      => 'number|between:0,' . PHP_INT_MAX,
        'banner_stime_end'      => 'number|between:1,' . PHP_INT_MAX,
        'banner_stime_start'      => 'number|between:1,' . PHP_INT_MAX,
        'banner_etime_end'      => 'number|between:1,' . PHP_INT_MAX,
        'banner_etime_start'      => 'number|between:1,' . PHP_INT_MAX,
        'id'      => 'number|between:1,' . PHP_INT_MAX,
        'banner_id'      => 'require|number|between:1,' . PHP_INT_MAX,
        'pic'      => 'number|between:1,' . PHP_INT_MAX,
        'title'      => 'max:30',
        'link'      => 'max:30',
        'cat'      => 'max:30',
        'type'      => 'number|between:1,10',
        'status'      => 'number|between:1,10',
        'order'      => 'in|id,etime,stime',
    ];

    protected $message = [
        
    ];

    protected $scene = [
        'get_list' => [
            'offset',
            'limit',
            'banner_stime_start',
            'banner_stime_end',
            'banner_etime_start',
            'banner_etime_end',
            'id',
            'pic',
            'title',
            'link',
            'cat',
            'type',
            'status',
            'order',
        ],
        'get_detail' => [
            'banner_id',
        ],
    ];
}
