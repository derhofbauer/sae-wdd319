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

    <?php foreach ($topics as $topic): ?>
        <div class="form-group form-check">
            <input type="checkbox" class="form-check-input" id="topics[<?php echo $topic['id']; ?>]" name="topics[<?php echo $topic['id']; ?>]">
            <label class="form-check-label" for="topics[<?php echo $topic['id']; ?>]">
                <?php echo $topic['name']; ?>
            </label>
            <?php if (!empty($topic['description'])): ?>
                <small class="form-text text-muted"><?php echo $topic['description']; ?></small>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>

    <button type="submit" class="btn btn-primary">Submit</button>
</form>

<?php require_once __DIR__ . '/partials/footer.php'; ?>
