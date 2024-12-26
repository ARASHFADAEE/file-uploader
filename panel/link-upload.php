<?php
session_start();

require_once('./class/auth.php');

$auth = new Auth();

$auth->is_login();

if (isset($_POST['submit'])) {

    try {
        // Validate link_upload
        if (isset($_POST['link_upload']) && !empty($_POST['link_upload'])) {
            $file_url = filter_var($_POST['link_upload'], FILTER_SANITIZE_URL);

            if (!filter_var($file_url, FILTER_VALIDATE_URL)) {
                header("location: ../panel/link-upload.php?error=invalid_url");
                exit;
            }

            // Prepare upload path
            $savePath = '../uploads/';
            if (!is_dir($savePath) || !is_writable($savePath)) {
                header("location: ../panel/link-upload.php?error=upload_path_error");
                exit;
            }

            // Fetch file content
            $fileContent = @file_get_contents($file_url);
            if (!$fileContent) {
                header("location: ../panel/link-upload.php?error=file_not_found");
                exit;
            }

            // Generate file name and validate extension
            $fileName = time() . basename(parse_url($file_url, PHP_URL_PATH));
            $ext = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
            $allowedExtensions = ['jpg', 'png', 'pdf', 'txt', 'mp3', 'zip'];

            if (!in_array($ext, $allowedExtensions)) {
                header("location: ../panel/link-upload.php?error=ok&message=invalid_file_type");
                exit;
            }

            // Save the file locally
            $filePath = $savePath . $fileName;
            if (file_put_contents($filePath, $fileContent) === false) {
                header("location: ../panel/link-upload.php?error=upload_failed");
                exit;
            }

            include './config/loader.php';

            // Validate session and type_link
            if (!isset($_SESSION['user_id'])) {
                header("location: ./panel/link-upload.php?error=no_user_session");
                exit;
            }

            $allowedTypes = ['directly', 'indirect'];
            if (!isset($_POST['type_link']) || !in_array($_POST['type_link'], $allowedTypes)) {
                header("location: ./panel/link-upload.php?error=invalid_type");
                exit;
            }

            // Handle database operations
            $query = "";
            $url = "";

            if ($_POST['type_link'] === 'directly') {
                $query = "INSERT INTO files (user_id, file_name, file_link, type, create_time) VALUES (?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($query);
                $stmt->bindValue(1, $_SESSION['user_id'], PDO::PARAM_INT);
                $stmt->bindValue(2, $fileName, PDO::PARAM_STR);
                $stmt->bindValue(3, $filePath, PDO::PARAM_STR);
                $stmt->bindValue(4, 'directly', PDO::PARAM_STR);
                $stmt->bindValue(5, time(), PDO::PARAM_INT);

                $url = './link-upload.php?file_upload=ok&url_file=' . urlencode($filePath);
            } elseif ($_POST['type_link'] === 'indirect') {
                $random = rand(100000, 99999) . time();
                $query = "INSERT INTO files (user_id, file_name, file_link, type, indirect_slug, create_time) VALUES (?, ?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($query);
                $stmt->bindValue(1, $_SESSION['user_id'], PDO::PARAM_INT);
                $stmt->bindValue(2, $fileName, PDO::PARAM_STR);
                $stmt->bindValue(3, $filePath, PDO::PARAM_STR);
                $stmt->bindValue(4, 'indirect', PDO::PARAM_STR);
                $stmt->bindValue(5, $random, PDO::PARAM_INT);
                $stmt->bindValue(6, time(), PDO::PARAM_INT);

                $url = './link-upload.php?file_upload=ok&url_file=' . urlencode($_ENV['SITE_URL'] . '/?slug=' . $random);
            }

            // Execute query
            $stmt->execute();
            header("location: $url");
            exit;
        } else {
            header("location: ../link-upload.php?error=no_link_provided");
            exit;
        }
    } catch (Exception $e) {
        error_log($e->getMessage());
        header("location: ../upload-file.php?error=db_error&message=" . urlencode("Database error occurred."));
        exit;
    }
} else {
 
}



$title='upload file';

?>

<?php include 'header-main.php'; ?>
<?php require_once ('./config/alerts.php')?>
<form class="space-y-5" method="post" >
    <div class="flex sm:flex-row flex-col">
        <label for="link_upload" class="mb-0 sm:w-1/4 sm:ltr:mr-2 rtl:ml-2">File</label>
        <input id="link_upload" name="link_upload" type="url" placeholder="enter link for upload" class="form-input flex-1" required />
    </div>

    <div class="flex sm:flex-row flex-col">
        <label class="sm:w-1/4 sm:ltr:mr-2 rtl:ml-2">Choose type</label>
        <select name="type_link" class="form-select flex-1" required>
            <option value="directly">Directly</option>
            <option value="indirect">Indirect</option>
        </select>
    </div>

    <button name="submit" type="submit" class="btn btn-primary !mt-6">Upload</button>
</form>

<?php include 'footer-main.php'; ?>
