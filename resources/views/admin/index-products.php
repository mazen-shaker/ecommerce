<?php

$pageTitle = 'Products';
$breadcrumbs = [
    ['label' => 'Home', 'url' => 'index.php'],
    ['label' => 'Products', 'url' => null],
];

$validationErrors = $_SESSION['valedation'] ?? [];
unset($_SESSION['valedation']);

// lookup: category_id => category name
$categoryNames = array_column($categories, 'name', 'id');
?>

<?php include __DIR__ . '/layouts/head.php'; ?>
<?php include __DIR__ . '/layouts/header.php'; ?>
<?php include __DIR__ . '/layouts/sidebar.php'; ?>

<main id="main" class="main">

    <?php include __DIR__ . '/layouts/page-header.php'; ?>

    <section class="section">
        <div class="row">
            <div class="col-12">

                <?php if (!empty($validationErrors)): ?>
                    <?php foreach ($validationErrors as $error): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="bi bi-exclamation-octagon me-1"></i>
                            <?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?>

                            <button
                                type="button"
                                class="btn-close"
                                data-bs-dismiss="alert"
                                aria-label="Close"
                            ></button>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>

                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                            <div>
                                <h5 class="card-title">Products</h5>
                                <p class="text-muted mb-0">Manage and view all products.</p>
                            </div>

                            <button
                                type="button"
                                class="btn btn-primary"
                                data-bs-toggle="modal"
                                data-bs-target="#addProductModal"
                            >
                                <i class="bi bi-plus-lg me-1"></i>
                                Add Product
                            </button>
                        </div>

                        <div class="table-responsive mt-4">
                            <table class="table table-borderless datatable">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Category</th>
                                        <th scope="col">Price</th>
                                        <th scope="col">Stock</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Created At</th>
                                        <th scope="col">Actions</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php foreach ($products as $product): ?>
                                        <tr>
                                            <th scope="row">
                                                <?= htmlspecialchars((string) $product['id']) ?>
                                            </th>

                                            <td><?= htmlspecialchars($product['name']) ?></td>

                                            <td>
                                                <?= htmlspecialchars($categoryNames[$product['category_id']] ?? '-') ?>
                                            </td>

                                            <td>
                                                <?= number_format((float) $product['price'], 2) ?>
                                                <?php if (!empty($product['old_price'])): ?>
                                                    <br>
                                                    <del class="text-muted small">
                                                        <?= number_format((float) $product['old_price'], 2) ?>
                                                    </del>
                                                <?php endif; ?>
                                            </td>

                                            <td>
                                                <?php if ((int) $product['stock'] > 0): ?>
                                                    <?= htmlspecialchars((string) $product['stock']) ?>
                                                <?php else: ?>
                                                    <span class="badge bg-danger">Out of stock</span>
                                                <?php endif; ?>
                                            </td>

                                            <td>
                                                <span class="badge bg-<?= $product['is_active'] ? 'success' : 'secondary' ?>">
                                                    <?= $product['is_active'] ? 'Active' : 'Inactive' ?>
                                                </span>
                                            </td>

                                            <td><?= htmlspecialchars($product['created_at']) ?></td>

                                            <td>
                                                <div class="d-flex align-items-center gap-2">

                                                    <a
                                                        href="<?= $GLOBALS['basePath'] ?>/products/assets/index/<?= urlencode((string) $product['id']) ?>"
                                                        class="btn btn-link text-info p-0"
                                                        title="Manage product assets"
                                                    >
                                                        <i class="bi bi-images"></i>
                                                    </a>

                                                    <button
                                                        type="button"
                                                        class="btn btn-link text-primary p-0"
                                                        title="Edit product"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#editProductModal"
                                                        data-product-id="<?= htmlspecialchars((string) $product['id'], ENT_QUOTES) ?>"
                                                        data-product-category-id="<?= htmlspecialchars((string) $product['category_id'], ENT_QUOTES) ?>"
                                                        data-product-name="<?= htmlspecialchars($product['name'], ENT_QUOTES) ?>"
                                                        data-product-description="<?= htmlspecialchars((string) $product['description'], ENT_QUOTES) ?>"
                                                        data-product-price="<?= htmlspecialchars((string) $product['price'], ENT_QUOTES) ?>"
                                                        data-product-old-price="<?= htmlspecialchars((string) $product['old_price'], ENT_QUOTES) ?>"
                                                        data-product-stock="<?= htmlspecialchars((string) $product['stock'], ENT_QUOTES) ?>"
                                                        data-product-is-active="<?= (int) $product['is_active'] ?>"
                                                    >
                                                        <i class="bi bi-pencil-square"></i>
                                                    </button>

                                                    <button
                                                        type="button"
                                                        class="btn btn-link text-danger p-0"
                                                        title="Delete product"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#deleteProductModal"
                                                        data-product-id="<?= htmlspecialchars((string) $product['id'], ENT_QUOTES) ?>"
                                                        data-product-name="<?= htmlspecialchars($product['name'], ENT_QUOTES) ?>"
                                                    >
                                                        <i class="bi bi-trash"></i>
                                                    </button>

                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </section>

</main>

