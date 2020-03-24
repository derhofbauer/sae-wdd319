<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Aufgabe 2</title>
</head>
<body>

<form action="handle.php" class="sample-form" method="post">
    <div class="form-group">
        <label for="name">Name</label>
        <input type="text" name="name" placeholder="Name" class="form-control">
    </div>
    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" name="email" placeholder="Email" class="form-control">
    </div>
    <div class="form-group">
        <label for="salutation">Anrede</label>
        <?php

        /**
         * An dieser Stelle definieren wir uns die HTML Values und den Label Text für die Radiobuttons. Der Array Key
         * ist der HTML Value und der Array Value ist der HTML Label Text.
         */
        $options = [
            'f' => 'Frau', // f female
            'm' => 'Herr', // m male
            'o' => 'Non-Binary', // o other
            'c' => 'Firma' // c company
        ];


        /**
         * Schleifen und If/Else Konstrukte können in PHP statt mit {} auch mit : und endforeach begonnen und beendet
         * werden. Dabei wird ein HTML Block als Schleifenkörper verwendet. Innerhalb dieses Blocks kann mit PHP auf
         * die Variablen der Schleife zugegriffen werden.
         */
        foreach ($options as $htmlValue => $label): ?>
            <p>
                <label>
                    <input type="radio" name="salutation" class="form-control" value="<?php echo $htmlValue; ?>"> <?php echo $label; ?>
                </label>
            </p>
        <?php endforeach; ?>
    </div>
    <div class="form-group">
        <label for="gender">Geschlecht</label>
        <?php

        // _default, Weiblich, Männlich, LGBTQ, other (no offense)

        ?>
        <select name="" id="">
            <option value=""></option>
        </select>
    </div>
</form>

</body>
</html>
