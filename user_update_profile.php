<?php
@include 'config.php';

session_start();
$user_id = $_SESSION['user_id'];
if (!isset($user_id)) {
    header('location: login.php');
}

if (isset($_POST['update_profile'])) {
    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);

    $update_profile = $conn->prepare("UPDATE `users` SET name = ? WHERE id = ?");
    $update_profile->execute([$name, $user_id]);

    $image = $_FILES['image']['name'];
    $image = filter_var($image, FILTER_SANITIZE_STRING);
    $image_size = $_FILES['image']['size'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_folder = 'uploaded_img/' . $image;
    $old_image = $_POST['old_image'];
    
    // array message alert
    $success_msgs = [];
    $error_msgs = [];
    $warning_msgs = [];

    if(!empty($image)) {
        if($image_size > 20000000) {
          array_push( $warning_msgs, 'Kích thước ảnh quá lớn');
        }else{
            $update_img = $conn->prepare("UPDATE `users` SET image = ? WHERE id = ?");
            $update_img->execute([$image, $user_id]);
            if ($update_img) {
                move_uploaded_file($image_tmp_name, $image_folder);
                unlink('uploaded_img/'. $old_image);
            };
        };
    };

    $old_pass = $_POST['old_pass'];
    $update_pass = md5($_POST['update_pass']);
    $update_pass = filter_var($update_pass, FILTER_SANITIZE_STRING);
    $new_pass = md5($_POST['new_pass']);
    $new_pass = filter_var($new_pass, FILTER_SANITIZE_STRING);
    $confirm_pass = md5($_POST['confirm_pass']);
    $confirm_pass = filter_var($confirm_pass, FILTER_SANITIZE_STRING);

    if (!empty($update_pass) AND !empty($new_pass) AND !empty($confirm_pass)) {
        if($update_pass != $old_pass) {
           array_push( $warning_msgs, 'Mật khẩu cũ không khớp !');
        }elseif($new_pass != $confirm_pass) {

           array_push( $warning_msgs, 'Xác nhận mật khẩu không trùng nhau !');
        } else {
            $update_pass_querry = $conn->prepare("UPDATE `users` SET password = ? 
                    WHERE id = ?");
            $update_pass_querry->execute([$confirm_pass, $user_id]);
           array_push( $success_msgs, 'Thay đổi thành công ');
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>update user profile</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

    <!-- css custom link -->
    <link rel="stylesheet" href="./css//update_profile.css">
    <link rel="stylesheet" href="./css//header.css">
    <link rel="stylesheet" href="../css//root.css">
</head>

<body>

    <?php include 'header.php'; ?>

    <section class="update-profile">

        <h1 class="title">Cập nhật thông tin</h1>

        <form action="" method="POST" enctype="multipart/form-data">

            <div class="image-avt">
                <img src="uploaded_img/<?= $fetch_profile['image']; ?>" alt="">
                <div class="btn-changeImage">
                    <input type="file" id="file" name="image" accept="image/jpg, image/png, image/jpeg">
                    <label for="file" class="fa-solid fa-camera"></label>
                    <input type="hidden" name="old_image" value="<?= $fetch_profile['image']; ?>" >
                </div>
            </div>

            <div class="flex">
                <div class="inputBox">
                    <span>Tên: </span>
                    <input type="text" name="name" value="<?= $fetch_profile['name']; ?>" placeholder="username" required class="box">

                    <span>Email: </span>
                    <span class="email-noChange"><?= $fetch_profile['email']; ?> </span>
                </div>

                <div class="inputBox">
                    <input type="hidden" name="old_pass" value="<?= $fetch_profile['password']; ?>">

                    <span>Mật khẩu cũ: </span>
                    <input type="password" name="update_pass" placeholder="Nhập mật khẩu trước đó" required class="box">

                    <span>Mật khẩu mới: </span>
                    <input type="password" name="new_pass" placeholder="Nhập mật khẩu mới" required class="box">

                    <span>Xác nhận mật khẩu: </span>
                    <input type="password" name="confirm_pass" placeholder="Xác nhận mật khẩu" required class="box">
                </div>
            </div>

            <div class="flex-btn">
                <input type="submit" class="btn" value="Cập nhật thông tin" name="update_profile">
                <a href="home.php" class="option-btn">Trở lại</a>
            </div>
        </form>
    </section>


    <!-- sweet alert cdn link -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <!-- custom script file link -->

    <!-- include file alert.php -->
    <?php include 'alert.php';?>
</body>

</html>