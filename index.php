<?php
require_once ('./config/loader.php');


// start show lists files uploaded
$query_all_file="SELECT * FROM files ";
$result=$conn->query($query_all_file);
$result->execute();
$files_list=$result->fetchAll();


//delete file

if(isset($_GET['delete'])){
    try {
        $id=$_GET['delete'];
        $query_delete="DELETE FROM files WHERE id=?";
        $result=$conn->prepare($query_delete);
        $result->bindValue(1,$id);
        $result->execute();

        header('location: index.php');

    }catch (Exception $e){
        echo $e->getMessage();
    }


}
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Link shortener</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="./assets/style.css">
</head>
<body>
<div class="container">
    <div class="box">
        <h1>File Uploader</h1>
        <div class="link-box">
            <form method="post" action="upload.php" enctype="multipart/form-data">

            <br>
                <h2>Select image to upload:</h2>
                <br>
                <input type="file" name="fileToUpload" id="fileToUpload">
                <br>
                <br>
                <select name="type_link" class="select-fe" name="" id="">
                    <option value="directly">directly</option>
                    <option value="indirect">indirect</option>

                </select>


                <br>

            <br>
            <button type="submit" name="submit" class="button-submit">upload</button>

                <?php require_once ('./config/alerts.php');?>


        </form>

        </div>
    </div>


</div>

<div class="container">
    <div class="container mt-3">
        <h2>Uploaded files</h2>
        <table class="table table-striped">
            <thead>
            <tr>
                <th>File Name</th>
                <th>Operation</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ( $files_list as $file ):?>

            <tr>


                <td><?= $file['file_name']?></td>

                <td>
                    <a class="delete-btn" href="index.php?delete=<?= $file['id']?>">delete</a>
                    <a class="save-btn" download href="<?= $file['file_link']?>">download</a>
                </td>

            </tr>
            <?php endforeach;?>


            </tbody>
        </table>
    </div>

</div>

</body>
</html>
