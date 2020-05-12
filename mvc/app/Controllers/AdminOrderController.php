<?php

namespace App\Controllers;

use App\Models\Address;
use App\Models\Order;
use App\Models\Payment;
use App\Models\User;
use Core\View;

class AdminOrderController
{

    public static function editForm (int $id)
    {
        /**
         * Daten aus der Datenbank abfragen
         */
        $order = Order::find($id);
        $user = User::find($order->user_id);
        $delivery_address = Address::find($order->delivery_address_id);
        $invoice_address = Address::find($order->invoice_address_id);
        $payment = Payment::find($order->payment_id);

        /**
         * Daten an View übergeben
         */
        View::load('admin/orderForm', [
            'order' => $order,
            'user' => $user,
            'delivery_address' => $delivery_address,
            'invoice_address' => $invoice_address,
            'payment' => $payment
        ]);
    }

}
