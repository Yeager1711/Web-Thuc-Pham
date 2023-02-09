<header class="header">
    <div class="image-logo">
        <img src="./images//logo.png" alt="">
    </div>

    <nav class="navbar">
        <div id="marker"></div>
        <a href="home.php">Trang chủ</a>
        <a href="about.php">Giới thiệu </a>
        <a href="products.php">Sản Phẩm</a>
        <a href="contact.php">Liên hệ</a>
    </nav>

    <div class="icons">
        <a href="search_page.php" class="fa-solid fa-magnifying-glass search-btn"></a>
        <div id="menu-btn" class="fas fa-bars"></div>
        <a id="cart-btn" class="fa-solid fa-cart-shopping">
            <?php
                $total_cart_user = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
                $total_cart_user->execute([$user_id]);
            ?>
            <span class="show-total"><?= $total_cart_user->rowCount();?></span>
        </a>

        <?php
        $select_profile = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
        $select_profile->execute([$user_id]);
        $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
        ?>
        <div id="users-btn">
            <img src="uploaded_img/<?= $fetch_profile['image']; ?>" alt="">
        </div>
    </div>

    <div class="profile">
        <?php
        $select_profile = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
        $select_profile->execute([$user_id]);
        $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
        ?>
        <div class="profile-title">
            <img src="uploaded_img/<?= $fetch_profile['image']; ?>" alt="">
            <p>
                <?= $fetch_profile['name']; ?>
            </p>
        </div>
        <a href="user_update_profile.php" class="btn-normal"> <i class="fa-solid fa-file-invoice"></i> Cập nhật thông tin </a>
        <a href="login.php" class="btn-normal"> <i class="fa-solid fa-right-from-bracket"></i> Đăng xuất</a>
    </div>

    <!-- model cart -->
    <div class="btn-showModelCart">
        <i class="fa-solid fa-xmark"></i>
        <div class="container">
            <?php include 'cart.php'; ?>
        </div>
    </div>
</header>

<!-- script JS -->
<script src="./js//admin//admin_header.js" ></script>
<script>
    var modelCart = document.querySelector('.btn-showModelCart');
    var btnCart = document.querySelector('#cart-btn');
    mocalContainer = document.querySelector('.container')

    btnCart.onclick = () => {
        modelCart.classList.toggle('active')
    }

    modelCart.onclick = () => {
        modelCart.classList.remove('active')
    }

    mocalContainer.addEventListener('click', function(event) {
        event.stopPropagation();
    })  
    
</script>
<link rel="stylesheet" href="./css//header.css">


