
<table class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>#</th>
            <th>Username</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email</th>
            <th>Role</th>
            <th>Admin</th>
            <th>Subscriber</th>
            <th>Status</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>
    </thead>
    <tbody>
        <?php
        try {
            $users = User::getUsers();
            foreach ($users as $u) {
                echo "<tr>
                    <td>$u->userID</td>
                    <td>$u->userName</td>
                    <td>$u->firstName</td>
                    <td>$u->lastName</td>
                    <td>$u->email</td>
                    <td>$u->userRole</td>
                    <td><a href='process/processUser.php?admin=$u->userID'>Admin</a></td>
                    <td><a href='process/processUser.php?subscriber=$u->userID'>Subscriber</a></td>";

                if ($u->isActive) {
                    echo "<td><a href='process/processUser.php?status=inactive&userID=$u->userID'>Active</a></td>";
                } else {
                    echo "<td><a href='process/processUser.php?status=active&userID=$u->userID'>Inactive</a></td>";
                }

                echo "<td><a href='users.php?source=edit_user&user_id=$u->userID'>Edit</a></td>
                    <td><a href='process/processUser.php?delete=$u->userID'>Delete</a></td>
                </tr>";
            }
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
        ?>
    </tbody>
</table>