<?php
if (isset($message)) {
    foreach ($message as $message) {
        echo '
            <div class ="message">
            <span>' . $message . '</span>
            
            </div>
            ';
    }
}
?>
<header class="header">
    <a href="admin_page.php" class="logo">Admin <span>Management</span></a>

    <nav class="navbar">
        <div id="marker"></div>
        <a href="admin_page.php">Home</a>
        <a href="admin_products.php">Products</a>
        <a href="admin_orders.php">orders</a>
        <a href="admin_users.php">users</a>
        <a href="admin_contacts.php">messege</a>
    </nav>

    <div class="icons">
        <div id="menu-btn" class="fas fa-bars"></div>
        <?php
        $select_profile = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
        $select_profile->execute([$admin_id]);
        $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
        ?>
        <div id="users-btn">
            <img src="uploaded_img/<?= $fetch_profile['image']; ?>" alt="">
        </div>
    </div>

    <!-- truyền data image vào [$admin_id] từ admin_page.php -->
    <div class="profile">
        <?php
        $select_profile = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
        $select_profile->execute([$admin_id]);
        $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
        ?>

        <a href="admin_update_profile.php" class="btn-normal"> <i class="fa-solid fa-file-invoice"></i> Cập nhật thông tin </a>
        <a href="login.php" class="btn-normal"> <i class="fa-solid fa-right-from-bracket"></i> Đăng xuất</a>
    </div>
</header>

<div class="banner-section">
    <div class="image-banner">
        <img src="./images//OIP.jpg" alt="">

        <div class="info-contactAdmin">
            <?php
            $select_profile = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
            $select_profile->execute([$admin_id]);
            $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
            ?>
            <div class="profile-titleAdmin">
                <img src="uploaded_img/<?= $fetch_profile['image']; ?>" alt="">

                <div class="desc">
                    <p  class="desc-name">
                        <?= $fetch_profile['name']; ?>
                    </p>
                    <span> Tài khoản: <p><?= $fetch_profile['user_type']; ?></p></span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- script JS -->
<script src="./js//admin//admin_header.js" defer></script>