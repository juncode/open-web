<?php
/**
 * Created by PhpStorm.
 * User: juanpi-1
 * Date: 2015/12/8
 * Time: 10:42
 */
namespace Home\Model;
use Think\Model;
class StdModel extends  Model{
    protected $connection ='DB_LAGOU';
    protected $tablePrefix  = 'la_';


    public function saveData() {
        $data = array(
            'name' => I('name' , '','trim'),
            'tel' => I('tel' , '' , 'trim'),
            'city' => I('city' , '' , 'trim'),
            'qq' => I('qq' , '' , 'trim'),
            'weixin' => I('weixin' , '' , 'trim'),
            'comment' => I('comment' , '' , 'trim'),
            'ip' => get_client_ip(),
            'add' => date('Y-m-d H:i:s')
        );
        if( !$this->check_verify(I('vcode') ) ) {
            return array( 'code' => 1 , 'msg' => '验证码输入错误！');
        }
        if( !$this->checkCode(I('scode')) ) {
            return array( 'code' => 1 , 'msg' => '非法请求，请重新打开页面');
        };
        if( empty( $data['name'] ) || empty( $data['tel'] ) ) {
            return array( 'code' => 1 , 'msg' => '请填写姓名和手机号');
        }
        $result = $this->add($data);
        if( $result ) {
            return array( 'code' => 2 ,'msg' => '保存成功');
        } else {
            return array( 'code' => 1 , 'msg' => '保存失败');
        }
    }

    function check_verify($code, $id = ''){    $verify = new \Think\Verify();    return $verify->check($code, $id);}

    public function getCode() {
        return $_SESSION['scode'] = time();
    }

    private function checkCode($code) {
        if(  $_SESSION['scode'] && $_SESSION['scode'] == $code ) {
            $_SESSION['scode'] == '';
            return true;
        } else {
            return false;
        }
    }
}