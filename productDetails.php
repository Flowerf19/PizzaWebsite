<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 50px;
        }
        h2 {
            color: #333;
        }
        img {
            max-width: 100%;
            height: auto;
            margin-bottom: 20px;
        }
        p {
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
    <?php
    // Kết nối vào cơ sở dữ liệu
    require_once('Lib/intialize.php');
    require_once('SQL/Connect.php');
    require_once('SQL/Function.php');

    // Kiểm tra xem id sản phẩm được truyền vào không
    if(isset($_GET['id'])) {
        // Lấy ID của sản phẩm từ tham số truyền vào
        $product_id = $_GET['id'];

        // Gọi hàm để lấy thông tin sản phẩm
        $result = function_details_Product($db, $product_id);

        // Kiểm tra xem có sản phẩm nào được tìm thấy không
        if (mysqli_num_rows($result) == 1) {
            // Lấy thông tin sản phẩm từ kết quả truy vấn
            $product = mysqli_fetch_assoc($result);

            // Hiển thị thông tin sản phẩm
            echo '<h2>' . $product['products_name'] . '</h2>';
            echo '<img src="' . $product['image_url'] . '" alt="' . $product['products_name'] . '">';
            echo '<p>Description: ' . $product['description'] . '</p>';
            echo '<p>Price: $' . $product['price'] . '</p>';
            echo '<p>Size: ' . $product['size'] . ' inches</p>';
            echo '<p>Base: ' . $product['base'] . '</p>';
            echo '<p>Cheese: ' . $product['cheese'] . '</p>';

            echo "<button class='btn-back' type='button' onclick='history.go(-1)'>Back to Order</button>";
        } else {
            echo 'Product not found.';
        }

        // Giải phóng kết quả truy vấn
        mysqli_free_result($result);
    } else {
        echo 'Product ID is missing.';
    }

    // Đóng kết nối
    //mysqli_close($db_connection);
    ?>
</div>

</body>
</html>
