<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function download(){
        $this->display('index');
    }
    public function index() {
        $this->assign('code' , $this->getCode() );
        $this->display('contact');
    }

    public function save() {
        if( $_POST ) {
            $result = D('std')->saveData($this->checkCode());
            if( $result['code'] == 2 ) {
                $this->Success( $result['msg'] );
            } else {
                $this->Error( $result['msg'] );
            }

        } else {
            $this->Error('非法请求');
        }
    }



    private  function getCode() {
        return $_SESSION['scode'] = time();
    }

    private function checkCode() {
        $scode = $_SESSION['scode'];
        $_SESSION['scode'] = '';
        return $scode ? $scode : false;
    }
}