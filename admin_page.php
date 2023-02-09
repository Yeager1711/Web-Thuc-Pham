<?php
@include 'config.php';
session_start();

$admin_id = $_SESSION['admin_id'];
if (!isset($admin_id)) {
    header('location: login.php');
}

if (isset($_GET['delete'])) {
    $success_msgs  = [];
    $delete_id = $_GET['delete'];
    $delete_products = $conn->prepare("DELETE  FROM `products` WHERE id = ?");
    $delete_products->execute([$delete_id]);
    array_push($success_msgs, 'Xóa thành công');
    header('location: admin_page.php');
}

// update products
if (isset($_POST['update_product'])) {
    $pid = $_POST['pid'];

    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);

    $price = $_POST['price'];
    $price = filter_var($price, FILTER_SANITIZE_STRING);

    $category = $_POST['category'];
    $category = filter_var($category, FILTER_SANITIZE_STRING);

    $status = $_POST['status'];
    $status = filter_var($status, FILTER_SANITIZE_STRING);

    $details = $_POST['details'];
    $details = filter_var($details, FILTER_SANITIZE_STRING);

    $image = $_FILES['image']['name'];
    $image = filter_var($image, FILTER_SANITIZE_STRING);
    $image_size = $_FILES['image']['size'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_folder = 'uploaded_img/' . $image;
    $old_image = $_POST['old_image'];

    $update_products = $conn->prepare("UPDATE `products` SET name = ?, category = ?, 
    details = ?, price = ?, status = ? WHERE id = ?");
    $update_products->execute([$name, $category, $details, $price, $status, $pid]);

    $success_msgs = [];
    $warning_msgs = [];

    array_push($success_msgs, 'Cập nhật thành công');

    if (!empty($image)) {
        if ($image_size > 2000000) {
            array_push($warning_msgs, 'Kích thước ảnh quá lớn !');
        } else {
            $update_image = $conn->prepare("UPDATE `products` SET image = ? WHERE id = ?");
            $update_image->execute([$image, $pid]);

            if ($update_image) {
                move_uploaded_file($image_tmp_name, $image_folder);
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
    <title>admin page</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

    <!-- css custom link -->
    <link rel="stylesheet" href="../css//root.css">
    <link rel="stylesheet" href="./css//admin_page.css">
</head>

<body>
    <?php include 'admin_header.php'; ?>

    <div class="home-wrapper">

        <section class="showProducts" id="home">
            <?php
            $count_products = $conn->prepare("SELECT * FROM `products` WHERE $admin_id = ?");
            $count_products->execute([$admin_id]);
            ?>

            <h1 class="title">Tất cả sản phẩm (<span><?= $count_products->rowCount(); ?></span>)</h1>

            <div class="wrap-container">

                <div class="box-container">
                    <?php
                    $select_products = $conn->prepare("SELECT * FROM `products` ");
                    $select_products->execute();
                    if ($select_products->rowCount() > 0) {
                        while ($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)) {
                    ?>
                            <div class="box">
                                <form action="" method="post" enctype="multipart/form-data">
                                    <div class="flex-title">
                                        <div class="image-products">
                                            <img src="uploaded_img/<?= $fetch_products['image']; ?>" alt="">
                                            <div class="btn-changeImage">
                                                <input type="file" id="file" name="image" accept="image/jpg, image/png, image/jpeg">
                                                <label for="file" class="fa-solid fa-camera"></label>
                                                <input type="hidden" name="pid" value="<?= $fetch_products['id']; ?>">
                                                <input type="hidden" name="old_image" value="<?= $fetch_products['image']; ?>">

                                            </div>
                                        </div>
                                        <div class="flex-btn">
                                            <input type="submit" class="btn" value="Sửa" title="Sửa thông tin sản phẩm" name="update_product">
                                            <a href="admin_page.php?delete=<?= $fetch_products['id'] ?>" onclick="return confirm('Xóa sản phẩm đã chọn ?')" title="Xóa sản phẩm" class="btn">Xóa </a>
                                        </div>
                                    </div>

                                    <div class="content">

                                        <div class="inputBox">
                                            <span>Tên: </span>
                                            <input type="text" name="name" value="<?= $fetch_products['name']; ?>">
                                        </div>

                                        <div class="inputBox">
                                            <span>Giá:</span>
                                            <input type="text" min="0" name="price" value="<?= $fetch_products['price']; ?>₫">
                                        </div>

                                        <div class="inputBox">
                                            <span>Loại: </span>
                                            <select name="category" class="box" required>
                                                <option selected><?= $fetch_products['category']; ?></option>
                                                <option value="Trái cây">Trái cây</option>
                                                <option value="Thịt tươi">Thịt tươi</option>
                                                <option value="Hải sản tươi">Hải sản tươi</option>
                                                <option value="Rau củ">Rau củ</option>
                                                <option value="Thực phẩm khô">Thực phẩm khô</option>
                                            </select>
                                        </div>

                                        <div class="inputBox">
                                            <span>Trạng thái: </span>
                                            <select name="status" class="box" required>
                                                <option selected><?= $fetch_products['status']; ?></option>
                                                <option value="Còn hàng">Còn hàng</option>
                                                <option value="Đang cập nhật">Đang cập nhật</option>
                                                <option value="Hết hàng">Hết hàng</option>
                                            </select>
                                        </div>

                                        <div class="inputBox">
                                            <span>Mô tả:</span>
                                            <input type="text" name="details" value="<?= $fetch_products['details']; ?>">
                                        </div>
                                    </div>
                            </div>
                            </form>

                    <?php
                        }
                    } else {
                    }
                    ?>
                </div>
            </div>
        </section>
    </div>

    <!-- sweet alert cdn link -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <!-- custom script file link -->

    <!-- include file alert.php -->
    <?php include 'alert.php'; ?>
</body>

</html>