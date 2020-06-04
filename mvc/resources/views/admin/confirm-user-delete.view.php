<div class="card col-6">
    <div class="card-body">
        <h4 class="card-title">
            <?php echo "{$user->firstname} {$user->lastname}"; ?> löschen?
        </h4>

        <a href="dashboard/accounts/do-delete/<?php echo $user->id; ?>" class="btn btn-danger">Yes</a>
        <a href="dashboard/accounts" class="btn btn-secondary">OMG no!</a>
    </div>
</div>
