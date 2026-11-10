<?php

$pageTitle = 'Users';
$breadcrumbs = [
    ['label' => 'Home', 'url' => 'index.php'],
    ['label' => 'Users', 'url' => null],
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
                                <h5 class="card-title">Users</h5>
                                <p class="text-muted mb-0">Manage and view all registered users.</p>
                            </div>

                            <button
                                type="button"
                                class="btn btn-primary"
                                data-bs-toggle="modal"
                                data-bs-target="#addUserModal"
                            >
                                <i class="bi bi-plus-lg me-1"></i>
                                Add User
                            </button>
                        </div>

                        <div class="table-responsive mt-4">
                            <table class="table table-borderless datatable">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">User</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Phone</th>
                                        <th scope="col">Created At</th>
                                        <th scope="col">Actions</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php foreach ($users as $user): ?>
                                        <tr>
                                            <th scope="row">
                                                <?= htmlspecialchars((string) $user['id']) ?>
                                            </th>

                                            <td><?= htmlspecialchars($user['name']) ?></td>
                                            <td><?= htmlspecialchars($user['email']) ?></td>
                                            <td><?= htmlspecialchars((string) $user['phone']) ?></td>
                                            <td><?= htmlspecialchars($user['created_at']) ?></td>

                                            <td>
                                                <div class="d-flex align-items-center gap-2">

                                                    <button
                                                        type="button"
                                                        class="btn btn-link text-primary p-0"
                                                        title="Edit user"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#editUserModal"
                                                        data-user-id="<?= htmlspecialchars((string) $user['id'], ENT_QUOTES) ?>"
                                                        data-user-name="<?= htmlspecialchars($user['name'], ENT_QUOTES) ?>"
                                                        data-user-email="<?= htmlspecialchars($user['email'], ENT_QUOTES) ?>"
                                                        data-user-phone="<?= htmlspecialchars((string) $user['phone'], ENT_QUOTES) ?>"
                                                    >
                                                        <i class="bi bi-pencil-square"></i>
                                                    </button>

                                                    <button
                                                        type="button"
                                                        class="btn btn-link text-danger p-0"
                                                        title="Delete user"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#deleteUserModal"
                                                        data-user-id="<?= htmlspecialchars((string) $user['id'], ENT_QUOTES) ?>"
                                                        data-user-name="<?= htmlspecialchars($user['name'], ENT_QUOTES) ?>"
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

<!-- Add User Modal -->
<div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="addUserModalLabel">
                    <i class="bi bi-person-plus me-2"></i>Add User
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="<?= $GLOBALS['basePath'] ?>/users/store" method="POST">
                <div class="modal-body">

                    <div class="mb-3">
                        <label for="userName" class="form-label">Name</label>
                        <input type="text" class="form-control" id="userName" name="name" required>
                    </div>

                    <div class="mb-3">
                        <label for="userEmail" class="form-label">Email</label>
                        <input type="email" class="form-control" id="userEmail" name="email" required>
                    </div>

                    <div class="mb-3">
                        <label for="userPhone" class="form-label">Phone</label>
                        <input type="tel" class="form-control" id="userPhone" name="phone">
                    </div>

                    <div class="mb-3">
                        <label for="userPassword" class="form-label">Password</label>
                        <input type="password" class="form-control" id="userPassword" name="password" required>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-lg me-1"></i>Create User
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>

<!-- Edit User Modal -->
<div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="editUserModalLabel">
                    <i class="bi bi-pencil-square me-2"></i>Edit User
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="<?= $GLOBALS['basePath'] ?>/users/update" method="POST">
                <div class="modal-body">

                    <input type="hidden" name="id" id="editUserId">

                    <div class="mb-3">
                        <label for="editUserName" class="form-label">Name</label>
                        <input type="text" class="form-control" id="editUserName" name="name" required>
                    </div>

                    <div class="mb-3">
                        <label for="editUserEmail" class="form-label">Email</label>
                        <input type="email" class="form-control" id="editUserEmail" name="email" required>
                    </div>

                    <div class="mb-3">
                        <label for="editUserPhone" class="form-label">Phone</label>
                        <input type="tel" class="form-control" id="editUserPhone" name="phone">
                    </div>

                    <div class="mb-3">
                        <label for="editUserPassword" class="form-label">New Password</label>
                        <input
                            type="password"
                            class="form-control"
                            id="editUserPassword"
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
<div class="modal fade" id="deleteUserModal" tabindex="-1" aria-labelledby="deleteUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="deleteUserModalLabel">
                    <i class="bi bi-exclamation-triangle text-danger me-2"></i>Confirm Deletion
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="<?= $GLOBALS['basePath'] ?>/users/destroy" method="POST">
                <div class="modal-body">

                    <input type="hidden" name="id" id="deleteUserId">

                    Are you sure you want to delete
                    <strong id="deleteUserName"></strong>?

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
    document.getElementById('editUserModal').addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;

        document.getElementById('editUserId').value       = button.getAttribute('data-user-id');
        document.getElementById('editUserName').value     = button.getAttribute('data-user-name');
        document.getElementById('editUserEmail').value    = button.getAttribute('data-user-email');
        document.getElementById('editUserPhone').value    = button.getAttribute('data-user-phone');
        document.getElementById('editUserPassword').value = '';
    });

    document.getElementById('deleteUserModal').addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;

        document.getElementById('deleteUserId').value         = button.getAttribute('data-user-id');
        document.getElementById('deleteUserName').textContent = button.getAttribute('data-user-name');
    });
</script>

<?php include __DIR__ . '/layouts/footer.php'; ?>
<?php include __DIR__ . '/layouts/footer-scripts.php'; ?>
