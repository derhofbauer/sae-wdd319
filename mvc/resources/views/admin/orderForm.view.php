<h1>Order: #<?php echo $order->id; ?></h1>

<form action="orders/<?php echo $order->id; ?>/do-edit" method="post">
    <div class="row">
        <div class="form-group col">
            <label for="delivery_address">Delivery Address</label>
            <textarea name="delivery_address" id="delivery_address" rows="5" class="form-control"><?php echo $delivery_address->address; ?></textarea>
        </div>

        <div class="form-group col">
            <label for="invoice_address">Invoice Address</label>
            <textarea name="invoice_address" id="invoice_address" rows="5" class="form-control"><?php echo $invoice_address->address; ?></textarea>
        </div>
    </div>
</form>
