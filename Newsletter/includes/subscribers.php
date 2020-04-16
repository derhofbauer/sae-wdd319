<?php

/**
 * Damit wir nicht in der while-Schleife für jeden Subscriber die Anzahl der Subscriptions in einem eigenen Query
 * abfragen müssen sondern alles in einem einzigen Query abhandeln können, verwenden wir einen JOIN. Dabei wird eine
 * SELECT Abfrage über mehrere Tabellen gemacht, wobei die Beziehung zwischen den Tabellen über das ON Keyword definiert
 * wird. In diesem konkreten Fall werden Datensätze aus subscribers und subscribers_topics_mm als zusammengehörig
 * erkannt, wenn die Werte in subscribers_topics_mm.subscriber_id und subscribers.id ident sind. Durch den GROUP BY
 * Befehl, wird der die COUNT Funktion auf die Zeilen der einzelnen Gruppen und nicht das gesamte Ergebnis angewendet.
 */
$query = '
SELECT subscribers.*, COUNT(subscribers_topics_mm.id) AS numberofsubscriptions
FROM subscribers
    JOIN subscribers_topics_mm
        ON subscribers_topics_mm.subscriber_id = subscribers.id
GROUP BY subscribers.id
';

$result = mysqli_query($link, $query);
$subscribers = [];

while ($row = mysqli_fetch_assoc($result)) {
    $subscribers[] = $row;
}

require_once __DIR__ . '/../views/admin.subscribers.php';
