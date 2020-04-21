<?php require_once __DIR__ . '/partials/header.php'; ?>

<div class="row">
    <?php if (isset($topics)): ?>
        <div class="col">
            <h2>Topics <small><a href="index.php?page=new-topic">New</a></small></h2>
            <div class="list-group">
                <?php foreach ($topics as $topic): ?>
                    <a href="index.php?page=edit-topic&id=<?php echo $topic['id']; ?>" class="list-group-item list-group-item-action">
                        <span><?php echo $topic['name']; ?></span>
                        <?php if (!empty($topic['description'])): ?>
                            <small><?php echo $topic['description']; ?></small>
                        <?php endif; ?>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>
    <?php if (isset($numberOfSubscribers)) : ?>
        <div class="col">
            <h2>Number of Subscribers</h2>
            <div><?php echo $numberOfSubscribers; ?></div>
            <a href="index.php?page=subscribers">Subscriber List</a>
        </div>
    <?php endif; ?>
</div>

<?php require_once __DIR__ . '/partials/footer.php'; ?>
