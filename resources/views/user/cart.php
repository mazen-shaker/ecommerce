<?php
$pageTitle = 'Checkout';

$breadcrumbs = [
    ['label' => 'Checkout', 'url' => null],
];

$carts = $carts ?? [];

$imageBasePath = $GLOBALS['basePath'] . '/';

$total = 0;

foreach ($carts as $cart) {
    $total += (float) ($cart['price'] ?? 0) * (int) ($cart['quantity'] ?? 1);
}

include __DIR__ . '/layouts/head.php';
include __DIR__ . '/layouts/header.php';
?>

<style>
    .checkout_quantity {
        width: 85px;
        height: 40px;
        text-align: center;
        border: 1px solid #e5e5e5;
        border-radius: 5px;
        padding: 5px 8px;
        outline: none;
        transition: border-color 0.2s ease;
    }

    .checkout_quantity:focus {
        border-color: #222;
    }

    .order_table table {
        width: 100%;
    }

    .order_table table th,
    .order_table table td {
        padding: 14px 12px;
        vertical-align: middle;
    }

    .order_table table tbody tr {
        border-bottom: 1px solid #eee;
    }

    .checkout_product_name {
        font-weight: 500;
        color: #333;
    }

    .order_total td strong {
        font-size: 17px;
    }
</style>

