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

</head>

<body>
    <header>
        <h1>Pizza Website</h1>
        <ul>

            <?php if (isset($_SESSION['authenticated']) && $_SESSION['authenticated']) : ?>
                <li><a href="manageUsers.php">Manage Users</a></li>
                <li><a href="cart.php">Manage categories</a></li>
                <li><a href="cart.php">Manage Products</a></li>
                <li><a href="#"><?php echo 'Hello ' . $_SESSION['username']; ?></a></li>
                <li><a href="logout.php">Logout</a></li>
            <?php else : ?>

                <?php
                // Loop through categories if available
                if ($categories_set) {
                    while ($category = mysqli_fetch_assoc($categories_set)) :
                ?>
                        <li><a href="#"><?php echo $category["category_name"]; ?></a></li>
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
                        <button type="submit">Search Pizza</button>
                    </form>
                </li>
                <li><a href="cart.php">Cart</a></li>
                <li><a href="login.php">Login</a></li>

            <?php endif; ?>

        </ul>
    </header>

    <div id="content">
        <!-- Your content here -->
    </div>

</body>

</html>