<?php
// Kết nối đến database
require_once('Lib/intialize.php');
require_once('SQL/Connect.php');
require_once('SQL/Function.php');
require_once('header.php');

// Xử lý tìm kiếm
if(isset($_GET['query'])) {
    $search_query = $_GET['query'];
    $result = search_all_product($db, $search_query);
}

?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pizza Website - Search Results</title>
    <link rel="stylesheet" href="Css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/8fe1611e9e.js" crossorigin="anonymous"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        header {
            background-color: #333;
            color: #fff;
            padding: 20px 0;
            text-align: center;
        }
        .logo img {
            width: 100px;
            height: auto;
        }
        .main-menu {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            justify-content: center;
        }
        .main-menu li {
            margin: 0 10px;
        }
        .main-menu li a {
            color: #fff;
            text-decoration: none;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
        }
        .product {
            border: 1px solid #ccc;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
        }
        .product img {
            max-width: 100%;
            height: auto;
            margin-bottom: 10px;
        }
        .product h2 {
            color: #333;
        }
        .product p {
            color: #666;
        }
        button {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .btn-back {
            background-color: #4caf50;
            color: #fff;
            margin-right: 10px;
        }
    </style>
</head>

<body>

    <div class="container">
        <h1>Search Results</h1>
        <?php
        if(isset($result) && mysqli_num_rows($result) > 0) {
            while($product = mysqli_fetch_assoc($result)) {
                echo '<div class="product">';
                echo '<h2>' . $product['products_name'] . '</h2>';
                echo '<img src="' . $product['image_url'] . '" alt="' . $product['products_name'] . '">';
                echo '<p>Description: ' . $product['description'] . '</p>';
                echo '<p>Price: $' . $product['price'] . '</p>';
                echo '<p>Size: ' . $product['size'] . ' inches</p>';
                echo '<p>Base: ' . $product['base'] . '</p>';
                echo '<p>Cheese: ' . $product['cheese'] . '</p>';
                echo '</div>';

                
            }
        } else {
            echo '<p>No results found.</p>';
        }

        echo "<button class='btn-back' type='button' onclick='history.go(-1)'>Back to Order</button>";
        ?>
    </div>
        
</body>

</html>