<!-- Add Product Modal -->
<div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="addProductModalLabel">
                    <i class="bi bi-plus-circle me-2"></i>Add Product
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="<?= $GLOBALS['basePath'] ?>/products/store" method="POST" enctype="multipart/form-data">
                <div class="modal-body">

                    <div class="mb-3">
                        <label for="productName" class="form-label">Name</label>
                        <input type="text" class="form-control" id="productName" name="name" required>
                    </div>

                    <div class="mb-3">
                        <label for="productCategory" class="form-label">Category</label>
                        <select class="form-select" id="productCategory" name="category_id" required>
                            <option value="" selected disabled>Select category</option>
                            <?php foreach ($categories as $category): ?>
                                <option value="<?= htmlspecialchars((string) $category['id'], ENT_QUOTES) ?>">
                                    <?= htmlspecialchars($category['name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="productDescription" class="form-label">Description</label>
                        <textarea class="form-control" id="productDescription" name="description" rows="3"></textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="productPrice" class="form-label">Price</label>
                            <input type="number" step="0.01" min="0" class="form-control" id="productPrice" name="price" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="productOldPrice" class="form-label">Old Price</label>
                            <input type="number" step="0.01" min="0" class="form-control" id="productOldPrice" name="old_price">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="productStock" class="form-label">Stock</label>
                        <input type="number" min="0" class="form-control" id="productStock" name="stock" value="0" required>
                    </div>

                    <div class="mb-3">
                        <label for="productImages" class="form-label">Images</label>
                        <input type="file" class="form-control" id="productImages" name="images[]" accept="image/*" multiple>
                    </div>

                    <div class="form-check form-switch">
                        <input type="hidden" name="is_active" value="0">
                        <input class="form-check-input" type="checkbox" role="switch" id="productIsActive" name="is_active" value="1" checked>
                        <label class="form-check-label" for="productIsActive">Active</label>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-lg me-1"></i>Create Product
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>

<!-- Edit Product Modal -->
<div class="modal fade" id="editProductModal" tabindex="-1" aria-labelledby="editProductModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="editProductModalLabel">
                    <i class="bi bi-pencil-square me-2"></i>Edit Product
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="<?= $GLOBALS['basePath'] ?>/products/update" method="POST" enctype="multipart/form-data">
                <div class="modal-body">

                    <input type="hidden" name="id" id="editProductId">

                    <div class="mb-3">
                        <label for="editProductName" class="form-label">Name</label>
                        <input type="text" class="form-control" id="editProductName" name="name" required>
                    </div>

                    <div class="mb-3">
                        <label for="editProductCategory" class="form-label">Category</label>
                        <select class="form-select" id="editProductCategory" name="category_id" required>
                            <?php foreach ($categories as $category): ?>
                                <option value="<?= htmlspecialchars((string) $category['id'], ENT_QUOTES) ?>">
                                    <?= htmlspecialchars($category['name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="editProductDescription" class="form-label">Description</label>
                        <textarea class="form-control" id="editProductDescription" name="description" rows="3"></textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="editProductPrice" class="form-label">Price</label>
                            <input type="number" step="0.01" min="0" class="form-control" id="editProductPrice" name="price" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="editProductOldPrice" class="form-label">Old Price</label>
                            <input type="number" step="0.01" min="0" class="form-control" id="editProductOldPrice" name="old_price">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="editProductStock" class="form-label">Stock</label>
                        <input type="number" min="0" class="form-control" id="editProductStock" name="stock" required>
                    </div>



                    <div class="form-check form-switch">
                        <input type="hidden" name="is_active" value="0">
                        <input class="form-check-input" type="checkbox" role="switch" id="editProductIsActive" name="is_active" value="1">
                        <label class="form-check-label" for="editProductIsActive">Active</label>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-lg me-1"></i>Save Changes
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteProductModal" tabindex="-1" aria-labelledby="deleteProductModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="deleteProductModalLabel">
                    <i class="bi bi-exclamation-triangle text-danger me-2"></i>Confirm Deletion
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="<?= $GLOBALS['basePath'] ?>/products/destroy" method="POST">
                <div class="modal-body">

                    <input type="hidden" name="id" id="deleteProductId">

                    Are you sure you want to delete
                    <strong id="deleteProductName"></strong>?

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-trash me-1"></i>Delete
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>

<script>
    document.getElementById('editProductModal').addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;

        document.getElementById('editProductId').value          = button.getAttribute('data-product-id');
        document.getElementById('editProductCategory').value    = button.getAttribute('data-product-category-id');
        document.getElementById('editProductName').value        = button.getAttribute('data-product-name');
        document.getElementById('editProductDescription').value = button.getAttribute('data-product-description');
        document.getElementById('editProductPrice').value       = button.getAttribute('data-product-price');
        document.getElementById('editProductOldPrice').value    = button.getAttribute('data-product-old-price');
        document.getElementById('editProductStock').value       = button.getAttribute('data-product-stock');
        document.getElementById('editProductIsActive').checked  = button.getAttribute('data-product-is-active') === '1';
    });

    document.getElementById('deleteProductModal').addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;

        document.getElementById('deleteProductId').value         = button.getAttribute('data-product-id');
        document.getElementById('deleteProductName').textContent = button.getAttribute('data-product-name');
    });
</script>

<?php include __DIR__ . '/layouts/footer.php'; ?>
<?php include __DIR__ . '/layouts/footer-scripts.php'; ?>

