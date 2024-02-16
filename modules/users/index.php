<?php
include_once "../common/header.php";
include_once "../auth/displayUsers.php";
$users_obj= new DisplayUser();
$allUser=$users_obj->showUser();
// pr($allUser);
// die();
?>
<div id="main-content">
    <?php
    $userId=$_SESSION['authUser'];
    
    if (isset($userId)) {
        if ($allUser && count($allUser) > 0) {
    ?>
        <h2>All User</h2>
        <table cellpadding="7px">
            <thead>
                <th>S.No</th>
                <th>User Name</th>
                <th>User email</th>
                <th>User Status</th>
                <th>Action</th>
            </thead>
            <tbody>
                <?php
                foreach ($allUser as $user) {
                ?>
                    <tr>
                        <td><?php echo $user['id'] ?></td>
                        <td><?php echo $user['first_name'] ?></td>
                        <td><?php echo $user['email'] ?></td>
                        <td><?php echo $user['status'] ?></td>

                        <td>
                            <a href='#'>Edit</a>
                            <a href='#'>Delete</a>
                        </td>
                    </tr>

                <?php
                }
                ?>
            </tbody>
        </table>
    <?php
        }else {
            echo '<h2 style="text-align:center; color:red;">No Record Found<h2>';
        }
    } else {
        echo '<h2 style="text-align:center; color:red;">User not authenticated</h2>';
    }
    ?>
</div>
</div>
</body>

</html>

