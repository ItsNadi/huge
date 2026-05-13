<div class="container">
    <h1>User & Group List</h1>

    <table class="overview-table">
        <tr>
            <td>ID</td>
            <td>Username</td>
            <td>Email</td>
            <td>Group</td>
        </tr>

        <?php foreach ($this->users as $user) { ?>
            <tr>
                <td><?= $user->user_id ?></td>
                <td><?= $user->user_name ?></td>
                <td><?= $user->user_email ?></td>
                <td><?= $user->group_name ?? 'No group' ?></td>
            </tr>
        <?php } ?>
    </table>
</div>