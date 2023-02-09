<?php
    // kết nối database
    include 'config.php';

    //Bắt sự kiện submit
    if(isset($_POST['submit'])){
        session_start();
        $email = $_POST['email'];
        $email = filter_var($email, FILTER_SANITIZE_STRING);

        $pass = md5($_POST['pass']);
        $pass = filter_var($pass, FILTER_SANITIZE_STRING);

        $sql_connection = "SELECT * FROM `users` WHERE email = ? AND password = ?";
        $tmp = $conn->prepare($sql_connection);
        $tmp->execute([$email, $pass]);
        $rowCount = $tmp->rowCount();

        $row = $tmp->fetch(PDO::FETCH_ASSOC); 

        $messages = [];
        if($rowCount > 0 ){

            if($row['user_type'] == 'admin'){

                $_SESSION['admin_id'] = $row['id'];
                header('location:admin_page.php');
                
            }elseif($row['user_type'] == 'user') {
                $_SESSION['user_id'] = $row['id'];
                header('location:home.php');
                }else {
                    array_push($messages, 'Không tìm thấy user');
            }
        }else {
            array_push($messages, 'Email hoặc mật khẩu không chính xác !');
        }
    }


    
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

    <!-- css custom link -->
    <link rel="stylesheet" href="../css//login.css">
    <link rel="stylesheet" href="../css//root.css">
</head>
<body>
    


<section class="form-container">
    <div class="Login-container">
        <form action="" enctype="multipart/form-data" method="POST">
            <h3>Đăng nhập</h3>
            <?php
                if(isset($messages)) {
                    foreach($messages as $message){
                        echo '
                        <div class ="message">
                        <span>'.$message.'</span>
                        
                        </div>
                        ';
                    }
                }
            ?>
            <!-- <i class="fas fa-times" onclick="this.parentElement.remove();"></i> -->
            <div class="box-input"><input type="email" name="email" class="box" placeholder="Tài khoản đăng nhập băng email" required></div>
            <div class="box-input"><input type="password" name="pass" class="box" placeholder="Nhập mật khẩu" required></div>
            <div class="box-input btn-select"> 
                <input type="submit" value="Đăng nhập" class="btn" name="submit">
                <p><a href="register.php">Đăng ký ngay</a></p>
            </div>
        </form>
    </div>

</section>
</body>
</html>