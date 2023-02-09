<?php
@include 'config.php';
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
    <title>Trang chủ</title>
    <link rel="stylesheet" href="https://unpkg.com/swiper@7/swiper-bundle.min.css" />

    <script src="https://unpkg.com/swiper@7/swiper-bundle.min.js"></script>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

    <!-- css custom link -->
    <link rel="stylesheet" href="../css//root.css">
    <link rel="stylesheet" href="./css//home.css">
</head>

<body>
    <?php include 'header.php'; ?>

    <!-- home -->
    <div class="home">
        <div class="swiper home-slider">

            <div class="swiper-wrapper">
                <div class="swiper-slide slide" style="background: url(images/slider_1.png) no-repeat;">
                    <!-- <div class="content">
                        <span>outstanding food</span>
                        <h3>delicious cooking</h3>
                        <a href="#" class="btn">get started</a>
                    </div> -->
                </div>
            </div>
        </div>
    </div>

    <!-- Cate  -->
    <section class="cate">
        <div class="swiper cate-slider">
            <div class="swiper-wrapper">
                <div class="swiper-slide box">
                    <a href="#">
                        <img src="./images//cate_1.webp" alt="">
                        <span class="text_title"> Trứng</span>
                    </a>
                </div>

                <div class="swiper-slide box">
                    <a href="#">
                        <img src="./images//cate_2.webp" alt="">
                        <span class="text_title"> Thực phẩm khô</span>
                    </a>
                </div>

                <div class="swiper-slide box">
                    <a href="#">
                        <img src="./images//cate_3.webp" alt="">
                        <span class="text_title"> Thịt tươi sống</span>
                    </a>
                </div>

                <div class="swiper-slide box">
                    <a href="#">
                        <img src="./images//cate_4.webp" alt="">
                        <span class="text_title"> Trái cây</span>
                    </a>
                </div>

                <div class="swiper-slide box">
                    <a href="#">
                        <img src="./images//cate_5.webp" alt="">
                        <span class="text_title"> Rau củ quả</span>
                    </a>
                </div>

                <div class="swiper-slide box">
                    <a href="#">
                        <img src="./images//cate_6.jpg" alt="">
                        <span class="text_title"> Nước ép</span>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <section class="banner-home">
        <div class="flex">
            <div class="banner_1">
                <a href="shop.php">
                    <img src="./images//banner_1.webp" alt="">
                </a>
            </div>

            <div class="banner_2">
                <a href="shop.php">
                    <img src="./images//banner_2.webp" alt="">
                </a>
            </div>
        </div>
    </section>

    <!-- products[Trái cây] -->
    <section class="products-details">

        <div class="flex">
            <div class="title-links">
                <div class="image">
                    <img src="./images//bg-title-link-1.webp" alt="">

                    <div class="content">
                        <h3>Trái cây</h3>
                        <ul>
                            <li>Trái cây</li>
                            <li>Thịt tươi</li>
                            <li>Hải sản tươi</li>
                            <li>Rau củ</li>
                            <li>Thực phẩm khô</li>
                        </ul>

                        <a href="shop.php" class="btn">Mua sắm ngay bây giờ !</a>
                    </div>
                </div>
            </div>

            <div class="swiper products-slider">
                <div class="swiper-wrapper">
                    <?php
                    $select_products = $conn->prepare("SELECT * FROM `products`");
                    $select_products->execute();
                    if ($select_products->rowCount() > 0) {
                        while ($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)) {
                            if ($fetch_products['category'] == 'Trái cây') {
                    ?>
                                <div class="swiper-slide slider">
                                    <div class="image">
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
                                            <a href="popup_products.php?pid=<?= $fetch_products['id'];?>" class="btn-addCart" style="background-color : <?php 
                                            if ($fetch_products['status'] == 'Còn hàng') {
                                                echo 'orange';
                                            } else {
                                                echo 'Gray';
                                            }
                                            ?>;">Xem thông tin</a>
                                            
                                        </div>
                                    </div>
                                </div>
                    <?php
                            }
                        }
                    } else {
                        echo '<p class="empty">Chưa có sản phẩm thuộc nhóm hàng !</p>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </section>

    <!-- products[Rau củ] -->
    <section class="products-details">

        <div class="flex vegetable">

            <div class="swiper products-slider">
                <div class="swiper-wrapper">
                    <?php
                    $select_products = $conn->prepare("SELECT * FROM `products`");
                    $select_products->execute();
                    if ($select_products->rowCount() > 0) {
                        while ($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)) {
                            if ($fetch_products['category'] == 'Rau củ') {
                    ?>
                                <div class="swiper-slide slider">
                                    <div class="image">
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
                                            <a href="popup_products.php?pid=<?= $fetch_products['id'];?>" class="btn-addCart" style="background-color : <?php 
                                            if ($fetch_products['status'] == 'Còn hàng') {
                                                echo 'orange';
                                            } else {
                                                echo 'Gray';
                                            }
                                            ?>;">Xem thông tin</a>
                                            
                                        </div>
                                    </div>
                                </div>
                    <?php
                            }
                        }
                    } else {
                        echo '<p class="empty">Chưa có sản phẩm thuộc nhóm hàng !</p>';
                    }
                    ?>
                </div>
            </div>

            <div class="title-links">
                <div class="image">
                    <img src="./images//bg-title-link-1.webp" alt="">

                    <div class="content">
                        <h3>Rau củ</h3>
                        <ul>
                            <li>Rau củ</li>
                            <li>Thịt tươi</li>
                            <li>Hải sản tươi</li>
                            <li>Trái cây</li>
                            <li>Thực phẩm khô</li>
                        </ul>

                        <a href="shop.php" class="btn">Mua sắm ngay bây giờ !</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- products[Thực phẩm tươi] -->
    <section class="products-details">

        <div class="flex">
            <div class="title-links">
                <div class="image">
                    <img src="./images//bg-title-link-1.webp" alt="">

                    <div class="content">
                        <h3>Thực Phẩm tươi</h3>
                        <ul>
                            <li>Thực Phẩm tươi</li>
                            <li>Rau củ</li>
                            <li>Hải sản tươi</li>
                            <li>Trái cây</li>
                            <li>Thực phẩm khô</li>
                        </ul>

                        <a href="shop.php" class="btn">Mua sắm ngay bây giờ !</a>
                    </div>
                </div>
            </div>

            <div class="swiper products-slider">
                <div class="swiper-wrapper">
                    <?php
                    $select_products = $conn->prepare("SELECT * FROM `products`");
                    $select_products->execute();
                    if ($select_products->rowCount() > 0) {
                        while ($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)) {
                            if ($fetch_products['category'] == 'Thịt tươi') {
                    ?>
                                <div class="swiper-slide slider">
                                    <div class="image">
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
                                            <a href="popup_products.php?pid=<?= $fetch_products['id']; ?>" class="btn-addCart" style="background-color : <?php 
                                            if ($fetch_products['status'] == 'Còn hàng') {
                                                echo 'orange';
                                            } else {
                                                echo 'Gray';
                                            }
                                            ?>;">Xem thông tin</a>
                                            
                                        </div>
                                    </div>
                                </div>
                    <?php
                            }
                        }
                    } else {
                        echo '<p class="empty">Chưa có sản phẩm thuộc nhóm hàng !</p>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>
    <script src="./js//user//home.js" defer></script>
</body>

</html>