<h1>Welcome</h1>

<div class="row">
    <?php foreach ($products as $product): ?>
        <div class="card">
            <img class="card-img-top" src="..." alt="<?php echo $product->name; ?>">
            <div class="card-body">
                <h5 class="card-title"><?php echo $product->name; ?></h5>
                <p class="card-text"><?php echo $product->description; ?></p>
                <a href="products/<?php echo $product->id; ?>" class="btn btn-primary">Go to product</a>
            </div>
        </div>
    <?php endforeach; ?>
</div>
