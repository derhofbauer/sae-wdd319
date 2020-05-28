<table class="table table-striped">
    <tr>
        <th>#</th>
        <th>Title</th>
        <th>Quantity</th>
        <th>Price Single</th>
        <th>Subtotal</th>
        <?php
        /**
         * Dadurch, dass wir hier die $isCart Variable verwenden, legen wir fest, dass sie vor der Verwendung des
         * Partials definiert sein kann und dann das Verhalten des Partials ändert. Sie gibt an, ob das Partial in einem
         * Cart View verwendet wird und damit Buttons zum verändern des Cart Inhalts anzeigen soll, oder nicht.
         */
        if (isset($isCart) && $isCart === true) {
            echo "<th>Actions</th>";
        }
        ?>
    </tr>
    <?php
    $totalPrice = 0;
    foreach ($products as $product): ?>

        <tr>
            <td><?php echo $product->id; ?></td>
            <td><?php echo $product->name; ?></td>
            <td>
                <?php if (isset($isCart) && $isCart === true): ?>
                    <form action="cart/update/<?php echo $product->id; ?>" method="post">
                        <div class="input-group">
                            <input type="number" name="quantity" value="<?php echo $product->quantity; ?>" class="form-control" min="1">
                            <div class="input-group-append">
                                <button class="btn btn-secondary" type="submit">Save</button>
                            </div>
                        </div>
                    </form>
                <?php else: ?>
                    <?php echo $product->quantity; ?>
                <?php endif; ?>
            </td>
            <td><?php echo \App\Models\Product::formatPrice($product->price); ?></td>
            <?php
            $subTotal = $product->price * $product->quantity;
            $totalPrice = $totalPrice + $subTotal;
            ?>
            <td><?php echo \App\Models\Product::formatPrice($subTotal); ?></td>
            <?php if (isset($isCart) && $isCart === true): ?>
                <td>
                    <div class="btn-group">
                        <a href="cart/add/<?php echo $product->id; ?>" class="btn btn-secondary">+</a>
                        <a href="cart/sub/<?php echo $product->id; ?>" class="btn btn-secondary">-</a>
                        <a href="cart/remove/<?php echo $product->id; ?>" class="btn btn-secondary">Remove</a>
                    </div>
                </td>
            <?php endif; ?>
        </tr>

    <?php endforeach; ?>

    <tr>
        <td></td>
        <td></td>
        <td></td>
        <td><strong>Total:</strong></td>
        <td><?php echo \App\Models\Product::formatPrice($totalPrice); ?></td>
        <?php if (isset($isCart) && $isCart === true): ?>
        <td>
            <a href="checkout" class="btn btn-primary">Buy</a>
        </td>
        <?php endif; ?>
    </tr>
</table>
