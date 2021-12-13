<?php require_once 'pages/header.php' ?>
<div class="body"><!-- start body-->
    <?php require_once 'pages/sidebar.php' ?>

    <div class="content"> <!--- start Content --->
    <?php 
        if(isset($_GET['sendReplay'])){
            ?>
            <div class="alert alert-success">پاسخ شما با موفقیت ثبت شد</div>
            <?php
        }
    ?>
    <table>
        <thead>
            <tr>
                <th>ردیف</th>
                <th>مطلب</th>
                <th>فرستنده</th>
                <th>پیغام</th>
                <th>ایمیل</th>
                <th>تاریخ</th>
                <th>وضعیت</th>
                <th>عملیات</th>
            </tr>
        </thead>
        <tbody>
        <?php $selectComments = selectComments();
            foreach ($selectComments as $key => $value) { ?>
                <tr>
                    <td style="width: 5%;"><?= $key+1 ?></td>
                    <td><?= ShowPostTitle($value->post_id) ?></td>
                    <td><?= $value->author ?></td>
                    <td><?= $value->body ?></td>
                    <td><?= $value->email ?></td>
                    <td><?= convertDateToFarsi($value->created_at) ?></td>
                    <td>
                    <?php
                        
                        $active = activeComment($value->id);
                        $deactive = deActiveComment($value->id);
                        if($active){
                            header("location:Comments.php?activated=ok");
                        }elseif($deactive){
                            header("location:Comments.php?deactivated=ok");
                        }
                        if($value->status==1){?>
                        <a href="Comments.php?deactive=<?= $value->id ?>" class="edit">فعال</a>
                    <?php }else{ ?>
                        <a href="Comments.php?active=<?= $value->id ?>" class="delete">غیر فعال</a>
                    <?php } ?>
                    </td>
                    <td style="width: 21%;">
                        <a href="replayComment.php?comment_id=<?= $value->id ?>" class="answer">پاسخ</a>
                        <?php 
                        if(isset($_GET['deleteCommand'])){
                            deleteCommand($_GET['deleteCommand']);
                            header("location:Comments.php?deleteCommend=ok");
                        }
                        ?>
                        <a href="Comments.php?deleteCommand=<?= $value->id ?>" class="delete">حذف</a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
    </div><!--- end Content --->
    <div class="clear"></div>
</div><!-- end body-->

<?php require_once 'pages/footer.php' ?>

