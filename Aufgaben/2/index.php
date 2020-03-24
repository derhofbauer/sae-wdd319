<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Aufgabe 2</title>
</head>
<body>

<?php if (!isset($errors) || !empty($errors)): ?>

    <?php

    if (!empty($errors)) {
        echo "<ul class=\"errors\">";
        foreach ($errors as $message) {
            echo "<li>$message</li>";
        }
        echo "</ul>";
    }

    ?>

    <form action="validate.php" class="sample-form" method="post">
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" id="name" placeholder="Name" class="form-control">
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" placeholder="Email" class="form-control">
        </div>
        <div class="form-group">
            <label for="phone">Telefon</label>
            <input type="text" name="phone" id="phone" placeholder="+43 ..." class="form-control">
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
            $options = [
                '_default' => 'Bitte auswählen ...',
                'f' => 'Weiblich', // f female
                'm' => 'Männlich', // m male
                'nb' => 'LGBTQ', // nb non-binary
                'o' => 'Other' // o other
            ];

            ?>
            <select name="gender" id="gender">
                <?php
                foreach ($options as $htmlValue => $label) {
                    if ($htmlValue === '_default') {
                        echo '<option value="' . $htmlValue . '" selected hidden>' . $label . '</option>';
                    } else {
                        echo '<option value="' . $htmlValue . '">' . $label . '</option>';
                        // echo "<option value=\"$htmlValue\">$label</option>";
                    }
                }
                ?>
            </select>
        </div>
        <div class="form-group">
            <label for="message">Nachricht</label>
            <textarea name="message" id="message" cols="30" rows="10" placeholder="Message"></textarea>
        </div>
        <div class="form-group">
            <label for="newsletter">
                <input type="checkbox" name="newsletter" id="newsletter"> Newsletter abonnieren?
            </label>
        </div>
        <div class="form-group">
            <button type="submit" value="do-submit">Submit</button>
        </div>
    </form>
<?php else: ?>
    <h2>Juhu!</h2>

    <p>Das Formular wurde erfolgreich abgeschickt.</p>

    <?php if ($newsletter === true): ?>
        <p>Sie haben den Newsletter erfolgreich abonniert! Danke schön!</p>
    <?php endif; ?>
<?php endif; ?>
</body>
</html>
