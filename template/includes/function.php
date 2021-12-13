<?php 

// Select Category
function selectCategory(){
    global $connection;
    $sql = "SELECT * FROM `categories`";
    $stmt = $connection->prepare($sql);
    $stmt->execute();
    if($stmt->rowCount()){
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }else{
        return false;
    }
}

// Select Posts
function selectPosts(){
    global $connection;
    global $count;
    if(!isset($_GET['page'])){
        $offset = 0;
    }else{
        $offset = ($_GET['page']-1) * 4;
    }

    $sql = "select * from `posts`";
    $stmt = $connection->prepare($sql);
    $stmt->execute();
    $count = $stmt->rowCount() / 4;

    $sql = "SELECT * FROM `posts` LIMIT {$offset},4";
    $stmt = $connection->prepare($sql);
    if($stmt->execute()){
        $row = $stmt->fetchAll(PDO::FETCH_OBJ);
        return $row;
    }else{
        return false;
    }
}

// Convert Date To Farsi
function convertDateToFarsi($value){
    $date = explode('-', $value);
    return gregorian_to_jalali($date[0], $date[1], $date[2], '/');
}

// Search Post
function searchPost($value){
    if(isset($_POST['btnSearch'])){
        global $connection;
        $sql = "SELECT * FROM `posts` WHERE `tag` LIKE ?";
        $stmt = $connection->prepare($sql);
        $stmt->bindValue(1,"%$value%");
        if($stmt->execute()){
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }
    }
}

// Show Single Post
function singlePost($id){
    if(isset($id)){
        global $connection;
        $sql = "SELECT * FROM `posts` WHERE `id`=?";
        $stmt = $connection->prepare($sql);
        $stmt->bindValue(1,$id);
        if($stmt->execute()){
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }
    }
}

// Show Shot Description
function readMore($value)
{
    return mb_substr($value, 0, 100, 'utf-8') . ' ... ';
}

// Show Category Posts
function categoryPosts($id){
    if(isset($id)){
        global $connection;
        $sql = "SELECT * FROM `posts` WHERE `category_id`=?";
        $stmt = $connection->prepare($sql);
        $stmt->bindValue(1,$id);
        if($stmt->execute()){
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }else{
            return false;
        }
    }
}

// Send Comments
function sendComment(){
    if(isset($_POST['sendComment'])){
        global $connection;
        $created_at = date('y-m-d');
        $sql = "INSERT INTO `comments` (`post_id`,`author`,`body`,`email`,`created_at`) VALUES (?,?,?,?,?)";
        $stmt = $connection->prepare($sql);
        $stmt->bindValue(1,$_GET['id']);
        $stmt->bindValue(2,$_POST['author']);
        $stmt->bindValue(3,$_POST['body']);
        $stmt->bindValue(4,$_POST['email']);
        $stmt->bindValue(5,$created_at);
        if($stmt->execute()){
            return $stmt;
        }else{
            return false;
        }
    }
}

// Select Command For Show Users
function showQuestion($id)
{
    global $connection;
    $sql = "select * from `comments` where `status`=?  and `post_id`=? and `replay_id`=?";
    $stmt = $connection->prepare($sql);
    $stmt->bindValue(1, 1);
    $stmt->bindValue(2, $id);
    $stmt->bindValue(3, 0);
    $stmt->execute();
    if ($stmt->rowCount()) {
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } else {
        return false;
    }
}

// Select show Comment Reply
function showCommentReply($id)
{
    global $connection;
    $sql = "select * from `comments` where `replay_id`=?";
    $stmt = $connection->prepare($sql);
    $stmt->bindValue(1, $id);
    $stmt->execute();
    if ($stmt->rowCount()) {
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } else {
        return false;
    }
}

function LoginCheck()
{
    global $con;
    if (isset($_POST['Login'])) {
        $sql = "select * from `admins` where `username`=? and `password`=?";
        $stmt = $con->prepare($sql);
        $stmt->bindValue(1, $_POST['admin_username']);
        $stmt->bindValue(2, md5($_POST['admin_password']));
        $stmt->execute();
        if ($stmt->rowCount()) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $_SESSION['AdminId'] = [
                'id' => $row['admin_id'],
                'username' => $row['admin_username']
            ];
            header('location:admin/');
        } else {
            header('location:Login.php?Login=error');
        }
    }
}
?>