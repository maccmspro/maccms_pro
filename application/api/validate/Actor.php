<?php

namespace app\api\validate;

use think\Validate;

class Actor extends Validate
{
    protected $rule = [
        'actor_id'      => 'require|number|between:1,' . PHP_INT_MAX,
        'offset'      => 'number|between:1,' . PHP_INT_MAX,
        'limit'      => 'number|between:1,' . PHP_INT_MAX,
        'id'      => 'number|between:1,' . PHP_INT_MAX,
        'type_id'      => 'number|between:1,100',
        'sex' =>  'in:男,女',
        'area' =>  'max:255',
        'letter'      => 'max:1',
        'level'      => 'max:1',
        'name'      => 'max:20',
        'blood'      => 'max:10',
        'starsign'      => 'max:255',
        'time_end'      => 'number|between:1,' . PHP_INT_MAX,
        'time_start'      => 'number|between:1,' . PHP_INT_MAX,
//        'en'      => 'max:20',
//        'alias'      => 'max:20',
//        'status'      => 'number|between:1,9',
//        'color'      => 'max:6',
//        'blurb'      => 'max:50',
//        'remarks'      => 'max:50',
//        'weight'      => 'max:10',
//        'height'      => 'max:10',
//        'birthday'      => 'max:10',
//        'birtharea'      => 'max:20',
        'orderby' => 'in:hits,hits_month,hits_week,hits_day,time',

    ];

    protected $message = [
        
    ];

    protected $scene = [
        'get_list' => [
            'offset',
            'limit',
            'id',
            'type_id',
            'sex',
            'area',
            'letter',
            'level',
            'name',
            'blood',
            'starsign',
            'orderby',
        ],
        'get_detail' => [
            'actor_id',
        ],
    ];
}
