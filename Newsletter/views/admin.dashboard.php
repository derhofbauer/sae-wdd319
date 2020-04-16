<?php require_once __DIR__ . '/partials/header.php'; ?>

<div class="row">
    <div class="col">
        <h2>Topics</h2>
        <ul>

        </ul>
    </div>
    <?php if (isset($numberOfSubscribers)) : ?>
        <div class="col">
            <h2>Number of Subscribers</h2>
            <div><?php echo $numberOfSubscribers; ?></div>
            <a href="index.php?page=admin.subscribers">Subscriber List</a>
        </div>
    <?php endif; ?>
</div>

<?php require_once __DIR__ . '/partials/footer.php'; ?>
