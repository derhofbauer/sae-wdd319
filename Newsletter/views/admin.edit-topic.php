<?php require_once __DIR__ . '/partials/header.php'; ?>

<h2>Edit Topic</h2>

<?php foreach ($errors as $error): ?>
    <p class="alert alert-danger"><?php echo $error; ?></p>
<?php endforeach; ?>

<form action="index.php?page=edit-topic&id=<?php echo $_GET['id']; ?>" method="post">
    <div class="form-group">
        <label for="name">Name</label>
        <?php
        /**
         * Wir können hier $name anstelle von $resultData['name'] verwenden, weil wir im includes/edit-topic.php die
         * extract Funktion verwendet haben. Selbiges gilt auch für $description im nächsten Formularfeld.
         */
        ?>
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
    <a href="index.php?page=delete-topic&id=<?php echo $id; ?>" class="btn btn-danger">DELETE?</a>
</form>

<?php require_once __DIR__ . '/partials/footer.php'; ?>
