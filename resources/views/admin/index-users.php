<?php

$pageTitle = 'Users';
$breadcrumbs = [
    ['label' => 'Home', 'url' => 'index.php'],
    ['label' => 'Users', 'url' => null],
];

$users = [
    [
        'id' => 1,
        'name' => 'Brandon Jacob',
        'email' => 'brandon.jacob@example.com',
        'phone' => '+1 555-0101',
        'role' => 'Admin',
        'status' => 'Active',
    ],
    [
        'id' => 2,
        'name' => 'Bridie Kessler',
        'email' => 'bridie.kessler@example.com',
        'phone' => '+1 555-0102',
        'role' => 'Editor',
        'status' => 'Active',
    ],
    [
        'id' => 3,
        'name' => 'Ashleigh Langosh',
        'email' => 'ashleigh.langosh@example.com',
        'phone' => '+1 555-0103',
        'role' => 'User',
        'status' => 'Pending',
    ],
    [
        'id' => 4,
        'name' => 'Angus Grady',
        'email' => 'angus.grady@example.com',
        'phone' => '+1 555-0104',
        'role' => 'User',
        'status' => 'Inactive',
    ],
    [
        'id' => 5,
        'name' => 'Raheem Lehner',
        'email' => 'raheem.lehner@example.com',
        'phone' => '+1 555-0105',
        'role' => 'Editor',
        'status' => 'Active',
    ],
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
                                        <th scope="col">Role</th>
                                        <th scope="col">Status</th>
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
                                            <td><?= htmlspecialchars($user['phone']) ?></td>
                                            <td><?= htmlspecialchars($user['role']) ?></td>

                                            <td>
                                                <?php
                                                $statusClass = match ($user['status']) {
                                                    'Active' => 'success',
                                                    'Pending' => 'warning',
                                                    'Inactive' => 'secondary',
                                                    default => 'secondary',
                                                };
                                                ?>
                                                <span class="badge bg-<?= $statusClass ?>">
                                                    <?= htmlspecialchars($user['status']) ?>
                                                </span>
                                            </td>

                                            <td>
                                                <div class="d-flex align-items-center gap-2">

                                                    <button
                                                        type="button"
                                                        class="btn btn-link text-primary p-0"
                                                        title="Edit user"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#editUserModal"
                                                        data-user-id="<?= htmlspecialchars((string) $user['id']) ?>"
                                                        data-user-name="<?= htmlspecialchars($user['name'], ENT_QUOTES) ?>"
                                                        data-user-email="<?= htmlspecialchars($user['email'], ENT_QUOTES) ?>"
                                                        data-user-phone="<?= htmlspecialchars($user['phone'], ENT_QUOTES) ?>"
                                                        data-user-role="<?= htmlspecialchars($user['role'], ENT_QUOTES) ?>"
                                                        data-user-status="<?= htmlspecialchars($user['status'], ENT_QUOTES) ?>"
                                                    >
                                                        <i class="bi bi-pencil-square"></i>
                                                    </button>

                                                    <button
                                                        type="button"
                                                        class="btn btn-link text-danger p-0"
                                                        title="Delete user"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#deleteUserModal"
                                                        data-user-id="<?= htmlspecialchars((string) $user['id']) ?>"
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

            <form action="user-create.php" method="POST">
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
                        <label for="userRole" class="form-label">Role</label>
                        <select class="form-select" id="userRole" name="role" required>
                            <option value="User" selected>User</option>
                            <option value="Editor">Editor</option>
                            <option value="Admin">Admin</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="userStatus" class="form-label">Status</label>
                        <select class="form-select" id="userStatus" name="status" required>
                            <option value="Active" selected>Active</option>
                            <option value="Pending">Pending</option>
                            <option value="Inactive">Inactive</option>
                        </select>
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

            <form action="user-edit.php" method="POST">
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
                        <label for="editUserRole" class="form-label">Role</label>
                        <select class="form-select" id="editUserRole" name="role" required>
                            <option value="User">User</option>
                            <option value="Editor">Editor</option>
                            <option value="Admin">Admin</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="editUserStatus" class="form-label">Status</label>
                        <select class="form-select" id="editUserStatus" name="status" required>
                            <option value="Active">Active</option>
                            <option value="Pending">Pending</option>
                            <option value="Inactive">Inactive</option>
                        </select>
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

            <div class="modal-body">
                Are you sure you want to delete
                <strong id="deleteUserName"></strong>?
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>

                <a href="#" id="confirmDeleteUser" class="btn btn-danger">
                    <i class="bi bi-trash me-1"></i>Delete
                </a>
            </div>

        </div>
    </div>
</div>

<script>
    document.getElementById('editUserModal').addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;

        document.getElementById('editUserId').value = button.getAttribute('data-user-id');
        document.getElementById('editUserName').value = button.getAttribute('data-user-name');
        document.getElementById('editUserEmail').value = button.getAttribute('data-user-email');
        document.getElementById('editUserPhone').value = button.getAttribute('data-user-phone');
        document.getElementById('editUserRole').value = button.getAttribute('data-user-role');
        document.getElementById('editUserStatus').value = button.getAttribute('data-user-status');
    });

    document.getElementById('deleteUserModal').addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const userId = button.getAttribute('data-user-id');
        const userName = button.getAttribute('data-user-name');

        document.getElementById('deleteUserName').textContent = userName;

        document.getElementById('confirmDeleteUser').href =
            'user-delete.php?id=' + encodeURIComponent(userId);
    });
</script>

<?php include __DIR__ . '/layouts/footer.php'; ?>
<?php include __DIR__ . '/layouts/footer-scripts.php'; ?>
