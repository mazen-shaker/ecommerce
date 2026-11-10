<?php

$pageTitle = 'Categories';
$breadcrumbs = [
    ['label' => 'Home', 'url' => 'index.php'],
    ['label' => 'Categories', 'url' => null],
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
                                <h5 class="card-title">Categories</h5>
                                <p class="text-muted mb-0">Manage and view all categories.</p>
                            </div>

                            <button
                                type="button"
                                class="btn btn-primary"
                                data-bs-toggle="modal"
                                data-bs-target="#addCategoryModal"
                            >
                                <i class="bi bi-plus-lg me-1"></i>
                                Add Category
                            </button>
                        </div>

                        <div class="table-responsive mt-4">
                            <table class="table table-borderless datatable">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Description</th>
                                        <th scope="col">Created At</th>
                                        <th scope="col">Actions</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php foreach ($categories as $category): ?>
                                        <tr>
                                            <th scope="row">
                                                <?= htmlspecialchars((string) $category['id']) ?>
                                            </th>

                                            <td><?= htmlspecialchars($category['name']) ?></td>
                                            <td><?= htmlspecialchars((string) $category['description']) ?></td>
                                            <td><?= htmlspecialchars($category['created_at']) ?></td>

                                            <td>
                                                <div class="d-flex align-items-center gap-2">

                                                    <button
                                                        type="button"
                                                        class="btn btn-link text-primary p-0"
                                                        title="Edit category"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#editCategoryModal"
                                                        data-category-id="<?= htmlspecialchars((string) $category['id'], ENT_QUOTES) ?>"
                                                        data-category-name="<?= htmlspecialchars($category['name'], ENT_QUOTES) ?>"
                                                        data-category-description="<?= htmlspecialchars((string) $category['description'], ENT_QUOTES) ?>"
                                                    >
                                                        <i class="bi bi-pencil-square"></i>
                                                    </button>

                                                    <button
                                                        type="button"
                                                        class="btn btn-link text-danger p-0"
                                                        title="Delete category"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#deleteCategoryModal"
                                                        data-category-id="<?= htmlspecialchars((string) $category['id'], ENT_QUOTES) ?>"
                                                        data-category-name="<?= htmlspecialchars($category['name'], ENT_QUOTES) ?>"
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

<!-- Add Category Modal -->
<div class="modal fade" id="addCategoryModal" tabindex="-1" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="addCategoryModalLabel">
                    <i class="bi bi-plus-circle me-2"></i>Add Category
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="<?= $GLOBALS['basePath'] ?>/categories/store" method="POST">
                <div class="modal-body">

                    <div class="mb-3">
                        <label for="categoryName" class="form-label">Name</label>
                        <input type="text" class="form-control" id="categoryName" name="name" required>
                    </div>

                    <div class="mb-3">
                        <label for="categoryDescription" class="form-label">Description</label>
                        <textarea class="form-control" id="categoryDescription" name="description" rows="3"></textarea>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-lg me-1"></i>Create Category
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>

<!-- Edit Category Modal -->
<div class="modal fade" id="editCategoryModal" tabindex="-1" aria-labelledby="editCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="editCategoryModalLabel">
                    <i class="bi bi-pencil-square me-2"></i>Edit Category
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="<?= $GLOBALS['basePath'] ?>/categories/update" method="POST">
                <div class="modal-body">

                    <input type="hidden" name="id" id="editCategoryId">

                    <div class="mb-3">
                        <label for="editCategoryName" class="form-label">Name</label>
                        <input type="text" class="form-control" id="editCategoryName" name="name" required>
                    </div>

                    <div class="mb-3">
                        <label for="editCategoryDescription" class="form-label">Description</label>
                        <textarea class="form-control" id="editCategoryDescription" name="description" rows="3"></textarea>
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
<div class="modal fade" id="deleteCategoryModal" tabindex="-1" aria-labelledby="deleteCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="deleteCategoryModalLabel">
                    <i class="bi bi-exclamation-triangle text-danger me-2"></i>Confirm Deletion
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="<?= $GLOBALS['basePath'] ?>/categories/destroy" method="POST">
                <div class="modal-body">

                    <input type="hidden" name="id" id="deleteCategoryId">

                    Are you sure you want to delete
                    <strong id="deleteCategoryName"></strong>?

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
    document.getElementById('editCategoryModal').addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;

        document.getElementById('editCategoryId').value          = button.getAttribute('data-category-id');
        document.getElementById('editCategoryName').value        = button.getAttribute('data-category-name');
        document.getElementById('editCategoryDescription').value = button.getAttribute('data-category-description');
    });

    document.getElementById('deleteCategoryModal').addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;

        document.getElementById('deleteCategoryId').value         = button.getAttribute('data-category-id');
        document.getElementById('deleteCategoryName').textContent = button.getAttribute('data-category-name');
    });
</script>

<?php include __DIR__ . '/layouts/footer.php'; ?>
<?php include __DIR__ . '/layouts/footer-scripts.php'; ?>
