<?php include __DIR__ . '/../layouts/head.php'; ?>

<main id="main" class="main">

    <div class="pagetitle">
        <h1>Profile</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="<?= $GLOBALS['basePath'] ?>/admin">Home</a>
                </li>
                <li class="breadcrumb-item">Users</li>
                <li class="breadcrumb-item active">Profile</li>
            </ol>
        </nav>
    </div>

    <section class="section profile">
        <div class="row">

            <div class="col-xl-8">

                <div class="card">
                    <div class="card-body pt-3">

                        <ul class="nav nav-tabs nav-tabs-bordered">

                            <li class="nav-item">
                                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-edit">
                                    Edit Profile
                                </button>
                            </li>

                            <li class="nav-item">
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-change-password">
                                    Change Password
                                </button>
                            </li>

                        </ul>

                        <form id="profileForm" action="<?= $GLOBALS['basePath'] ?>/admin/profile/update" method="POST">

                            <div class="tab-content pt-2">

                                <!-- Edit Profile -->
                                <div class="tab-pane fade show active profile-edit pt-3" id="profile-edit">

                                    <div class="row mb-3">
                                        <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Name</label>

                                        <div class="col-md-8 col-lg-9">
                                            <input
                                                name="name"
                                                type="text"
                                                class="form-control"
                                                id="fullName"
                                                value="<?= htmlspecialchars($data['name'] ?? '') ?>"
                                            >

                                            <?php if (isset($_SESSION['valedation']['name'])): ?>
                                                <small style="display: block; color: #dc3545; font-size: 13px; margin-top: 6px;">
                                                    <?= htmlspecialchars($_SESSION['valedation']['name']) ?>
                                                </small>
                                                <?php unset($_SESSION['valedation']['name']); ?>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="Phone" class="col-md-4 col-lg-3 col-form-label">Phone</label>

                                        <div class="col-md-8 col-lg-9">
                                            <input
                                                name="phone"
                                                type="text"
                                                class="form-control"
                                                id="Phone"
                                                value="<?= htmlspecialchars($data['phone'] ?? '') ?>"
                                            >

                                            <?php if (isset($_SESSION['valedation']['phone'])): ?>
                                                <small style="display: block; color: #dc3545; font-size: 13px; margin-top: 6px;">
                                                    <?= htmlspecialchars($_SESSION['valedation']['phone']) ?>
                                                </small>
                                                <?php unset($_SESSION['valedation']['phone']); ?>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="Email" class="col-md-4 col-lg-3 col-form-label">Email</label>

                                        <div class="col-md-8 col-lg-9">
                                            <input
                                                name="email"
                                                type="email"
                                                class="form-control"
                                                id="Email"
                                                value="<?= htmlspecialchars($data['email'] ?? '') ?>"
                                            >

                                            <?php if (isset($_SESSION['valedation']['email'])): ?>
                                                <small style="display: block; color: #dc3545; font-size: 13px; margin-top: 6px;">
                                                    <?= htmlspecialchars($_SESSION['valedation']['email']) ?>
                                                </small>
                                                <?php unset($_SESSION['valedation']['email']); ?>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                    <?php if (isset($_SESSION['error']['profileUpdate'])): ?>
                                        <small style="display: block; color: #dc3545; font-size: 13px; margin-top: 8px; margin-bottom: 12px; padding: 9px 12px; background: #fff1f1; border-left: 3px solid #dc3545; border-radius: 3px;">
                                            <?= htmlspecialchars($_SESSION['error']['profileUpdate']) ?>
                                        </small>
                                        <?php unset($_SESSION['error']['profileUpdate']); ?>
                                    <?php endif; ?>

                                    <div class="text-center">
                                        <button form="profileForm" type="submit" class="btn btn-primary">
                                            Save Changes
                                        </button>
                                    </div>

                                </div>

                                <!-- Change Password -->
                                <div class="tab-pane fade pt-3" id="profile-change-password">

                                    <div class="row mb-3">
                                        <label for="currentPassword" class="col-md-4 col-lg-3 col-form-label">Current Password</label>

                                        <div class="col-md-8 col-lg-9">
                                            <input
                                                name="oldpassword"
                                                type="password"
                                                class="form-control"
                                                id="currentPassword"
                                            >

                                            <?php if (isset($_SESSION['valedation']['oldpassword'])): ?>
                                                <small style="display: block; color: #dc3545; font-size: 13px; margin-top: 6px;">
                                                    <?= htmlspecialchars($_SESSION['valedation']['oldpassword']) ?>
                                                </small>
                                                <?php unset($_SESSION['valedation']['oldpassword']); ?>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="newPassword" class="col-md-4 col-lg-3 col-form-label">New Password</label>

                                        <div class="col-md-8 col-lg-9">
                                            <input
                                                name="password"
                                                type="password"
                                                class="form-control"
                                                id="newPassword"
                                            >

                                            <?php if (isset($_SESSION['valedation']['password'])): ?>
                                                <small style="display: block; color: #dc3545; font-size: 13px; margin-top: 6px;">
                                                    <?= htmlspecialchars($_SESSION['valedation']['password']) ?>
                                                </small>
                                                <?php unset($_SESSION['valedation']['password']); ?>
                                            <?php endif; ?>

                                            <?php if (isset($_SESSION['error']['prfilePassword'])): ?>
                                                <small style="display: block; color: #dc3545; font-size: 13px; margin-top: 8px; padding: 9px 12px; background: #fff1f1; border-left: 3px solid #dc3545; border-radius: 3px;">
                                                    <?= htmlspecialchars($_SESSION['error']['prfilePassword']) ?>
                                                </small>
                                                <?php unset($_SESSION['error']['prfilePassword']); ?>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                    <div class="text-center">
                                        <button form="profileForm" type="submit" class="btn btn-primary">
                                            Change Password
                                        </button>
                                    </div>

                                </div>

                            </div>

                        </form>

                    </div>
                </div>

            </div>

        </div>
    </section>

</main>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
<?php include __DIR__ . '/../layouts/footer-scripts.php'; ?>

