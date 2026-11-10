<?php
$pageTitle = 'Home';

$breadcrumbs = [
    ['label' => 'Home', 'url' => null],
];

include __DIR__ . '/../layouts/head.php';
include __DIR__ . '/../layouts/header.php';
?>

<section class="account">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="account-contents" style="background: url('assets/img/about/about1.jpg'); background-size: cover;">
                    <div class="row">
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                            <div class="account-thumb">
                                <h2>Register now</h2>
                                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quis consectetur similique deleniti pariatur enim cumque eum</p>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                            <div class="account-content">

                                <form action="<?=$GLOBALS['basePath']?>/register" method="POST">
                                    <div class="single-acc-field">
                                        <label for="name">Name</label>
                                        <input type="text" name="name" id="name" placeholder="Enter Your Name">

                                        <?php if (isset($_SESSION['valedation']['name'])): ?>
                                            <small style="display: block; color: #dc3545; font-size: 13px; margin-top: 6px;">
                                                <?= htmlspecialchars($_SESSION['valedation']['name']) ?>
                                            </small>
                                        <?php endif; ?>
                                    </div>

                                    <div class="single-acc-field">
                                        <label for="email">Email</label>
                                        <input type="email" name="email" id="email" placeholder="Enter your Email">

                                        <?php if (isset($_SESSION['valedation']['email'])): ?>
                                            <small style="display: block; color: #dc3545; font-size: 13px; margin-top: 6px;">
                                                <?= htmlspecialchars($_SESSION['valedation']['email']) ?>
                                            </small>
                                        <?php endif; ?>
                                    </div>

                                    <div class="single-acc-field">
                                        <label for="phone">Phone</label>
                                        <input type="tel" name="phone" id="phone" placeholder="Enter your Phone">

                                        <?php if (isset($_SESSION['valedation']['phone'])): ?>
                                            <small style="display: block; color: #dc3545; font-size: 13px; margin-top: 6px;">
                                                <?= htmlspecialchars($_SESSION['valedation']['phone']) ?>
                                            </small>
                                        <?php endif; ?>
                                    </div>

                                    <div class="single-acc-field">
                                        <label for="password">Password</label>
                                        <input type="password" name="password" id="password" placeholder="At least 6 Charecter">

                                        <?php if (isset($_SESSION['valedation']['password'])): ?>
                                            <small style="display: block; color: #dc3545; font-size: 13px; margin-top: 6px;">
                                                <?= htmlspecialchars($_SESSION['valedation']['password']) ?>
                                            </small>
                                        <?php endif; ?>
                                    </div>

                                    <div class="single-acc-field">
                                        <button>Register now</button>
                                    </div>

                                    <a href="signin">Already account? Login</a>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
include __DIR__ . '/../layouts/footer.php';
include __DIR__ . '/../layouts/footer-scripts.php';
?>
