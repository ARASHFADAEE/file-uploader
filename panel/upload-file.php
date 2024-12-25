<?php
session_start();

require_once('./class/auth.php');

$auth = new Auth();

$auth->is_login();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['fileToUpload'])) {
    $target_dir = "../uploads/";
    $file_name = basename($_FILES["fileToUpload"]["name"]);
    $target_file = $target_dir . "file_" . time() . "_set_" . $file_name;
    $target_name="file_" . time() . "_set_" . $file_name;
    $uploadOk = true;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Validate file type
    $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
    if (!in_array($imageFileType, $allowed_types)) {
        header("location: ./upload-file.php?file_format=no&message=Only JPG, JPEG, PNG, and GIF files are allowed.");
        $uploadOk = false;
    }

    // Validate file size
    if ($_FILES["fileToUpload"]["size"] > 50000000) {
        header("location: ./upload-file.php?file_large=ok&message=File size exceeds limit.");
        $uploadOk = false;
    }

    // Validate image
    if (getimagesize($_FILES["fileToUpload"]["tmp_name"]) === false) {
        header("location: ./upload-file.php?error=ok&message=File is not a valid image.");
        $uploadOk = false;
    }

    // Check for upload errors
    if ($uploadOk) {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            $url = $_ENV['SITE_URL'].str_replace('../','/',$target_file) ;
            $type_link = htmlspecialchars($_POST['type_link'] ?? 'directly');


            try {
                include './config/loader.php';
                
                  if ($_POST['type_link']=='directly'){

                $query = "INSERT INTO files (user_id, file_name, file_link, type, create_time) VALUES (?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($query);

                $stmt->bindValue(1, $_SESSION['user_id'], PDO::PARAM_INT);
                $stmt->bindValue(2, $target_name, PDO::PARAM_STR);
                $stmt->bindValue(3, $url, PDO::PARAM_STR);
                $stmt->bindValue(4, $type_link, PDO::PARAM_STR);
                $stmt->bindValue(5, time(), PDO::PARAM_INT);

                $stmt->execute();

                header("location: ./upload-file.php?file_upload=ok&url_file=" . urlencode($url));
                  }elseif ($_POST['type_link']=='indirect'){
                      $random=rand(100000,99999).time();
                      $query = "INSERT INTO files (user_id, file_name, file_link, type,indirect_slug, create_time) VALUES (?, ?, ?, ?, ?,?)";
                      $stmt = $conn->prepare($query);

                      $stmt->bindValue(1, $_SESSION['user_id'], PDO::PARAM_INT);
                      $stmt->bindValue(2, $target_name, PDO::PARAM_STR);
                      $stmt->bindValue(3, $url, PDO::PARAM_STR);
                      $stmt->bindValue(4, $_POST['type_link'], PDO::PARAM_STR);
                      $stmt->bindValue(5,$random , PDO::PARAM_INT);
                      $stmt->bindValue(6, time(), PDO::PARAM_INT);

                      $stmt->execute();
                      $url2=$_ENV['SITE_URL'].'/?slug='.$random;
                      header("location: ./upload-file.php?file_upload=ok&url_file=" . urlencode($url2));


                  }

            } catch (Exception $e) {
                error_log($e->getMessage());
                header("location: ./upload-file.php?error=db&message=Database error.");
            
            
            
            }
        } else {
            header("location: ./upload-file.php?error=upload_failed&message=File upload failed.");
        }
    }
}
$title='upload file';

?>

<?php include 'header-main.php'; ?>
<?php require_once ('./config/alerts.php')?>
<form class="space-y-5" method="post" enctype="multipart/form-data">
    <div class="flex sm:flex-row flex-col">
        <label for="fileToUpload" class="mb-0 sm:w-1/4 sm:ltr:mr-2 rtl:ml-2">File</label>
        <input id="fileToUpload" name="fileToUpload" type="file" placeholder="Upload file" class="form-input flex-1" required />
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
