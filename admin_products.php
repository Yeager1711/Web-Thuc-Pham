<?php
@include 'config.php';

session_start();
$admin_id = $_SESSION['admin_id'];
if (!isset($admin_id)) {
    header('location: login.php');
}

if (isset($_POST['add-products'])) {
    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);

    $category = $_POST['category'];
    $category = filter_var($category, FILTER_SANITIZE_STRING);

    $status = $_POST['status'];
    $status = filter_var($status, FILTER_SANITIZE_STRING);


    $details = $_POST['details'];
    $details = filter_var($details, FILTER_SANITIZE_STRING);

    $price = $_POST['price'];
    $price = filter_var($price, FILTER_SANITIZE_STRING);

    $image = $_FILES['image']['name'];
    $image = filter_var($image, FILTER_SANITIZE_STRING);
    $image_size = $_FILES['image']['size'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_folder = 'uploaded_img/' . $image;

    $select_products = $conn->prepare("SELECT * FROM `products` WHERE name = ?");
    $select_products->execute([$name]);

    $success_msgs = [];
    $warning_msgs = [];
    if ($select_products->rowCount() > 0) {
        array_push($warning_msgs, 'Tên sản phẩm đã tồn tại !');
    } else {
        $insert_products = $conn->prepare("INSERT INTO 
        `products`(name, category, details, price, status, image) VALUE(?,?,?,?,?,?)");
        $insert_products->execute([
            $name, $category, $details, $price, $status, $image
        ]);

        if ($insert_products) {
            if ($image_size > 2000000) {
                array_push($warning_msgs, 'Kích thước ảnh quá lớn !');
            } else {
                move_uploaded_file($image_tmp_name, $image_folder);
                array_push($success_msgs, 'Thêm mới sản phẩm thành công ');
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
    <title>admin products</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

    <!-- css custom link -->
    <link rel="stylesheet" href="./css//admin-products.css">
    <link rel="stylesheet" href="../css//root.css">
</head>

<body>
    <?php include 'admin_header.php'; ?>

    <section class="add-products">

        <h1 class="title">Thêm mới sản phẩm</h1>

        <form action="" method="POST" enctype="multipart/form-data">
            <div class="flex">
                <div class="wrap-inputBox">
                    <div class="inputBox">
                        <select name="category" class="box" required>
                            <option value="selected disabled"> Chọn loại sản phẩm</option>
                            <option value="Trái cây">Trái cây</option>
                            <option value="Thịt tươi">Thịt tươi</option>
                            <option value="Hải sản tươi">Hải sản tươi</option>
                            <option value="Rau củ">Rau củ</option>
                            <option value="Thực phẩm khô">Thực phẩm khô</option>
                        </select>
                    </div>

                    <div class="inputBox">
                        <input type="text" name="name" class="box" required placeholder="Nhập tên sản phẩm">
                    </div>

                    <div class="inputBox">
                        <input type="number" min="0" name="price" class="box" required placeholder="Nhập giá sản phẩm">
                    </div>

                    <div class="inputBox">
                        <input type="file" name="image" class="box" accept="image/jpg, image/png, image/jpeg" required placeholder="Nhập tên sản phẩm">
                    </div>

                    <div class="inputBox">
                        <select name="status" class="box" required>
                            <option value="selected disabled"> Chọn trạng thái</option>
                            <option value="Còn hàng">Còn hàng</option>
                            <option value="Còn hàng">Đang cập nhật</option>
                        </select>
                    </div>
                </div>

                <div class="textarea">
                    <textarea name="details" class="box" required placeholder="Nhập mô tả sản phẩm" cols="30" rows="10"></textarea>
                </div>
            </div>
            <input type="submit" class="btn" value="Thêm sản phẩm" name="add-products">
        </form>
    </section>

    <!-- sweet alert cdn link -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <!-- custom script file link -->

    <!-- include file alert.php -->
    <?php include 'alert.php'; ?>

</body>

</html>