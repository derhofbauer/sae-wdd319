<h1>Product: #<?php echo $product->id; ?></h1>

<form action="products/<?php echo $product->id; ?>/do-edit" method="post" enctype="multipart/form-data">

    <div class="form-group">
        <label for="name">Name</label>
        <input type="text" class="form-control" name="name" value="<?php echo $product->name; ?>">
    </div>

    <div class="form-group">
        <label for="description">Description</label>
        <textarea name="description" id="description" rows="5" class="form-control"><?php echo $product->description; ?></textarea>
    </div>

    <div class="row">
        <div class="form-group col">
            <label for="price">Price</label>
            <input type="number" class="form-control" name="price" step="0.01" value="<?php echo $product->getPriceFloat(); ?>">
        </div>

        <div class="form-group col">
            <label for="stock">Stock</label>
            <input type="number" class="form-control" name="stock" value="<?php echo $product->stock; ?>">
        </div>
    </div>

    <div class="row">
        <div class="form-group col">
            <label for="images[]">Images</label>
            <input type="file" class="form-control-file" name="images[]" multiple>
        </div>

        <!--
        @todo: Show uploaded files.
        -->
    </div>

    <a href="dashboard" class="btn btn-danger">Cancel</a>
    <button class="btn btn-primary" type="submit">Save</button>

</form>
