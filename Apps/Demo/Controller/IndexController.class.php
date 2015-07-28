<?php
/**
 * Created by PhpStorm.
 * User: juanpi-1
 * Date: 2015/7/24
 * Time: 11:44
 */
namespace Demo\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index() {
        $this->display();
    }
}