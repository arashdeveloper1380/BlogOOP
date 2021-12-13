<?php 

// Insert Category
function insertCategory(){
    global $connection;
    if(isset($_POST['insertCategory'])){
        $sql = "INSERT INTO `categories` (`name`) VALUES (:name)";
        $stmt = $connection->prepare($sql);
        $stmt->bindParam('name',$_POST['name']);
        if($stmt->execute()){
            return $stmt;
        }else{
            return false;
        }
    }
}

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

// Delete Category
function deleteCategory($id){
    global $connection;
    if(isset($_GET['delete'])){
        $sql = "DELETE FROM `categories` WHERE `id`=:id";
        $stmt = $connection->prepare($sql);
        $stmt->bindParam('id',$id);
        if($stmt->execute()){
            return $stmt;
        }else{
            return false;
        }
    }
}

// Select Category For Update
function selectForCategory($id){
    global $connection;
    if(isset($_GET['edit'])){
        $sql = "SELECT * FROM `categories` WHERE id=?";
        $stmt = $connection->prepare($sql);
        $stmt->bindValue(1,$id);
        if($stmt->execute()){
            $row = $stmt->fetch(PDO::FETCH_OBJ);
            return $row;
        }else{
            return false;
        }
    }
}

// Update Category
function updateCategory($id){
    global $connection;
    if(isset($_POST['updateCategory'])){
        $sql = "UPDATE `categories` SET `name`=? WHERE id=?";
        $stmt = $connection->prepare($sql);
        $stmt->bindValue(1,$_POST['name']);
        $stmt->bindValue(2,$id);
        $stmt->execute();
        if($stmt->rowCount()){
            return $stmt;
        }else{
            return false;
        }
    }
}

// Added Post
function addPost(){
    global $connection;
    if(isset($_POST['insertPost'])){
        $post_title = $_POST['title'];
        $post_category_id = $_POST['category_id'];
        $post_author = $_POST['author'];
        $post_body = $_POST['body'];
        $post_tags = $_POST['tag'];
        $post_created_at = date('y-m-d');
        $file = $_FILES['img']['name'];
        // Upload File
        $file = $_FILES['img']['name'];
        $extension = explode('.', $file);
        $fileExt = strtolower(end($extension));
        $post_img = md5(microtime() . $file);
        $post_img .= "." . $fileExt;
        $error = $_FILES['img']['error'];
        $tmp_name = $_FILES['img']['tmp_name'];

        switch ($error) {
            case UPLOAD_ERR_OK;
                $valid = true;
                if (!in_array($fileExt, array('png', 'jpg', 'gif', 'jepg'))) {
                    $valid = false;
                    echo '<p class="alert alert-warning">پسوند فایل انتخابی باید png , jpg , gif , jpeg باشد</p>';
                }
                if ($error > 200000) {
                    $valid = false;
                    echo '<p class="alert alert-warning">عکس انتخاب شده بیش از حد بزرگ است</p>';
                }
                if ($valid) {
                    $valid = true;
                    echo '<p class="alert alert-success">عکس با موفقیت اپلودشد</p>';
                    move_uploaded_file($tmp_name, '../images/'.$post_img);
                    $sql = "INSERT INTO `posts` (`category_id`,`title`,`author`,`created_at`,`img`,`body`,`tag`) 
                    VALUES (:category_id,:title,:author,:created_at,:img,:body,:tag)";
                    $stmt = $connection->prepare($sql);
                    $stmt->bindParam(':category_id', $post_category_id);
                    $stmt->bindParam(':title', $post_title);
                    $stmt->bindParam(':author', $post_author);
                    $stmt->bindParam(':created_at', $post_created_at);
                    $stmt->bindParam(':img', $post_img);
                    $stmt->bindParam(':body', $post_body);
                    $stmt->bindParam(':tag', $post_tags);
                    $stmt->execute();
                    if ($stmt->rowCount()) {
                        return $stmt;
                    } else {
                        return false;
                    }
                }
                break;
            case UPLOAD_ERR_PARTIAL;
                echo '<p class="alert alert-warning">بخشی از عکس اپلود نشده است</p>';
                break;
            case UPLOAD_ERR_NO_TMP_DIR;
                echo '<p class="alert alert-warning">عکست کجاست؟</p>';
                break;
            default:
                echo '<p class="alert alert-error">خطا در درج</p>';
                break;
        }
    }
}

