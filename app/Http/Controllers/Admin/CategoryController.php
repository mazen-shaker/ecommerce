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

    public function index(){

   
$categories = [
    [
        'id'          => 1,
        'name'        => 'Electronics',
        'description' => 'Phones, laptops, tablets and other electronic devices.',
        'created_at'  => '2026-11-01 09:15:20',
    ],
    [
        'id'          => 2,
        'name'        => 'Clothing',
        'description' => 'Men, women and kids clothing and fashion accessories.',
        'created_at'  => '2026-11-01 10:30:45',
    ],
    [
        'id'          => 3,
        'name'        => 'Books',
        'description' => 'Educational, scientific and entertainment books.',
        'created_at'  => '2026-11-02 11:05:10',
    ],
    [
        'id'          => 4,
        'name'        => 'Home & Kitchen',
        'description' => 'Furniture, cookware and home appliances.',
        'created_at'  => '2026-11-03 14:20:33',
    ],
    [
        'id'          => 5,
        'name'        => 'Sports',
        'description' => 'Sports equipment, fitness gear and outdoor activities.',
        'created_at'  => '2026-11-04 16:45:12',
    ],
    [
        'id'          => 6,
        'name'        => 'Toys',
        'description' => 'Toys and games for kids of all ages.',
        'created_at'  => '2026-11-05 18:10:05',
    ],
];



    return $this->view('admin/index-categories',compact('categories'));

    }



}
