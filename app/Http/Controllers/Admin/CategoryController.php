<?php

namespace App\Http\Controllers\Admin;

use core\view\Main;
use App\Models\Category;

class CategoryController extends Main
{
    public object $model;

    public function __construct()
    {
        $this->model = new Category();
    }


    public function index()
    {
       $categories = $this->model->all();

        return $this->view('admin/index-categories',compact('categories'));
    }


    public function store($data)
    {

        if(isset($_SESSION['admin']['logedIn'])){
        $this->model->insert([
            'name' => $data['name'],
            'description' => $data['description'],
        ]);
        }


        return header("Location:" . $GLOBALS['basePath'] . "/" . $GLOBALS['previousUrl']);

    }


    public function update($data)
    {
        if(isset($_SESSION['admin']['logedIn'])){
        $this->model->update($data['id'],[
            'name' => $data['name'],
            'description' => $data['description'],
            ]);       
        }
        return header("Location:" . $GLOBALS['basePath'] . "/" . $GLOBALS['previousUrl']);
    }


    public function destroy($data)
    {
        if(isset($_SESSION['admin']['logedIn'])){
        $this->model->destroy($data['id']);
        }
        return header("Location:" . $GLOBALS['basePath'] . "/" . $GLOBALS['previousUrl']);
    }



}
