<?php
// Kết nối đến database
require_once('Lib/intialize.php');
require_once('SQL/Connect.php');
require_once('SQL/Function.php');

// Retrieve categories
$categories_set = find_all_categories();
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pizza Website</title>
    <link rel="stylesheet" href="Css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/8fe1611e9e.js" crossorigin="anonymous"></script>
</head>

<body>
    <header>
        <a href="index.php" class="logo">
            <img src="image/Logo.png" alt="Pizza Website">
        </a>
        <nav>
            <ul class="main-menu">
                <li><a href="index.php">Home</a></li>
                <?php if (isset($_SESSION['authenticated']) && $_SESSION['authenticated']) : ?>
                    <li><a href="manageUsers.php">Manage Users</a></li>
                    <li><a href="manageCategories.php">Manage Categories</a></li>
                    <li><a href="index_product.php">Manage Products</a></li>
                    <li><a href="product_by_category.php"><i class="fa-solid fa-user"></i> <?php echo $_SESSION['username']; ?></a></li>
                    <li><a href="logout.php"><i class="fa-solid fa-right-from-bracket"></i></a></li>
                <?php else : ?>
                    <!-- Loop through categories if available -->
                    <?php
                    if ($categories_set && mysqli_num_rows($categories_set) > 0) {
                        while ($category = mysqli_fetch_assoc($categories_set)) :
                            // Update the link to point to products_by_category.php with the category ID
                    ?>
                            <li><a href="product_by_category.php?category_id=<?php echo $category["id"]; ?>"><?php echo $category["category_name"]; ?></a></li>
                    <?php
                        endwhile;
                    } else {
                        // Handle no categories found
                        echo "<li>No categories found</li>";
                    }
                    ?>


                    <li>
                        <form action="search.php" method="GET">
                            <input type="text" name="query" placeholder="Find Pizza...">
                            <button type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                        </form>
                    </li>
                    <li><a href="cart.php"><i class="fa-solid fa-cart-shopping"></i></a></li>
                    <?php
                    if (isset($_SESSION['username'])) {
                        echo '<li><a href="product_by_category.php"><i class="fa-solid fa-user"></i> ' . $_SESSION['username'] . '</a></li>';
                        echo '<li><a href="logout.php"><i class="fa-solid fa-right-from-bracket"></i></a></li>';
                    }
                    ?>

                    <?php
                    if (!isset($_SESSION['username'])) {
                        echo '<li><a href="login.php"><i class="fa-solid fa-user"></i></a></li>';
                    }
                    ?>

                <?php endif; ?>
            </ul>
        </nav>
    </header>

</body>

</html>