<?php

$pageTitle = 'product-details';

$breadcrumbs = [
    ['label' => 'product-details', 'url' => null],
];

$product = $product ?? [];

$productData = $product[0] ?? [];

$images = $product['image'] ?? [];

$imageBasePath = $GLOBALS['basePath'] . '/storage/upload/';

$mainImage = $product['thub']['file_path'] ?? null;

$productName = htmlspecialchars($productData['name'] ?? 'Product');
$productDescription = htmlspecialchars($productData['description'] ?? 'لا يوجد وصف.');

$price = (float)($productData['price'] ?? 0);
$oldPrice = (float)($productData['old_price'] ?? 0);

$stock = (int)($productData['stock'] ?? 0);
$isAvailable = !empty($productData['is_active']) && $stock > 0;

$mainImagePath = $mainImage
    ? $imageBasePath . htmlspecialchars($mainImage)
    : null;

include __DIR__ . '/layouts/head.php';

?>

<style>
    .product_d_right .product_desc ul li {
        position: relative;
        padding-left: 24px;
        color: inherit;
    }

    .product_d_right .product_desc ul li::before {
        content: none !important;
        display: none !important;
    }

    .product_d_right .product_desc ul li .stock-icon {
        position: absolute;
        left: 0;
        top: 5px;
        width: 15px;
        height: 15px;
    }

    .product_d_right .product_desc ul li .stock-icon.available,
    .product_d_right .product_desc ul li .stock-icon.quantity {
        color: #39b93c;
    }

    .product_d_right .product_desc ul li .stock-icon.unavailable {
        color: #e53935;
    }

    .product_d_right .priduct_social svg {
        fill: #ffffff !important;
    }
</style>

<?php include __DIR__ . '/layouts/header.php'; ?>

<!-- breadcrumbs area start -->
<div class="breadcrumbs_area">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="breadcrumb_content">
                    <ul>
                        <li>
                            <a href="<?= $GLOBALS['basePath'] ?>/">home</a>
                        </li>
                        <li>Product details</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- breadcrumbs area end -->


