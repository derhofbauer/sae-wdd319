<h2>Orders</h2>

<?php
/**
 * Flash Messages aus der Session laden und löschen.
 */
$flashMessage = \Core\Session::get('flash', null, true);

/**
 * Gibt es Messages in der Session, geben wir sie hier aus.
 */
if ($flashMessage !== null) {
    echo "<div class=\"alert alert-success\">$flashMessage</div>";
}
?>

<table class="table table-striped">
    <thead>
    <tr>
        <th>#</th>
        <th>Date</th>
        <th>Price</th>
        <th>Delivery Address</th>
        <th>Products</th>
        <th>Status</th>
    </tr>
    </thead>

    <tbody>
    <?php foreach ($orders as $order): ?>
        <tr>
            <td><?php echo $order->id; ?></td>
            <td><?php echo $order->crdate; ?></td>
            <td><?php echo \App\Models\Product::formatPrice($order->getPrice()); ?></td>
            <td>
                <?php
                /**
                 * Die Order bietet die Möglichkeit, die Daten der Lieferadresse aus der Datenbank zu laden.
                 */
                $address = $order->getDeliveryAddress();

                /**
                 * Die Lieferadresse wiederum ist vom Typ Address und hat damit die Möglichkeit, die Adresse in <br>-
                 * Entities umzuformatieren und zurückzugeben.
                 */
                echo $address->getAddressHtml();
                ?>
            </td>
            <td>
                <ul>
                    <?php
                    /**
                     * Nachdem eine Order mehrere Products haben kann, gehen wir innerhalb der ersten foreach-Schleife
                     * nochmal in einer foreach-Schleife alle Produkte durch.
                     */
                    ?>
                    <?php foreach ($order->getProducts() as $product): ?>
                        <li><?php echo "{$product->quantity}x $product->name"; ?></li>
                    <?php endforeach; ?>
                </ul>
            </td>
            <td><?php echo $order->status; ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
