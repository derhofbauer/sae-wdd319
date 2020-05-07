<div class="card col-6">
    <article class="card-body">
        <h4 class="card-title text-center mb-4 mt-1">Sign in</h4>
        <hr>
        <?php
        /**
         * $errors wurde in includes/login.php definiert und dieses File wird im selben Scope wie $errors eingebunden,
         * wodurch $errors hier verfügbar ist.
         */
        foreach($errors as $error): ?>
            <p class="text-danger text-center"><?php echo $error; ?></p>
        <?php endforeach; ?>
        <form action="do-login" method="post">
            <div class="form-group">
                <div class="input-group">
                    <input name="email" class="form-control" placeholder="Email" type="email">
                </div> <!-- input-group.// -->
            </div> <!-- form-group// -->
            <div class="form-group">
                <div class="input-group">
                    <input class="form-control" placeholder="******" type="password" name="password">
                </div> <!-- input-group.// -->
            </div> <!-- form-group// -->
            <div class="form-group">
                <button type="submit" class="btn btn-primary btn-block">Login</button>
            </div> <!-- form-group// -->
        </form>
    </article>
</div>
