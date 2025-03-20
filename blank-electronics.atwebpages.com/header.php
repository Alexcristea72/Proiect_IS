<link rel="stylesheet" href="header_style.css">
<header class="header">
    <!-- Logo -->
    <div class="logo-container">
        <a href="http://blank-electronics.atwebpages.com/"><img
                src="https://img.freepik.com/free-vector/online-shopping-cart-logo-shopping-basket-design_460848-10303.jpg?t=st=1739181222~exp=1739184822~hmac=4fb48aa25f9427ca236d166512744123acdd546bb63b6063b12e494c053d5d26&w=1380"
                alt="Logo" class="logo"></a>
    </div>

    <!-- Bara de căutare -->
    <div class="search-bar">
        <label>
            <input type="text" name="query" placeholder="Caută produse...">
        </label>
        <button type="submit"><i class="fas fa-search"></i></button>
    </div>

    <div class="nav-right">
        <!-- My Account Dropdown -->
        <nav>
            <ul>
                <?php if (isset($_SESSION['username'])): ?>
                    <li class="dropdown">
                        <a href="javascript:void(0)" class="dropbtn">Contul Meu</a>
                        <div class="dropdown-content">
                            <a href="account_info.php">Info Cont</a>
                            <a href="my_purchases.php">Cumparaturile Mele</a>
                            <a href="logout.php">Logout</a>
                            <div>
                    </li>
                <?php else: ?>
                    <li class="login"><a href="login">Login</a></li>
                <?php endif; ?>

                <!-- Shopping Cart Icon -->

            </ul>
        </nav>
    </div>
    <li class="cart-icon">
         <a href="cart">
            <img src="https://icons.veryicon.com/png/o/miscellaneous/flower-mall-color-icon/shopping-cart-114.png"
                 alt="Shopping Cart" class="cart-image">
        </a>
    </li>
</header>