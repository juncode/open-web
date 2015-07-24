<?php
/**
 * Created by PhpStorm.
 * User: juanpi-1
 * Date: 2015/7/23
 * Time: 16:46
 */

class ApiLogic {
    /*
    *   @description 百度api获取ip地址的物理信息
    *   @param string/array $ip ip地址，以xx.xxx.xx.x 格式
    *   @return array
    *   @datetime 2015-7-23 16:51:25
    */
    public function getIPLocation( $ip ) {
        if( empty( $ip ) ) {
            return false;
        }
        $location = array();
        $key = C('BAIDU_KEY');
        $url = 'http://apis.baidu.com/apistore/iplookupservice/iplookup?ip=';
        if( is_array( $ip ) ) {
            foreach ( $ip as $v ) {
                $location[] = $this->_curl( $url . $v , $key );
            }
        } else {
            $location = $this->_curl( $url . $ip , $key );
        }
        return $location;
    }

    public function getWeather( $city ) {
        if( empty ( $city ) ) {
            return false;
        }
        $weather = array();
        $key = C('BAIDU_KEY');
        $url = 'http://apis.baidu.com/apistore/weatherservice/weather?citypinyin=';
        if( is_array( $city ) ) {
            foreach( $city as $v ) {
                $weather[] = $this->_curl( $url . $v , $key );
            }
        } else {
            $weather = $this->_curl($url . $city , $key );
        }
        return $weather;
    }

    private function _curl($url , $key ) {
        $ch = curl_init();
        $header = array(
            'apikey: ' . $key ,
        );
        // 添加apikey到header
        curl_setopt($ch, CURLOPT_HTTPHEADER  , $header);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // 执行HTTP请求
        curl_setopt($ch , CURLOPT_URL , $url);
        $res = curl_exec($ch);
        return json_decode( $res , TRUE );
    }
}