// Select Posts
function selectPosts(){
    global $connection;
    $sql = "SELECT * FROM `posts`";
    $stmt = $connection->prepare($sql);
    if($stmt->execute()){
        $row = $stmt->fetchAll(PDO::FETCH_OBJ);
        return $row;
    }else{
        return false;
    }
}

// Show Category Title Post
function showCategoryTitle($id){
    global $connection;
    $sql = "SELECT * FROM `categories` WHERE `id`=:id";
    $stmt = $connection->prepare($sql);
    $stmt->bindParam(':id',$id);
    if($stmt->execute()){
        $row = $stmt->fetchAll(PDO::FETCH_OBJ);
        foreach ($row as $value) {
            return $value->name;
        }
    }else{
        return false;
    }
}

// Convert Date To Farsi
function convertDateToFarsi($value)
{
    $date = explode('-', $value);
    return gregorian_to_jalali($date[0], $date[1], $date[2], '/');
}

// Delete Posts
function deletePost($id){
    global $connection;
    if(isset($_GET['delete'])){
        $sql = "DELETE FROM `posts` WHERE `id`=:id";
        $stmt = $connection->prepare($sql);
        $stmt->bindParam(':id',$id);
        if($stmt->execute()){
            return $stmt;
        }else{
            return false;
        }
    }
}

// Select Post For Fetch
function SelecteditPost($id){
    global $connection;
    if(isset($_GET['edit'])){
        $sql = "SELECT * FROM `posts` WHERE `id`=:id";
        $stmt = $connection->prepare($sql);
        $stmt->bindParam(':id',$id);
        if($stmt->execute()){
            $row = $stmt->fetch(PDO::FETCH_OBJ);
            return $row;
        }else{
            return false;
        }
    }
}

// Update Post
function updatePost($id)
{
    global $connection;
    if (isset($_POST['updatePost'])) {
        $post_title = $_POST['title'];
        $post_category_id = $_POST['category_id'];
        $post_author = $_POST['author'];
        $post_body = $_POST['body'];
        $post_tags = $_POST['tag'];
        $post_created_at = date('y-m-d');
        $file = $_FILES['img']['name'];
//        var_dump($file);
        $extension = explode('.', $file); // lara.jpg lara.5.7.jpg
//        var_dump($extension);
        $fileExt = strtolower(end($extension));
//        var_dump($fileExt);
        $post_img = md5(microtime() . $file);
//        var_dump($post_img);
        $post_img .= "." . $fileExt;
//        var_dump($post_img);
        $error = $_FILES['img']['error'];
        $tmp_name = $_FILES['img']['tmp_name'];

        echo "<p class='alert alert-info'> پسوند فایل انتخابی شما : $fileExt </p>";

        switch ($error) {
            case UPLOAD_ERR_OK;
                $valid = true;
                if (!in_array($fileExt, array('png', 'jpg', 'gif', 'jepg'))) {
                    $valid = false;
                    echo '<p class="alert alert-warning">پسوند فایل انتخابی باید png , jpg , gif , jpeg باشد</p>';
                }
                if ($error > 200000) {
                    $valid = false;
                    echo '<p class="alert alert-warning">عکس انتخاب شده بیش از حد بزرگ است</p>';
                }
                if ($valid) {
                    $valid = true;
                    echo '<p class="alert alert-success">عکس با موفقیت اپلودشد</p>';
                    move_uploaded_file($tmp_name, '../images/' . $post_img);
                    $sql = "UPDATE `posts` SET `category_id`=:post_category_id,`title`=:post_title,`author`=:post_author,`created_at`=:post_created_at,`img`=:post_img,`body`=:post_body,`tag`=:post_tags where `id`=:id";
                    $stmt = $connection->prepare($sql);
                    $stmt->bindParam(':post_category_id', $post_category_id);
                    $stmt->bindParam(':post_title', $post_title);
                    $stmt->bindParam(':post_author', $post_author);
                    $stmt->bindParam(':post_created_at', $post_created_at);
                    $stmt->bindParam(':post_img', $post_img);
                    $stmt->bindParam(':post_body', $post_body);
                    $stmt->bindParam(':post_tags', $post_tags);
                    $stmt->bindParam(':id', $id);
                    $stmt->execute();
                    if ($stmt->rowCount()) {
                        return $stmt;
                    } else {
                        return false;
                    }
                }
                break;
            case UPLOAD_ERR_PARTIAL;
                echo '<p class="alert alert-warning">بخشی از عکس اپلود نشده است</p>';
                break;
            case UPLOAD_ERR_NO_TMP_DIR;
                echo '<p class="alert alert-warning">عکست کجاست؟</p>';
                break;
            default:
                echo '<p class="alert alert-error">خطا در درج</p>';
                break;
        }

    }

}

