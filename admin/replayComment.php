<?php require_once 'pages/header.php' ?>
<div class="body"><!-- start body-->
    <?php require_once 'pages/sidebar.php' ?>
    <div class="content"> <!--- start Content --->
    <?php $selectCommand = selectCommand($_GET['comment_id']); $sendReplyComment = sendReplyComment($selectCommand->replay_id, $selectCommand->id) ?>
    <?php 
        if($sendReplyComment){
            header("location:Comments.php?sendReplay=ok");
        }
    ?>
        <form action="" method="post">
            <input type="hidden" value="<?= $selectCommand->id ?>" class="textbox" name="id">
            <input disabled value="<?= $selectCommand->author ?>" type="text" class="textbox">
            <input disabled value="<?= ShowPostTitle($selectCommand->post_id) ?>" type="text"class="textbox">
            <input disabled type="text" value="<?= $selectCommand->email ?>" class="textbox">
            <textarea disabled class="textbox"style="height: 150px;padding: 12px;"><?= $selectCommand->body ?></textarea>
            <textarea name="comment_admin_body" class="textbox" style="height: 170px;padding: 12px;"></textarea>
            <br>
            <input type="submit" class="btn btn-success" name="sendReplyComment" value="ارسال پاسخ">
            <input type="reset" class="btn btn-error" value="انصراف">
        </form>
    </div><!--- end Content --->
    <div class="clear"></div>
</div><!-- end body-->
<?php require_once 'pages/footer.php' ?>
