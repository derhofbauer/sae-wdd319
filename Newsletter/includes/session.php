<?php

/**
 * Wir starten die Session in einem eigenen File, damit wir uns das index.php File nicht unnötig voll räumen, wenn hier
 * Konfigurationen dazu kommen würden (bspw. für den Session-Cookie).
 */
session_start();
