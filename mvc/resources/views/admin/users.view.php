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
        <td><?php echo ($user->is_admin === true ? 'yes': 'no'); ?></td>
        <td>
            <a href="dashboard/accounts/edit/<?php echo $user->id; ?>" class="btn btn-secondary btn-sm">Edit</a>
        </td>
    </tr>
    <?php endforeach; ?>
    </tbody>
</table>