<!--Checkout page section-->
<div class="Checkout_section mt-60">
    <div class="container">

        <div class="row">
            <div class="col-12">

                <div class="user-actions">
                    <h3>
                        <i class="fa fa-file-o" aria-hidden="true"></i>
                        Returning customer?
                        <a class="Returning" href="#" data-toggle="collapse"
                            data-target="#checkout_login" aria-expanded="true"
                            aria-controls="checkout_login">Click here to login</a>
                    </h3>

                    <div id="checkout_login" class="collapse" data-parent="#accordionExample">
                        <div class="checkout_info">
                            <p>If you have shopped with us before, please enter your details in the boxes below. If you are a new customer please proceed to the Billing & Shipping section.</p>

                            <form action="#">
                                <div class="form_group">
                                    <label>Username or email <span>*</span></label>
                                    <input type="text">
                                </div>

                                <div class="form_group">
                                    <label>Password <span>*</span></label>
                                    <input type="password">
                                </div>

                                <div class="form_group group_3">
                                    <button type="submit">Login</button>
                                    <label for="remember_box">
                                        <input id="remember_box" type="checkbox">
                                        <span> Remember me </span>
                                    </label>
                                </div>

                                <a href="#">Lost your password?</a>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="user-actions">
                    <h3>
                        <i class="fa fa-file-o" aria-hidden="true"></i>
                        Get any promo code?
                        <a class="Returning" href="#" data-toggle="collapse"
                            data-target="#checkout_coupon" aria-expanded="true"
                            aria-controls="checkout_coupon">Click here to enter your code</a>
                    </h3>

                    <div id="checkout_coupon" class="collapse" data-parent="#accordionExample">
                        <div class="checkout_info">
                            <form action="#">
                                <input placeholder="Coupon code" type="text">
                                <button type="submit">Apply coupon</button>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- Main Checkout Form -->
        <form action="#" method="POST">

            <div class="checkout_form">
                <div class="row">

                    <!-- Billing Details -->
                    <div class="col-lg-6 col-md-6">

                        <h3>Billing Details</h3>

                        <div class="row">

                            <div class="col-lg-6 mb-20">
                                <label>First Name <span>*</span></label>
                                <input type="text" name="first_name" required>
                            </div>

                            <div class="col-lg-6 mb-20">
                                <label>Last Name <span>*</span></label>
                                <input type="text" name="last_name" required>
                            </div>

                            <div class="col-12 mb-20">
                                <label>Company Name</label>
                                <input type="text" name="company_name">
                            </div>

                            <div class="col-12 mb-20">
                                <label for="country">Country <span>*</span></label>

                                <select class="niceselect_option" name="country" id="country" required>
                                    <option value="2">Bangladesh</option>
                                    <option value="3">Algeria</option>
                                    <option value="4">Afghanistan</option>
                                    <option value="5">Ghana</option>
                                    <option value="6">Albania</option>
                                    <option value="7">Bahrain</option>
                                    <option value="8">Colombia</option>
                                    <option value="9">Dominican Republic</option>
                                </select>
                            </div>

                            <div class="col-12 mb-20">
                                <label>Street address <span>*</span></label>
                                <input
                                    placeholder="House number and street name"
                                    type="text"
                                    name="address"
                                    required
                                >
                            </div>

                            <div class="col-12 mb-20">
                                <input
                                    placeholder="Apartment, suite, unit etc. (optional)"
                                    type="text"
                                    name="apartment"
                                >
                            </div>

                            <div class="col-12 mb-20">
                                <label>Town / City <span>*</span></label>
                                <input type="text" name="city" required>
                            </div>

                            <div class="col-12 mb-20">
                                <label>State / County <span>*</span></label>
                                <input type="text" name="state" required>
                            </div>

                            <div class="col-lg-6 mb-20">
                                <label>Phone <span>*</span></label>
                                <input type="text" name="phone" required>
                            </div>

                            <div class="col-lg-6 mb-20">
                                <label>Email Address <span>*</span></label>
                                <input type="email" name="email" required>
                            </div>

                            <div class="col-12">
                                <div class="order-notes">
                                    <label for="order_note">Order Notes</label>

                                    <textarea
                                        id="order_note"
                                        name="order_notes"
                                        rows="2"
                                        placeholder="Notes about your order, e.g. special notes for delivery."
                                    ></textarea>
                                </div>
                            </div>

                        </div>

                    </div>

                    <!-- Order Details -->
                    <div class="col-lg-6 col-md-6">

                        <h3>Your order</h3>

                        <div class="order_table table-responsive">

                            <table>

                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Price</th>
                                        <th>Quantity</th>
                                    </tr>
                                </thead>

                                <tbody>

                                    <?php foreach ($carts as $cart): ?>

                                        <?php
                                        $id = (int) $cart['id'];
                                        $name = $cart['name'] ?? '';
                                        $price = (float) ($cart['price'] ?? 0);
                                        $quantity = (int) ($cart['quantity'] ?? 1);
                                        ?>

                                        <tr>

                                            <td>
                                                <div class="checkout_product_name">
                                                    <?= htmlspecialchars($name, ENT_QUOTES, 'UTF-8') ?>
                                                </div>
                                            </td>

                                            <td>
                                                $<?= number_format($price, 2) ?>
                                            </td>

                                            <td>
                                                <input
                                                    type="number"
                                                    class="checkout_quantity"
                                                    name="products[<?= $id ?>][quantity]"
                                                    value="<?= $quantity ?>"
                                                    min="1"
                                                    step="1"
                                                    data-price="<?= $price ?>"
                                                    required
                                                >
                                            </td>

                                        </tr>

                                        <input
                                            type="hidden"
                                            name="products[<?= $id ?>][id]"
                                            value="<?= $id ?>"
                                        >

                                        <input
                                            type="hidden"
                                            name="products[<?= $id ?>][name]"
                                            value="<?= htmlspecialchars($name, ENT_QUOTES, 'UTF-8') ?>"
                                        >

                                    <?php endforeach; ?>

                                    <?php if (empty($carts)): ?>
                                        <tr>
                                            <td colspan="3" class="text-center">
                                                Your cart is empty.
                                            </td>
                                        </tr>
                                    <?php endif; ?>

                                </tbody>

                                <tfoot>

                                    <tr>
                                        <th colspan="2">Cart Subtotal</th>
                                        <td id="cart-subtotal">
                                            $<?= number_format($total, 2) ?>
                                        </td>
                                    </tr>

                                    <tr class="order_total">
                                        <th colspan="2">Order Total</th>
                                        <td>
                                            <strong id="order-total">
                                                $<?= number_format($total, 2) ?>
                                            </strong>
                                        </td>
                                    </tr>

                                </tfoot>

                            </table>

                        </div>

                        <div class="order_button">
                            <button type="submit" <?= empty($carts) ? 'disabled' : '' ?>>
                                Proceed to buy
                            </button>
                        </div>

                    </div>

                </div>
            </div>

        </form>

    </div>
</div>
<!--Checkout page section end-->

<script>
    const quantities = document.querySelectorAll('.checkout_quantity');

    function updateTotal() {
        let total = 0;

        quantities.forEach(input => {
            const price = parseFloat(input.dataset.price) || 0;
            const quantity = parseInt(input.value) || 0;

            total += price * quantity;
        });

        document.getElementById('cart-subtotal').textContent = '$' + total.toFixed(2);
        document.getElementById('order-total').textContent = '$' + total.toFixed(2);
    }

    quantities.forEach(input => {
        input.addEventListener('input', updateTotal);
    });
</script>

<?php
include __DIR__ . '/layouts/footer.php';
include __DIR__ . '/layouts/footer-scripts.php';
?>

