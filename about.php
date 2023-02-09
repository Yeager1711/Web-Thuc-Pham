<?php
include 'config.php';
session_start();
$user_id = $_SESSION['user_id'];
if (!isset($user_id)) {
    header('location: login.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông tin sản phẩm</title>
    <link rel="stylesheet" href="https://unpkg.com/swiper@7/swiper-bundle.min.css" />

    <script src="https://unpkg.com/swiper@7/swiper-bundle.min.js"></script>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

    <!-- css custom link -->
    <link rel="stylesheet" href="../css//root.css">
    <link rel="stylesheet" href="./css/about.css">
</head>

<body>
    <?php include 'header.php'; ?>

    <div class="banner">
        <div class="title">Giới thiệu</div>
        <div class="content-links">
            <a href="home.php">Trang chủ</a>
            <a href="products.php" style="display: none">Tất cả sản phẩm</a>
            <a> Giới thiệu</a>
        </div>
    </div>

    <section class="about-detail">
        <h3>Giới thiệu</h3>

        <div class="content-container">
            <span>Fresh Mart <p>là hệ thống cửa hàng thực phẩm sạch uy tín, chuyên cung cấp thưc phẩm sạch tới từng bếp ăn gia đình bạn.</p></span>
            <div class="flex-text">
                <span>Mục tiêu: </span>
                <p>Sản phẩm được giao đến tay khách hàng luôn cam kết đúng chất lượng, luôn được bảo quản trong môi trường lý tưởng, đảm bảo vệ sinh an toàn thực phẩm.</p>
            </div>
        </div>
    </section>



    <!-- sweet alert cdn link -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <!-- custom script file link -->

    <!-- include file alert.php -->
    <?php include 'alert.php'; ?>

</body>

</html>