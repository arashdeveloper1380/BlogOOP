<?php require_once 'pages/header.php' ?>
<div class="body"><!-- start body-->
    <?php require_once 'pages/sidebar.php' ?>

    <div class="content"> <!--- start Content --->
    <?php insertCategory(); ?>
    <form action="" method="post">
        <input type="text" name="name" class="textbox">
        <br>
        <input type="submit" value="ثبت دسته" name="insertCategory" class="btn btn-success">
        <input type="reset" value="انصراف" class="btn btn-error">
    </form>
    <?php 
        if(isset($_GET['delete'])){
            deleteCategory($_GET['delete']);
            header('Loaction:Categories.php?delete=ok');
        }
        if(isset($_GET['updated'])){
            echo '<div class="alert alert-success">دسته بندی با موفقیت ویرایش شد</div>';
        }
        $selectCategory = selectCategory();
        if($selectCategory)
        {?>
        <?php 
        if(isset($_GET['delete'])){
            echo '<div class="alert alert-success">دسته بندی با موفقیت حذف شد</div>';
        }
        ?>
    <table>
        <thead>
            <tr>
                <th>ردیف</th>
                <th>نام دسته</th>
                <th>عملیات</th>
            </tr>
        </thead>
        <tbody>
            <?php 
             foreach($selectCategory as $key=>$value)
             {
            ?>
            <tr>
                <td><?= $key+1 ?></td>
                <td><?= $value->name ?></td>
                <td>
                    <a href="Categories.php?delete=<?= $value->id ?>" class="delete">حذف</a>
                    <a href="EditCategory.php?edit=<?= $value->id ?>" class="edit">ویرایش</a>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
    <?php } ?>
    </div><!--- end Content --->
    <div class="clear"></div>
</div><!-- end body-->

<?php require_once 'pages/footer.php' ?>