<!-- product details start -->
<div class="product_details mt-60 mb-60">
    <div class="container">
        <div class="row">

            <!-- Product Images -->
            <div class="col-lg-6 col-md-6">
                <div class="product-details-tab">

                    <div id="img-1" class="zoomWrapper single-zoom">
                        <a href="#">
                            <?php if ($mainImagePath): ?>
                                <img
                                    id="zoom1"
                                    src="<?= $mainImagePath ?>"
                                    data-zoom-image="<?= $mainImagePath ?>"
                                    alt="<?= $productName ?>"
                                >
                            <?php else: ?>
                                <img
                                    id="zoom1"
                                    src="<?= $GLOBALS['basePath'] ?>/assets/img/product/no-image.jpg"
                                    alt="<?= $productName ?>"
                                >
                            <?php endif; ?>
                        </a>
                    </div>

                    <div class="single-zoom-thumb">
                        <ul
                            class="s-tab-zoom owl-carousel single-product-active"
                            id="gallery_01"
                        >

                            <?php foreach ($images as $index => $image): ?>

                                <?php
                                    $imagePath = $imageBasePath . htmlspecialchars($image['file_path']);
                                ?>

                                <li>
                                    <a
                                        href="#"
                                        class="elevatezoom-gallery <?= $index === 0 ? 'active' : '' ?>"
                                        data-update=""
                                        data-image="<?= $imagePath ?>"
                                        data-zoom-image="<?= $imagePath ?>"
                                    >
                                        <img
                                            src="<?= $imagePath ?>"
                                            alt="<?= $productName ?>"
                                        >
                                    </a>
                                </li>

                            <?php endforeach; ?>

                        </ul>
                    </div>

                </div>
            </div>


            <!-- Product Information -->
            <div class="col-lg-6 col-md-6">
                <div class="product_d_right">

                    <form action="#" method="POST">

                        <h1><?= $productName ?></h1>

                        <!-- Rating -->
                        <div class="product_ratting">
                            <ul>
                                <?php for ($i = 0; $i < 5; $i++): ?>
                                    <li>
                                        <a href="#">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="#F9A825">
                                                <path d="M12 2.25c.35 0 .67.2.82.52l2.76 5.6 6.18.9c.35.05.64.3.75.64.1.34.01.7-.24.95l-4.47 4.36 1.05 6.16a.9.9 0 0 1-1.3.95L12 19.42l-5.53 2.91a.9.9 0 0 1-1.3-.95l1.05-6.16-4.47-4.36a.9.9 0 0 1 .5-1.59l6.18-.9 2.76-5.6a.9.9 0 0 1 .81-.52Z"/>
                                            </svg>
                                        </a>
                                    </li>
                                <?php endfor; ?>
                            </ul>
                        </div>


                        <!-- Price -->
                        <div class="price_box">

                            <span class="current_price">
                                $<?= number_format($price, 2) ?>
                            </span>

                            <?php if ($oldPrice > $price): ?>
                                <span class="old_price">
                                    $<?= number_format($oldPrice, 2) ?>
                                </span>
                            <?php endif; ?>

                        </div>


                        <!-- Description -->
                        <div class="product_desc">

                            <ul>
                                <li>
                                    <?php if ($isAvailable): ?>
                                        <svg class="stock-icon available" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M12 2a10 10 0 1 0 0 20 10 10 0 0 0 0-20Zm4.7 7.7-5.5 5.5a1 1 0 0 1-1.4 0l-2.5-2.5a1 1 0 1 1 1.4-1.4l1.8 1.8 4.8-4.8a1 1 0 0 1 1.4 1.4Z"/>
                                        </svg>
                                    <?php else: ?>
                                        <svg class="stock-icon unavailable" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M12 2a10 10 0 1 0 0 20 10 10 0 0 0 0-20Zm3.7 12.3a1 1 0 0 1-1.4 1.4L12 13.4l-2.3 2.3a1 1 0 0 1-1.4-1.4l2.3-2.3-2.3-2.3a1 1 0 0 1 1.4-1.4l2.3 2.3 2.3-2.3a1 1 0 0 1 1.4 1.4L13.4 12l2.3 2.3Z"/>
                                        </svg>
                                    <?php endif; ?>

                                    <?= $isAvailable ? 'In Stock' : 'Out Of Stock' ?>
                                </li>

                                <li>
                                    <svg class="stock-icon quantity" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M20 4h-3.2a4.98 4.98 0 0 0-9.6 0H4a2 2 0 0 0-2 2v13a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2ZM12 3a3 3 0 0 1 2.83 2H9.17A3 3 0 0 1 12 3Zm8 16H4V6h16v13Zm-9-2h2v-2h-2v2Zm0-4h2V9h-2v4Z"/>
                                    </svg>

                                    <?= $stock ?> Items In Stock
                                </li>
                            </ul>

                            <p><?= $productDescription ?></p>

                        </div>


                        <!-- Countdown -->
                        <?php if (!empty($productData['sale_ends_at'])): ?>
                            <div class="product_timing">
                                <div data-countdown="<?= htmlspecialchars($productData['sale_ends_at']) ?>"></div>
                            </div>
                        <?php endif; ?>


                        <!-- Product Options -->
                        <div class="product_variant color">
                            <h3>Available Options</h3>
                        </div>


                        <!-- Quantity -->
                        <div class="product_variant quantity">

                            <label>Quantity</label>

                            <input
                                type="number"
                                min="1"
                                max="<?= $stock ?>"
                                value="1"
                                name="quantity"
                                <?= !$isAvailable ? 'disabled' : '' ?>
                            >

                            <button
                                class="button"
                                type="submit"
                                <?= !$isAvailable ? 'disabled' : '' ?>
                            >
                                Add to Cart
                            </button>

                        </div>


                        <!-- Wishlist & Compare -->
                        <div class="product_d_action">
                            <ul>
                                <li>
                                    <a href="#" title="Add to wishlist">
                                        + Add to Wishlist
                                    </a>
                                </li>

                                <li>

                                </li>
                            </ul>
                        </div>


                        <!-- Product Meta -->
                        <div class="product_meta">
                            <span>
                                Product ID:
                                <a href="#">
                                    #<?= (int)($productData['id'] ?? 0) ?>
                                </a>
                            </span>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
<!-- product details end -->


