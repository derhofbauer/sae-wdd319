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
} else {
    /**
     * Keine sehr hübsche Lösung, aber es löst das Problem, dass beim Aufrug von renderError() ein Fatal Error geworfen
     * wird, weil $errors nicht existiert.
     */
    $errors = [];
}

/**
 * @param string $key
 * @param array  $errors
 */
function renderError (string $key, array $errors)
{
    if (isset($errors[$key])) {
        echo "<p class=\"alert alert-warning\">" . $errors[$key] . ".</p >";
    }
}

/**
 * @param string $key
 */
function oldValue (string $key)
{
    if (isset($_POST[$key])) {
        echo $_POST[$key];
    }
}

/**
 * @param string $key
 * @param string $value
 */
function oldValueRadio (string $key, string $value)
{
    if (isset($_POST[$key]) && $_POST[$key] === $value) {
        echo "checked";
    }
}

?>

<div class="container">
    <h1>Formularvalidierung</h1>

    <form action="index.php" method="post">
        <div class="form-check">
            <input class="form-check-input" type="radio" name="salutation" id="salutation_1" value="f" <?php oldValueRadio('salutation', 'f'); ?>>
            <label class="form-check-label" for="salutation_1">
                Frau *
            </label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="salutation" id="salutation_2" value="m" <?php oldValueRadio('salutation', 'm'); ?>>
            <label class="form-check-label" for="salutation_2">
                Herr *
            </label>
        </div>
        <?php renderError('salutation', $errors); ?>
        <div class="form-group">
            <label for="name">Name *</label>
            <input type="text" class="form-control" name="name" value="<?php oldValue('name'); ?>">
        </div>
        <?php renderError('name', $errors); ?>
        <div class="form-group">
            <label for="email">E-Mail *</label>
            <input type="text" class="form-control" name="email" value="<?php oldValue('email'); ?>">
        </div>
        <?php renderError('email', $errors); ?>
        <div class="form-group">
            <label for="birthday">Geburtstag (DD.MM.YYYY) *</label>
            <input type="text" class="form-control" name="birthday" value="<?php oldValue('birthday'); ?>">
        </div>
        <?php renderError('birthday', $errors); ?>
        <div class="form-group">
            <label for="creditcard">Kreditkartennummer</label>
            <input type="text" class="form-control" name="creditcard" value="<?php oldValue('creditcard'); ?>">
        </div>
        <?php renderError('creditcard', $errors); ?>
        <div class="form-group">
            <label for="country">Land *</label>
            <select name="country" id="country" class="form-control">
                <?php

                // dynamisch generiertes Dropdown (Bitte auswählen..., Österreich, Deutschland, Schweiz, Liechtenstein)

                $options = require 'countries.php';
                $options['_default'] = 'Bitte auswählen ...';

                $selected = '_default';
                if (isset($_POST['country'])) {
                    $selected = $_POST['country'];
                }

                foreach ($options as $value => $label) {

                    $selectedParticle = ($selected === $value ? ' selected' : '');

                    if ($value === '_default') {
                        echo "<option value=\"${value}\" hidden${selectedParticle}>${label}</option>";
                    } else {
                        echo "<option value=\"${value}\"${selectedParticle}>${label}</option>";
                    }
                    
                }

                ?>
            </select>
        </div>
        <?php renderError('country', $errors); ?>
        <div class="form-check">
            <input type="checkbox" name="agb" id="agb" class="form-check-input">
            <label for="agb" class="form-check-label">
                Ich habe die AGB gelesen, verstanden und akzeptiere diese. *
            </label>
        </div>
        <?php renderError('agb', $errors); ?>

        <input type="submit" name="do-submit" value="Senden">
    </form>
</div>

</body>
</html>
