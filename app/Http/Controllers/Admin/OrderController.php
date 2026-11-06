<?php

namespace App\Http\Controllers\Admin;

use core\view\Main;
use App\Models\Order;

class OrderController extends Main
{
    public object $model;

    public function __construct()
    {
        $this->model = new Order();
    }


    public function index(){


$orders = [
    [
        'id'              => 1,
        'user_id'         => 1,
        'address_id'      => 1,
        'order_number'    => 'ORD-20261101-0001',
        'subtotal'        => 8500.00,
        'discount_amount' => 500.00,
        'shipping_cost'   => 50.00,
        'total'           => 8050.00,
        'status'          => 'delivered',
        'customer_name'   => 'ahmed',
        'customer_email'  => 'ahmed@example.com',
        'customer_phone'  => '20101234567',
        'shipping_address'=> '12 El Horreya St, Alexandria, Egypt',
        'notes'           => 'Please call before delivery.',
        'created_at'      => '2026-11-01 10:00:00',
        'updated_at'      => '2026-11-03 15:30:00',
    ],
    [
        'id'              => 2,
        'user_id'         => 2,
        'address_id'      => 2,
        'order_number'    => 'ORD-20261102-0002',
        'subtotal'        => 250.00,
        'discount_amount' => 0.00,
        'shipping_cost'   => 40.00,
        'total'           => 290.00,
        'status'          => 'shipped',
        'customer_name'   => 'sara',
        'customer_email'  => 'sara@example.com',
        'customer_phone'  => '20111234567',
        'shipping_address'=> '5 Salah Salem St, Cairo, Egypt',
        'notes'           => null,
        'created_at'      => '2026-11-02 12:15:00',
        'updated_at'      => '2026-11-04 09:00:00',
    ],
    [
        'id'              => 3,
        'user_id'         => 3,
        'address_id'      => 3,
        'order_number'    => 'ORD-20261103-0003',
        'subtotal'        => 24999.00,
        'discount_amount' => 1000.00,
        'shipping_cost'   => 100.00,
        'total'           => 24099.00,
        'status'          => 'processing',
        'customer_name'   => 'omar',
        'customer_email'  => 'omar@example.com',
        'customer_phone'  => '20121234567',
        'shipping_address'=> '27 Mostafa Kamel St, Alexandria, Egypt',
        'notes'           => 'Leave the package with the doorman.',
        'created_at'      => '2026-11-03 14:30:00',
        'updated_at'      => '2026-11-03 16:00:00',
    ],
    [
        'id'              => 4,
        'user_id'         => 4,
        'address_id'      => 4,
        'order_number'    => 'ORD-20261104-0004',
        'subtotal'        => 770.00,
        'discount_amount' => 70.00,
        'shipping_cost'   => 35.00,
        'total'           => 735.00,
        'status'          => 'pending',
        'customer_name'   => 'mazen',
        'customer_email'  => 'mazen@mazen.mazen',
        'customer_phone'  => '20123456789',
        'shipping_address'=> '8 Tahrir Square, Giza, Egypt',
        'notes'           => null,
        'created_at'      => '2026-11-04 17:45:00',
        'updated_at'      => '2026-11-04 17:45:00',
    ],
    [
        'id'              => 5,
        'user_id'         => 5,
        'address_id'      => 5,
        'order_number'    => 'ORD-20261105-0005',
        'subtotal'        => 1800.00,
        'discount_amount' => 200.00,
        'shipping_cost'   => 60.00,
        'total'           => 1660.00,
        'status'          => 'cancelled',
        'customer_name'   => 'nour',
        'customer_email'  => 'nour@example.com',
        'customer_phone'  => '20151234567',
        'shipping_address'=> '33 Abu Qir St, Alexandria, Egypt',
        'notes'           => 'Customer requested cancellation.',
        'created_at'      => '2026-11-05 09:20:00',
        'updated_at'      => '2026-11-05 11:00:00',
    ],
    [
        'id'              => 6,
        'user_id'         => 6,
        'address_id'      => 6,
        'order_number'    => 'ORD-20261105-0006',
        'subtotal'        => 1050.00,
        'discount_amount' => 0.00,
        'shipping_cost'   => 45.00,
        'total'           => 1095.00,
        'status'          => 'pending',
        'customer_name'   => 'youssef',
        'customer_email'  => 'youssef@example.com',
        'customer_phone'  => '20109876543',
        'shipping_address'=> '14 Gamal Abdel Nasser St, Mansoura, Egypt',
        'notes'           => null,
        'created_at'      => '2026-11-05 20:30:00',
        'updated_at'      => '2026-11-05 20:30:00',
    ],
        ];



    return $this->view('admin/index-orders',compact('orders'));

    }



}
