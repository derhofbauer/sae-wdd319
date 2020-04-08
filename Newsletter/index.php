<?php

/**
 * 1) Newsletter-Anmeldung Formular + Validierung
 * 2) Datenbank (subscribers, topics, users [Newsletter Admins])
 * 3) Backend (Login, Subscriber-Übersicht [C/RUD], Topic Bearbeitung [CRUD])
 *
 * Spezialfeatures:
 * + Mute Subscriber
 *
 * Datenbank:
 * + subscriber
 *   + id INT,PK,A_I
 *   + email VARCHAR,UNIQUE
 *   + firstname VARCHAR,NULL
 *   + lastname VARCHAR,NULL
 *   + muted BOOL,NULL,DEFAULT=NULL
 * + topics
 *   + id INT,PK,A_I
 *   + name VARCHAR
 *   + description TEXT,NULL
 * + users
 *   + id INT,PK,A_I
 *   + email VARCHAR,UNIQUE
 *   + password (hash) VARCHAR
 * + subscribers_topics_mm
 *   + id INT,PK,A_I
 *   + subscriber_id INT
 *   + topic_id INT
 */

require_once 'includes/database.php';

?>
