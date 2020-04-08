<?php require_once __DIR__ . '/partials/header.php'; ?>

<form action="index.php?page=subscribe" method="post">
    <div class="form-group">
        <label for="email">Email address</label>
        <input type="email" class="form-control" id="email" name="email">
        <small class="form-text text-muted">We'll never share your email with anyone else.</small>
    </div>
    <div class="row">
        <div class="form-group col">
            <label for="firstname">First Name</label>
            <input type="text" class="form-control" id="firstname" name="firstname">
        </div>
        <div class="form-group col">
            <label for="lastname">Last Name</label>
            <input type="text" class="form-control" id="lastname" name="lastname">
        </div>
    </div>

    <?php // Der folgende Block soll pro Topic aus der Datenbank generiert werden. ?>
    <div class="form-group form-check">
        <input type="checkbox" class="form-check-input" id="topic_1" name="topics[]" value="1">
        <label class="form-check-label" for="topic_1">Topic Name</label>
        <small class="form-text text-muted">Topic Description</small>
    </div>

    <button type="submit" class="btn btn-primary">Submit</button>
</form>

<?php require_once __DIR__ . '/partials/footer.php'; ?>
