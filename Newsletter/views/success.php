<?php require_once __DIR__ . '/partials/header.php'; ?>

<?php
/**
 * Wenn in includes/subscribe.php Fehler aufgetreten sind, dann möchten wir diese hier ausgeben.
 *
 * $errors wurde im oben genannten File definiert und dieses file (success.php) wurde im selben Scope eingebunden, in
 * dem auch $errors ist. Dadurch ist $errors auch hier verfügbar und wir können die Fehler einfach ausgeben.
 */
if (!empty($errors)) {
    foreach ($errors as $error): ?>

    <p class="alert alert-danger"><?php echo $error; ?></p>

<?php endforeach;
} else { ?>

    <p class="alert alert-success">Sie haben den Newsletter erfolgreich bestellt! Danke! :D</p>

<?php } ?>

<?php require_once __DIR__ . '/partials/footer.php'; ?>
