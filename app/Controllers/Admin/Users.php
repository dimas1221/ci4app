<?php

namespace App\Controllers\Admin;

//agar basecontroler tidk eror mengambil
use App\Controllers\BaseController;
//end

class Users extends BaseController
{
    public function index()
    {
        echo 'ini controler  users method index di folder admin';
    }
}
