<!-- errors validation-->
<?php if(isset($_GET['check']) && $_GET['check']=='ok'):?>
    <div class="alert alert-danger alert_custom " >
        <p><?php echo $_GET['message']?></p>
    </div>
<?php endif;?>


<!-- general error-->
<?php if(isset($_GET['error']) && $_GET['error']=='ok'):?>
    <div class="alert alert-danger alert_custom " >
        <p><?php echo $_GET['message']?></p>
    </div>
<?php endif;?>

<!-- file exists error-->
<?php if(isset($_GET['file_exists']) && $_GET['file_exists']=='ok'):?>
    <div class="alert alert-danger alert_custom " >
        <p><?php echo $_GET['message']?></p>
    </div>
<?php endif;?>

<!-- file validate size error (>500000 size)-->

<?php if(isset($_GET['file_large']) && $_GET['file_largefile_large']=='ok'):?>
    <div class="alert alert-danger alert_custom " >
        <p><?php echo $_GET['message']?></p>
    </div>
<?php endif;?>



<!-- file  validate format error-->

<?php if(isset($_GET['file_format']) && $_GET['file_format']=='no'):?>
    <div class="alert alert-danger alert_custom " >
        <p><?php echo $_GET['message']?></p>
    </div>
<?php endif;?>

<!-- file upload error -->

<?php if(isset($_GET['file_upload']) && $_GET['file_upload']=='no'):?>
    <div class="alert alert-danger alert_custom " >
        <p><?php echo $_GET['message']?></p>
    </div>
<?php endif;?>


<!-- success file upload-->
<?php if(isset($_GET['file_upload']) && $_GET['file_upload']=='ok'):?>
    <div class="alert alert-success alert_custom " >
        <p>file uploaded</p>
        <a href="<?php echo $_GET['url_file']?>">link :<?php echo $_GET['url_file']?></a>
    </div>
<?php endif;?>
