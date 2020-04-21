<?php require_once __DIR__ . '/partials/header.php'; ?>

<h2>Edit Topic</h2>

<?php foreach ($errors as $error): ?>
    <p class="text-danger text-center"><?php echo $error; ?></p>
<?php endforeach; ?>

<form action="index.php?page=edit-topic&id=<?php echo $_GET['id']; ?>" method="post">
    <div class="form-group">
        <label for="name">Name</label>
        <input type="text" class="form-control" id="name" name="name" value="<?php echo $name; ?>">
    </div>
    <div class="row">
        <div class="form-group col">
            <label for="description">Description</label>
            <textarea name="description" id="description" class="form-control"><?php echo $description; ?></textarea>
        </div>
    </div>

    <button type="submit" class="btn btn-primary">Submit</button>
    <a href="index.php?page=dashboard" class="btn btn-danger">Cancel</a>
</form>

<?php require_once __DIR__ . '/partials/footer.php'; ?>