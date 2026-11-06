<?php

namespace App\Http\Controllers\Admin;

use core\view\Main;
use App\Models\Product;

class ProductController extends Main
{
    public object $model;

    public function __construct()
    {
        $this->model = new Product();
    }



    public function index(){

        $products = [
        [
        'id'          => 1,
        'category_id' => 1,
        'name'        => 'Smartphone X200',
        'description' => '6.5 inch display, 128GB storage, dual camera.',
        'price'       => 8500.00,
        'old_price'   => 9500.00,
        'stock'       => 25,
        'is_active'   => 1,
        'created_at'  => '2026-11-01 09:30:00',
        'updated_at'  => '2026-11-01 09:30:00',
    ],
    [
        'id'          => 2,
        'category_id' => 1,
        'name'        => 'Laptop Pro 15',
        'description' => '15 inch laptop, 16GB RAM, 512GB SSD.',
        'price'       => 24999.00,
        'old_price'   => 27500.00,
        'stock'       => 10,
        'is_active'   => 1,
        'created_at'  => '2026-11-01 10:15:00',
        'updated_at'  => '2026-11-02 12:00:00',
    ],
    [
        'id'          => 3,
        'category_id' => 2,
        'name'        => 'Cotton T-Shirt',
        'description' => 'Comfortable 100% cotton t-shirt, available in many sizes.',
        'price'       => 250.00,
        'old_price'   => null,
        'stock'       => 120,
        'is_active'   => 1,
        'created_at'  => '2026-11-02 11:20:00',
        'updated_at'  => '2026-11-02 11:20:00',
    ],
    [
        'id'          => 4,
        'category_id' => 3,
        'name'        => 'PHP for Beginners',
        'description' => 'A practical guide to learning PHP from scratch.',
        'price'       => 320.00,
        'old_price'   => 400.00,
        'stock'       => 40,
        'is_active'   => 1,
        'created_at'  => '2026-11-03 13:40:00',
        'updated_at'  => '2026-11-03 13:40:00',
    ],
    [
        'id'          => 5,
        'category_id' => 4,
        'name'        => 'Non-Stick Cookware Set',
        'description' => 'Set of 7 non-stick pots and pans.',
        'price'       => 1800.00,
        'old_price'   => 2200.00,
        'stock'       => 0,
        'is_active'   => 0,
        'created_at'  => '2026-11-04 15:05:00',
        'updated_at'  => '2026-11-05 09:10:00',
    ],
    [
        'id'          => 6,
        'category_id' => 5,
        'name'        => 'Yoga Mat',
        'description' => 'Anti-slip yoga mat, 6mm thickness.',
        'price'       => 450.00,
        'old_price'   => null,
        'stock'       => 60,
        'is_active'   => 1,
        'created_at'  => '2026-11-04 16:30:00',
        'updated_at'  => '2026-11-04 16:30:00',
    ],
    [
        'id'          => 7,
        'category_id' => 6,
        'name'        => 'Building Blocks Set',
        'description' => '500-piece building blocks for kids.',
        'price'       => 600.00,
        'old_price'   => 750.00,
        'stock'       => 35,
        'is_active'   => 1,
        'created_at'  => '2026-11-05 18:00:00',
        'updated_at'  => '2026-11-05 18:00:00',
     ]
    ];

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
    ]
];



    return $this->view('admin/index-products',compact('categories','products'));

    }



}
