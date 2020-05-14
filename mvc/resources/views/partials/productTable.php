<table class="table table-striped">
    <tr>
        <th>#</th>
        <th>Title</th>
        <th>Quantity</th>
        <th>Price Single</th>
        <th>Subtotal</th>
    </tr>
    <?php
    $totalPrice = 0;
    foreach ($products as $product): ?>

        <tr>
            <td><?php echo $product->id; ?></td>
            <td><?php echo $product->name; ?></td>
            <td><?php echo $product->quantity; ?></td>
            <td><?php echo \App\Models\Product::formatPrice($product->price); ?></td>
            <?php
            $subTotal = $product->price * $product->quantity;
            $totalPrice = $totalPrice + $subTotal;
            ?>
            <td><?php echo \App\Models\Product::formatPrice($subTotal); ?></td>
        </tr>

    <?php endforeach; ?>

    <tr>
        <td></td>
        <td></td>
        <td></td>
        <td><strong>Total:</strong></td>
        <td><?php echo \App\Models\Product::formatPrice($totalPrice); ?></td>
    </tr>
</table>
