<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function download(){
        $this->display('index');
    }
    public function index() {
        $this->assign('code' , D('std')->getCode() );
        $this->display('contact');
    }
    public function getVery( ) {
        $Verify = new \Think\Verify();
        $Verify->fontSize = 18;$Verify->length   = 4;$Verify->useNoise = false;
        $Verify->entry();
    }

    public function save() {
        if( $_POST ) {
            $result = D('std')->saveData();
            if( $result['code'] == 2 ) {
                $this->Success( $result['msg'] );
            } else {
                $this->Error( $result['msg'] );
            }
        } else {
            $this->Error('非法请求');
        }
    }
}