<div class="row">
    <div class="col">
        <h1><?php echo $product->name; ?></h1>
        <div class="description">
            <?php echo $product->description; ?>
        </div>
        <div class="price"><?php printf('%0.2f ,-', $product->price); ?></div>

        <a class="btn btn-default" href="products">View all</a>
    </div>
</div>
