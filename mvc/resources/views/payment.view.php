<h2>Chosen/Add Payment</h2>

<div class="row">
    <div class="col chose-payment">
        <h3>Choose Payment</h3>

        <?php
        /**
         * Fehler ausgeben, die potentiell aufgetreten sind.
         */
        ?>
        <?php foreach ($errors as $error): ?>
            <p class="alert alert-danger"><?php echo $error; ?></p>
        <?php endforeach; ?>

        <form action="checkout/handle-payment" method="post">
            <div class="form-group">
                <label for="payment" class="sr-only">Choose payment</label>
                <select name="payment" class="form-control">
                    <option value="_default" selected hidden>Choose ...</option>
                    <?php foreach ($payments as $payment): ?>
                        <option value="<?php echo $payment->id; ?>"><?php echo $payment->name; ?>: ...<?php echo substr($payment->number, -4); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button class="btn btn-primary">Choose</button>
        </form>
    </div>

    <div class="col add-payment">
        <h3>Create Payment</h3>
        <form action="checkout/handle-payment" method="post">
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" class="form-control">
            </div>

            <div class="form-group">
                <label for="number">Number</label>
                <input type="text" name="number" class="form-control">
            </div>

            <div class="form-group">
                <label for="expires">Expires</label>
                <input type="text" name="expires" class="form-control">
            </div>

            <div class="form-group">
                <label for="ccv">CCV</label>
                <input type="number" name="ccv" class="form-control">
            </div>

            <button class="btn btn-primary">Save</button>
        </form>
    </div>
</div>
