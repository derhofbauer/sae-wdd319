<div class="row">
    <div class="col">
        <h1><?php echo $product->name; ?></h1>
        <div class="description">
            <?php echo $product->description; ?>
        </div>
        <div class="price"><?php printf('%0.2f ,-', $product->price); ?></div>

        <form action="cart/add/<?php echo $product->id; ?>" method="post" class="form-inline">
            <input type="number" class="form-control" value="1" min="1" name="quantity">
            <button type="submit" class="btn btn-primary">Add to Cart</button>
        </form>

        <a class="btn btn-default" href="products">View all</a>
    </div>
    <?php if (!empty($product->images)): ?>
        <div class="col">
            <?php foreach ($product->images as $image): ?>
                <img class="img-thumbnail" src="storage/<?php echo $image; ?>" alt="<?php echo $product->name; ?>" style="max-width: 250px; height: auto;">
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
