<div class="card col-6">
    <article class="card-body">
        <h4 class="card-title text-center mb-4 mt-1">Sign Up</h4>
        <hr>
        <?php foreach ($errors as $error): ?>
            <p class="text-danger text-center"><?php echo $error; ?></p>
        <?php endforeach; ?>
        <form action="do-sign-up" method="post">
            <div class="form-group">
                <label for="firstname">Vorname</label>
                <input name="firstname" class="form-control" placeholder="Vorname" type="text">
            </div> <!-- form-group// -->
            <div class="form-group">
                <label for="lastname">Nachname</label>
                <input name="lastname" class="form-control" placeholder="Nachname" type="text">
            </div> <!-- form-group// -->
            <div class="form-group">
                <label for="email">Email</label>
                <input name="email" class="form-control" placeholder="Email" type="email">
            </div> <!-- form-group// -->
            <div class="form-group">
                <label for="password">Password</label>
                <input class="form-control" placeholder="******" type="password" name="password">
            </div> <!-- form-group// -->
            <div class="form-group">
                <label for="password2">Passwort wiederholen</label>
                <input class="form-control" placeholder="******" type="password" name="password2">
            </div> <!-- form-group// -->
            <div class="form-group">
                <button type="submit" class="btn btn-primary btn-block">Login</button>
            </div> <!-- form-group// -->
        </form>
    </article>
</div>