// Select All Comments
function selectComments(){
    global $connection;
    $sql = "SELECT * FROM `comments`";
    $stmt = $connection->prepare($sql);
    if($stmt->execute()){
        $row = $stmt->fetchAll(PDO::FETCH_OBJ);
        return $row;
    }else{
        return false;
    }
}

// Show Post Title For Comment
function ShowPostTitle($id){
    global $connection;
    $sql = "SELECT * FROM `posts` WHERE `id` = :id";
    $stmt = $connection->prepare($sql);
    $stmt->bindParam(':id', $id);
    if($stmt->execute()){
        $row = $stmt->fetchAll(PDO::FETCH_OBJ);
        foreach ($row as $value) {
            return $value->title;
        }
    }else{
        return false;
    }
}

// Active Status Comment
function activeComment($id){
    global $connection;
    if(isset($_GET['active'])){
        $sql = "UPDATE `comments` SET `status` = ? WHERE `id` = ?";
        $stmt = $connection->prepare($sql);
        $stmt->bindValue(1,1);
        $stmt->bindValue(2,$id);
        if($stmt->execute()){
            return $stmt;
        }else{
            return false;
        }
    }
}

// DeActive Status Comment
function deActiveComment($id){
    global $connection;
    if(isset($_GET['deactive'])){
        $sql = "UPDATE `comments` SET `status` = ? WHERE `id` = ?";
        $stmt = $connection->prepare($sql);
        $stmt->bindValue(1,0);
        $stmt->bindValue(2,$id);
        if($stmt->execute()){
            return $stmt;
        }else{
            return false;
        }
    }
}

// Select Comment For Send Answer
function selectCommand($comment_id){
    global $connection;
    if(isset($_GET['comment_id'])){
        $sql = "SELECT * FROM `comments` WHERE id = ?";
        $stmt = $connection->prepare($sql);
        $stmt->bindValue(1,$comment_id);
        if($stmt->execute()){
            return $stmt->fetch(PDO::FETCH_OBJ);
        }else{
            return false;
        }
    }
}

// Select Comment For Send Answer
function sendReplyComment($comment_post_id, $id){
    global $connection;
    if(isset($_POST['sendReplyComment'])){
        $sql = "INSERT INTO `comments` (`post_id`,`author`,`body`,`status`,`email`,`created_at`,`replay_id`) VALUES (?,?,?,?,?,?,?)";
        $stmt = $connection->prepare($sql);
        $stmt->bindValue(1, $comment_post_id);
        $stmt->bindValue(2, 'مدیر سایت');
        $stmt->bindValue(3, $_POST['comment_admin_body']);
        $stmt->bindValue(4, 1);
        $stmt->bindValue(5, 'arash@gmail.com');
        $stmt->bindValue(6, date('y-m-d'));
        $stmt->bindValue(7, $id);
        $stmt->execute();
        if($stmt->rowCount()){
            return $stmt;
        }else{
            return false;
        }
    }
}

// Delete Command
function deleteCommand($id){
    global $connection;
    if(isset($_GET['deleteCommand'])){
        $sql = "DELETE FROM `comments` WHERE id=?";
        $stmt = $connection->prepare($sql);
        $stmt->bindParam(1,$id);
        if($stmt->execute()){
            return $stmt;
        }else{
            return false;
        }
    }
}

?>