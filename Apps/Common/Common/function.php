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




