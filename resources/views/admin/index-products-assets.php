<?php

$pageTitle = 'Product Assets';
$breadcrumbs = [
    ['label' => 'Home', 'url' => 'index.php'],
    ['label' => 'Products', 'url' => 'products/index'],
    ['label' => 'Product Assets', 'url' => null],
];

$validationErrors = $_SESSION['valedation'] ?? [];
unset($_SESSION['valedation']);
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
                                <h5 class="card-title">Product Assets</h5>
                                <p class="text-muted mb-0">
                                    Manage and view all product assets.
                                </p>
                            </div>

                            <button
                                type="button"
                                class="btn btn-primary"
                                data-bs-toggle="modal"
                                data-bs-target="#addAssetModal"
                            >
                                <i class="bi bi-plus-lg me-1"></i>
                                Add Asset
                            </button>

                        </div>

                        <div class="table-responsive mt-4">

                            <table class="table table-borderless datatable">

                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">File Path</th>
                                        <th scope="col">Actions</th>
                                    </tr>
                                </thead>

                                <tbody>

                                    <?php foreach ($images as $image): ?>

                                        <tr>

                                            <th scope="row">
                                                <?= $image['id'] ?>
                                            </th>

                                            <td>
                                                <?= $image['file_path'] ?>
                                            </td>

                                            <td>

                                                <div class="d-flex align-items-center gap-2">

                                                    <a
                                                        href="<?= $GLOBALS['basePath'] ?>/storage/upload/<?= $image['file_path'] ?>"
                                                        target="_blank"
                                                        rel="noopener noreferrer"
                                                        class="btn btn-link text-info p-0"
                                                        title="View asset"
                                                    >
                                                        <i class="bi bi-eye"></i>
                                                    </a>
                                                    <button
                                                        type="button"
                                                        class="btn btn-link text-danger p-0"
                                                        title="Delete asset"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#deleteAssetModal"
                                                        data-asset-id="<?= $image['id'] ?>"
                                                        data-asset-path="<?= $image['file_path']?>"
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


<!-- Add Asset Modal -->

<div class="modal fade" id="addAssetModal" tabindex="-1" aria-labelledby="addAssetModalLabel" aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title" id="addAssetModalLabel">
                    <i class="bi bi-plus-circle me-2"></i>
                    Add Asset
                </h5>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"
                ></button>

            </div>

            <form
                action="<?= $GLOBALS['basePath'] ?>/products/assets/store"
                method="POST"
                enctype="multipart/form-data"
            >

                <div class="modal-body">

                    <input
                        type="hidden"
                        name="product_id"
                        value="<?=$productId?>"
                    >

                    <div class="mb-3">

                        <label for="assetFile" class="form-label">
                            File
                        </label>

                        <input
                            type="file"
                            class="form-control"
                            id="assetFile"
                            name="images[]"
                            accept="image/*"
                            multiple
                            required
                        >

                    </div>

                </div>

                <div class="modal-footer">

                    <button
                        type="button"
                        class="btn btn-secondary"
                        data-bs-dismiss="modal"
                    >
                        Cancel
                    </button>

                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-lg me-1"></i>
                        Add Asset
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>


<!-- Edit Asset Modal -->

<div class="modal fade" id="editAssetModal" tabindex="-1" aria-labelledby="editAssetModalLabel" aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title" id="editAssetModalLabel">
                    <i class="bi bi-pencil-square me-2"></i>
                    Edit Asset
                </h5>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"
                ></button>

            </div>

            <form
                action="<?= $GLOBALS['basePath'] ?>/products/assets/update"
                method="POST"
                enctype="multipart/form-data"
            >

                <div class="modal-body">

                    <input
                        type="hidden"
                        name="id"
                        id="editAssetId"
                    >

                    <input
                        type="hidden"
                        name="product_id"
                        value="<?=$productId?>"
                    >

                    <div class="mb-3">

                        <label class="form-label">
                            Current File Path
                        </label>

                        <input
                            type="text"
                            class="form-control"
                            id="editAssetPath"
                            readonly
                        >

                    </div>

                    <div class="mb-3">

                        <label for="editAssetFile" class="form-label">
                            Replace File
                        </label>

                        <input
                            type="file"
                            class="form-control"
                            id="editAssetFile"
                            name="images[]"
                            accept="image/*"
                        >

                    </div>

                </div>

                <div class="modal-footer">

                    <button
                        type="button"
                        class="btn btn-secondary"
                        data-bs-dismiss="modal"
                    >
                        Cancel
                    </button>

                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-lg me-1"></i>
                        Save Changes
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>


<!-- Delete Confirmation Modal -->

<div class="modal fade" id="deleteAssetModal" tabindex="-1" aria-labelledby="deleteAssetModalLabel" aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title" id="deleteAssetModalLabel">
                    <i class="bi bi-exclamation-triangle text-danger me-2"></i>
                    Confirm Deletion
                </h5>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"
                ></button>

            </div>

            <form
                action="<?= $GLOBALS['basePath'] ?>/products/assets/destroy"
                method="POST"
            >

                <div class="modal-body">

                    <input
                        type="hidden"
                        name="id"
                        id="deleteAssetId"
                    >

                    <input
                        type="hidden"
                        name="product_id"
                        value="<?=$productId ?>"
                    >

                    Are you sure you want to delete this asset?

                    <strong
                        id="deleteAssetPath"
                        class="d-block mt-2 text-break"
                    ></strong>

                </div>

                <div class="modal-footer">

                    <button
                        type="button"
                        class="btn btn-secondary"
                        data-bs-dismiss="modal"
                    >
                        Cancel
                    </button>

                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-trash me-1"></i>
                        Delete
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>


<script>

    document.getElementById('editAssetModal').addEventListener('show.bs.modal', function (event) {

        const button = event.relatedTarget;

        document.getElementById('editAssetId').value =
            button.getAttribute('data-asset-id');

        document.getElementById('editAssetPath').value =
            button.getAttribute('data-asset-path');

    });


    document.getElementById('deleteAssetModal').addEventListener('show.bs.modal', function (event) {

        const button = event.relatedTarget;

        document.getElementById('deleteAssetId').value =
            button.getAttribute('data-asset-id');

        document.getElementById('deleteAssetPath').textContent =
            button.getAttribute('data-asset-path');

    });

</script>


<?php include __DIR__ . '/layouts/footer.php'; ?>
<?php include __DIR__ . '/layouts/footer-scripts.php'; ?>
