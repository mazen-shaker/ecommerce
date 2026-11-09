<!-- Header Area Start -->

<!-- Offcanvas Menu Area Start -->


<!-- Offcanvas Menu Area End -->


<header>
    <div class="main_header">

        <!-- Header Top Start -->
        <div class="header_top">
            <div class="container">
                <div class="row align-items-center">

                    <div class="col-lg-6 col-md-6">
                        <div class="support_info">
                            <p>Email: <a href="mailto:">support@drophunt.com</a></p>
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-6">
                        <div class="top_right text-right">
                            <ul>
                                <li><a href="signin">Account</a></li>
                                <li><a href="checkout">Checkout</a></li>
                            </ul>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <!-- Header Top End -->


        <!-- Header Middle Start -->
        <div class="header_middle">
            <div class="container">
                <div class="row align-items-center">

                    <div class="col-lg-3 col-md-6">
                        <div class="logo">
                            <a href="<?= $GLOBALS['BasePath'] ?>">
                                <img src="<?= $GLOBALS['BasePath'] ?>/public/assets/user/img/logo/logo.png" alt="">
                            </a>
                        </div>
                    </div>

                    <div class="col-lg-9 col-md-6">
                        <div class="middel_right">

                            <div class="middel_right_info">
                                <div class="header_wishlist">
                                    <?php if (isset($_SESSION['user']['logedIn'])): ?>

                                        <div class="account-dropdown">
                                            <button type="button" class="account-dropdown-toggle">
                                                <span style=" color: white;">
                                                    <?= htmlspecialchars($_SESSION['user']['name']) ?>
                                                </span>

                                                <svg width="14" height="14" viewBox="0 0 24 24" fill="white">
                                                    <path d="m6 9 6 6 6-6" />
                                                </svg>
                                            </button>

                                            <div class="account-dropdown-menu">
                                                <a href="logout">Logout</a>
                                            </div>
                                        </div>

                                    <?php else: ?>

                                        <a href="signin" aria-label="Account">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="#fff" aria-hidden="true">
                                                <path d="M12 12a4.75 4.75 0 1 0 0-9.5 4.75 4.75 0 0 0 0 9.5Zm0 2c-4.7 0-8.5 3.2-8.5 7.1 0 .5.4.9.9.9h15.2c.5 0 .9-.4.9-.9 0-3.9-3.8-7.1-8.5-7.1Z" />
                                            </svg>
                                        </a>

                                    <?php endif; ?>
                                </div>
                                <div class="mini_cart_wrapper">

                                    <a href="javascript:void(0)" aria-label="Shopping cart">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="#fff" aria-hidden="true">
                                            <path d="M5 7.5h14.2c.8 0 1.4.6 1.5 1.4l1 11.2c.1.9-.6 1.7-1.5 1.7H3.8c-.9 0-1.6-.8-1.5-1.7l1-11.2c.1-.8.7-1.4 1.5-1.4Zm3.5 0V6a3.5 3.5 0 0 1 7 0v1.5h-2V6a1.5 1.5 0 0 0-3 0v1.5h-2Z" />
                                        </svg>
                                    </a>

                                    <span class="cart_quantity">2</span>

                                    <!-- Mini Cart -->
                                    <div class="mini_cart">
                                        <div class="mini_cart_footer">
                                            <div class="cart_button">
                                                <a href="cart">View cart</a>
                                            </div>

                                            <div class="cart_button">
                                                <a href="checkout">Checkout</a>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Mini Cart End -->

                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <!-- Header Middle End -->


        <!-- Header Bottom Start -->
        <div class="main_menu_area">
            <div class="container">
                <div class="row justify-content-center">

                    <div class="col-lg-12 col-md-12">
                        <div class="main_menu menu_position">

                            <nav>
                                <ul>

                                    <li><a href="/">home</a></li>

                                    <li>
                                        <a href="blog">
                                            blog
                                        </a>

                                        <ul class="sub_menu pages">
                                            <li><a href="blog.html">blog</a></li>
                                            <li><a href="blog-details.html">blog details</a></li>
                                        </ul>
                                    </li>

                                    <li><a href="contact">Contact Us</a></li>
                                    <li><a href="product/create">Create Products</a></li>

                                </ul>
                            </nav>

                        </div>
                    </div>

                </div>
            </div>
        </div>
        <!-- Header Bottom End -->

    </div>
</header>

<!-- Header Area End -->