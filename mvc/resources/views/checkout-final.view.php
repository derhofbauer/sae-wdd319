<h2>Checkout</h2>

<div class="row">
    <div class="col address">
        <h3>Address</h3>
        <p>
            <strong><?php echo "$user->firstname $user->lastname"; ?></strong>
            <br>
            <?php echo $address->getAddressHtml(); ?>
        </p>
    </div>

    <div class="col payment">
        <h3>Payment</h3>
        <p>
            Name: <strong><?php echo $payment->name; ?></strong>
            <br>
            Number: ...<?php echo substr($payment->number, -4); ?>
            <br>
            Expires: <?php echo $payment->expires; ?>
        </p>
    </div>
</div>

<?php require_once __DIR__ . '/partials/productTable.php'; ?>

<a href="checkout/do-checkout" class="btn btn-primary">Pay</a>
<a href="cart" class="btn btn-danger">Abort</a>
