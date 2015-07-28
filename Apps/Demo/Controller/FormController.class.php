<?php
/**
 * Created by PhpStorm.
 * User: juanpi-1
 * Date: 2015/7/24
 * Time: 11:44
 */
namespace Demo\Controller;
use Think\Controller;
class FormController extends Controller {
    public function index() {
        if( !empty( $_POST ) ) {
            print_r($_POST );exit();
        }
        $this->display();
    }
    public function getpost( ) {
        print_r( $_GET  );

    }
}