<!-- product info start -->
<div class="product_d_info mb-60">
    <div class="container">
        <div class="row">
            <div class="col-12">

                <div class="product_d_inner">

                    <!-- Tabs Navigation -->
                    <div class="product_info_button">
                        <ul class="nav" role="tablist">

                            <li>
                                <a
                                    class="active"
                                    data-toggle="tab"
                                    href="#info"
                                    role="tab"
                                    aria-controls="info"
                                    aria-selected="true"
                                >
                                    Description
                                </a>
                            </li>

                            <li>
                                <a
                                    data-toggle="tab"
                                    href="#sheet"
                                    role="tab"
                                    aria-controls="sheet"
                                    aria-selected="false"
                                >
                                    Specification
                                </a>
                            </li>

                            <li>
                                <a
                                    data-toggle="tab"
                                    href="#reviews"
                                    role="tab"
                                    aria-controls="reviews"
                                    aria-selected="false"
                                >
                                    Reviews (0)
                                </a>
                            </li>

                        </ul>
                    </div>


                    <!-- Tabs Content -->
                    <div class="tab-content">

                        <!-- Description -->
                        <div
                            class="tab-pane fade show active"
                            id="info"
                            role="tabpanel"
                        >
                            <div class="product_info_content">
                                <p><?= nl2br($productDescription) ?></p>
                            </div>
                        </div>


                        <!-- Specification -->
                        <div
                            class="tab-pane fade"
                            id="sheet"
                            role="tabpanel"
                        >
                            <div class="product_d_table">
                                <table>
                                    <tbody>

                                        <tr>
                                            <td class="first_child">
                                                Product Name
                                            </td>
                                            <td><?= $productName ?></td>
                                        </tr>

                                        <tr>
                                            <td class="first_child">
                                                Category
                                            </td>
                                            <td>
                                                <?= htmlspecialchars($productData['category_id'] ?? 'N/A') ?>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td class="first_child">
                                                Price
                                            </td>
                                            <td>
                                                $<?= number_format($price, 2) ?>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td class="first_child">
                                                Stock
                                            </td>
                                            <td><?= $stock ?></td>
                                        </tr>

                                        <tr>
                                            <td class="first_child">
                                                Availability
                                            </td>
                                            <td>
                                                <?= $isAvailable ? 'Available' : 'Unavailable' ?>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td class="first_child">
                                                Created At
                                            </td>
                                            <td>
                                                <?= htmlspecialchars($productData['created_at'] ?? '') ?>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td class="first_child">
                                                Updated At
                                            </td>
                                            <td>
                                                <?= htmlspecialchars($productData['updated_at'] ?? '') ?>
                                            </td>
                                        </tr>

                                    </tbody>
                                </table>
                            </div>
                        </div>


                        <!-- Reviews -->
                        <div
                            class="tab-pane fade"
                            id="reviews"
                            role="tabpanel"
                        >
                            <div class="reviews_wrapper">

                                <h2>Reviews</h2>

                                <p>No reviews yet.</p>

                                <div class="comment_title">
                                    <h2>Add a review</h2>

                                    <p>
                                        Your email address will not be published.
                                        Required fields are marked.
                                    </p>
                                </div>

                                <div class="product_ratting mb-10">
                                    <h3>Your rating</h3>

                                    <ul>
                                        <?php for ($i = 1; $i <= 5; $i++): ?>
                                            <li>
                                                <a href="#" data-rating="<?= $i ?>">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="#F9A825">
                                                        <path d="M12 2.25c.35 0 .67.2.82.52l2.76 5.6 6.18.9c.35.05.64.3.75.64.1.34.01.7-.24.95l-4.47 4.36 1.05 6.16a.9.9 0 0 1-1.3.95L12 19.42l-5.53 2.91a.9.9 0 0 1-1.3-.95l1.05-6.16-4.47-4.36a.9.9 0 0 1 .5-1.59l6.18-.9 2.76-5.6a.9.9 0 0 1 .81-.52Z"/>
                                                    </svg>
                                                </a>
                                            </li>
                                        <?php endfor; ?>
                                    </ul>
                                </div>

                                <div class="product_review_form">
                                    <form action="#" method="POST">

                                        <div class="row">

                                            <div class="col-12">
                                                <label for="review_comment">
                                                    Your review
                                                </label>

                                                <textarea
                                                    name="comment"
                                                    id="review_comment"
                                                ></textarea>
                                            </div>

                                            <div class="col-lg-6 col-md-6">
                                                <label for="author">
                                                    Name
                                                </label>

                                                <input
                                                    id="author"
                                                    name="name"
                                                    type="text"
                                                >
                                            </div>

                                            <div class="col-lg-6 col-md-6">
                                                <label for="email">
                                                    Email
                                                </label>

                                                <input
                                                    id="email"
                                                    name="email"
                                                    type="email"
                                                >
                                            </div>

                                        </div>

                                        <button type="submit">
                                            Submit
                                        </button>

                                    </form>
                                </div>

                            </div>
                        </div>

                    </div>

                </div>

            </div>
        </div>
    </div>
</div>
<!-- product info end -->


<?php
include __DIR__ . '/layouts/footer.php';
include __DIR__ . '/layouts/footer-scripts.php';
?>
