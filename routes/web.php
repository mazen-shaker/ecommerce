<?php

use Core\Routing\Main;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\AdminProfileUpdateRequest as AdminProfileRequest;


//User routs

Main::get('/', ['Storefront\HomeController', 'index']);
Main::get('/product/create', ['Storefront\ProductController', 'create']);
Main::get('/product/product-details', ['Storefront\ProductController', 'ProductDetails']);

Main::get('/signin', ['Admin\UserController', 'createLogin']);
Main::get('/signup', ['Admin\UserController', 'createRegister']);
Main::get('/cart', ['Customer\CartController', 'index']);
Main::get('/checkout', ['Customer\CheckoutController', 'index']);


Main::post('/login', ['Admin\UserController', 'login']);
Main::post('/register', ['Admin\UserController', 'register'], UserStoreRequest::class);
Main::get('/logout', ['Admin\UserController', 'logout']);


Main::post('/admin/profile/update', ['Admin\AdminController', 'profileUpdate'], AdminProfileRequest::class);
Main::get('/admin/profile', ['Admin\AdminController', 'profile']);
Main::post('/admin/login', ['Admin\AdminController', 'login']);
Main::get('/admin', ['Admin\DashboardController', 'index']);
Main::get('/users/index', ['Admin\UserController', 'index']);
<<<<<<< HEAD
Main::get('/categories/index', ['Admin\CategoryController', 'index']);
Main::get('/products/index', ['Admin\ProductController', 'index']);
Main::get('/orders/index', ['Admin\OrderController', 'index']);
Main::get('/admins/index', ['Admin\AdminController', 'index']);

// Main::get('/categories/destroy/{id}', ['Admin\CategoryController', 'destroy']);

=======
>>>>>>> main
