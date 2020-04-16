<?php

/**
 * 1) Anzahl der Abonnenten + Link zur Liste der Abonnenten
 * 2) Liste der Topics + Bearbeitungslink
 */

/**
 * Sind wir eingeloggt?
 *
 * In includes/functions.php haben wir Funktionen programmiert, die uns dabei helfen, möglichst einfach prüfen zu
 * können, ob jemand eingeloggt ist oder nicht.
 */
redirectIfNotLoggedIn('index.php?page=home');

/**
 * Topic List
 */
$result = mysqli_query($link, 'SELECT * FROM topics');
$topics = [];

while ($row = mysqli_fetch_assoc($result)) {
    $topics[] = $row;
}

/**
 * Number of Subscribers
 *
 * Wir verwenden für den MySQL Query diesmal nicht die sprintf-Funktion, weil wir keine Parameter haben, die in den
 * Query eingefügt werden müssen.
 */
$query = 'SELECT COUNT(*) AS count FROM `subscribers`';
$result = mysqli_query($link, $query);

/**
 * Wenn kein Fehler aufgetreten ist, holen wir uns hier das Ergebnis und schreiben es in eine Variable, um es im View
 * verwenden zu können.
 *
 * Wir können das $result auf `false` prüfen, weil mysqli_query false zurück gibt, wenn ein Fehler auftritt. Ein leeres
 * Ergebnis ist dabei kein Fehler, es geht eher um technische Fehler oder Fehler in Syntax oder Semantik.
 */
if ($result !== false) {
    $resultData = mysqli_fetch_assoc($result);
    $numberOfSubscribers = $resultData['count'];
}

/**
 * View laden
 */
require_once __DIR__ . '/../views/admin.dashboard.php';
