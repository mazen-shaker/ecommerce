<?php

$pageTitle = 'Orders';
$breadcrumbs = [
    ['label' => 'Home', 'url' => 'index.php'],
    ['label' => 'Orders', 'url' => null],
];

// allowed statuses
$statuses = ['pending', 'processing', 'shipped', 'delivered', 'cancelled'];

// status => badge color
$statusClasses = [
    'pending'    => 'warning',
    'processing' => 'info',
    'shipped'    => 'primary',
    'delivered'  => 'success',
    'cancelled'  => 'danger',
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
                        <div>
                            <h5 class="card-title">Orders</h5>
                            <p class="text-muted mb-0">Manage and view all customer orders.</p>
                        </div>

                        <div class="table-responsive mt-4">
                            <table class="table table-borderless datatable">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Order No.</th>
                                        <th scope="col">Customer</th>
                                        <th scope="col">Subtotal</th>
                                        <th scope="col">Discount</th>
                                        <th scope="col">Shipping</th>
                                        <th scope="col">Total</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Created At</th>
                                        <th scope="col">Actions</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php foreach ($orders as $order): ?>
                                        <?php $statusClass = $statusClasses[$order['status']] ?? 'secondary'; ?>
                                        <tr>
                                            <th scope="row">
                                                <?= htmlspecialchars((string) $order['id']) ?>
                                            </th>

                                            <td><?= htmlspecialchars($order['order_number']) ?></td>

                                            <td>
                                                <?= htmlspecialchars($order['customer_name']) ?>
                                                <br>
                                                <small class="text-muted"><?= htmlspecialchars($order['customer_email']) ?></small>
                                            </td>

                                            <td><?= number_format((float) $order['subtotal'], 2) ?></td>
                                            <td><?= number_format((float) $order['discount_amount'], 2) ?></td>
                                            <td><?= number_format((float) $order['shipping_cost'], 2) ?></td>
                                            <td><strong><?= number_format((float) $order['total'], 2) ?></strong></td>

                                            <td>
                                                <span class="badge bg-<?= $statusClass ?>">
                                                    <?= htmlspecialchars(ucfirst($order['status'])) ?>
                                                </span>
                                            </td>

                                            <td><?= htmlspecialchars($order['created_at']) ?></td>

                                            <td>
                                                <div class="d-flex align-items-center gap-2">

                                                    <button
                                                        type="button"
                                                        class="btn btn-link text-secondary p-0"
                                                        title="View details"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#viewOrderModal"
                                                        data-order-number="<?= htmlspecialchars($order['order_number'], ENT_QUOTES) ?>"
                                                        data-order-customer-name="<?= htmlspecialchars($order['customer_name'], ENT_QUOTES) ?>"
                                                        data-order-customer-email="<?= htmlspecialchars($order['customer_email'], ENT_QUOTES) ?>"
                                                        data-order-customer-phone="<?= htmlspecialchars((string) $order['customer_phone'], ENT_QUOTES) ?>"
                                                        data-order-shipping-address="<?= htmlspecialchars((string) $order['shipping_address'], ENT_QUOTES) ?>"
                                                        data-order-notes="<?= htmlspecialchars((string) $order['notes'], ENT_QUOTES) ?>"
                                                        data-order-subtotal="<?= number_format((float) $order['subtotal'], 2) ?>"
                                                        data-order-discount="<?= number_format((float) $order['discount_amount'], 2) ?>"
                                                        data-order-shipping-cost="<?= number_format((float) $order['shipping_cost'], 2) ?>"
                                                        data-order-total="<?= number_format((float) $order['total'], 2) ?>"
                                                        data-order-status="<?= htmlspecialchars(ucfirst($order['status']), ENT_QUOTES) ?>"
                                                        data-order-status-class="<?= $statusClass ?>"
                                                        data-order-created-at="<?= htmlspecialchars($order['created_at'], ENT_QUOTES) ?>"
                                                        data-order-updated-at="<?= htmlspecialchars((string) $order['updated_at'], ENT_QUOTES) ?>"
                                                    >
                                                        <i class="bi bi-eye"></i>
                                                    </button>

                                                    <button
                                                        type="button"
                                                        class="btn btn-link text-primary p-0"
                                                        title="Update status"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#editOrderStatusModal"
                                                        data-order-id="<?= htmlspecialchars((string) $order['id'], ENT_QUOTES) ?>"
                                                        data-order-number="<?= htmlspecialchars($order['order_number'], ENT_QUOTES) ?>"
                                                        data-order-status-value="<?= htmlspecialchars($order['status'], ENT_QUOTES) ?>"
                                                    >
                                                        <i class="bi bi-pencil-square"></i>
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

<!-- View Order Modal -->
<div class="modal fade" id="viewOrderModal" tabindex="-1" aria-labelledby="viewOrderModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="viewOrderModalLabel">
                    <i class="bi bi-receipt me-2"></i>Order <span id="viewOrderNumber"></span>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="row">

                    <div class="col-md-6 mb-3">
                        <h6 class="text-muted">Customer</h6>
                        <div id="viewOrderCustomerName" class="fw-semibold"></div>
                        <div id="viewOrderCustomerEmail"></div>
                        <div id="viewOrderCustomerPhone"></div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <h6 class="text-muted">Shipping Address</h6>
                        <div id="viewOrderShippingAddress"></div>
                    </div>

                    <div class="col-12 mb-3">
                        <h6 class="text-muted">Notes</h6>
                        <div id="viewOrderNotes"></div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <h6 class="text-muted">Summary</h6>
                        <table class="table table-sm table-borderless mb-0">
                            <tr><td>Subtotal</td><td class="text-end" id="viewOrderSubtotal"></td></tr>
                            <tr><td>Discount</td><td class="text-end" id="viewOrderDiscount"></td></tr>
                            <tr><td>Shipping</td><td class="text-end" id="viewOrderShippingCost"></td></tr>
                            <tr class="fw-bold border-top"><td>Total</td><td class="text-end" id="viewOrderTotal"></td></tr>
                        </table>
                    </div>

                    <div class="col-md-6 mb-3">
                        <h6 class="text-muted">Status</h6>
                        <span id="viewOrderStatus" class="badge"></span>

                        <h6 class="text-muted mt-3">Dates</h6>
                        <div><small>Created: <span id="viewOrderCreatedAt"></span></small></div>
                        <div><small>Updated: <span id="viewOrderUpdatedAt"></span></small></div>
                    </div>

                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>

        </div>
    </div>
</div>

<!-- Edit Order Status Modal -->
<div class="modal fade" id="editOrderStatusModal" tabindex="-1" aria-labelledby="editOrderStatusModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="editOrderStatusModalLabel">
                    <i class="bi bi-pencil-square me-2"></i>Update Order Status
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="<?= $GLOBALS['basePath'] ?>/order/update-status" method="POST">
                <div class="modal-body">

                    <input type="hidden" name="id" id="editOrderId">

                    <p class="mb-3">
                        Order: <strong id="editOrderNumber"></strong>
                    </p>

                    <div class="mb-3">
                        <label for="editOrderStatus" class="form-label">Status</label>
                        <select class="form-select" id="editOrderStatus" name="status" required>
                            <?php foreach ($statuses as $status): ?>
                                <option value="<?= htmlspecialchars($status, ENT_QUOTES) ?>">
                                    <?= htmlspecialchars(ucfirst($status)) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-lg me-1"></i>Save Status
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>

<script>
    document.getElementById('viewOrderModal').addEventListener('show.bs.modal', function (event) {
        const b = event.relatedTarget;

        document.getElementById('viewOrderNumber').textContent          = b.getAttribute('data-order-number');
        document.getElementById('viewOrderCustomerName').textContent    = b.getAttribute('data-order-customer-name');
        document.getElementById('viewOrderCustomerEmail').textContent   = b.getAttribute('data-order-customer-email');
        document.getElementById('viewOrderCustomerPhone').textContent   = b.getAttribute('data-order-customer-phone');
        document.getElementById('viewOrderShippingAddress').textContent = b.getAttribute('data-order-shipping-address') || '-';
        document.getElementById('viewOrderNotes').textContent           = b.getAttribute('data-order-notes') || '-';
        document.getElementById('viewOrderSubtotal').textContent        = b.getAttribute('data-order-subtotal');
        document.getElementById('viewOrderDiscount').textContent        = b.getAttribute('data-order-discount');
        document.getElementById('viewOrderShippingCost').textContent    = b.getAttribute('data-order-shipping-cost');
        document.getElementById('viewOrderTotal').textContent           = b.getAttribute('data-order-total');
        document.getElementById('viewOrderCreatedAt').textContent       = b.getAttribute('data-order-created-at');
        document.getElementById('viewOrderUpdatedAt').textContent       = b.getAttribute('data-order-updated-at') || '-';

        const statusEl = document.getElementById('viewOrderStatus');
        statusEl.textContent = b.getAttribute('data-order-status');
        statusEl.className   = 'badge bg-' + b.getAttribute('data-order-status-class');
    });

    document.getElementById('editOrderStatusModal').addEventListener('show.bs.modal', function (event) {
        const b = event.relatedTarget;

        document.getElementById('editOrderId').value        = b.getAttribute('data-order-id');
        document.getElementById('editOrderNumber').textContent = b.getAttribute('data-order-number');
        document.getElementById('editOrderStatus').value    = b.getAttribute('data-order-status-value');
    });
</script>

<?php include __DIR__ . '/layouts/footer.php'; ?>
<?php include __DIR__ . '/layouts/footer-scripts.php'; ?>
