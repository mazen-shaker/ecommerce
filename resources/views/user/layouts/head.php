<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <title>Drophut - Single Product eCommerce Template</title>

    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="<?= $GLOBALS['basePath'] ?>/public/assets/user/img/favicon.ico">

    <!-- Plugins CSS -->
    <link rel="stylesheet" href="<?= $GLOBALS['basePath'] ?>/public/assets/user/css/plugins.css">

    <!-- Main Style CSS -->
    <link rel="stylesheet" href="<?= $GLOBALS['basePath'] ?>/public/assets/user/css/style.css">
    <link rel="stylesheet" href="<?= $GLOBALS['basePath'] ?>/public/assets/user/css/custom.css">
    
 <style>
.account-dropdown {
    position: relative;
    display: inline-block;
}

.account-dropdown-toggle {
    display: flex;
    align-items: center;
    gap: 8px;
    background: transparent;
    border: none;
    cursor: pointer;
    font-size: 15px;
}

.account-dropdown-menu {
    position: absolute;
    top: 100%;
    right: 0;
    min-width: 150px;
    background: #fff;
    border-radius: 6px;
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.15);
    padding: 8px 0;
    display: none;
    z-index: 999;
}

.account-dropdown:hover .account-dropdown-menu,
.account-dropdown:focus-within .account-dropdown-menu {
    display: block;
}

.account-dropdown-menu a {
    display: block;
    padding: 10px 15px;
    color: #333;
    font-size: 14px;
    text-decoration: none;
    transition: 0.2s;
}

.account-dropdown-menu a:hover {
    background: #f5f5f5;
    color: #e74c3c;
}
</style>   
    
</head>

<body>
