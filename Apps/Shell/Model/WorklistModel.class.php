<?php
/**
 * Created by PhpStorm.
 * User: juanpi-1
 * Date: 2015/11/17
 * Time: 10:43
 */

namespace Shell\Model;
use Think\Model;


class WorklistModel extends Model {
    protected $connection ='DB_LAGOU';
    protected $tablePrefix  = 'la_';

    public function insert_work( $data , $li_fields , $batch ) {

        $row_value = array();
        if( empty( $data ) ) {
            exit('没有数据了'.' PHP_EOL ');
        }
        echo '正在处理数据...'.' PHP_EOL ';
        $fileds =  implode( ',' , $li_fields ) ;
        foreach( $data as $key => $value ){
            $row = array();
            foreach( $li_fields as $filed ) {
                if( !isset( $value[$filed] ) ) {
                    if( $filed == 'batchid' ) {
                        $value[$filed] = $batch;
                    } else {
                        $value[$filed] = '';
                    }
                }
                $row[]  = $value[$filed];
            }

            $row_value[$key] = '(\'' . implode('\',\'' , $row) . '\')';
        }
        $sql = "INSERT INTO la_worklist ($fileds) VALUES " . implode(',' , $row_value );
        $this->execute( $sql );
        echo $this->getLastSql();
    }

    public function get_url( $url , $post_data ) {
        echo '正在获取数据....'.' PHP_EOL ';
        sleep( 1 ); //防止被恶意发现
        $ch = curl_init();
        curl_setopt( $ch , CURLOPT_URL , $url );
        curl_setopt( $ch , CURLOPT_POST , 1 );
        curl_setopt ( $ch , CURLOPT_POSTFIELDS , $post_data );
        curl_setopt( $ch , CURLOPT_RETURNTRANSFER , 1 );
        $output = curl_exec ( $ch );
        curl_close ( $ch ) ;
        return json_decode( $output , TRUE);
    }
}