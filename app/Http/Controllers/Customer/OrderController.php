<?php

namespace App\Http\Controllers\Customer;

use core\view\Main;
use App\Models\Order;
use App\Models\Product;
use App\Models\OrderItem;

class OrderController extends Main
{
    public object $model;

    public function __construct()
    {
        $this->model = new Order();
    }

    public function store($data)
    {
        $products = $data['products'] ?? [];

        if (empty($products)) {
            return false;
        }

        $orderItems = [];
        $subtotal = 0;

        $productModel = new Product();

        foreach ($products as $product) {

            $productData = $productModel->find($product['id']);

            if (!$productData || !$productData['is_active']) {
                return false;
            }

            $quantity = (int) $product['quantity'];

            if ($quantity < 1 || $quantity > $productData['stock']) {
                return false;
            }

            $unitPrice = (float) $productData['price'];
            $lineTotal = $unitPrice * $quantity;

            $subtotal += $lineTotal;

            $orderItems[] = [
                'product_id' => $productData['id'],
                'product_name' => $productData['name'],
                'unit_price' => $unitPrice,
                'quantity' => $quantity,
                'line_total' => $lineTotal,
            ];
        }

        $shippingCost = (float) ($data['shipping_cost'] ?? 0);
        $discountAmount = (float) ($data['discount_amount'] ?? 0);

        $total = $subtotal - $discountAmount + $shippingCost;

        $orderId = $this->model->insert([
            'user_id' => $data['user_id'] ?? null,
            'address_id' => $data['address_id'] ?? null,
            'coupon_id' => $data['coupon_id'] ?? null,
            'order_number' => $data['order_number'] ?? uniqid('ORD-'),
            'subtotal' => $subtotal,
            'discount_amount' => $discountAmount,
            'shipping_cost' => $shippingCost,
            'total' => $total,
            'status' => 'pending',
            'customer_name' => $data['customer_name'],
            'customer_email' => $data['customer_email'],
            'customer_phone' => $data['customer_phone'],
            'shipping_address' => $data['shipping_address'],
            'notes' => $data['notes'] ?? null,
        ]);

        if (!$orderId) {
            return false;
        }

        $orderItemModel = new OrderItem();

        foreach ($orderItems as $item) {

            $item['order_id'] = $orderId;

            $orderItemId = $orderItemModel->insert($item);

            if (!$orderItemId) {
                return false;
            }

            $productData = $productModel->find($item['product_id']);

            $productModel->update(
                $item['product_id'],
                [
                    'stock' => $productData['stock'] - $item['quantity']
                ]
            );
        }

        return $orderId;
    }
}

