<?php

require_once('../../oss/conf.inc.php');
require_once('../../oss/sdk.class.php');

class OSSobj {
private $ossobj;
private $ossbuket;
private $ossid;
private $osskey;
private $ossserver;

/**
* 初始化$oss_sdk_service对象
*/
function __construct() {
$this->ossbuket = OSS_BUCKET;
$this->ossid = OSS_ACCESS_ID;
$this->osskey = OSS_ACCESS_KEY;
$this->ossserver = OSS_SERVER;
$this->ossobj = new ALIOSS($this->ossid, $this->osskey, $this->ossserver);
}

function upload_by_multi_part($serverpath, $osspath) {
$isok = true;
$osspath = substr_replace($osspath, "", 0, 1);
$options = array(
'fileUpload' => $serverpath,
'partSize' => 5242880
);
$is_object_exist = $this->ossobj->is_object_exist($this->ossbuket, $osspath);
$isexist = $is_object_exist->isOK();
if (!$isexist) {
$response = $this->ossobj->create_mpu_object($this->ossbuket, $osspath, $options);
$isok = $response->isOK();
if (!$isok) {
$this->_format($response);
die();
}
}
return $isok;
}

function delete_object($osspath) {
$isok = true;
$osspath = substr_replace($osspath, "", 0, 1);
$isexist = $this->ossobj->is_object_exist($this->ossbuket, $osspath);
if ($isexist) {
$response = $this->ossobj->delete_object($this->ossbuket, $osspath);
$isok = $response->isOK();
if (!$isok) {
$this->_format($response);
die();
}
}
return $isok;
}

function is_object_exist($osspath) {
$osspath = substr_replace($osspath, "", 0, 1);
$response = $this->ossobj->is_object_exist($this->ossbuket, $osspath);
$isok = $response->isOK();
if (!$isok) {
$this->_format($response);
die();
}
return $isok;
}

function _format($response) {
echo '|———————–Start—————————————————————————————————' . "<br>";
echo '|-Status:' . $response->status . "<br>";
echo '|-Body:' . "<br>";
echo $response->body . "<br>";
echo "|-Header:<br>";
print_r($response->header);
echo '———————–End—————————————————————————————————–' . "<br><br>";
}
}