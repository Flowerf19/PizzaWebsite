<?php
// Kết nối đến database
require_once('Connect.php');
require_once('Function.php');
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pizza Website</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body>
    <header>
        <h1>Pizza Website</h1>
        <ul>
            <?php
            $categories_set = find_all_categories();
            while ($category = mysqli_fetch_assoc($categories_set)):
            ?>
                <li><a href="#"><?php echo $category["category_name"]; ?></a></li>
            <?php endwhile; ?>
            <li><a href="cart.php">Cart</a></li>
            <li><a href="login.php">Login</a></li>
            <li><a href="logout.php">Logout</a></li>
            <li>
                <form action="search.php" method="GET">
                    <input type="text" name="query" placeholder="Find Pizza...">
                    <button type="submit">Search Pizza</button>
                </form>
            </li>
        </ul>
    </header>

    <div id="content">
        <!-- Your content here -->
    </div>

</body>

</html>
