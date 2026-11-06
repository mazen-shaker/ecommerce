<?php

$pageTitle = 'Admins';
$breadcrumbs = [
    ['label' => 'Home', 'url' => 'index.php'],
    ['label' => 'Admins', 'url' => null],
];
?>

<?php include __DIR__ . '/layouts/head.php'; ?>
<?php include __DIR__ . '/layouts/header.php'; ?>
<?php include __DIR__ . '/layouts/sidebar.php'; ?>

<main id="main" class="main">

    <?php include __DIR__ . '/layouts/page-header.php'; ?>

    <section class="section">
        <div class="row">
            <div class="col-12">

                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                            <div>
                                <h5 class="card-title">Admins</h5>
                                <p class="text-muted mb-0">Manage and view all administrators.</p>
                            </div>

                            <button
                                type="button"
                                class="btn btn-primary"
                                data-bs-toggle="modal"
                                data-bs-target="#addAdminModal"
                            >
                                <i class="bi bi-plus-lg me-1"></i>
                                Add Admin
                            </button>
                        </div>

                        <div class="table-responsive mt-4">
                            <table class="table table-borderless datatable">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Admin</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Phone</th>
                                        <th scope="col">Created At</th>
                                        <th scope="col">Updated At</th>
                                        <th scope="col">Actions</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php foreach ($admins as $admin): ?>
                                        <tr>
                                            <th scope="row">
                                                <?= htmlspecialchars((string) $admin['id']) ?>
                                            </th>

                                            <td><?= htmlspecialchars($admin['name']) ?></td>
                                            <td><?= htmlspecialchars($admin['email']) ?></td>
                                            <td><?= htmlspecialchars((string) $admin['phone']) ?></td>
                                            <td><?= htmlspecialchars($admin['created_at']) ?></td>
                                            <td><?= htmlspecialchars((string) $admin['updated_at']) ?></td>

                                            <td>
                                                <div class="d-flex align-items-center gap-2">

                                                    <button
                                                        type="button"
                                                        class="btn btn-link text-primary p-0"
                                                        title="Edit admin"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#editAdminModal"
                                                        data-admin-id="<?= htmlspecialchars((string) $admin['id'], ENT_QUOTES) ?>"
                                                        data-admin-name="<?= htmlspecialchars($admin['name'], ENT_QUOTES) ?>"
                                                        data-admin-email="<?= htmlspecialchars($admin['email'], ENT_QUOTES) ?>"
                                                        data-admin-phone="<?= htmlspecialchars((string) $admin['phone'], ENT_QUOTES) ?>"
                                                    >
                                                        <i class="bi bi-pencil-square"></i>
                                                    </button>

                                                    <button
                                                        type="button"
                                                        class="btn btn-link text-danger p-0"
                                                        title="Delete admin"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#deleteAdminModal"
                                                        data-admin-id="<?= htmlspecialchars((string) $admin['id'], ENT_QUOTES) ?>"
                                                        data-admin-name="<?= htmlspecialchars($admin['name'], ENT_QUOTES) ?>"
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

<!-- Add Admin Modal -->
<div class="modal fade" id="addAdminModal" tabindex="-1" aria-labelledby="addAdminModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="addAdminModalLabel">
                    <i class="bi bi-person-plus me-2"></i>Add Admin
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="<?= $GLOBALS['basePath'] ?>/admin/store" method="POST">
                <div class="modal-body">

                    <div class="mb-3">
                        <label for="adminName" class="form-label">Name</label>
                        <input type="text" class="form-control" id="adminName" name="name" required>
                    </div>

                    <div class="mb-3">
                        <label for="adminEmail" class="form-label">Email</label>
                        <input type="email" class="form-control" id="adminEmail" name="email" required>
                    </div>

                    <div class="mb-3">
                        <label for="adminPhone" class="form-label">Phone</label>
                        <input type="tel" class="form-control" id="adminPhone" name="phone">
                    </div>

                    <div class="mb-3">
                        <label for="adminPassword" class="form-label">Password</label>
                        <input type="password" class="form-control" id="adminPassword" name="password" required>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-lg me-1"></i>Create Admin
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>

<!-- Edit Admin Modal -->
<div class="modal fade" id="editAdminModal" tabindex="-1" aria-labelledby="editAdminModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="editAdminModalLabel">
                    <i class="bi bi-pencil-square me-2"></i>Edit Admin
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="<?= $GLOBALS['basePath'] ?>/admin/update" method="POST">
                <div class="modal-body">

                    <input type="hidden" name="id" id="editAdminId">

                    <div class="mb-3">
                        <label for="editAdminName" class="form-label">Name</label>
                        <input type="text" class="form-control" id="editAdminName" name="name" required>
                    </div>

                    <div class="mb-3">
                        <label for="editAdminEmail" class="form-label">Email</label>
                        <input type="email" class="form-control" id="editAdminEmail" name="email" required>
                    </div>

                    <div class="mb-3">
                        <label for="editAdminPhone" class="form-label">Phone</label>
                        <input type="tel" class="form-control" id="editAdminPhone" name="phone">
                    </div>

                    <div class="mb-3">
                        <label for="editAdminPassword" class="form-label">New Password</label>
                        <input
                            type="password"
                            class="form-control"
                            id="editAdminPassword"
                            name="password"
                            placeholder="Leave blank to keep current password"
                        >
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
<div class="modal fade" id="deleteAdminModal" tabindex="-1" aria-labelledby="deleteAdminModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="deleteAdminModalLabel">
                    <i class="bi bi-exclamation-triangle text-danger me-2"></i>Confirm Deletion
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="<?= $GLOBALS['basePath'] ?>/admin/delete" method="POST">
                <div class="modal-body">

                    <input type="hidden" name="id" id="deleteAdminId">

                    Are you sure you want to delete
                    <strong id="deleteAdminName"></strong>?

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
    document.getElementById('editAdminModal').addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;

        document.getElementById('editAdminId').value       = button.getAttribute('data-admin-id');
        document.getElementById('editAdminName').value     = button.getAttribute('data-admin-name');
        document.getElementById('editAdminEmail').value    = button.getAttribute('data-admin-email');
        document.getElementById('editAdminPhone').value    = button.getAttribute('data-admin-phone');
        document.getElementById('editAdminPassword').value = '';
    });

    document.getElementById('deleteAdminModal').addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;

        document.getElementById('deleteAdminId').value         = button.getAttribute('data-admin-id');
        document.getElementById('deleteAdminName').textContent = button.getAttribute('data-admin-name');
    });
</script>

<?php include __DIR__ . '/layouts/footer.php'; ?>
<?php include __DIR__ . '/layouts/footer-scripts.php'; ?>
