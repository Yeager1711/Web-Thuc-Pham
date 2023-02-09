<?php
@include 'config.php';

if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    $delete_cart_item = $conn->prepare("DELETE FROM `cart` WHERE id = ?");
    $delete_cart_item->execute([$delete_id]);
    header('location: home.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giỏ hàng</title>
    <link rel="stylesheet" href="https://unpkg.com/swiper@7/swiper-bundle.min.css" />

    <script src="https://unpkg.com/swiper@7/swiper-bundle.min.js"></script>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

    <!-- css custom link -->
    <link rel="stylesheet" href="../css//root.css">
    <link rel="stylesheet" href="./css//cart.css">
</head>

<body>
    <div class="wrapper-cart">
        <div class="banner">
            <div class="title_cart">Giỏ hàng của bạn</div>
            <div class="content-links_cart">
                <a href="home.php">Trang chủ</a>
                <a href="products.php">Tất cả sản phẩm</a>
                <a href="#">Giỏ hàng</a>
            </div>
        </div>

        <div class="cart-container">
            <?php
            $grand_total = 0;
            $select_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
            $select_cart->execute([$user_id]);
            if ($select_cart->rowCount() > 0) {
                while ($fetch_cart_user = $select_cart->fetch(PDO::FETCH_ASSOC)) {
            ?>
                    <div class="box">
                        <div class="image-cart">
                            <!-- <span>Hình ảnh</span> -->
                            <img src="uploaded_img/<?= $fetch_cart_user['image']; ?>" alt="">
                        </div>

                        <div class="wrap-infoCart">
                            <h3 class="name-product"><?= $fetch_cart_user['name']; ?></h3>

                            <div class="info-cartUser">
                                <div class="option-total">
                                    <div class="total">
                                        <span>Số lượng: KG</span>
                                        
                                    
                                        <div class="option-show">
                                            <input type="number" min="1" max="99" value="<?= $fetch_cart_user['quantity']; ?>">
                                        <?php
                                            if($fetch_cart_user['quantity'] != $fetch_cart_user['quantity']) {
                                                echo '<a href = "" class="btn">Lưu số lượng</a>';
                                            }
                                        ?>
                                    </div>
                                    </div>

                                    
                                </div>

                                <div class="price-btnDelete">
                                    <span class="price-vlu">
                                        <?= number_format($sub_total = ($fetch_cart_user['price'] * $fetch_cart_user['quantity'])); ?>₫
                                    </span>

                                    <div class="change-delete">
                                        <a href="cart.php?delete=<?= $fetch_cart_user['id']; ?>" onclick="return comfirm('Xóa sản phẩm ?')" title="Bỏ sản phẩm">Bỏ sản phẩm</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            <?php
                    $grand_total += $sub_total;
                }
            }
            ?>
        </div>

        <div class="total-cart">
            <span>Tổng tiền:</span>
            <span><?= number_format($grand_total); ?>₫</span>
        </div>

        <div class="btn">Thanh toán</div>
    </div>
</body>

</html>