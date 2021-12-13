<?php require_once 'pages/header.php' ?>
<div class="body"><!-- start body-->
    <?php require_once 'pages/sidebar.php' ?>

    <div class="content"> <!--- start Content --->
    <?php 
        addPost();
        if(addPost()){
            header("location:Post.php?addPostOk=ok"); 
        }
    ?>
        <form action="" method="POST" enctype="multipart/form-data">
            <input type="text" name="title" class="textbox" placeholder="عنوان مطلب را وارد کنید">
            <select name="category_id" class="textbox" id="">
                <?php $selectCategory = selectCategory();
                foreach ($selectCategory as $key => $value) {?>
                    <option value="<?= $value->id ?>"><?= $value->name ?></option>
                <?php } ?>
            </select>
            <input type="text" name="author" class="textbox" placeholder="نویسنده مطلب را وارد کنید">
            <input type="file" name="img" class="textbox">
            <textarea name="body" id="" cols="98" rows="12" style="border: 1px solid #000;"></textarea>
            <input type="text" name="tag" class="textbox" placeholder="تگ مطلب را وارد کنید"><br>
            <input type="submit" class="btn btn-success" name="insertPost" value="ثبت مطلب">
            <input type="reset" class="btn btn-error" name="" value="انصراف">
        </form>
    </div><!--- end Content --->
    <div class="clear"></div>
</div><!-- end body-->



