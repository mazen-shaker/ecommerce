<?php

namespace App\Http\Controllers\Admin;

use core\view\Main;

class DashboardController extends Main
{

    public function index()
    {
if (isset($_SESSION['admin']['logedIn'])) {
    var_dump($_SESSION['admin']);
    return $this->view('admin/dashboard');
}    
    return $this->view('admin/auth/login');
    }

}
