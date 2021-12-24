<?php
/*
'软件名称：MacCMS Pro 源码库：https://github.com/maccmspro
'--------------------------------------------------------
'Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
'遵循Apache2开源协议发布，并提供免费使用。
'--------------------------------------------------------
*/
header('Content-Type:text/html;charset=utf-8');
// 检测PHP环境
if(version_compare(PHP_VERSION,'5.5.0','<'))  die('PHP版本需要>=5.5，请升级【PHP version requires > = 5.5，please upgrade】');
//超时时间
@ini_set('max_execution_time', '0');
//内存限制 取消内存限制
@ini_set("memory_limit",'-1');
// 定义应用目录
define('ROOT_PATH', __DIR__ . '/');
define('APP_PATH', __DIR__ . '/application/');
define('MAC_COMM', __DIR__.'/application/common/common/');
define('MAC_HOME_COMM', __DIR__.'/application/index/common/');
define('MAC_ADMIN_COMM', __DIR__.'/application/admin/common/');
define('MAC_START_TIME', microtime(true) );
define('BIND_MODULE','index');
define('ENTRANCE', 'index');
$in_file = rtrim($_SERVER['SCRIPT_NAME'],'/');
if(substr($in_file,strlen($in_file)-4)!=='.php'){
    $in_file = substr($in_file,0,strpos($in_file,'.php')) .'.php';
}
define('IN_FILE',$in_file);
if(!is_file('./application/data/install/install.lock')) {
    header("Location: ./install.php");
    exit;
}
if (!@mb_check_encoding($_SERVER['PATH_INFO'], 'utf-8')){
    $_SERVER['PATH_INFO']=@mb_convert_encoding($_SERVER['PATH_INFO'], 'UTF-8', 'GBK');
}

/**
 * 蜘蛛统计开始       walle
*/
$useragent = addslashes(strtolower($_SERVER['HTTP_USER_AGENT']));
if (strpos($useragent, 'googlebot')!== false) {
    $bot = 'Google';
} elseif (strpos($useragent,'mediapartners-google') !== false){
    $bot = 'Google Adsense';
} elseif (strpos($useragent,'baiduspider') !== false){
    $bot = 'Baidu';
} elseif (strpos($useragent,'sogou spider') !== false){
    $bot = 'Sogou';
} elseif (strpos($useragent,'sogou web') !== false){
    $bot = 'Sogou web';
} elseif (strpos($useragent,'sosospider') !== false){
    $bot = 'SOSO';
} elseif (strpos($useragent,'yahoo') !== false){
    $bot = 'Yahoo';
} elseif (strpos($useragent,'msn') !== false){
    $bot = 'MSN';
} elseif (strpos($useragent,'msnbot') !== false){
    $bot = 'msnbot';
} elseif (strpos($useragent,'sohu') !== false){
    $bot = 'Sohu';
} elseif (strpos($useragent,'yodaoBot') !== false){
    $bot = 'Yodao';
} elseif (strpos($useragent,'twiceler') !== false){
    $bot = 'Twiceler';
} elseif (strpos($useragent,'ia_archiver') !== false){
    $bot = 'Alexa_';
} elseif (strpos($useragent,'iaarchiver') !== false){
    $bot = 'Alexa';
} elseif (strpos($useragent,'slurp') !== false){
    $bot = '雅虎';
} //elseif (strpos($useragent,'bot') !== false){
    //$bot = '其它蜘蛛';
//}
if(isset($bot)){
    $today_date = date('Y-m-d');
    $fp = @fopen('./runtime/log/bot/'.$today_date.'.txt','a');
    fwrite($fp,date('Y-m-d H:i:s')."\t".$_SERVER["REMOTE_ADDR"]."\t".$bot."\t".'http://'.$_SERVER['SERVER_NAME'].$_SERVER["REQUEST_URI"]."\r\n");
    fclose($fp);
}
/**
 *  蜘蛛统计   end
 */

// 加载框架引导文件
require __DIR__ . '/thinkphp/start.php';

