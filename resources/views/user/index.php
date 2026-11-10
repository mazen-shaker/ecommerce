<?php
$pageTitle = 'Home';

$breadcrumbs = [
    ['label' => 'Home', 'url' => null],
];

include __DIR__ . '/layouts/head.php';
include __DIR__ . '/layouts/header.php';
?>

<!-- Slider Area Start -->
<section class="slider_section d-flex align-items-center" data-bgimg="<?= $GLOBALS['basePath'] ?>/assets/img/slider/slider3.jpg">
    <div class="slider_area owl-carousel">

        <div class="single_slider d-flex align-items-center">
            <div class="container">
                <div class="row">
                    <div class="col-xl-6 col-md-6">
                        <div class="slider_content">
                            <h1>Next level of Drone</h1>
                            <h2>Insane Quality for use</h2>
                            <p>Special offer <span>20% off</span> this week</p>
                            <a class="button" href="<?= $GLOBALS['basePath'] ?>/product-details">Buy now</a>
                        </div>
                    </div>

                    <div class="col-xl-6 col-md-6">
                        <div class="slider_content">
                            <img src="<?= $GLOBALS['basePath'] ?>/assets/img/product/1.png" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="single_slider d-flex align-items-center">
            <div class="container">
                <div class="row">
                    <div class="col-xl-6 col-md-6">
                        <div class="slider_content">
                            <h1>Best Camera Included</h1>
                            <h2>100% Flexible</h2>
                            <p>exclusive offer <span>20% off</span> this week</p>
                            <a class="button" href="<?= $GLOBALS['basePath'] ?>/product-details">Shop now</a>
                        </div>
                    </div>

                    <div class="col-xl-6 col-md-6">
                        <div class="slider_content">
                            <img src="<?= $GLOBALS['basePath'] ?>/assets/img/product/2.png" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="single_slider d-flex align-items-center">
            <div class="container">
                <div class="row">
                    <div class="col-xl-6 col-md-6">
                        <div class="slider_content">
                            <h1>With some gifts</h1>
                            <h2>Special one for you</h2>
                            <p>exclusive offer <span>20% off</span> this week</p>
                            <a class="button" href="<?= $GLOBALS['basePath'] ?>/product-details">shopping now</a>
                        </div>
                    </div>

                    <div class="col-xl-6 col-md-6">
                        <div class="slider_content">
                            <img src="<?= $GLOBALS['basePath'] ?>/assets/img/product/3.png" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>
<!-- Slider Area End -->


<!-- Trending Products -->
<section class="pt-60 pb-30 gray-bg">
    <div class="container">

        <div class="row">
            <div class="col text-center">
                <div class="section-title">
                    <h2>Tranding Products</h2>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <?php foreach ($products ?? [] as $product) : ?>
                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">
                    <div class="single-tranding">

                        <a href="<?= $GLOBALS['basePath'] ?>/product/product/details/<?= $product['id'] ?>">

                            <div class="tranding-pro-img">
                                <img
                                    src="<?= $GLOBALS['basePath'] ?>/storage/upload/<?=$product['thub']['file_path']?>"
                                    alt="<?= htmlspecialchars($product['name']) ?>">
                            </div>

                            <div class="tranding-pro-title">
                                <h3>
                                    <?= htmlspecialchars($product['name']) ?>
                                </h3>

                                <h4>
                                    <?= htmlspecialchars($product['description']) ?>
                                </h4>
                            </div>

                            <div class="tranding-pro-price">
                                <div class="price_box">

                                    <span class="current_price">
                                        <?= number_format($product['price'], 2) ?> EGP
                                    </span>

                                    <?php if ($product['old_price'] > $product['price']) : ?>
                                        <span class="old_price">
                                            <?= number_format($product['old_price'], 2) ?> EGP
                                        </span>
                                    <?php endif; ?>

                                </div>
                            </div>

                        </a>

                        <div class="text-center mt-3 mb-3">
                            <a href="<?= $GLOBALS['basePath'] ?>/cart?id=<?= $product['id'] ?>"
                                class="btn btn-dark rounded-pill px-4 py-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="white" style="vertical-align: middle; margin-right: 8px;">
                                    <path d="M7 18a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm10 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4ZM5.2 3H2v2h1.8l2.7 11.2A2.3 2.3 0 0 0 8.7 18H19v-2H8.7a.3.3 0 0 1-.3-.2L8 14h10.5a2 2 0 0 0 1.9-1.4L22 6H6.1L5.6 4a1 1 0 0 0-.4-.7A1 1 0 0 0 5.2 3Z"/>
                                </svg>
                                Add To Cart
                            </a>
                        </div>

                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<!-- Trending Products End -->


