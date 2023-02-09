<?php
// kết nối database
include 'config.php';

//Bắt sự kiện submit
if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);

    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_STRING);

    $pass = $_POST['pass'];
    $pass = filter_var($pass, FILTER_SANITIZE_STRING);

    $cpass = $_POST['cpass'];
    $cpass = filter_var($cpass, FILTER_SANITIZE_STRING);

    $image = $_FILES['image']['name'];
    $image_size = $_FILES['image']['size'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_folder = 'uploaded_img/' . $image;

    $select = $conn->prepare("SELECT * FROM `users` WHERE email = ?");
    $select->execute([$email]);

    if ($select->rowCount() > 0) {
        $message[] = 'Email đăng kí đã được sử dụng !';
    } else if (strlen(trim($pass)) <= 5) {
        $message[] = 'Mật khẩu không quá 5 kí tự';
    } else {
        $pass = md5($_POST['pass']);
        $pass = filter_var($pass, FILTER_SANITIZE_STRING);

        $cpass = md5($_POST['cpass']);
        $cpass = filter_var($cpass, FILTER_SANITIZE_STRING);
        if ($pass != $cpass) {
            $message[] = 'Thông tin xác nhận mật khẩu không khớp !';
        } else {
            $insert = $conn->prepare("INSERT INTO 
                `users`(name, email, password, image) VALUE(?,?,?,?)");
            $insert->execute([$name, $email, $pass, $image]);

            if ($insert) {
                if ($image_size > 2000000) {
                    $message[] = 'Kích thước ảnh quá lớn !';
                } else {
                    move_uploaded_file($image_tmp_name, $image_folder);
                    $message[] = 'Tạo tài khoản thành công  với';
                    $message[] = $email;
                }
            }
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
    <title>Register</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

    <!-- css custom link -->
    <link rel="stylesheet" href="../css//register.css">
    <link rel="stylesheet" href="../css//root.css">
</head>

<body>



    <section class="form-container">
        <div class="register-container">
            <form action="" enctype="multipart/form-data" method="POST">
                <h3>Đăng kí ngay</h3>

                <?php
                if (isset($message)) {
                    foreach ($message as $message) {
                        echo '
                        <div class ="message">
                        <span>' . $message . '</span>
                        
                        </div>
                        ';
                    }
                }
                ?>
                <!-- <i class="fas fa-times" onclick="this.parentElement.remove();"></i> -->
                <div class="box-input"> <input type="text" name="name" class="box" placeholder="Nhập tài khoản" required></div>
                <div class="box-input"><input type="email" name="email" class="box" placeholder="Nhập email" required></div>
                <div class="box-input"><input type="password" name="pass" class="box box-pass" placeholder="Nhập mật khẩu (không quá 5 kí tự)" required></div>
                <div class="box-input"><input type="password" name="cpass" class="box" placeholder="Xác nhận mật khẩu" required></div>
                <div class="box-input"><input type="file" name="image" class="box" required accept="image/jpg, image/jpeg, image/png"></div>
                <div class="box-input btn-select">
                    <input type="submit" value="Đăng kí ngay" class="btn" name="submit">
                    <p><a href="login.php">Đăng nhập ngay</a></p>
                </div>
            </form>
        </div>

    </section>

</body>

</html>