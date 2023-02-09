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
    <title>Thông tin sản phẩm</title>
    <link rel="stylesheet" href="https://unpkg.com/swiper@7/swiper-bundle.min.css" />

    <script src="https://unpkg.com/swiper@7/swiper-bundle.min.js"></script>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

    <!-- css custom link -->
    <link rel="stylesheet" href="../css//root.css">
    <link rel="stylesheet" href="./css/search-page.css">
</head>

<body>
    <?php include 'header.php'; ?>

    <div class="banner">

        <div class="title">Tìm kiếm</div>
        <div class="content-links">
            <a href="home.php">Trang chủ</a>
            <a href="products.php">Tất cả sản phẩm</a>
            <a>Tìm kiếm sản phẩm</a>
        </div>
    </div>

    <section class="search-form">
        <div class="title">Nhập từ khóa tìm kiếm sản phẩm</div>

        <form action="" method="POST">
            <input type="text" name="search_box" class="box" placeholder="Bạn cần tìm gì ?">
            <input type="submit" name="search_btn" value="Tìm kiếm" class="btn-search">
        </form>
    </section>

    <section class="search-products">
        <div class="box-container">
            <?php
            if (isset($_POST['search_btn'])) {
                $search_box = $_POST['search_box'];
                $search_box = filter_var($search_box, FILTER_SANITIZE_STRING);
                $select_products = $conn->prepare("SELECT * FROM `products` 
                WHERE name LIKE '%{$search_box}%' OR category LIKE '%{$search_box}%'");
                $select_products->execute();
                if ($select_products->rowCount() > 0) {
                    while ($fetch_searchs = $select_products->fetch(PDO::FETCH_ASSOC)) {
            ?>

                        <form action="" method="POST" class="box">
                            <a href="popup_products.php?pid=<?= $fetch_searchs['id'];?>" class="box">
                                <div class="image-boxSearch">
                                    <img src="uploaded_img/<?= $fetch_searchs['image']; ?>" alt="">
                                </div>

                                <div class="desc-product">
                                    <h2> <?= $fetch_searchs['name'] ?> </h2>

                                    <span class="price"><?= number_format($fetch_searchs['price']);?>₫</span>
                                </div>
                            </a>
                        </form>

            <?php
                    }
                }else {
                    echo '<p class="empty">no result found!</p>';
                }
            }
            ?>
        </div>
    </section>
</body>

</html>