<?php

session_start();

$links = [
    'https://google.com',
    'https://sae.edu',
    'https://nasa.gov'
];

var_dump($_SESSION);

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Link Tracker</title>
</head>
<body>
<ul>
    <?php
        /**
         * Wir generieren eine Liste dynamisch aus dem Array $links, dadurch ist sie ganz einfach erweiterbar
         */
        foreach ($links as $link):
    ?>
        <li>
            <a href="redirect.php?url=<?php echo urlencode($link); ?>" target="_blank"><?php echo $link; ?></a>
            <?php
            /**
             * Wenn der Link, der aktuell gerendert wird, bereits in der Session steht und somit schon einmal geklickt
             * wurde, hängen wir hier einen Zusatz dran.
             */
            if (isset($_SESSION['url-counter'][$link])) {
                $count = $_SESSION['url-counter'][$link];
                echo "({$count}x besucht)";
            }
            ?>
        </li>
    <?php endforeach; ?>
</ul>
</body>
</html>
