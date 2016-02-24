<?php
//header('Access-Control-Allow-Origin: http://www.baidu.com'); //设置http://www.baidu.com允许跨域访问
//header('Access-Control-Allow-Headers: X-Requested-With,X_Requested_With'); //设置允许的跨域header
// date_default_timezone_set("Asia/chongqing");
// error_reporting(E_ERROR);
// header("Content-Type: text/html; charset=utf-8");

// $CONFIG = json_decode(preg_replace("/\/\*[\s\S]+?\*\//", "", file_get_contents("config.json")), true);
// $action = $_GET['action'];

//header('Access-Control-Allow-Origin: http://www.baidu.com'); //设置http://www.baidu.com允许跨域访问
//header('Access-Control-Allow-Headers: X-Requested-With,X_Requested_With'); //设置允许的跨域header
require_once("../../oss/conf.inc.php");
date_default_timezone_set("Asia/chongqing");
error_reporting(E_ERROR);
//header("Content-Type:text/html;charset=utf-8");
file_put_contents('./aa/txt',OSS_URL);

$CONFIG = json_decode(preg_replace("/\/\*[\s\S]+?\*\//", "", file_get_contents("config.json")), true);
$action = $_GET['action'];

$timepath = "upload/ueditor/image/{yyyy}{mm}{dd}/{time}{rand:6}"; //日期栏目目录
// 重定义存放目录
$CONFIG['imagePathFormat'] = $timepath;
$CONFIG['scrawlPathFormat'] = $timepath;
$CONFIG['snapscreenPathFormat'] = $timepath;
$CONFIG['videoPathFormat'] = $timepath;
$CONFIG['filePathFormat'] = $timepath;
$CONFIG['catcherPathFormat'] = $timepath;
// 前缀补全
$CONFIG['imageUrlPrefix'] = OSS_URL . "/";
$CONFIG['scrawlUrlPrefix'] = OSS_URL . "/";
$CONFIG['snapscreenUrlPrefix'] = OSS_URL . "/";
$CONFIG['catcherUrlPrefix'] = OSS_URL . "/";
$CONFIG['videoUrlPrefix'] = OSS_URL . "/";
$CONFIG['fileUrlPrefix'] = OSS_URL . "/";
//$CONFIG['imageManagerListPath'] = $public_r['newsurl'].$classpath['filepath'];
//$CONFIG['fileManagerListPath'] = OSS_URL ."/";
$CONFIG['fileManagerUrlPrefix'] = OSS_URL;
$CONFIG['imageManagerUrlPrefix'] = OSS_URL;

switch ($action) {
    case 'config':
        $result =  json_encode($CONFIG);
        break;

    /* 上传图片 */
    case 'uploadimage':
    /* 上传涂鸦 */
    case 'uploadscrawl':
    /* 上传视频 */
    case 'uploadvideo':
    /* 上传文件 */
    case 'uploadfile':
        $result = include("action_upload.php");
        break;

    /* 列出图片 */
    case 'listimage':
        $result = include("action_list.php");
        break;
    /* 列出文件 */
    case 'listfile':
        $result = include("action_list.php");
        break;

    /* 抓取远程文件 */
    case 'catchimage':
        $result = include("action_crawler.php");
        break;

    default:
        $result = json_encode(array(
            'state'=> '请求地址出错'
        ));
        break;
}

/* 输出结果 */
// if (isset($_GET["callback"])) {
//     if (preg_match("/^[\w_]+$/", $_GET["callback"])) {
//         echo htmlspecialchars($_GET["callback"]) . '(' . $result . ')';
//     } else {
//         echo json_encode(array(
//             'state'=> 'callback参数不合法'
//         ));
//     }
// } else {
//     echo $result;
// }

/* 输出结果 */
if (isset($_GET["callback"])) {
if (preg_match("/^[\w_]+$/", $_GET["callback"])) {
echo htmlspecialchars($_GET["callback"]) . '(' . $result . ')';
} else {
echo json_encode(array(
'state'=> 'callback参数不合法'
));
}
} else {
echo $result;
}