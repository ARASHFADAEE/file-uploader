<?php
session_start();

require_once('./class/auth.php');

$auth = new Auth();

$auth->is_login();
include './config/loader.php';

if ($_SESSION['role'] == 'user') {
    $query_all_file = "SELECT * FROM `files` WHERE user_id=?";
    $result = $conn->prepare($query_all_file);
    $result->bindValue(1, $_SESSION['user_id']);
    $result->execute();
    $files_list = $result->fetchAll(PDO::FETCH_OBJ);
} elseif ($_SESSION['role'] == 'admin') {
    $query_all_file = "SELECT * FROM `files` ";
    $result = $conn->query($query_all_file);
    $result->execute();
    $files_list = $result->fetchAll(PDO::FETCH_OBJ);

}
$i = 1;

//delete file
if (isset($_GET['delete'])) {
    try {
        $id = $_GET['delete'];
        $user_id = $_SESSION['user_id'];
        $is_admin = $_SESSION['role'] === 'admin';

        // بررسی وجود فایل در دیتابیس
        $query_verify = "SELECT * FROM files WHERE id = ?";
        $stmt_verify = $conn->prepare($query_verify);
        $stmt_verify->bindValue(1, $id, PDO::PARAM_INT);
        $stmt_verify->execute();
        $file_data = $stmt_verify->fetch(PDO::FETCH_ASSOC);

        if ($file_data) {
            $file_path = '../uploads/' . $file_data['file_name'];


            // بررسی دسترسی کاربر به فایل
            if ($file_data['user_id'] === $user_id || $is_admin) {
                $query_delete = "DELETE FROM files WHERE id = ?";
                $stmt_delete = $conn->prepare($query_delete);
                $stmt_delete->bindValue(1, $id, PDO::PARAM_INT);
                $stmt_delete->execute();
                // بررسی وجود فایل در سرور
                if (is_file($file_path)) {
                    unlink($file_path); // حذف فایل از سرور
                } else {
                    header('location: ./uploaded-files.php?error-ok&message=File not found on server');
                    exit();
                }

                header('location: ./uploaded-files.php?error=ok&message=File deleted successfully');
                exit();
            } else {
                header('location: ./uploaded-files.php?error=ok&message=Access denied');
                exit();
            }
        } else {
            header('location: ./uploaded-files.php?error=ok&message=File not found in database');
            exit();
        }
    } catch (Exception $e) {
        echo 'Error: ' . $e->getMessage();
    }
}


$title = 'uploaded files';

?>
<?php include 'header-main.php'; ?>

<!-- start main content section -->
<div class="panel mt-6">
    <?php if ($_SESSION['role'] == 'admin'): ?>
        <h5 class="text-lg font-semibold dark:text-white-light">Uploaded File in script</h5>
    <?php elseif ($_SESSION['role'] == 'user'): ?>
        <h5 class="text-lg font-semibold dark:text-white-light">Uploaded File</h5>

    <?php endif; ?>

    <?php require_once('./config/alerts.php') ?>

    <div class="dataTable-wrapper dataTable-loading no-footer fixed-columns">
        <div class="dataTable-top"></div>
        <div class="dataTable-container">
            <table id="myTable" class="table-hover whitespace-nowrap dataTable-table">
                <thead>
                <tr>
                    <th style="width: 12.7939%;">Row</th>
                    <th style="width: 13.7884%;">File Type</th>
                    <th style="width: 21.0669%;">File Name</th>
                    <th style="width: 22.9656%;">Actions</th>

                </tr>
                </thead>
                <tbody>
                <?php foreach ($files_list as $file) { ?>

                    <tr>
                        <td><?= $i++ ?></td>
                        <?php
                        $check = getimagesize($file->file_link);

                        if ($check):?>

                            <td><img src="<?= $file->file_link ?>" style=" width: 100px" alt=""></td>

                        <?php else: ?>


                            <td><?= $file->file_name ?></td>
                        <?php endif; ?>
                        <td><?= $file->file_name ?></td>
                        <td>
                            <a href="./uploaded-files.php?delete=<?= $file->id ?>"
                               style="background: red; padding: 4px; border-radius: 10px; color: #ffff;margin-right: 5px; ">delete</a>
                            <?php if ($file->type == 'indirect'): ?>
                                <a style="background: blue; padding: 4px; border-radius: 10px; color: #ffff;margin-right: 5px; "
                                   href="<?= $_ENV['SITE_URL'] . "/?slug=" . $file->indirect_slug ?>">indirect link</a>
                            <?php elseif ($file->type == 'directly'): ?>

                                <a style="background: blue; padding: 4px; border-radius: 10px; color: #ffff;margin-right: 5px; "
                                   download href="<?= $file->file_link ?>">download</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

</div>

<?php include 'footer-main.php'; ?>
