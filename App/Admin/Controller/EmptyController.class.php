<?php
namespace Admin\Controller;

use Think\Controller;

class EmptyController extends Controller
{
    public function _empty()
    {
        $login_status = R('Login/checkLoginStatus');

        if ($login_status) {
            redirect(U('Index/index'));
        } else {
            redirect(U('Login/login'));
        }
    }
}