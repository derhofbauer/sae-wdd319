<h2>Accounts</h2>

<table class="table table-striped">
    <thead>
    <tr>
        <th>#</th>
        <th>Email</th>
        <th>Admin?</th>
        <th>Actions</th>
    </tr>
    </thead>

    <tbody>
    <?php foreach ($users as $user): ?>
        <tr>
            <td><?php echo $user->id; ?></td>
            <td><?php echo $user->email; ?></td>
            <td><?php echo($user->is_admin === true ? 'yes' : 'no'); ?></td>
            <td>
                <a href="dashboard/accounts/edit/<?php echo $user->id; ?>" class="btn btn-secondary btn-sm">Edit</a>
                <?php
                /**
                 * Für den aktuell eingeloggten User werden wir keinen Löschen Button rendern. Ein User kann sich also
                 * selbst nicht löschen. Nachdem nur Admins andere User löschen können bleibt auf jeden Fall ein Admin
                 * übrig. Grundsätzlich existiert natürlich die Route, auf die der Link zeigt, auf für den aktuell
                 * eingeloggten User und die entsprechende Action prüft aktuell nicht, ob der aktuell eingeloggte User
                 * gelöscht werden soll. Theoretisch könnte ein User sich also schon selbst löschen, indem die
                 * entsprechende Route eingegeben wird.
                 */
                if (\App\Models\User::getLoggedInUser()->id !== $user->id): ?>
                    <a href="dashboard/accounts/delete/<?php echo $user->id; ?>" class="btn btn-danger btn-sm">Delete</a>
                <?php endif; ?>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
