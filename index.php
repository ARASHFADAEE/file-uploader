<?php
require_once ('./config/loader.php');


?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Link shortener</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

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

</body>
</html>

<?php
//get url
//
// get shorted link
// shorted link  is in database url

// shorted link  in database = true   alert = url is not use

//shorted link  in database = false
//
//save link and show shortlink in page
//
//




?>