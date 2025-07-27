<?php
include("../Server/Admin-Panel/config/db.php");
$user_id = $_SESSION['user_id'] ?? '';
?>
<style>
    .bottom-nav {
        position: fixed;
        bottom: 0;
        left: 0;
        right: 0;
        height: 60px;
        /* slightly smaller, better visual balance */
        background-color: #fff;
        border-top: 1px solid #ddd;
        display: flex;
        justify-content: space-around;
        align-items: center;
        box-shadow: 0 -2px 8px rgba(0, 0, 0, 0.05);
        z-index: 1000;
        border-radius: 12px 12px 0 0;
        padding: 4px 0;
        /* added padding for spacing */
    }

    .bottom-nav a {
        text-decoration: none;
        color: #6b7280;
        font-size: 11px;
        /* slightly smaller for compact look */
        transition: all 0.3s ease-in-out;
        flex: 1;
        /* distribute evenly */
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }

    .bottom-nav a.active {
        color: #1d4ed8;
        font-weight: 600;
    }

    .bottom-nav a:hover {
        color: #1d4ed8;
    }

    .bottom-nav i {
        font-size: 20px;
        margin-bottom: 2px;
        transition: transform 0.2s;
        line-height: 1;
    }

    .bottom-nav .nav-item:hover i {
        transform: scale(1.1);
    }

    #mobile_icons {
        display: none;
    }

    @media (max-width: 864px) {
        #mobile_icons {
            display: flex !important;

        }
    }

    body {
        padding-bottom: 70px;


    }
</style>


<div id="mobile_icons" class="bottom-nav shadow-sm ">
    <a href="./index.php" class="nav-item <?= basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : '' ?>">
        <i class="fas fa-home"></i>
        <span>Home</span>
    </a>
    <a href="./test.php" class="nav-item a">
        <i class="bi-play-circle-fill"></i>
        <span>Categories</span>
    </a>
    <a onclick="checkauth()" class="nav-item px-0 mx-0 cursor-pointer <?= basename($_SERVER['PHP_SELF']) == 'view-cart.php' ? 'active' : '' ?>">
        <i class="fas fa-cart-shopping"></i>
        <span>Cart</span>
    </a>
    <a
        <?php if (isset($_SESSION['user_id'])): ?>
        href="./homeprofile.php"
        <?php else: ?>
        href="javascript:void(0)" onclick="showAuthModal('login')"
        <?php endif; ?>
        class="nav-item cursor-pointer <?= basename($_SERVER['PHP_SELF']) == 'homeprofile.php' ? 'active' : '' ?>">


        <?php
        $profilePath = '../Server/uploads/user.png'; // default

        if (!empty($_SESSION['user_id'])) {
            $user_id = (int)$_SESSION['user_id'];

            $sql = "SELECT user_profile FROM users WHERE id = $user_id";
            $result = $conn->query($sql);

            if ($result && $row = $result->fetch_assoc()) {
                $profile = $row['user_profile'];
                if (!empty($profile)) {
                    $profilePath = '../Server/uploads/' . $profile;
                }
            }
        }
        ?>
        <img
            src="<?= htmlspecialchars($profilePath) ?>"
            width="30"
            height="30"
            class="rounded-circle mb-1"
            alt="User Profile"
            style="object-fit: cover;">
        <span>Account</span>
    </a>


</div>