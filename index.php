<?php

if (isset($_GET['slug'])){
    $slug=$_GET['slug'];

    include './panel/config/loader.php';

    $query="SELECT * FROM files WHERE indirect_slug=?";
    $stmt=$conn->prepare($query);
    $stmt->bindValue(1,$slug ,PDO::PARAM_INT);
    $stmt->execute();
    $data=$stmt->fetch(PDO::FETCH_ASSOC);

    ?>


    <div style="
    display: flex;
    padding: 10px;
    flex-direction: column;
    align-items: center;


">
        <img style="margin-top: 10px" src="https://biz-cdn.varzesh3.com/banners/2024/12/11/D/oe0a1iur.gif" alt="">
        <img style="margin-top: 10px"  src="https://biz-cdn.varzesh3.com/banners/2024/12/10/C/trwotx42.gif" alt="">

        <a download style="text-decoration: none;color: white;background: #006fff;padding: 17px;border-radius: 12px;margin-top: 23px;" href="<?php echo $data['file_link']?>">
            DOWNLOAD
        </a>


    </div>



<?php


}else{
    header("location: ./panel/index.php");
}



?>
