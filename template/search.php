<?php require_once "includes/header.php" ?>
    <div class="contanier"><!-- start contanier-->
        <ul class="menu">
            <?php 
                $selectCategory = selectCategory(); 
                foreach ($selectCategory as $value) {
                ?>
                    <li><a href="postCategory.php?id=<?= $value->id ?>"><?= $value->name ?></a></li>
                <?php } ?>

            
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
    if(isset($_POST['search']) && !empty($_POST['search'])){
        $search = searchPost($_POST['search']);
    }
     
    foreach ($search as $value) {?>
        <div class="post"><!-- start post-->
                <div class="postHeader"><!-- start postHeader-->
                    <h1 class="postTitle"><a href="single.php?id=<?= $value->id ?>"><?= $value->title ?></a></h1>
                    <span> تاریخ انتشار : <?= convertDateToFarsi($value->created_at) ?> </span>
                    <div class="clear"></div>
                </div><!-- end postHeader-->
                <div class="postBody"><!-- start postBody-->
                    <div class="postPic"><!-- start postPic-->
                        <img src="../images/<?= $value->img ?>">
                    </div><!-- end postPic-->
                    <div class="postDesc"><!-- start postHeader-->
                    <?= $value->body ?>
                    </div><!-- end postDesc-->
                    <div class="clear"></div>
                </div><!-- end postBody-->
                <div class="postFooter"><!-- start postFooter-->
                    <span>نویسنده مطلب : <?= $value->author ?></span>
                    <a class="ReadMore" href="single.php?id=<?= $value->id ?>">ادامه مطلب</a>
                    <div class="clear"></div>
                </div><!-- end postHeader-->

                <div class="clear"></div>
            </div><!-- end post-->
        <?php } ?>
        <div class="clear"></div>
    </div><!-- end body-->
    <div class="clear"></div>
    <style>
            .pagination{
                width: 100%;
                padding: 20px 10px;
                background-color: #fff;
                box-shadow: 0 0 3px #ccc;
                margin-bottom: 10px;
            }
            .paginate{
                width: 32px;
                height: 32px;
                line-height: 34px;
                background: #fff;
                border: 1px solid #21a1ff;
                text-align: center;
                color: #000;

                border-radius: 100%;
                margin-left: 1px;
                display: inline-block;
            }
            .paginate.active{
                background: #21a1ff;
                color: #fff;
            }
        </style>
        <div class="pagination">   
            <?php 
                for($i = 1;$i<=$count;$i++){?>
                    <a href="index.php?page=<?= $i; ?>" class="paginate active"><?= $i ?></a>
            <?php } ?>     
        </div>
</div><!-- end body-->
<?php require_once "includes/footer.php" ?>