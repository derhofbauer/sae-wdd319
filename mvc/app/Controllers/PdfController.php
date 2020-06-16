<?php

namespace App\Controllers;

use App\Models\Address;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Mpdf\Mpdf;

class PdfController
{

    /**
     * In dieser Beispiel Methode generieren wir eine einfache PDF Rechnung dynamisch für jede Order.
     *
     * @param int $id
     *
     * @throws \Mpdf\MpdfExceptionI
     */
    public function example (int $id)
    {
        /**
         * Informationen aus der Datenbank holen, die wir für die Rechnung brauchen.
         */
        $order = Order::find($id);
        $user = User::find($order->user_id);
        $delivery_address = Address::find($order->delivery_address_id);

        /**
         * Mpdf initialisieren und angeben, wo temporäre Dateien hin geschrieben werden sollen.
         *
         * s. https://mpdf.github.io/
         */
        $pdf = new Mpdf([
            'tempDir' => __DIR__ . '/../../storage/tmp'
        ]);

        /**
         * Mpdf ermöglicht es, HTML in ein PDF zu schreiben. Näheres dazu in der offiziellen Dokumentation:
         * https://mpdf.github.io/
         */
        $pdf->WriteHTML("<h1>Invoice #{$order->id}</h1>");
        $pdf->WriteHTML("<div>{$user->firstname} {$user->lastname}</div>");
        $pdf->WriteHTML("<div>{$_address}</div>");
        $pdf->WriteHTML("<h2>Products</h2>");

        $pdf->WriteHTML("<table>");
        $pdf->WriteHTML("<thead>");
        $pdf->WriteHTML("<tr style=\"background-color: lightgrey;\">");
        $pdf->WriteHTML("<th>#</th>");
        $pdf->WriteHTML("<th>Quantity</th>");
        $pdf->WriteHTML("<th>Title</th>");
        $pdf->WriteHTML("<th>PPU</th>");
        $pdf->WriteHTML("<th>Total</th>");
        $pdf->WriteHTML("</tr>");
        $pdf->WriteHTML("</thead>");

        $pdf->WriteHTML("<tbody>");

        /**
         * Variable vorbereiten, damit wir uns den Gesamtpreis zusammenrechnen können.
         */
        $endTotal = 0;

        /**
         * Alle Produkte der Order durchgehen.
         */
        foreach ($order->getProducts() as $product) {
            $pdf->WriteHTML('<tr>');

            /**
             * Sub-Total dieses Postens berechnen und den Order-Gesamtpreis um diesen Wert erhöhen.
             */
            $totalPrice = $product->price * $product->quantity;
            $endTotal = $endTotal + $totalPrice;

            /**
             * Berechnete Preise formatieren.
             */
            $totalPrice = Product::formatPrice($totalPrice);
            $price = Product::formatPrice($product->price);

            $pdf->WriteHTML("<td>{$product->id}</td>");
            $pdf->WriteHTML("<td>{$product->quantity}</td>");
            $pdf->WriteHTML("<td>{$product->name}</td>");
            $pdf->WriteHTML("<td style=\"text-align: right;\">{$price}</td>");
            $pdf->WriteHTML("<td style=\"text-align: right;\">{$totalPrice}</td>");

            $pdf->WriteHTML('</tr>');
        }

        $pdf->WriteHTML("<tr>");
        $pdf->WriteHTML("<td></td>");
        $pdf->WriteHTML("<td></td>");
        $pdf->WriteHTML("<td></td>");
        $pdf->WriteHTML("<td><strong>Total:</strong></td>");
        /**
         * Berechneten Gesamtpreis formatieren
         */
        $endTotal = Product::formatPrice($endTotal);
        $pdf->WriteHTML("<td style=\"text-align: right;\"><strong>{$endTotal}</strong></td>");
        $pdf->WriteHTML("</tr>");
        $pdf->WriteHTML("</tbody>");
        $pdf->WriteHTML("</table>");

        /**
         * PDF direkt im Browser ausgegen. Von dort aus kann es heruntergeladen oder gedruckt werden.
         */
        $pdf->Output();
    }

}
