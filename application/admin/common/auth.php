<?php
return array(
    '1' => array('name' => lang('menu/index'), 'icon' => 'layui-icon-home', 'sub' => array(
        '11' => array("show"=>1,"name" =>lang('menu/welcome'), 'controller' => 'index', 'action' => 'welcome'),
        '12' => array("show"=>1,"name" =>lang('menu/quickmenu'), 'controller' => 'index', 'action' => 'quickmenu'),

        '1001' => array("show"=>0,"name" => '--'.lang('admin/menu/switch'), 'controller' => 'index', 'action' => 'iframe'),
        '1002' => array("show"=>0,"name" => '--'.lang('admin/menu/clearCache'), 'controller' => 'index', 'action' => 'clear'),
        '1003' => array("show"=>0,"name" => '--'.lang('admin/menu/lock'), 'controller' => 'index', 'action' => 'unlocked'),
        '1004' => array("show"=>0,"name" => '--'.lang('admin/menu/public'), 'controller' => 'index', 'action' => 'select'),
        '1005' => array("show"=>0,"name" => '--'.lang('admin/menu/file'), 'controller' => 'upload', 'action' => 'upload'),
    )),
    '2' => array('name' => lang('menu/system'), 'icon' => 'layui-icon-engine', 'sub' => array(
        '21' => array("show"=>1,'name' => lang('menu/config'), 'controller' => 'system',                'action' => 'config'),
        '210' => array("show"=>1,"name" => lang('menu/configseo'), 'controller' => 'system',            'action' => 'configseo'),
        '211' => array("show"=>1,"name" => lang('menu/configuser'), 'controller' => 'system',           'action' => 'configuser'),
        '212' => array("show"=>1,"name" => lang('menu/configcomment'), 'controller' => 'system',            'action' => 'configcomment'),
        '213' => array("show"=>1,"name" => lang('menu/configupload'), 'controller' => 'system',         'action' => 'configupload'),
        '22' => array("show"=>1,"name" => lang('menu/configurl'), 'controller' => 'system',             'action' => 'configurl'),
        '23' => array("show"=>1,"name" => lang('menu/configplay'), 'controller' => 'system',            'action' => 'configplay'),
        '24' => array("show"=>1,"name" => lang('menu/configcollect'), 'controller' => 'system',         'action' => 'configcollect'),
        '25' => array("show"=>1,"name" => lang('menu/configinterface'), 'controller' => 'system',           'action' => 'configinterface'),
        '26' => array("show"=>1,"name" => lang('menu/configapi'), 'controller' => 'system',         'action' => 'configapi'),
        '27' => array("show"=>1,"name" => lang('menu/configconnect'), 'controller' => 'system',         'action' => 'configconnect'),
        '28' => array("show"=>1,"name" => lang('menu/configpay'), 'controller' => 'system',         'action' => 'configpay'),
        '29' => array("show"=>1,"name" => lang('menu/configweixin'), 'controller' => 'system',          'action' => 'configweixin'),
        '291' => array("show"=>1,"name" => lang('menu/configemail'), 'controller' => 'system',          'action' => 'configemail'),
        '292' => array("show"=>1,"name" => lang('menu/configsms'), 'controller' => 'system',            'action' => 'configsms'),

        '2910' => array("show"=>1,"name" => lang('menu/timming'), 'controller' => 'timming',    'action' => 'index'),
        '2911' => array("show"=>0,'name' => '--'.lang('admin/menu/timing'), 'controller' => 'timming',        'action' => 'info'),
        '2912' => array("show"=>0,'name' => '--'.lang('admin/menu/scheduled'), 'controller' => 'timming',      'action' => 'del'),
        '2913' => array("show"=>0,'name' => '--'.lang('admin/menu/timed'), 'controller' => 'timming',      'action' => 'field'),
        '2920' => array("show"=>1,"name" => lang('menu/domain'), 'controller' => 'domain',  'action' => 'index'),
        '2922' => array("show"=>0,'name' => '--'.lang('admin/menu/station_del'), 'controller' => 'domain',     'action' => 'del'),
        '2923' => array("show"=>0,'name' => '--'.lang('admin/menu/station_exp'), 'controller' => 'domain',     'action' => 'export'),
        '2924' => array("show"=>0,'name' => '--'.lang('admin/menu/station_imp'), 'controller' => 'domain',     'action' => 'import'),
    )),
    '3' => array('name' => lang('menu/base'), 'icon' => 'layui-icon-set', 'sub' => array(
        '31' => array("show"=>1,'name' => lang('menu/type'), 'controller' => 'type',        'action' => 'index'),

        '3101' => array("show"=>0,'name' => '--'.lang('admin/menu/classification_info'), 'controller' => 'type',     'action' => 'info'),
        '3102' => array("show"=>0,'name' => '--'.lang('admin/menu/classification_bat'), 'controller' => 'type',     'action' => 'batch'),
        '3103' => array("show"=>0,'name' => '--'.lang('admin/menu/category'), 'controller' => 'type',       'action' => 'del'),
        '3104' => array("show"=>0,'name' => '--'.lang('admin/menu/classification'), 'controller' => 'type',       'action' => 'field'),
        '3105' => array("show"=>0,'name' => '--'.lang('admin/menu/classification_ext'), 'controller' => 'type',       'action' => 'extend'),

        '32' => array("show"=>1,'name' => lang('menu/topic'), 'controller' => 'topic',      'action' => 'data'),
        '3201' => array("show"=>0,'name' => '--'.lang('admin/menu/thematic_info'), 'controller' => 'topic',        'action' => 'info'),
        '3202' => array("show"=>0,'name' => '--'.lang('admin/menu/thematic_bat'), 'controller' => 'topic',        'action' => 'batch'),
        '3203' => array("show"=>0,'name' => '--'.lang('admin/menu/thematic_del'), 'controller' => 'topic',      'action' => 'del'),
        '3204' => array("show"=>0,'name' => '--'.lang('admin/menu/topic'), 'controller' => 'topic',      'action' => 'field'),

        '33' => array("show"=>1,'name' => lang('menu/link'), 'controller' => 'link',        'action' => 'index'),
        '3301' => array("show"=>0,'name' => '--'.lang('admin/menu/friendsChainInformationMaintenance'), 'controller' => 'link',     'action' => 'info'),
        '3302' => array("show"=>0,'name' => '--'.lang('admin/menu/bulkModificationOfFriendsChain'), 'controller' => 'link',     'action' => 'batch'),
        '3303' => array("show"=>0,'name' => '--'.lang('admin/menu/friendsChainDelete'), 'controller' => 'link',       'action' => 'del'),
        '3304' => array("show"=>0,'name' => '--'.lang('admin/menu/friendsChainStatus'), 'controller' => 'link',       'action' => 'field'),

        '34' => array("show"=>1,'name' => lang('menu/gbook'), 'controller' => 'gbook',      'action' => 'data'),
        '3401' => array("show"=>0,'name' => '--'.lang('admin/menu/messageMaintenance'), 'controller' => 'gbook',        'action' => 'info'),
        '3402' => array("show"=>0,'name' => '--'.lang('admin/menu/deleteMessage'), 'controller' => 'gbook',      'action' => 'del'),
        '3404' => array("show"=>0,'name' => '--'.lang('admin/menu/messageStatus'), 'controller' => 'gbook',      'action' => 'field'),

        '35' => array("show"=>1,'name' => lang('menu/comment'), 'controller' => 'comment',      'action' => 'data'),
        '3501' => array("show"=>0,'name' => '--'.lang('admin/menu/reviewInformationMaintenance'), 'controller' => 'comment',      'action' => 'info'),
        '3502' => array("show"=>0,'name' => '--'.lang('admin/menu/deleteComment'), 'controller' => 'comment',        'action' => 'del'),
        '3504' => array("show"=>0,'name' => '--'.lang('admin/menu/commentStatus'), 'controller' => 'comment',        'action' => 'field'),

        '36' => array("show"=>1,'name' => lang('menu/images'), 'controller' => 'annex',     'action' => 'data'),
        '3604' => array("show"=>0,'name' => '--'.lang('admin/menu/attachmentFolder'), 'controller' => 'annex',     'action' => 'file'),
        '3605' => array("show"=>0,'name' => '--'.lang('admin/menu/attachmentDetection'), 'controller' => 'annex',      'action' => 'check'),
        '3606' => array("show"=>0,'name' => '--'.lang('admin/menu/attachmentDataInitialization'), 'controller' => 'annex',       'action' => 'init'),
        '3601' => array("show"=>0,'name' => '--'.lang('admin/menu/attachmentDeletion'), 'controller' => 'annex',      'action' => 'del'),
        '3602' => array("show"=>0,'name' => '--'.lang('admin/menu/syncPictureOptions'), 'controller' => 'images',       'action' => 'opt'),
        '3603' => array("show"=>0,'name' => '--'.lang('admin/menu/syncPictureMethod'), 'controller' => 'images',       'action' => 'sync'),
    
        '37' => array("show"=>1,'name' => lang('menu/advertising_management'), 'controller' => 'banner',     'action' => 'index'),
        '3701' => array("show"=>0,'name' => '--'.lang('admin/menu/adRemoval'), 'controller' => 'banner',     'action' => 'del'),
        '3702' => array("show"=>0,'name' => '--'.lang('admin/menu/syncPictureOptions'), 'controller' => 'banner',       'action' => 'opt'),
        '3703' => array("show"=>0,'name' => '--'.lang('admin/menu/syncPictureMethod'), 'controller' => 'banner',       'action' => 'sync'),
        '3704' => array("show"=>0,'name' => '--'.lang('admin/menu/adAdd'), 'controller' => 'banner',		'action' => 'info'),
        '3705' => array("show"=>0,'name' => '--'.lang('admin/menu/adPositionAdded'), 'controller' => 'banner',		'action' => 'infocat'),
        '3706' => array("show"=>0,'name' => '--'.lang('admin/menu/adField'), 'controller' => 'banner',		'action' => 'field'),
      
        '38' => array("show"=>1,'name' => lang('menu/app_management'), 'controller' => 'app',       'action' => 'index'),
        '3801' => array("show"=>0,'name' => lang('admin/menu/administration_addView'), 'controller' => 'app',		'action' => 'add'),
        '3802' => array("show"=>0,'name' => lang('admin/menu/administration_processAdd'), 'controller' => 'app',		'action' => 'doadd'),
        '3803' => array("show"=>0,'name' => lang('admin/menu/administration_edit'), 'controller' => 'app',		'action' => 'edit'),
        '3804' => array("show"=>0,'name' => lang('admin/menu/administration_processEditing'), 'controller' => 'app',		'action' => 'doedit'),
        '3805' => array("show"=>0,'name' => lang('admin/menu/administration_delete'), 'controller' => 'app',		'action' => 'del'),
    )),
    '5' => array('name' => lang('menu/art'), 'icon' => 'layui-icon-file', 'sub' => array(
        '51' => array("show"=>1,'name' => lang('menu/art_data'), 'controller' => 'art',     'action' => 'data'),
        '5101' => array("show"=>0,'name' => '--'.lang('admin/menu/articleInformationMaintenance'), 'controller' => 'art',      'action' => 'info'),
        '5102' => array("show"=>0,'name' => '--'.lang('admin/menu/articleDeletion'), 'controller' => 'art',        'action' => 'del'),
        '5103' => array("show"=>0,'name' => '--'.lang('admin/menu/articleStatus'), 'controller' => 'art',        'action' => 'field'),

        '52' => array("show"=>1,'name' => lang('menu/art_add'), 'controller' => 'art',      'action' => 'info'),
        '53' => array("show"=>1,'name' => lang('menu/art_data_lock'), 'controller' => 'art',        'action' => 'data','param'=>'lock=1'),
        '54' => array("show"=>1,'name' => lang('menu/art_data_audit'), 'controller' => 'art',       'action' => 'data','param'=>'status=0'),
        '59' => array("show"=>1,'name' => lang('menu/art_batch'), 'controller' => 'art',        'action' => 'batch'),
        '591' => array("show"=>1,'name' => lang('menu/art_repeat'), 'controller' => 'art',      'action' => 'data', 'param'=>'repeat=1'),
    )),
    '4' => array('name' => lang('menu/vod'), 'icon' => 'layui-icon-video', 'sub' => array(
        '41' => array("show"=>1,'name' => lang('menu/server'), 'controller' => 'vodserver',     'action' => 'index'),
        '4101' => array("show"=>0,'name' => '--'.lang('admin/menu/serverGroupInformationMaintenance'), 'controller' => 'vodserver',      'action' => 'info'),
        '4102' => array("show"=>0,'name' => '--'.lang('admin/menu/serverGroupDeletion'), 'controller' => 'vodserver',        'action' => 'del'),
        '4103' => array("show"=>0,'name' => '--'.lang('admin/menu/serverGroupStatus'), 'controller' => 'vodserver',        'action' => 'field'),

        '42' => array("show"=>1,'name' => lang('menu/player'), 'controller' => 'vodplayer',     'action' => 'index'),
        '4201' => array("show"=>0,'name' => '--'.lang('admin/menu/playerInformationMaintenance'), 'controller' => 'vodplayer',       'action' => 'info'),
        '4202' => array("show"=>0,'name' => '--'.lang('admin/menu/playerDelete'), 'controller' => 'vodplayer',     'action' => 'del'),
        '4203' => array("show"=>0,'name' => '--'.lang('admin/menu/playerGroupStatus'), 'controller' => 'vodplayer',        'action' => 'field'),

        '43' => array("show"=>1,'name' => lang('menu/downer'), 'controller' => 'voddowner',     'action' => 'index'),
        '4301' => array("show"=>0,'name' => '--'.lang('admin/menu/downloaderInformationMaintenance'), 'controller' => 'voddowner',       'action' => 'info'),
        '4302' => array("show"=>0,'name' => '--'.lang('admin/menu/downloaderDelete'), 'controller' => 'voddowner',     'action' => 'del'),
        '4303' => array("show"=>0,'name' => '--'.lang('admin/menu/downloaderGroupStatus'), 'controller' => 'voddowner',        'action' => 'field'),

        '44' => array("show"=>1,'name' => lang('menu/vod_data'), 'controller' => 'vod',     'action' => 'data'),
        '4401' => array("show"=>0,'name' => '--'.lang('admin/menu/videoInformationMaintenance'), 'controller' => 'vod',      'action' => 'info'),
        '4402' => array("show"=>0,'name' => '--'.lang('admin/menu/videoDeletion'), 'controller' => 'vod',        'action' => 'del'),
        '4403' => array("show"=>0,'name' => '--'.lang('admin/menu/videoStatus'), 'controller' => 'vod',        'action' => 'field'),

        '45' => array("show"=>1,'name' => lang('menu/vod_add'), 'controller' => 'vod',      'action' => 'info'),
        '46' => array("show"=>1,'name' => lang('menu/vod_data_url_empty'), 'controller' => 'vod',       'action' => 'data' , 'param'=>'url=1'),
        '47' => array("show"=>1,'name' => lang('menu/vod_data_lock'), 'controller' => 'vod',        'action' => 'data', 'param'=>'lock=1'),
        '48' => array("show"=>1,'name' => lang('menu/vod_data_audit'), 'controller' => 'vod',       'action' => 'data', 'param'=>'status=0'),
        '481' => array("show"=>1,'name' => lang('menu/vod_data_points'), 'controller' => 'vod',     'action' => 'data', 'param'=>'points=1'),
        '482' => array("show"=>1,'name' => lang('menu/vod_data_plot'), 'controller' => 'vod',       'action' => 'data', 'param'=>'plot=1'),
        '49' => array("show"=>1,'name' => lang('menu/vod_batch'), 'controller' => 'vod',        'action' => 'batch'),
        '491' => array("show"=>1,'name' => lang('menu/vod_repeat'), 'controller' => 'vod',      'action' => 'data', 'param'=>'repeat=1'),

        '495' => array("show"=>1,'name' => lang('menu/actor'), 'controller' => 'actor',     'action' => 'data', 'param'=>''),
        '4951' => array("show"=>0,'name' => '--'.lang('admin/menu/actorInformationMaintenance'), 'controller' => 'actor',        'action' => 'info'),
        '4952' => array("show"=>0,'name' => '--'.lang('admin/menu/actorDeletion'), 'controller' => 'actor',      'action' => 'del'),
        '4953' => array("show"=>0,'name' => '--'.lang('admin/menu/actorStatus'), 'controller' => 'actor',      'action' => 'field'),
        '4954' => array("show"=>0,'name' => '--'.lang('admin/menu/addActor'), 'controller' => 'actor',      'action' => 'info'),

        '496' => array("show"=>1,'name' => lang('menu/role'), 'controller' => 'role',       'action' => 'data', 'param'=>''),
        '4961' => array("show"=>0,'name' => '--'.lang('admin/menu/roleInformationMaintenance'), 'controller' => 'role',     'action' => 'info'),
        '4962' => array("show"=>0,'name' => '--'.lang('admin/menu/roleDeletion'), 'controller' => 'role',       'action' => 'del'),
        '4963' => array("show"=>0,'name' => '--'.lang('admin/menu/roleStatus'), 'controller' => 'role',       'action' => 'field'),
        '4964' => array("show"=>0,'name' => '--'.lang('admin/menu/addRole'), 'controller' => 'role',       'action' => 'info'),
    )),
    '12' => array('name' => lang('menu/website'), 'icon' => 'layui-icon-website', 'sub' => array(
        '121' => array("show"=>1,'name' => lang('menu/website_data'), 'controller' => 'website',        'action' => 'data'),
        '12101' => array("show"=>0,'name' => '--'.lang('admin/menu/websiteInformationMaintenance'), 'controller' => 'website',     'action' => 'info'),
        '12102' => array("show"=>0,'name' => '--'.lang('admin/menu/urlDeletion'), 'controller' => 'website',       'action' => 'del'),
        '12103' => array("show"=>0,'name' => '--'.lang('admin/menu/urlStatus'), 'controller' => 'website',       'action' => 'field'),

        '122' => array("show"=>1,'name' => lang('menu/website_add'), 'controller' => 'website',     'action' => 'info'),
        '123' => array("show"=>1,'name' => lang('menu/website_data_lock'), 'controller' => 'website',       'action' => 'data','param'=>'lock=1'),
        '124' => array("show"=>1,'name' => lang('menu/website_data_audit'), 'controller' => 'website',      'action' => 'data','param'=>'status=0'),
        '129' => array("show"=>1,'name' => lang('menu/website_batch'), 'controller' => 'website',       'action' => 'batch'),
        '1291' => array("show"=>1,'name' => lang('menu/website_repeat'), 'controller' => 'website',     'action' => 'data', 'param'=>'repeat=1'),
    )),
    '6' => array('name' => lang('menu/users'), 'icon' => 'layui-icon-user', 'sub' => array(
        '61' => array("show"=>1,'name' => lang('menu/admin'), 'controller' => 'admin',      'action' => 'index'),
        '6101' => array("show"=>0,'name' => '--'.lang('admin/menu/administratorInformationMaintenance'), 'controller' => 'admin',       'action' => 'info'),
        '6102' => array("show"=>0,'name' => '--'.lang('admin/menu/administratorDelete'), 'controller' => 'admin',     'action' => 'del'),
        '6103' => array("show"=>0,'name' => '--'.lang('admin/menu/administratorStatus'), 'controller' => 'admin',     'action' => 'field'),

        '62' => array("show"=>1,'name' => lang('menu/group'), 'controller' => 'group',      'action' => 'index'),
        '6201' => array("show"=>0,'name' => '--'.lang('admin/menu/memberGroupInformationMaintenance'), 'controller' => 'group',       'action' => 'info'),
        '6202' => array("show"=>0,'name' => '--'.lang('admin/menu/memberGroupDeletion'), 'controller' => 'group',     'action' => 'del'),
        '6203' => array("show"=>0,'name' => '--'.lang('admin/menu/memberGroupStatus'), 'controller' => 'group',     'action' => 'field'),

        '63' => array("show"=>1,'name' => lang('menu/user'), 'controller' => 'user',        'action' => 'data'),
        '6301' => array("show"=>0,'name' => '--'.lang('admin/menu/memberInformationMaintenance'), 'controller' => 'user',     'action' => 'info'),
        '6302' => array("show"=>0,'name' => '--'.lang('admin/menu/memberDeletion'), 'controller' => 'user',       'action' => 'del'),
        '6303' => array("show"=>0,'name' => '--'.lang('admin/menu/memberStatus'), 'controller' => 'user',       'action' => 'field'),

        '64' => array("show"=>1,'name' => lang('menu/card'), 'controller' => 'card',        'action' => 'index'),
        '6401' => array("show"=>0,'name' => '--'.lang('admin/menu/rechargeCardInformationMaintenance'), 'controller' => 'card',        'action' => 'info'),
        '6402' => array("show"=>0,'name' => '--'.lang('admin/menu/rechargeCardDeletion'), 'controller' => 'card',      'action' => 'del'),

        '65' => array("show"=>1,'name' => lang('menu/order'), 'controller' => 'order',      'action' => 'index'),
        '6501' => array("show"=>0,'name' => '--'.lang('admin/menu/orderDeletion'), 'controller' => 'order',      'action' => 'del'),

        '66' => array("show"=>1,'name' => lang('menu/ulog'), 'controller' => 'ulog',        'action' => 'index'),
        '6601' => array("show"=>0,'name' => '--'.lang('admin/menu/accessLogDeletion'), 'controller' => 'ulog',     'action' => 'del'),

        '67' => array("show"=>1,'name' => lang('menu/plog'), 'controller' => 'plog',        'action' => 'index'),
        '6701' => array("show"=>0,'name' => '--'.lang('admin/menu/deletePointsLog'), 'controller' => 'plog',     'action' => 'del'),

        '68' => array("show"=>1,'name' => lang('menu/cash'), 'controller' => 'cash',        'action' => 'index'),
        '6801' => array("show"=>0,'name' => '--'.lang('admin/menu/withdrawalDeletion'), 'controller' => 'cash',       'action' => 'del'),
        '6802' => array("show"=>0,'name' => '--'.lang('admin/menu/withdrawalReview'), 'controller' => 'cash',       'action' => 'audit'),
    )),
    '7' => array('name' => lang('menu/templates'), 'icon' => 'layui-icon-template', 'sub' => array(
        '71' => array("show"=>1,'name' => lang('menu/theme/config'), 'controller' => 'tpl_config',     'action' => 'theme', 'param'=>''),
        '72' => array("show"=>1,'name' => lang('menu/template'), 'controller' => 'template',        'action' => 'index'),
        '7201' => array("show"=>0,'name' => '--'.lang('admin/menu/templateInformationMaintenance'), 'controller' => 'template',     'action' => 'info'),
        '7202' => array("show"=>0,'name' => '--'.lang('admin/menu/templateDeletion'), 'controller' => 'template',       'action' => 'del'),
        '73' => array("show"=>1,'name' => lang('menu/template_market'), 'controller' => 'addon',        'action' => 'markettheme'),
        '74' => array("show"=>1,'name' => lang('menu/ads'), 'controller' => 'template',     'action' => 'ads',  'param'=>''),
        '75' => array("show"=>1,'name' => lang('menu/wizard'), 'controller' => 'template',      'action' => 'wizard'),
    )),
    '8' => array('name' => lang('menu/make'), 'icon' => 'layui-icon-component', 'sub' => array(
        '81' => array("show"=>1,'name' => lang('menu/make_opt'), 'controller' => 'make',        'action' => 'opt'),
        '82' => array("show"=>1,'name' => lang('menu/make_index'), 'controller' => 'make',      'action' => 'index'),
        '821' => array("show"=>1,'name' => lang('menu/make_index_wap'), 'controller' => 'make',     'action' => 'index?ac2=wap'),
        '83' => array("show"=>1,'name' => lang('menu/make_map'), 'controller' => 'make',        'action' => 'map'),

        '8101' => array("show"=>0,'name' => '--'.lang('admin/menu/generationEntry'), 'controller' => 'make',       'action' => 'make'),
        '8102' => array("show"=>0,'name' => '--'.lang('admin/menu/generateRSS'), 'controller' => 'make',      'action' => 'rss'),
        '8103' => array("show"=>0,'name' => '--'.lang('admin/menu/generateClassification'), 'controller' => 'make',       'action' => 'type'),
        '8104' => array("show"=>0,'name' => '--'.lang('admin/menu/generateTopicHomePage'), 'controller' => 'make',     'action' => 'topic_index'),
        '8105' => array("show"=>0,'name' => '--'.lang('admin/menu/generateThematicContent'), 'controller' => 'make',     'action' => 'topic_info'),
        '8106' => array("show"=>0,'name' => '--'.lang('admin/menu/generateContentPage'), 'controller' => 'make',      'action' => 'info'),
        '8107' => array("show"=>0,'name' => '--'.lang('admin/menu/generateCustomPage'), 'controller' => 'make',     'action' => 'label'),
    )),
    '9' => array('name' => lang('menu/cjs'), 'icon' => 'layui-icon-edit', 'sub' => array(
        '91' => array("show"=>0,'name' => lang('menu/union'), 'controller' => 'collect',        'action' => 'union'),
        '9101' => array("show"=>0,'name' => '--'.lang('admin/menu/acquisitionEntrance'), 'controller' => 'collect',        'action' => 'api'),
        '9102' => array("show"=>0,'name' => '--'.lang('admin/menu/breakpointCollection'), 'controller' => 'collect',        'action' => 'load'),
        '9103' => array("show"=>0,'name' => '--'.lang('admin/menu/bindingClassification'), 'controller' => 'collect',        'action' => 'bind'),
        '9104' => array("show"=>0,'name' => '--'.lang('admin/menu/captureVideo'), 'controller' => 'collect',        'action' => 'vod'),
        '9105' => array("show"=>0,'name' => '--'.lang('admin/menu/collectArticles'), 'controller' => 'collect',        'action' => 'art'),
        '92' => array("show"=>0,'name' => lang('menu/collect_timming'), 'controller' => 'collect',      'action' => 'timing'),

        '93' => array("show"=>1,'name' => lang('menu/collect'), 'controller' => 'collect',      'action' => 'index'),
        '9301' => array("show"=>0,'name' => '--'.lang('admin/menu/userDefinedResourceInformationMaintenance'), 'controller' => 'collect',       'action' => 'info'),
        '9302' => array("show"=>0,'name' => '--'.lang('admin/menu/customResourceDeletion'), 'controller' => 'collect',     'action' => 'del'),

        '94' => array("show"=>1,'name' => lang('menu/cj'), 'controller' => 'cj',        'action' => 'index'),
        '9401' => array("show"=>0,'name' => '--'.lang('admin/menu/customRuleInformationMaintenance'), 'controller' => 'cj',        'action' => 'info'),
        '9402' => array("show"=>0,'name' => '--'.lang('admin/menu/customRuleDeletion'), 'controller' => 'cj',      'action' => 'del'),
        '9403' => array("show"=>0,'name' => '--'.lang('admin/menu/customRulePublishingScheme'), 'controller' => 'cj',        'action' => 'program'),
        '9404' => array("show"=>0,'name' => '--'.lang('admin/menu/customRuleCollectionURL'), 'controller' => 'cj',        'action' => 'col_url'),
        '9405' => array("show"=>0,'name' => '--'.lang('admin/menu/customRuleCollectionContent'), 'controller' => 'cj',        'action' => 'col_content'),
        '9406' => array("show"=>0,'name' => '--'.lang('admin/menu/customRulePublishingContent'), 'controller' => 'cj',        'action' => 'publish'),
        '9407' => array("show"=>0,'name' => '--'.lang('admin/menu/customRuleExport'), 'controller' => 'cj',      'action' => 'export'),
        '9408' => array("show"=>0,'name' => '--'.lang('admin/menu/customRuleImport'), 'controller' => 'cj',      'action' => 'import'),
    )),
    '10' => array('name' => lang('menu/db'), 'icon' => 'layui-icon-code-circle', 'sub' => array(
        '101' => array("show"=>1,'name' => lang('menu/database'), 'controller' => 'database',       'action' => 'index'),
        '10001' => array("show"=>0,'name' => '--'.lang('admin/menu/databaseBackup'), 'controller' => 'database',     'action' => 'export'),
        '10002' => array("show"=>0,'name' => '--'.lang('admin/menu/databaseRestore'), 'controller' => 'database',     'action' => 'import'),
        '10003' => array("show"=>0,'name' => '--'.lang('admin/menu/databaseOptimization'), 'controller' => 'database',     'action' => 'optimize'),
        '10004' => array("show"=>0,'name' => '--'.lang('admin/menu/databaseRepair'), 'controller' => 'database',     'action' => 'repair'),
        '10005' => array("show"=>0,'name' => '--'.lang('admin/menu/databaseDeleteBackup'), 'controller' => 'database',       'action' => 'del'),
        '10006' => array("show"=>0,'name' => '--'.lang('admin/menu/databaseTableInformation'), 'controller' => 'database',        'action' => 'columns'),

        '102' => array("show"=>1,'name' => lang('menu/database_sql'), 'controller' => 'database',       'action' => 'sql'),
        '103' => array("show"=>1,'name' => lang('menu/database_rep'), 'controller' => 'database',       'action' => 'rep'),
    )),
    '11' => array('name' => lang('menu/apps'), 'icon' => 'layui-icon-cellphone-fine', 'sub' => array(
        '111' => array("show"=>1,'name' => lang('menu/addon'), 'controller' => 'addon',		'action' => 'index', 'param'=>''),
        '112' => array("show"=>1,'name' => lang('menu/market'), 'controller' => 'addon',		'action' => 'market', 'param'=>''),
        '113' => array("show"=>1,'name' => lang('menu/urlsend'), 'controller' => 'sitesend',		'action' => 'index', 'param'=>''),
        '11200' => array("show"=>0,'name' => '--'.lang('admin/menu/pushInlet'), 'controller' => 'urlsend',		'action' => 'push'),
        '11201' => array("show"=>0,'name' => '--'.lang('admin/menu/baiduActivePush'), 'controller' => 'urlsend',		'action' => 'baidu_push'),
        '11202' => array("show"=>0,'name' => '--'.lang('admin/menu/baiduBearSPawPush'), 'controller' => 'urlsend',		'action' => 'baidu_bear'),

        '11100' => array("show"=>0,'name' => '--'.lang('admin/menu/applicationPlugInList'), 'controller' => 'addon',		'action' => 'downloaded'),
        '11101' => array("show"=>0,'name' => '--'.lang('admin/menu/applicationPlugInInstallation'), 'controller' => 'addon',		'action' => 'install'),
        '11102' => array("show"=>0,'name' => '--'.lang('admin/menu/applicationPluginUninstall'), 'controller' => 'addon',		'action' => 'uninstall'),
        '11103' => array("show"=>0,'name' => '--'.lang('admin/menu/applicationPlugInConfiguration'), 'controller' => 'addon',		'action' => 'config'),
        '11104' => array("show"=>0,'name' => '--'.lang('admin/menu/applicationPlugInStatus'), 'controller' => 'addon',		'action' => 'state'),
        '11105' => array("show"=>0,'name' => '--'.lang('admin/menu/applicationPluginUpload'), 'controller' => 'addon',		'action' => 'local'),
        '11106' => array("show"=>0,'name' => '--'.lang('admin/menu/applicationPlugInUpgrade'), 'controller' => 'addon',		'action' => 'upgrade'),
        '11107' => array("show"=>0,'name' => '--'.lang('admin/menu/addApplicationPlugIns'), 'controller' => 'addon',		'action' => 'add'),
    )),
    '13' => array('name' => lang('menu/others'), 'icon' => 'layui-icon-note', 'sub' => array(
        '1301' => array("show"=>1,'name' => lang('menu/others/botcensus'), 'controller' => 'Others', 'action' => 'botlist'),
    )),

);