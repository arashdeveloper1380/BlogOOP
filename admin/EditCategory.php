<?php require_once 'pages/header.php' ?>
<div class="body"><!-- start body-->
    <?php require_once 'pages/sidebar.php' ?>

    <div class="content"> <!--- start Content --->
    <?php $value = selectForCategory($_GET['edit']) ?>
    <?php  
        if(isset($_POST['updateCategory'])){
            updateCategory($_POST['id']);
            header("location:Categories.php?updated=true");
        }
    ?>
    <form action="" method="post">
        <input type="text" value="<?= $value->name ?>" name="name" class="textbox">
        <input type="hidden" value="<?= $value->id ?>" name="id" class="textbox">
        <br>
        <input type="submit" value="ویرایش دسته" name="updateCategory" class="btn btn-warning">
        <input type="reset" value="انصراف" class="btn btn-error">
    </form>
    </div><!--- end Content --->
    <div class="clear"></div>
</div><!-- end body-->

<?php require_once 'pages/footer.php' ?>

