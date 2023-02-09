<?php @include 'config.php'; 

    session_start();

    $user_id = $_SESSION['user_id'];
    if(!isset($user_id)) {
        header('lcoation: longin.php');
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giỏ hàng yêu thích</title>
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
        <div class="title">Sản phẩm yêu thích</div>
        <div class="content-links">
            <a href="home.php">Trang chủ</a>
            <a href="products.php">Tất cả sản phẩm</a>
            <a href="#">Sản phẩm yêu thích</a>
        </div>

    </div>
</body>

</html>