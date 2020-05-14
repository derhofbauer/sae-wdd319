<h1>Order: #<?php echo $order->id; ?></h1>

<form action="orders/<?php echo $order->id; ?>/do-edit" method="post">
    <div class="row">
        <div class="form-group col">
            <label for="status">Status</label>
            <select name="status" id="status" class="form-control">
                <?php
                /**
                 * Damit wir in dem Dropdown den korrekten Wert vorauswählen können, müssen wir das Dropdown dynamisch
                 * generieren.
                 */

                /**
                 * Definieren der values und Labels für die <option>-Tags. Der Array Key ist immer der <option>-Value
                 * und der Array Value ist die Angezeigte Beschriftung.
                 */
                $stati = [
                    'open' => 'Open',
                    'in progress' => 'In Progress',
                    'in delivery' => 'In Delivery',
                    'storno' => 'Storno',
                    'delivered' => 'Delivered'
                ];

                /**
                 * Für jeden Wert aus $stati generieren wir einen <option>-Tag
                 */
                foreach ($stati as $htmlValue => $label) {
                    /**
                     * Entspricht der $htmlValue (Array Key von $stati) im aktuellen Schleifendurchlauf dem wert von
                     * $order->status, dann wollen wir die Option selected setzen. Andernfalls geben wir einen regulären
                     * <option>-Tag aus.
                     */
                    if ($htmlValue === $order->status) {
                        echo "<option value=\"$htmlValue\" selected>$label</option>";
                    } else {
                        echo "<option value=\"$htmlValue\">$label</option>";
                    }
                }

                ?>
            </select>

            <br>
            <label for="customer">Customer</label>
            <input name="customer" id="customer" name="customer" class="form-control" readonly value="<?php echo $user->firstname . ' ' . $user->lastname; ?>">

            <br>
            <label for="email">Email</label>
            <input type="email" id="email" name="email" class="form-control" readonly value="<?php echo $user->email; ?>">
        </div>

        <div class="form-group col">
            <label for="delivery_address">Delivery Address</label>
            <textarea name="delivery_address" id="delivery_address" rows="5" class="form-control"><?php echo $delivery_address->address; ?></textarea>
        </div>

        <div class="form-group col">
            <label for="invoice_address">Invoice Address</label>
            <textarea name="invoice_address" id="invoice_address" rows="5" class="form-control"><?php echo $invoice_address->address; ?></textarea>
        </div>
    </div>

    <label for="products">Products</label>
    <?php
    $products = $order->getProducts();

    require_once __DIR__ . '/../partials/productTable.php';
    ?>

    <a href="dashboard" class="btn btn-danger">Cancel</a>
    <button class="btn btn-primary" type="submit">Save</button>

</form>
