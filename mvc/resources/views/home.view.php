<h1>Welcome</h1>

<div class="row">
    <?php foreach ($products as $product): ?>
        <div class="card">
            <?php if (!empty($product->images)): ?>
                <img class="card-img-top" src="storage/<?php echo $product->images[0]; ?>" alt="<?php echo $product->name; ?>" style="max-width: 250px; height: auto;">
            <?php endif; ?>
            <div class="card-body">
                <h5 class="card-title"><?php echo $product->name; ?></h5>
                <p class="card-text"><?php echo $product->description; ?></p>
                <p class="card-text"><?php echo $product->getPrice(); ?></p>
                <a href="products/<?php echo $product->id; ?>" class="btn btn-primary">Go to product</a>
            </div>
        </div>
    <?php endforeach; ?>
</div>
