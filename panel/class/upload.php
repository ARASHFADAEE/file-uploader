<?php
class upload{
    
    private $conn;
    
    
    public function __construct()
    {

        require_once('../config/database.php');
        session_start();
        $this->conn = $conn;
        
    }
    
    public  function UploadFile($file)
    {


        $target_dir = "uploads/";
        $target_file = $target_dir."file_".time()."set".basename($_FILES["fileToUpload"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

// Check if image file is a actual image or fake image
        if(isset($_POST["submit"])) {
            $check = getimagesize($_FILES['fileToUpload']["tmp_name"]);
            if($check !== false) {
                header("location: ./index.php?check=ok&message=File is an image - ".$check["mime"].'.');

                $uploadOk = 1;
            } else {
                header("location: ./index.php?error=ok&message=File is not an image.");

                $uploadOk = 0;
            }
        }

// Check if file already exists
        if (file_exists($target_file)) {
            header("location: ./index.php?file_exists=ok&message= Sorry, file already exists.");


            $uploadOk = 0;
        }

// Check file size
        if ($_FILES["fileToUpload"]["size"] > 500000) {
            header("location: ./index.php?file_large=ok&message=Sorry, your file is too large.");

            $uploadOk = 0;
        }

// Allow certain file formats
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif" ) {
            header("location: ./index.php?file_format=no&message=Sorry, only JPG, JPEG, PNG & GIF files are allowed.");

            $uploadOk = 0;
        }

// Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            header("location: ./index.php?file_upload=no&message=Sorry, your file was not uploaded.");

// if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {

                $url="http://localhost/php/file-uploader/".$target_file;
                $file_name=basename( $_FILES["fileToUpload"]["name"]);
                $type_link=$_POST['type_link'];
                try {

                    if (isset($url)){
                        $query="INSERT INTO files SET user_id=?, file_name=? , file_link=? , type=? , create_time=?";

                        $stmt=$conn->prepare($query);
                        $stmt->bindvalue(1,$_SESSION['user_id']);
                        $stmt->bindvalue(2,$file_name);
                        $stmt->bindValue(3,$url);
                        $stmt->bindValue(4,$type_link);
                        $stmt->bindValue(5,time());


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
        
    }
    
    
    
}


?>


