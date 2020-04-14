<?php

$result = mysqli_query($link, 'SELECT * FROM topics');
$topics = [];

while ($row = mysqli_fetch_assoc($result)) {
    $topics[] = $row;
}

require_once __DIR__ . '/../views/home.php';
