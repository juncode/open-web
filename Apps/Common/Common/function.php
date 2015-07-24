<?php

/**
 * 服务层调用函数
 * @param string $name 服务名称
 * @return object
*/
function service($name){
    static $_obj=array();
    $layer='Service';
    $class=$name.$layer;
    if(isset($_obj[$name])){
        return $_obj[$name];
    }
    require APP_ROOT."{$layer}/".$class.'.class.php';
    $_obj[$name] = new $class($name);
    return $_obj[$name];
}

/**
 * 业务逻辑层调用函数
 * @param string $name 业务模型名称
 * @return object
*/
function logic($name){
    static $_obj=array();
    $layer='Logic';
    $class=$name.$layer;
    if(isset($_obj[$name])){
        return $_obj[$name];
    }
    require APP_ROOT."{$layer}/".$class.'.class.php';
    $_obj[$name] = new $class($name);
    return $_obj[$name];
}

/**
 * 数据层调用函数
 * @param string $name 数据模型名称
 * @return object
*/
function data($name){
    static $_obj=array();
    $layer='Data';
    $class=$name.$layer;
    if(isset($_obj[$name])){
        return $_obj[$name];
    }
    require APP_ROOT."{$layer}/".$class.'.class.php';
    $_obj[$name] = new $class($name);
    return $_obj[$name];
}

/**
 * 数据层调用函数
 * @param string $name 数据模型名称
 * @return object
*/
function cache($name){
    static $_obj=array();
    $layer='Cache';
    $class=$name.$layer;
    if(isset($_obj[$name])){
        return $_obj[$name];
    }
    require APP_ROOT."{$layer}/".$class.'.class.php';
    $model = new $class($name);
    $model->cachePrefix='cache_';
    $_obj[$name] = $model;
    return $_obj[$name];
}


/**
 * 请求过滤
*/
function filter_request(&$value){
    //过滤表单中的表达式
    filter_exp($value);
    //过滤空格
    $value=trim($value,' ');
}

/**
 * 转换字符类型
*/
function mixed_tostring(&$value){
    $value=(string)$value;
}

/**
 * 获取当前请求地址
*/
function request_url(){
    $current_page_url = 'http';
    if ($_SERVER["HTTPS"] == "on") {
        $current_page_url .= "s";
    }
     $current_page_url .= "://";
     if ($_SERVER["SERVER_PORT"] != "80") {
    $current_page_url .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
    } else {
        $current_page_url .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
    }
    return $current_page_url;
}

/**
* 获取来源地址
*/

function referer_url(){
    return $_SERVER['HTTP_REFERER'];
}



/**
 * 获取域名
 * @param string $url 地址
 * @return string
*/
function get_domain($url=''){
    //获取域名
    if(empty($url)){
        return $_SERVER['HTTP_HOST'];
    }else{
        $info=parse_url($url);
        return $info['host'];
    }
}

/**
 * 获取子域名
 * @param string $domain 域名
 * @param $topdomain
 * @return string
 */
function get_sub_domain($domain,$topdomain){
    $subdomain=str_replace($topdomain,'',$domain);
    return trim($subdomain,'.');
}

/**
 * XML转数组
 * @param string $xml XML文档内容或文件
 * @return array
*/
function xml_decode($xml){
    if(is_file($xml)){
        $data=(array)simplexml_load_file($xml);
    }else{
        $data=(array)simplexml_load_string($xml);
    }
    return $data;
}

/**
 * 获取密码安全等级
 * @param string $password 密码
 * @return int 0:低,1:中,2:高
*/
function password_level($password){
    if(preg_match('/^([0-9]{6,16})$/',$password)){
        return 0;
    }else if(preg_match('/^[0-9 a-z]{6,16}$/',$password)){
        return 1;
    }else if(preg_match('/^[0-9 a-z A-Z !@#$%^&*]{6,16}$/',$password)){
        return 2;
    }
    return 0;
}

/**
 * 字符串自动加密
 * @param string $str 明文字符串
 * @return string
*/
function str_encrypt($str){
    $str=authcode($str,C('APP_KEY'),true);
    return $str;
}

/**
 * 字符串自动加密
 * @param string $str 密文字符串
 * @return string
*/
function str_decrypt($str){
    $str=authcode($str,C('APP_KEY'),false);
    return $str;
}

/**
 * 10进制转字母（26）进制
*/
function decimal_to_abc($num){
    $ABCstr = "";
    $ten = $num;
    if($ten==0) return "A";
    while($ten!=0){
        $x = $ten%26;
        $ABCstr .= chr(65+$x);
        $ten = intval($ten/26);
    }
    return strrev($ABCstr);
}




/**
 * 加密解密函数
 * @param string $string 字符串
 * @param string $key 密钥
 * @param bool $operation 是否加密
 * @param int $expiry 密文有效期
 * @return string
*/
function authcode($string,$key,$operation=true,$expiry=0) {
    $ckey_length = 4;   // 随机密钥长度 取值 0-32;
    // 加入随机密钥，可以令密文无任何规律，即便是原文和密钥完全相同，加密结果也会每次不同，增大破解难度。
    // 取值越大，密文变动规律越大，密文变化 = 16 的 $ckey_length 次方
    // 当此值为 0 时，则不产生随机密钥
    $key = md5($key);
    $keya = md5(substr($key, 0, 16));
    $keyb = md5(substr($key, 16, 16));
    $keyc = $ckey_length ? ($operation == false ? substr($string, 0, $ckey_length): substr(md5(microtime()), -$ckey_length)) : '';
    $cryptkey = $keya.md5($keya.$keyc);
    $key_length = strlen($cryptkey);
    $string = $operation == false ? base64_decode(substr($string, $ckey_length)) : sprintf('%010d', $expiry ? $expiry + time() : 0).substr(md5($string.$keyb), 0, 16).$string;
    $string_length = strlen($string);
    $result = '';
    $box = range(0, 255);
    $rndkey = array();
    for($i = 0; $i <= 255; $i++) {
        $rndkey[$i] = ord($cryptkey[$i % $key_length]);
    }
    for($j = $i = 0; $i < 256; $i++) {
        $j = ($j + $box[$i] + $rndkey[$i]) % 256;
        $tmp = $box[$i];
        $box[$i] = $box[$j];
        $box[$j] = $tmp;
    }
    for($a = $j = $i = 0; $i < $string_length; $i++) {
        $a = ($a + 1) % 256;
        $j = ($j + $box[$a]) % 256;
        $tmp = $box[$a];
        $box[$a] = $box[$j];
        $box[$j] = $tmp;
        $result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
    }
    if($operation == false) {
        if((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26).$keyb), 0, 16)) {
            return substr($result, 26);
        } else {
            return '';
        }
    } else {
        return $keyc.str_replace('=', '', base64_encode($result));
    }
}