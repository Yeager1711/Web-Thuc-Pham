<?php
@include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];
if (!isset($user_id)) {
    header('location: login.php');
}

if (isset($_POST['add_to_cart'])) {
    $pid = $_POST['pid'];
    $pid = filter_var($pid, FILTER_SANITIZE_STRING);

    $p_name = $_POST['p_name'];
    $p_name = filter_var($p_name, FILTER_SANITIZE_STRING);

    $p_price = $_POST['p_price'];
    $p_price = filter_var($p_price, FILTER_SANITIZE_STRING);

    $p_image = $_POST['p_image'];
    $p_image = filter_var($p_image, FILTER_SANITIZE_STRING);

    $p_qty = $_POST['p_qty'];
    $p_qty = filter_var($p_qty, FILTER_SANITIZE_STRING);

    $check_cart_numbers = $conn->prepare("SELECT *  FROM `cart` WHERE name = ? AND user_id = ?");
    $check_cart_numbers->execute([$p_name,$user_id]);

    $success_msgs = [];
    $warning_msgs = [];

    if ($check_cart_numbers->rowCount() > 0) {
        array_push($success_msgs, 'Đã được thêm vào giỏ hàng !');
    } else {
        $insert_cart = $conn->prepare("INSERT INTO `cart`
        (user_id, pid, name, price, quantity ,image) 
        VALUES (?,?,?,?,?,?)");
        $insert_cart->execute([$user_id, $pid, $p_name, $p_price, $p_qty, $p_image]);
        array_push($success_msgs, 'Thêm vào giỏ hàng thành công');
    }
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
    <link rel="stylesheet" href="./css/popup_products.css">
</head>

<body>
    <?php include 'header.php'; ?>

    <div class="banner">
        <?php
        $pid = $_GET['pid'];
        $select_products = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
        $select_products->execute([$pid]);
        while ($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)) {

        ?>
            <div class="title"><?= $fetch_products['name']; ?></div>
            <div class="content-links">
                <a href="home.php">Trang chủ</a>
                <a href="products.php">Tất cả sản phẩm</a>
                <a><?= $fetch_products['name']; ?></a>
            </div>
        <?php
        }
        ?>

    </div>

    <div class="popup-products">

        <div class="box-container">
            <a href="home.php" class="xmark"><i class="fa-solid fa-xmark"></i></a>
            <h3 class="title">Thông tin sản phẩm</h3>

            <?php
            $pid = $_GET['pid'];
            $select_products = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
            $select_products->execute([$pid]);
            if ($select_products->rowCount() > 0) {
                while ($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)) {
            ?>
                    <form action="" method="POST" enctype="multipart/form-data">
                        <div class="product-info">
                            <img src="uploaded_img/<?= $fetch_products['image']; ?>" alt="">
                            <!-- value hidden add to cart -->
                            <input type="hidden" name="p_image" value="<?= $fetch_products['image']; ?>">
                            <!-- value hidden add to cart -->

                            <div class="desc-title">
                                <div class="name"><?= $fetch_products['name']; ?></div>
                                <div class="status">
                                    Tình trạng:
                                    <span>
                                        <?= $fetch_products['status']; ?>
                                        <?php
                                        if ($fetch_products['status'] == 'Còn hàng') {
                                            echo '<i class="fa-solid fa-check"></i>';
                                        } else if ($fetch_products['status'] == 'Đang cập nhật') {
                                            echo '<i class="fa-solid fa-pen"></i>';
                                        } else {
                                            echo '<i class="fa-solid fa-xmark"></i>';
                                        }


                                        ?>
                                    </span>
                                </div>

                                <div class="category">Loại hàng: <span> <?= $fetch_products['category']; ?></span></div>

                                <div class="details">Mô tả: <span><?= $fetch_products['details']; ?></span></div>

                                <div class="total">
                                    <div class="old-price"><?= number_format($fetch_products['price']); ?>₫</div>
                                    <!-- value hidden add to cart -->
                                    <input type="hidden" name="p_price" value="<?= $fetch_products['price']; ?>">
                                    <!--  -->

                                    <div class="Qty_total">
                                        <input type="number" min="1" value="1" name="p_qty" class="qty"> <span>KG</span>
                                    </div>

                                    <div class="add-to-cart">
                                        <input type="submit" value="Thêm vào giỏ hàng" class="btn" name="add_to_cart">
                                        <input type="submit" value="Thêm vào yêu thích" class="btn" name="add_to_wishlist">
                                        
                                    </div>
                                </div>
                            </div>

                            <!-- value hidden add to cart -->
                            <input type="hidden" name="pid" value="<?= $fetch_products['id']; ?>">
                            <input type="hidden" name="p_name" value="<?= $fetch_products['name']; ?>">
                            <!--  -->
                        </div>




                    </form>
            <?php
                }
            } else {
                echo '<p class="empty"> Không có sản phẩm nào !</p>';
            }
            ?>
        </div>
    </div>



    <!-- sweet alert cdn link -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <!-- custom script file link -->

    <!-- include file alert.php -->
    <?php include 'alert.php'; ?>

</body>

</html>