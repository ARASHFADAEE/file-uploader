<!-- errors validation file-->


<?php if(isset($_GET['check']) && $_GET['check']=='ok'):?>
    <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
        <p class="text-sm text-red-800  dark:bg-gray-800 dark:text-red-400 "><?= $_GET['message']?></p>
    </div>
<?php endif;?>


<!-- general error-->
<?php if(isset($_GET['error']) && $_GET['error']=='ok'):?>
    <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
        <p class="text-sm text-red-800  dark:bg-gray-800 dark:text-red-400 "><?= $_GET['message']?></p>
    </div>
<?php endif;?>

<!-- file exists error-->
<?php if(isset($_GET['file_exists']) && $_GET['file_exists']=='ok'):?>
    <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
        <p class="text-sm text-red-800  dark:bg-gray-800 dark:text-red-400 "><?= $_GET['message']?></p>
    </div>
<?php endif;?>

<!-- file validate size error (>500000 size)-->

<?php if(isset($_GET['file_large']) && $_GET['file_largefile_large']=='ok'):?>
    <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
        <p class="text-sm text-red-800  dark:bg-gray-800 dark:text-red-400 "><?= $_GET['message']?></p>
    </div>
<?php endif;?>



<!-- file  validate format error-->

<?php if(isset($_GET['error']) && $_GET['error']=='upload_failed' && $_GET['error']=='no_user_session' && $_GET['error']=='invalid_type'):?>
    <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
        <p class="text-sm text-red-800  dark:bg-gray-800 dark:text-red-400 "><?=$_GET['error']?></p>
    </div>
<?php endif;?>


<?php //if(isset($_GET['error']) && isset($_GET['message'])):?>
<!--    <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">-->
<!--        <p class="text-sm text-red-800  dark:bg-gray-800 dark:text-red-400 ">--><?php //=$_GET['message']?><!--</p>-->
<!--    </div>-->
<?php //endif;?>


<?php //if(isset($_GET['error']) && isset($_GET['message']) && $_GET['error']=='ok'):?>
<!--    <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">-->
<!--        <p class="text-sm text-red-800  dark:bg-gray-800 dark:text-red-400 ">--><?php //=$_GET['message']?><!--</p>-->
<!--    </div>-->
<?php //endif;?>


<?php if(isset($_GET['file_format']) && $_GET['file_format']=='no'):?>
    <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
        <p class="text-sm text-red-800  dark:bg-gray-800 dark:text-red-400 "><?= $_GET['message']?></p>
    </div>
<?php endif;?>

<!-- file upload error -->

<?php if(isset($_GET['file_upload']) && $_GET['file_upload']=='no'):?>
    <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
        <p class="text-sm text-red-800  dark:bg-gray-800 dark:text-red-400 "><?= $_GET['message']?></p>
    </div>
<?php endif;?>


<!-- success file upload-->
<?php if(isset($_GET['file_upload']) && $_GET['file_upload']=='ok'):?>
    <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
        <p>file uploaded</p>
        <a href="<?php echo $_GET['url_file']?>">link :<?php echo $_GET['url_file']?></a>    </div>

<?php endif;?>






<!-- action alert in lists uploaded files-->

<?php if(isset($_GET['delete_item']) && $_GET['delete_item']=='ok'):?>
    <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
        <p class="text-sm text-red-800  dark:bg-gray-800 dark:text-red-400 "><?= $_GET['message']?></p>
    </div>
<?php endif;?>


<!--delete: file not found -->

<?php if(isset($_GET['delete_item']) && $_GET['delete_item']=='no'):?>
    <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
        <p class="text-sm text-red-800  dark:bg-gray-800 dark:text-red-400 "><?= $_GET['message']?></p>
    </div>
<?php endif;?>
