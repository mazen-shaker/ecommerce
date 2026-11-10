<?php

$pageTitle = 'product-details';

$breadcrumbs = [
    ['label' => 'product-details', 'url' => null],
];

$product = $product ?? [];

$images = $product['image'] ?? [];

$mainImage = $images[0]['file_path'] ?? null;

$imageBasePath = $GLOBALS['basePath'].'/storage/upload/';

include __DIR__ . '/layouts/head.php';

?>

<?php include __DIR__ . '/layouts/header.php'; ?>

<!-- product details start -->
<div class="product_details mt-60 mb-60">
    <div class="container">
        <div class="row">

            <div class="col-lg-6 col-md-6">
                <div class="product-details-tab">

                    <div id="img-1" class="zoomWrapper single-zoom">
                        <a href="#">
                            <?php if ($mainImage): ?>
                                <img
                                    id="zoom1"
                                    src="<?= $imageBasePath . htmlspecialchars($mainImage) ?>"
                                    data-zoom-image="<?= $imageBasePath . htmlspecialchars($mainImage) ?>"
                                    alt="<?= htmlspecialchars($product['name'] ?? 'Product') ?>"
                                >
                            <?php endif; ?>
                        </a>
                    </div>

                    <div class="single-zoom-thumb">
                        <ul class="s-tab-zoom owl-carousel single-product-active" id="gallery_01">

                            <?php foreach ($images as $index => $image): ?>

                                <li>
                                    <a
                                        href="#"
                                        class="elevatezoom-gallery <?= $index === 0 ? 'active' : '' ?>"
                                        data-update=""
                                        data-image="<?= $imageBasePath .$image['file_path'] ?>"
                                        data-zoom-image="<?= $imageBasePath.$image['file_path'] ?>"
                                    >
                                        <img
                                            src="<?= $imageBasePath . htmlspecialchars($image['file_path']) ?>"
                                            alt="<?= $product['name'] ?? 'Product' ?>"
                                        />
                                    </a>
                                </li>

                            <?php endforeach; ?>

                        </ul>
                    </div>

                </div>
            </div>

            <div class="col-lg-6 col-md-6">
                <div class="product_d_right">

                    <form action="#">

                        <h1><?= htmlspecialchars($product['name'] ?? '') ?></h1>

                        <div class="product_ratting">
                            <ul>
                                <?php for ($i = 0; $i < 5; $i++): ?>
                                    <li>
                                        <a href="#">
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="#fff" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M12 2L15.09 8.26L22 9.27L17 14.14L18.18 21.02L12 17.77L5.82 21.02L7 14.14L2 9.27L8.91 8.26L12 2Z"/>
                                            </svg>
                                        </a>
                                    </li>
                                <?php endfor; ?>
                            </ul>
                        </div>

                        <div class="price_box">

                            <span class="current_price">
                                $<?= number_format((float)($product['price'] ?? 0), 2) ?>
                            </span>

                            <?php if (!empty($product['old_price'])): ?>
                                <span class="old_price">
                                    $<?= number_format((float)$product['old_price'], 2) ?>
                                </span>
                            <?php endif; ?>

                        </div>

                        <div class="product_desc">

                            <ul>
                                <li>
                                    <?= !empty($product['is_active']) ? 'Available' : 'Unavailable' ?>
                                </li>

                                <li>
                                    <?= (int)($product['stock'] ?? 0) ?> Items In Stock
                                </li>
                            </ul>

                            <p>
                                <?= htmlspecialchars($product['description'] ?? 'لا يوجد وصف.') ?>
                            </p>

                        </div>

                        <div class="product_variant quantity">
                            <label>Quantity</label>

                            <input
                                min="1"
                                max="<?= (int)($product['stock'] ?? 1) ?>"
                                value="1"
                                type="number"
                                <?= empty($product['is_active']) || empty($product['stock']) ? 'disabled' : '' ?>
                            >
                        </div>

                        <div class="product_timing">
                            <div data-countdown="2023/12/15"></div>
                        </div>

                        <div class="product_d_action">
                            <ul>

                                <li>
                                    <a href="#" title="Add to wishlist">
                                        <svg width="17" height="17" viewBox="0 0 24 24" fill="#fff" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M12 21.35L10.55 20.03C5.4 15.36 2 12.28 2 8.5C2 5.42 4.42 3 7.5 3C9.24 3 10.91 3.81 12 5.09C13.09 3.81 14.76 3 16.5 3C19.58 3 22 5.42 22 8.5C22 12.28 18.6 15.36 13.45 20.04L12 21.35Z"/>
                                        </svg>
                                        Add to Wishlist
                                    </a>
                                </li>

                                <li>
                                    <a href="#" title="Compare">
                                        <svg width="17" height="17" viewBox="0 0 24 24" fill="#fff" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M7 3H17V5H7V3ZM4 7H20V9H4V7ZM7 11H17V13H7V11ZM4 15H20V17H4V15ZM7 19H17V21H7V19Z"/>
                                        </svg>
                                        Compare
                                    </a>
                                </li>

                            </ul>
                        </div>

                        <div class="product_meta">
                            <span>
                                Product ID:
                                <a href="#">#<?= (int)($product['id'] ?? 0) ?></a>
                            </span>
                        </div>

                    </form>

                    <div class="priduct_social">
                        <ul>

                            <li>
                                <a class="facebook" href="#" title="facebook">
                                    <svg width="17" height="17" viewBox="0 0 24 24" fill="#fff" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M13.5 21V12.8H16.3L16.7 9.6H13.5V7.6C13.5 6.7 13.8 6.1 15.1 6.1H16.8V3.2C16.5 3.2 15.5 3.1 14.3 3.1C11.7 3.1 9.9 4.7 9.9 7.5V9.6H7V12.8H9.9V21H13.5Z"/>
                                    </svg>
                                    Like
                                </a>
                            </li>

                            <li>
                                <a class="twitter" href="#" title="twitter">
                                    <svg width="17" height="17" viewBox="0 0 24 24" fill="#fff" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M22 5.92C21.26 6.25 20.46 6.47 19.63 6.57C20.48 6.06 21.13 5.25 21.44 4.29C20.65 4.76 19.77 5.1 18.83 5.29C18.09 4.5 17.03 4 15.85 4C13.58 4 11.74 5.84 11.74 8.11C11.74 8.43 11.77 8.74 11.84 9.04C8.42 8.87 5.38 7.23 3.35 4.73C3 5.34 2.8 6.04 2.8 6.79C2.8 8.21 3.52 9.47 4.61 10.2C3.94 10.18 3.31 10 2.76 9.69V9.74C2.76 11.73 4.17 13.39 6.05 13.76C5.71 13.85 5.35 13.9 4.97 13.9C4.71 13.9 4.45 13.88 4.2 13.83C4.72 15.46 6.23 16.65 8.02 16.68C6.62 17.77 4.86 18.42 2.95 18.42C2.62 18.42 2.3 18.4 1.98 18.36C3.79 19.52 5.94 20.2 8.25 20.2C15.84 20.2 19.99 13.92 19.99 8.48L19.98 7.91C20.78 7.33 21.47 6.65 22 5.92Z"/>
                                    </svg>
                                    Tweet
                                </a>
                            </li>

                            <li>
                                <a class="pinterest" href="#" title="pinterest">
                                    <svg width="17" height="17" viewBox="0 0 24 24" fill="#fff" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M12 2C6.48 2 2 6.48 2 12C2 16.24 4.64 19.86 8.38 21.25C8.33 20.52 8.28 19.4 8.4 18.59L9.67 13.19C9.67 13.19 9.34 12.53 9.34 11.56C9.34 10.04 10.22 8.9 11.31 8.9C12.24 8.9 12.69 9.6 12.69 10.45C12.69 11.4 12.08 12.83 11.77 14.15C11.51 15.27 12.33 16.18 13.43 16.18C15.42 16.18 16.94 14.08 16.94 11.05C16.94 8.37 15.01 6.5 12.26 6.5
