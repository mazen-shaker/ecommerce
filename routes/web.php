<?php

use Core\Routing\Main;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\AdminProfileUpdateRequest as AdminProfileRequest; 


//User routs

Main::get('/', ['Storefront\HomeController', 'index']);

Main::get('/signin', ['Admin\UserController', 'createLogin']);
Main::get('/signup', ['Admin\UserController', 'createRegister']);


Main::post('/login', ['Admin\UserController', 'login']);
Main::post('/register', ['Admin\UserController', 'register'], UserStoreRequest::class);
Main::get('/logout', ['Admin\UserController', 'logout']);


Main::post('/admin/profile/update', ['Admin\AdminController', 'profileUpdate'], AdminProfileRequest::class);
Main::get('/admin/profile', ['Admin\AdminController', 'profile']);
Main::post('/admin/login', ['Admin\AdminController', 'login']);
Main::get('/admin', ['Admin\DashboardController', 'index']);
Main::get('/users/index', ['Admin\UserController', 'index']);



