<?php
$pageTitle = 'product create';

$breadcrumbs = [
    ['label' => 'product create', 'url' => null],
];

include dirname(__FILE__, 2) . "/layouts/head.php";
include dirname(__FILE__, 2) . "/layouts/header.php";
?>





<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-7">

            <div class="card shadow border-0">
                <div class="card-header bg-dark text-white py-3">
                    <h4 class="mb-0">Create New Product</h4>
                </div>

                <div class="card-body p-4">

                    <form action="" method="POST" enctype="multipart/form-data">

                        <div class="mb-3">
                            <label class="form-label">Product Name</label>
                            <input type="text" name="name"
                                class="form-control"
                                placeholder="Enter product name" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="description"
                                class="form-control"
                                rows="4"
                                placeholder="Enter product description"
                                required></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Price (EGP)</label>
                            <input type="number" name="price"
                                class="form-control"
                                step="0.01" min="0"
                                placeholder="Enter current price" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Old Price (EGP)</label>
                            <input type="number" name="old_price"
                                class="form-control"
                                step="0.01" min="0"
                                placeholder="Enter old price">
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Product Image</label>
                            <input type="file" name="image"
                                class="form-control"
                                accept="image/*">
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-dark px-4">
                                Create Product
                            </button>

                            <a href="javascript:history.back()"
                                class="btn btn-outline-secondary px-4">
                                Cancel
                            </a>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>
</div>








<?php
include dirname(__FILE__, 2) . "/layouts/footer.php";
include dirname(__FILE__, 2) . "/layouts/footer-scripts.php";
?>