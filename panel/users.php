<?php
session_start();

require_once('./class/auth.php');

$auth = new Auth();

$auth->is_login();
include './config/loader.php';
//lists users
if($_SESSION['role']=='admin'){
    $query_all_users = "SELECT * FROM `users` ";
    $result = $conn->query($query_all_users);
    $result->execute();
    $users_list = $result->fetchAll(PDO::FETCH_OBJ);

}
$i=1;

//delete file action
if(isset($_GET['delete'])){
    try {
        $id=$_GET['delete'];
        $query_delete="DELETE FROM users WHERE id=?";
        $result=$conn->prepare($query_delete);
        $result->bindValue(1,$id);
        $result->execute();

        header('location: ./users.php?users_lists=ok&delete_item=ok&message=user deleted successfully');

    }catch (Exception $e){
        echo $e->getMessage();
    }


}
$title='users lists';

?>
<?php include 'header-main.php'; ?>

<!-- start main content section -->
<div class="panel mt-6">
        <h5 class="text-lg font-semibold dark:text-white-light">users</h5>
    
    <?php require_once ('./config/alerts.php')?>

    <div class="dataTable-wrapper dataTable-loading no-footer fixed-columns">
        <div class="dataTable-top"></div>
        <div class="dataTable-container">
            <table id="myTable" class="table-hover whitespace-nowrap dataTable-table">
                <thead>
                <tr>
                    <th style="width: 12.7939%;">Row</th>
                    <th style="width: 13.7884%;">username</th>
                    <th style="width: 21.0669%;">email</th>
                    <th style="width: 10.0669%;">role</th>
                    <th style="width: 22.9656%;">Actions</th>

                </tr>
                </thead>
                <tbody>
                <?php foreach ($users_list as $user){?>

                    <tr>
                        <td><?= $i++?></td>
                            <td><?= $user->username?></td>
                        <td><?= $user->email?></td>
                        <td><?= $user->role?></td>

                        <td>
                            <a href="./users.php?delete=<?= $user->id ?>" style="background: red; padding: 4px; border-radius: 10px; color: #ffff;margin-right: 5px; ">delete</a>

                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include 'footer-main.php'; ?>
