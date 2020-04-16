<?php

/**
 * Session Wert, der während des Logins auf true gesetzt wird, umkehren. Wir könnten auch session_destroy() verwenden,
 * aber dann wären andere Werte, die in der Session gespeichert sind, auch verloren und nicht nur der Login-Status.
 */
$_SESSION['loggedIn'] = false;

/**
 * Weiterleitung
 */
header('Location: index.php');
exit;
