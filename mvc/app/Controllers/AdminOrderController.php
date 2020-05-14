<?php

namespace App\Controllers;

use App\Models\Address;
use App\Models\Order;
use App\Models\Payment;
use App\Models\User;
use Core\View;

class AdminOrderController
{

    /**
     * Edit Formular für eine Order anzeigen
     *
     * @param int $id
     */
    public function editForm (int $id)
    {
        /**
         * Daten aus der Datenbank abfragen
         *
         * Wir müssen hier sehr viele verschiedene Datensätze abfragen, weil eine Order ein relativ komplexer Datensatz
         * ist, der sehr viele andere Datensätze per id referenziert.
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

    /**
     * Daten aus dem Edit Formular einer Order entgegen nehmen und speichern
     *
     * @param int $id
     */
    public function edit (int $id)
    {
        /**
         * Validierung von $_POST-Daten ... wir Verzichten an dieser Stelle zur Übersichtlichkeit auf die genaue
         * Validierung.
         */

        /**
         * Order aus der DB abfragen
         */
        $order = Order::find($id);

        /**
         * Order Status mit dem Wert aus dem Formular überschreiben
         */
        $order->status = $_POST['status'];

        /**
         * "Alte" DeliveryAddress aus der Datenbank abfragen, also den Datensatz, der aktuell in der Order verlinkt ist.
         */
        $oldDeliveryAddress = Address::find($order->delivery_address_id);

        /**
         * Wenn der Wert im Formular abweicht von dem Wert in der Datenbank, dann erstellen wir eine neue Adresse,
         * weisen sie dem selben User zu, setzen den Wert aus dem Formular und speichern die neue Adresse. Beim
         * Speichern wird ein INSERT Query ausgeführt und somit auch eine neue ID erzeugt. Damit die neue Adresse also
         * auch in der Order verlinkt wird, setzen wir die delivery_address_id in der Order auf die neu generierte ID.
         */
        if ($oldDeliveryAddress->address !== $_POST['delivery_address']) {
            $deliveryAddress = new Address();
            $deliveryAddress->user_id = $order->user_id;
            $deliveryAddress->address = $_POST['delivery_address'];
            $deliveryAddress->save();
            $order->delivery_address_id = $deliveryAddress->id;
        }

        $oldInvoiceAddress = Address::find($order->invoice_address_id);
        if ($oldInvoiceAddress->address !== $_POST['invoice_address']) {
            $invoiceAddress = new Address();
            $invoiceAddress->user_id = $order->user_id;
            $invoiceAddress->address = $_POST['invoice_address'];
            $invoiceAddress->save();
            $order->invoice_address_id = $invoiceAddress->id;
        }

        /**
         * Die Order wurde potentiell mit einem neuen Status und bis zu 2 neuen Adressen aktualisiert. Wir speichern die
         * neuen Daten hier in die Datenbank, indem wir in der Save Methode einen UPDATE Query ausführen.
         */
        $order->save();

        /**
         * Redirect aufs Dashboard.
         */
        header('Location: ' . BASE_URL . 'dashboard');
        exit;
    }

}
