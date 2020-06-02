<h2>Chosen/Add Address</h2>

<div class="row">
    <div class="col chose-payment">
        <h3>Choose Address</h3>
        <form action="checkout/handle-address" method="post">
            <div class="form-group">
                <label for="address_id" class="sr-only">Choose address</label>
                <select name="address_id" class="form-control">
                    <option value="_default" selected hidden>Choose ...</option>
                    <?php foreach ($addresses as $address): ?>
                        <option value="<?php echo $address->id; ?>"><?php echo $address->address; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button class="btn btn-primary">Choose</button>
        </form>
    </div>

    <div class="col add-payment">
        <h3>Create Address</h3>
        <form action="checkout/handle-address" method="post">
            <div class="form-group">
                <label for="address">Address</label>
                <textarea name="address" rows="5" class="form-control"></textarea>
            </div>

            <button class="btn btn-primary">Save</button>
        </form>
    </div>
</div>
