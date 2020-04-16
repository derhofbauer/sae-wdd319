<?php

$result = mysqli_query($link, 'SELECT * FROM subscribers');
$subscribers = [];

while ($row = mysqli_fetch_assoc($result)) {
    $subscribers[] = $row;
}

require_once __DIR__ . '/../views/admin.subscribers.php';
