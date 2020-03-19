<?php
require_once 'partials/header.php';
?>

<?php

$page = $_GET['page']

if ($page === 'contact') {
    require_once 'content/contact.php';
} else {
    require_once 'content/home.php';
}

?>

<?php
require_once 'partials/footer.php';
?>