<?php require_once 'pages/header.php' ?>
<div class="body"><!-- start body-->
    <?php require_once 'pages/sidebar.php' ?>

    <div class="content"> <!--- start Content --->
    <?php $selectPosts = selectPosts(); if($selectPosts) {?>
    <?php if(isset($_GET['addPostOk'])) echo '<div class="alert alert-success">مطلب با موفقیت ایجاد شد</div>';?>
    <?php if(isset($_GET['delete'])){ 
        $del = selectPosts($_GET['delete']);
        $deletePost = deletePost($_GET['delete']);
        
        if($deletePost){
            $img = "../images/".$del['img'];
            unlink($img);
        }
        header("location:Post.php?deleteSuccess=ok");
        }?>
        <?php if(isset($_GET['deleteSuccess'])) echo '<div class="alert alert-success">مطلب با موفقیت حذف شد</div>';?>
    <table>
        <thead>
            <tr>
                <th>ردیف</th>
                <th>عنوان</th>
                <th>دسته بندی</th>
                <th>نویسنده</th>
                <th>تصویر</th>
                <th>تاریخ</th>
                <th>برچسب</th>
                <th>عملیات</th>
            </tr>
        </thead>
        <tbody>
        <?php $selectPosts = selectPosts();
        foreach ($selectPosts as $key => $value) {?>
            <tr>
                <td><?= $key+1 ?></td>
                <td><?= $value->title ?></td>
                <td><?= showCategoryTitle($value->category_id) ?></td>
                <td><?= $value->author ?></td>
                <td><img src="../images/<?= $value->img?>" width="150"></td>
                <td><?= convertDateToFarsi($value->created_at) ?></td>
                <td><?= $value->tag ?></td>
                <td>
                    <a href="Post.php?delete=<?= $value->id ?>" class="delete">حذف</a>
                    <a href="EditPost.php?edit=<?= $value->id ?>" class="edit">ویرایش</a>
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