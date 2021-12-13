<?php require_once 'pages/header.php' ?>
<div class="body"><!-- start body-->
    <?php require_once 'pages/sidebar.php' ?>
    <?php 
        $row = selectPosts($_GET['edit']);   
        if(isset($_POST['updatePost'])){
            $updatePost = updatePost($_POST['postid']);
            if ($updatePost) {
                $post_img = "../images/" . $row->img;
                unlink($post_img);
                $message = '<p class="alert alert-success">ویرایش با موفقیت انجام شد</p>';
                header("refresh:1, url = Posts.php");
                return $updatePost;
            } else {
                $message = '<p class="alert alert-error">ویرایش با خطا مواجه شد</p>';
            }
        }
    ?>
    <?php $SelecteditPost = SelecteditPost($_GET['edit']);?>
    <div class="content"> <!--- start Content --->
        <form action="" method="POST" enctype="multipart/form-data">
            <input type="text" value="<?= $SelecteditPost->title; ?>" name="title" class="textbox" placeholder="عنوان مطلب را وارد کنید">
            <select name="category_id" class="textbox" id="">
                <?php $selectCategory = selectCategory();
                foreach ($selectCategory as $row) {
                    if($row->id == $SelecteditPost->category_id){
				?>
				<option value="<?= $row->id ?>"><?= $row->name ?></option>
				<?php } } ?>
            </select>
            <input type="text" value="<?= $SelecteditPost->author; ?>" name="author" class="textbox" placeholder="نویسنده مطلب را وارد کنید">
            <input type="file" name="img" class="textbox">
            <?php 
                if(!empty($SelecteditPost->img)){
                ?>
                    <img src="../images/<?= $SelecteditPost->img ?>" width="150">
                <?php } ?>
            <textarea name="body" cols="98" rows="12" style="border: 1px solid #000;">
            <?= $SelecteditPost->body ?>
            </textarea>
            <input type="text" name="tag" value="<?= $SelecteditPost->tag; ?>" class="textbox" placeholder="تگ مطلب را وارد کنید"><br>
            <input type="hidden" value="<?= $SelecteditPost->id; ?>" name="postid" class="textbox">
            <input type="submit" class="btn btn-success" name="updatePost" value="ویرایش مطلب">
            <input type="reset" class="btn btn-error" name="" value="انصراف">
        </form>
    </div><!--- end Content --->
    <div class="clear"></div>
</div><!-- end body-->

<?php require_once 'pages/footer.php' ?>