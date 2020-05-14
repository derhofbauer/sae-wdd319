<h1>Order: #<?php echo $order->id; ?></h1>

<form action="orders/<?php echo $order->id; ?>/do-edit" method="post">
    <div class="row">
        <div class="form-group col">
            <label for="status">Status</label>
            <select name="status" id="status" class="form-control">
                <?php

                $stati = [
                    'open' => 'Open',
                    'in progress' => 'In Progress',
                    'in delivery' => 'In Delivery',
                    'storno' => 'Storno',
                    'delivered' => 'Delivered'
                ];

                foreach ($stati as $htmlValue => $label) {
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
    <a href="orders/<?php echo $order->id; ?>/do-edit" class="btn btn-primary">Save</a>

</form>
