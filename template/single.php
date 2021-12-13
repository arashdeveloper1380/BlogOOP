<?php require_once "includes/header.php" ?>
    <div class="contanier"><!-- start contanier-->
        <ul class="menu">
            <?php 
                $selectCategory = selectCategory(); 
                foreach ($selectCategory as $value) {
                ?>
                    <li><a href="postCategory.php?id=<?= $value->id ?>"><?= $value->name ?></a></li>
                <?php } sendComment()?>

            
                <li><a href="Login.php">ورود مدیریت</a></li>
            <li class="logo"><a href="./"><img src="images/weblogo.png"></a></li>
        </ul>
        <div class="clear"></div>
    </div><!-- end contanier-->

    <div class="HeaderPic"><!-- end HeaderPic-->
        <img src="images/bgtop.jpg">

        <form action="search.php" method="POST">
            <div class="search"><!-- end search-->
                <input type="text" name="search" class="inputSearch" placeholder="جستجو کنید ">
                <button class="searchBtn" name="btnSearch">جستجو</button>
                <div class="clear"></div>
            </div><!-- end search-->
        </form>
        <div class="clear"></div>
    </div><!-- end HeaderPic-->

    <div class="clear"></div>
</div><!-- end header-->
<div class="body"><!-- start body-->
    <div class="contanier"><!-- start contanier-->
    <?php 
    if(isset($_GET['id'])){
        $singlePost = singlePost($_GET['id']);
    }
    foreach ($singlePost as $value) {?>
        <div class="post" style="width: 70%;margin: 0 162px;"><!-- start post-->
                <div class="postHeader"><!-- start postHeader-->
                    <h1 class="postTitle"><a href=""><?= $value->title ?></a></h1>
                    <span> تاریخ انتشار : <?= convertDateToFarsi($value->created_at) ?> </span>
                    <div class="clear"></div>
                </div><!-- end postHeader-->
                <div class="postBody"><!-- start postBody-->
                    <div class="postPic" style="height: auto;"><!-- start postPic-->
                        <img width="100%" src="../images/<?= $value->img ?>">
                    </div><!-- end postPic-->
                    <div class="postDesc"><!-- start postHeader-->
                    <?= $value->body ?>
                    </div><!-- end postDesc-->
                    <div class="clear"></div>
                </div><!-- end postBody-->
                <div class="postFooter"><!-- start postFooter-->
                    <span>نویسنده مطلب : <?= $value->author ?></span>
                    <style>
                        .tags{
                            width: 80px;
                            padding: 5px 10px;
                            background: rgb-a(165,224,225,0.4);
                            text-align: center;
                            display: inline-block;
                            margin-left: 1px;
                        }
                    </style>
                    <div style="float: left;">
                        <?php 
                        $tags = explode(',',$value->tag);
                        foreach ($tags as $tag) {?>
                            <span class="tags"><?= $tag ?></span>
                        <?php } ?>
                    </div>
                    <div class="clear"></div>
                </div><!-- end postHeader-->

                <div class="clear"></div>
            </div><!-- end post-->
        <?php } ?>
        <div class="clear"></div>
        <style>
            .sendCommand{
                width: 100%;
                height: auto;
                box-shadow: 0 0 3px #ccc;
                background: #fff;
                margin-top: 10px;
                margin-bottom: 10px;
            }
            .commandHeader{
                padding: 10px 20px;
            }
            .commentBody{
                padding: 50px;
            }
            textarea{
                box-shadow: 0px 2px 7px #ccc;
                resize: none;
            }
            .asnwerComment{
                border: 1px solid #ddd;
                margin: 20px 50px;
            }
            .asnwerComment{
                padding: 20px;
            }
            .author{
                float: right;
                display: inline-block;
            }
            .date{
                float: left;
            }
            .commentQ{
                margin: 10px 10px;
                padding: 10px 0;
            }
            .divAdminReplay{
                background: #f8f8f8;
                padding: 10px;
                margin-top: 10px;
            }
            .adminReplay{
                padding: 20px;
                font-weight: bold;
            }
            .author{
                color: red;
            }
        </style>
        <div class="sendCommand">
            <div class="commandHeader">
                <h1>ارسال نظر</h1>
            </div>
            <div class="commentBody">
                <form action="" method="POST">
                    <input type="text" required="required" name="author" class="textbox" name="" placeholder="نام را وارد کنید">
                    <input type="text" required="required" name="email" class="textbox" name="" placeholder="ایمیل را وارد کنید"><br>
                    <textarea name="body" required="required" cols="108" rows="10"></textarea><br>
                    <input type="submit" name="sendComment" class="btn btn-success" value="درج نظر">
                    <input type="reset" class="btn btn-error" value="انصراف">
                </form>
            </div>
            <div class="commendFooter">
            <?php
                $showQuestion = showQuestion($_GET['id']);
                if ($showQuestion) {
                    foreach ($showQuestion as $value) {
                        ?>
                        <div class="answerCommnet">
                            <div class="info">
                                <span class="comment_author"> کاربر :  <?php echo $value['author'] ?>    گفته : </span>
                                <span class="comment_date"> تاریخ  : <?= convertDateToFarsi($value['created_at']); ?> </span>
                                <div class="clear"></div>
                            </div>
                            <div class="">
                                <p class="commentQ">
                                    <?php echo $value['body'] ?>
                                </p>
                            </div>
                            <?php

                            $showCommentReply = showCommentReply($value['id']);
                            if($showCommentReply){
                            foreach ($showCommentReply as $item) {
                                ?>
                                <div class="divAdminReply">
                                    <div class="info">
                                        <span class="comment_author" style="color: blue">مدیر سایت گفته : </span>
                                        <span class="comment_date"> تاریخ  : <?= convertDateToFarsi($item['created_at']); ?> </span>
                                        <div class="clear"></div>
                                    </div>
                                    <p class="AdminReply">
                                        <?php echo $item['body'] ?>
                                    </p>
                                </div>
                            <?php }} ?>
                        </div>
                    <?php }
                } else {
                    echo '<p class="alert alert-info">نظری برای این پست ثبت نشده است</p>';
                } ?>
            </div>
        </div>
        <div class="clear"></div>
    </div><!-- end body-->
    <div class="clear"></div>
</div><!-- end body-->
<?php require_once "includes/footer.php" ?>