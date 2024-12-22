<?php

require_once ('./config/loader.php');


$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        header("location: ./index.php?check=ok&message=File is an image - ".$check["mime"].'.');

        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
}

// Check if file already exists
if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
}

// Check file size
if ($_FILES["fileToUpload"]["size"] > 500000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}

// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
//        echo "The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.<br>";

        $url="http://localhost/php/file-uploader/uploads/".$_FILES["fileToUpload"]["name"];
        $file_name=basename( $_FILES["fileToUpload"]["name"]);
        $type_link=$_POST['type_link'];
        try {

            if (isset($url)){
                $query="INSERT INTO files SET file_name=? , file_link=? , type=?";

                $stmt=$conn->prepare($query);

                $stmt->bindvalue(1,$file_name);
                $stmt->bindValue(2,$url);
                $stmt->bindValue(3,$type_link);

                $stmt->execute();

                header("location: ./index.php?file_upload=ok&url_file=".$url);




            }

        }catch (Exception $e){
            $e->getMessage();
        }



    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}
?>