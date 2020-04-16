<?php require_once __DIR__ . '/partials/header.php'; ?>

<div class="row">
    <div class="col">
        <h2>Subscribers</h2>
        <ul class="list-group">
            <?php foreach ($subscribers as $subscriber): ?>
                <li class="list-group-item">
                    <h5><?php echo $subscriber['email']; ?></h5>
                    <span class="badge badge-primary badge-pill"><?php echo $subscriber['numberofsubscriptions']; ?></span>
                    <?php if (!empty($subscriber['firstname']) && !empty($subscriber['lastname'])): ?>
                        <small><?php echo $subscriber['firstname'] . ' ' . $subscriber['lastname']; ?></small>
                    <?php endif; ?>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>

<?php require_once __DIR__ . '/partials/footer.php'; ?>
