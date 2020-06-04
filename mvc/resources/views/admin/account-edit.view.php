<h2>Edit Account: #<?php echo $user->id; ?></h2>

<?php
/**
 * Flash Messages aus der Session laden und löschen.
 */
$flashMessage = \Core\Session::get('flash', null, true);

/**
 * Gibt es Messages in der Session, geben wir sie hier aus.
 */
if ($flashMessage !== null) {
    echo "<div class=\"alert alert-success\">$flashMessage</div>";
}
?>

<form action="dashboard/accounts/do-edit/<?php echo $user->id; ?>" method="post">
    <div class="form-group">
        <label for="firstname">Vorname</label>
        <input name="firstname" class="form-control" placeholder="Vorname" type="text" value="<?php echo $user->firstname; ?>">
    </div> <!-- form-group// -->
    <div class="form-group">
        <label for="lastname">Nachname</label>
        <input name="lastname" class="form-control" placeholder="Nachname" type="text" value="<?php echo $user->lastname; ?>">
    </div> <!-- form-group// -->
    <div class="form-group">
        <label for="email">Email</label>
        <input name="email" class="form-control" placeholder="Email" type="email" value="<?php echo $user->email; ?>">
    </div> <!-- form-group// -->
    <div class="form-group">
        <label for="password">Password</label>
        <input class="form-control" placeholder="******" type="password" name="password">
    </div> <!-- form-group// -->
    <div class="form-group">
        <label for="password2">Passwort wiederholen</label>
        <input class="form-control" placeholder="******" type="password" name="password2">
    </div> <!-- form-group// -->
    <div class="form-group form-check">
        <?php
        /**
         * Wir müssen die folgende Checkbox dynamisch anhakerln oder nicht anhakerln. Das machen wir, indem wir das
         * checked Binary Attribut in den <input>-Tag rendern oder eben nicht, je nachdem, ob der User ein Admin ist
         * oder nicht.
         */

        /**
         * Standardwert definieren
         */
        $isCheckedParticle = '';

        /**
         * Ist der User ein Admin, überschreiben wir den leeren String mit dem checked-Attribut.
         */
        if ($user->is_admin === true) {
            $isCheckedParticle = ' checked';
        }
        ?>
        <input type="checkbox" class="form-check-input" name="isAdmin"<?php echo $isCheckedParticle?>>
        <label for="isAdmin" class="form-check-label">Is Admin?</label>
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-primary btn-block">Save</button>
    </div> <!-- form-group// -->
</form>
