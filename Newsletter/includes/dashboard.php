<?php

/**
 * 1) Anzahl der Abonnenten + Link zur Liste der Abonnenten
 * 2) Liste der Topics + Bearbeitungslink
 */

/**
 * Topic List
 */


/**
 * Number of Subscribers
 */
$query = 'SELECT COUNT(*) AS numberOfSubscribers FROM `subscribers`';
$result = mysqli_query($link, $query);
if ($result !== false) {
    $resultData = mysqli_fetch_assoc($result);
    $numberOfSubscribers = $resultData['numberOfSubscribers'];
}

/**
 * View laden
 */
require_once __DIR__ . '/../views/admin.dashboard.php';
