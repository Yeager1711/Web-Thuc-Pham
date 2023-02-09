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
    <link rel="stylesheet" href="./css/products.css">
</head>

<body>
    <?php include 'header.php'; ?>

    <div class="banner">
        <div class="title">Danh sách sản phẩm</div>
        <div class="content-links">
            <a href="home.php">Trang chủ</a>
            <a href="products.php" style="display:none"></a>
            <a> Tất cả sản phẩm</a>
        </div>
    </div>

    <section class="products-detail">
        <h3>Danh sách sản phẩm</h3>

        <div class="box-container">
            <?php
            $select_products = $conn->prepare("SELECT * FROM `products` ");
            $select_products->execute();
            while ($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)) {
            ?>
                <div class="box">
                    <div class="image-products">
                        <img src="uploaded_img/<?= $fetch_products['image']; ?>" alt="">
                    </div>

                    <div class="content">
                        <div class="wrap-info">
                            <h2> <?= $fetch_products['name'] ?> </h2>
                            <!-- - - - - - - - - - - - - - - -  -->
                            <p class="price">
                                <span class="price-new"><?= number_format($fetch_products['price'], 0, ","); ?>₫</span>
                            </p>
                        </div>

                        <!-- Lấy id sản phẩm hiển thị tương ứng ở trang "popup_products" -->
                        <div class="btn-add">
                            <a href="popup_products.php?pid=<?= $fetch_products['id']; ?>" class="btn-addCart">Xem thông tin</a>
                        </div>
                    </div>
                </div>
            <?php
            }
            ?>
        </div>

        <ul class="listPage">
            <!-- random theo số sản phẩm load từ database -->
        </ul>
    </section>



    <!-- sweet alert cdn link -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <!-- custom script file link -->
    <script src="./js//user//products.js" defer></script>
    <!-- include file alert.php -->
    <?php include 'alert.php'; ?>

</body>

</html>