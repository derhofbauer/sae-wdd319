<h1>New Product</h1>

<?php foreach ($errors as $error): ?>
    <p class="alert alert-danger"><?php echo $error; ?></p>
<?php endforeach; ?>

<form action="dashboard/products/do-add" method="post" enctype="multipart/form-data">

    <div class="form-group">
        <label for="name">Name</label>
        <input type="text" class="form-control" name="name">
    </div>

    <div class="form-group">
        <label for="description">Description</label>
        <textarea name="description" id="description" rows="5" class="form-control"></textarea>
    </div>

    <div class="row">
        <div class="form-group col">
            <label for="price">Price</label>
            <input type="number" class="form-control" name="price" step="0.01">
        </div>

        <div class="form-group col">
            <label for="stock">Stock</label>
            <input type="number" class="form-control" name="stock">
        </div>
    </div>

    <div class="row">
        <div class="form-group col">
            <label for="images[]">Add Images</label>
            <input type="file" class="form-control-file" name="images[]" multiple>
        </div>


        <div class="col">
            <label for="delete-images">Images</label>
            <?php if (!empty($product->images)): ?>
                <div class="row">
                    <?php foreach ($product->images as $image): ?>
                        <div class="form-group form-check col-4">
                            <label>
                                <input type="checkbox" class="form-check-input" name="delete-images[<?php echo $image; ?>]">
                                <img src="storage/<?php echo $image; ?>" width="50" height="auto">
                            </label>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p class="alert alert-info">Derzeit sind keine Bilder verlinkt.</p>
            <?php endif; ?>
        </div>
    </div>

    <a href="dashboard" class="btn btn-danger">Cancel</a>
    <button class="btn btn-primary" type="submit">Save</button>

</form>
