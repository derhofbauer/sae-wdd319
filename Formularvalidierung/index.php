<!doctype html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Formularvalidierung</title>

    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>
<body>

<?php

if (isset($_POST['do-submit'])) {
    require_once 'validate.php';
}

?>

<div class="container">
    <h1>Formularvalidierung</h1>

    <form action="index.php" method="post">
        <div class="form-check">
            <input class="form-check-input" type="radio" name="salutation" id="salutation_1" value="f">
            <label class="form-check-label" for="salutation_1">
                Frau *
            </label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="salutation" id="salutation_2" value="m">
            <label class="form-check-label" for="salutation_2">
                Herr *
            </label>
        </div>
        <div class="form-group">
            <label for="name">Name *</label>
            <input type="text" class="form-control" name="name">
        </div>
        <div class="form-group">
            <label for="email">E-Mail *</label>
            <input type="text" class="form-control" name="email">
        </div>
        <div class="form-group">
            <label for="birthday">Geburtstag (DD.MM.YYYY) *</label>
            <input type="text" class="form-control" name="birthday">
        </div>
        <div class="form-group">
            <label for="creditcard">Kreditkartennummer *</label>
            <input type="text" class="form-control" name="creditcard">
        </div>
        <div class="form-group">
            <label for="country">Land *</label>
            <select name="country" id="country" class="form-control">
                <option value="_default" selected hidden>Bitte auswählen ...</option>
                <?php

                // dynamisch generiertes Dropdown (Bitte auswählen..., Österreich, Deutschland, Schweiz, Liechtenstein)
                $options = [
                    'AT' => 'Österreich',
                    'S' => 'Schweiz',
                    'D' => 'Deutschland',
                    'L' => 'Liechtenstein'
                ];

                foreach ($options as $value => $label) {
                    echo "<option value=\"${value}\">${label}</option>";
                }

                ?>
            </select>
        </div>
        <div class="form-check">
            <input type="checkbox" name="agb" id="agb" class="form-check-input">
            <label for="agb" class="form-check-label">
                Ich habe die AGB gelesen, verstanden und akzeptiere diese. *
            </label>
        </div>

        <input type="submit" name="do-submit" value="Senden">
    </form>
</div>

</body>
</html>