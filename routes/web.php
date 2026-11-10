<?php

use Core\Routing\Main;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Requests\CategoryStoreRequest;
use App\Http\Requests\CategoryUpdateRequest;
use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Http\Requests\AssetStoreRequest;
use App\Http\Requests\AdminProfileUpdateRequest as AdminProfileRequest;



Main::get('/', ['Storefront\HomeController', 'index']);
Main::get('/product/product/details/{id}', ['Admin\ProductController', 'productDetails']);



Main::get('/signin', ['Admin\UserController', 'createLogin']);
Main::get('/signup', ['Admin\UserController', 'createRegister']);

Main::post('/login', ['Admin\UserController', 'login']);
Main::post('/register', ['Admin\UserController', 'register'], UserStoreRequest::class);
Main::get('/logout', ['Admin\UserController', 'logout']);



Main::get('/cart', ['Customer\CartController', 'index']);
Main::get('/checkout', ['Customer\CheckoutController', 'index']);



Main::get('/admin', ['Admin\DashboardController', 'index']);



Main::get('/admin/profile', ['Admin\AdminController', 'profile']);
Main::post('/admin/profile/update', ['Admin\AdminController', 'profileUpdate'], AdminProfileRequest::class);
Main::post('/admin/login', ['Admin\AdminController', 'login']);



Main::get('/users/index', ['Admin\UserController', 'index']);

Main::post('/users/store', ['Admin\UserController', 'store'], UserStoreRequest::class);
Main::post('/users/update', ['Admin\UserController', 'update'], UserUpdateRequest::class);
Main::post('/users/destroy', ['Admin\UserController', 'destroy']);



Main::get('/categories/index', ['Admin\CategoryController', 'index']);

Main::post('/categories/store', ['Admin\CategoryController', 'store'], CategorystoreRequest::class);
Main::post('/categories/update', ['Admin\CategoryController', 'update'], CategoryUpdateRequest::class);
Main::post('/categories/destroy', ['Admin\CategoryController', 'destroy']);



Main::get('/products/index', ['Admin\ProductController', 'index']);

Main::post('/products/store', ['Admin\ProductController', 'store'], ProductStoreRequest::class);
Main::post('/products/update', ['Admin\ProductController', 'update'], ProductUpdateRequest::class);
Main::post('/products/destroy', ['Admin\ProductController', 'destroy']);



Main::get('/products/assets/index/{id}', ['Admin\AssetController', 'index']);

Main::post('/products/assets/store', ['Admin\AssetController', 'store'], AssetStoreRequest::class);
Main::post('/products/assets/destroy', ['Admin\AssetController', 'destroy']);



Main::get('/orders/index', ['Admin\OrderController', 'index']);



Main::get('/users/index', ['Admin\UserController', 'index']);