<!-- Blog -->
<section class="pt-60">
    <div class="container">

        <div class="row">
            <div class="col text-center">
                <div class="section-title">
                    <h2>Blog Posts</h2>
                </div>
            </div>
        </div>

        <div class="row blog_wrapper">

            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                <article class="single_blog mb-60">
                    <figure>
                        <div class="blog_thumb">
                            <a href="<?= $GLOBALS['basePath'] ?>/blog-details">
                                <img src="<?= $GLOBALS['basePath'] ?>/assets/img/blog/blog2.jpg" alt="">
                            </a>
                        </div>

                        <figcaption class="blog_content">
                            <h3><a href="<?= $GLOBALS['basePath'] ?>/blog-details">How to start drone</a></h3>

                            <div class="blog_meta">
                                <span class="author">Posted by : <a href="#">Rahul</a> / </span>
                                <span class="post_date"><a href="#">Sep 20, 2019</a></span>
                            </div>

                            <div class="blog_desc">
                                <p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less</p>
                            </div>

                            <footer class="readmore_button">
                                <a href="<?= $GLOBALS['basePath'] ?>/blog-details">read more</a>
                            </footer>
                        </figcaption>
                    </figure>
                </article>
            </div>


            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                <article class="single_blog blog_bidio mb-60">
                    <figure>
                        <div class="blog_thumb">
                            <a href="<?= $GLOBALS['basePath'] ?>/blog-details">
                                <img src="<?= $GLOBALS['basePath'] ?>/assets/img/blog/blog1.jpg" alt="">
                            </a>
                        </div>

                        <figcaption class="blog_content">
                            <h3><a href="<?= $GLOBALS['basePath'] ?>/blog-details">See the tutorial</a></h3>

                            <div class="blog_meta">
                                <span class="author">Posted by : <a href="#">Rahul</a> / </span>
                                <span class="post_date">On : <a href="#">Aug 25, 2019</a></span>
                            </div>

                            <div class="blog_desc">
                                <p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less</p>
                            </div>

                            <footer class="readmore_button">
                                <a href="<?= $GLOBALS['basePath'] ?>/blog-details">read more</a>
                            </footer>
                        </figcaption>
                    </figure>
                </article>
            </div>


            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                <article class="single_blog mb-60">
                    <figure>
                        <div class="blog_thumb">
                            <a href="<?= $GLOBALS['basePath'] ?>/blog-details">
                                <img src="<?= $GLOBALS['basePath'] ?>/assets/img/blog/blog-details.jpg" alt="">
                            </a>
                        </div>

                        <figcaption class="blog_content">
                            <h3><a href="<?= $GLOBALS['basePath'] ?>/blog-details">How to start drone</a></h3>

                            <div class="blog_meta">
                                <span class="author">Posted by : <a href="#">Rahul</a> / </span>
                                <span class="post_date"><a href="#">Sep 20, 2019</a></span>
                            </div>

                            <div class="blog_desc">
                                <p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less</p>
                            </div>

                            <footer class="readmore_button">
                                <a href="<?= $GLOBALS['basePath'] ?>/blog-details">read more</a>
                            </footer>
                        </figcaption>
                    </figure>
                </article>
            </div>

        </div>
    </div>
</section>
<!-- Blog End -->


<?php
include __DIR__ . '/layouts/footer.php';
include __DIR__ . '/layouts/footer-scripts.php';
?>
