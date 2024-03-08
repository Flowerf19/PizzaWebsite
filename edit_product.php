<?php
include('SQL/Connect.php');
require_once('Lib/intialize.php');
require_once('SQL/Connect.php');
require_once('SQL/Function.php');
require_once('header.php');

// Kiểm tra xem có ID của sản phẩm được chọn để chỉnh sửa không
if (isset($_GET['id'])) {
    $productId = $_GET['id'];

    // Lấy thông tin sản phẩm từ cơ sở dữ liệu dựa trên ID
    $query = "SELECT * FROM products WHERE id = $productId";
    $result = mysqli_query($db, $query);
    confirm_query_result($result);

    $product = mysqli_fetch_assoc($result);

    // Lấy danh sách các danh mục từ cơ sở dữ liệu
    $categoryQuery = "SELECT id, category_name FROM categories";
    $categoryResult = mysqli_query($db, $categoryQuery);
    confirm_query_result($categoryResult);
} else {
    // Nếu không có ID được chọn, chuyển hướng về trang danh sách sản phẩm
    header("Location: index_product.php");
    exit;
}

// Kiểm tra xem biểu mẫu đã được gửi đi chưa
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Lấy dữ liệu từ biểu mẫu
    $productName = $_POST['productName'];
    $categoryId = $_POST['categoryId'];
    $description = $_POST['description'];
    $imageUrl = $_POST['imageUrl'];
    $size = $_POST['size'];
    $base = $_POST['base'];
    $cheese = $_POST['cheese'];

    // Thực hiện truy vấn để cập nhật thông tin sản phẩm trong cơ sở dữ liệu
    $updateQuery = "UPDATE products
                    SET products_name = '$productName',
                        category_ID = '$categoryId',
                        description = '$description',
                        image_url = '$imageUrl',
                        size = '$size',
                        base = '$base',
                        cheese = '$cheese'
                    WHERE id = $productId";

    $updateResult = mysqli_query($db, $updateQuery);
    confirm_query_result($updateResult);

    // Chuyển hướng người dùng đến trang index_product.php sau khi chỉnh sửa sản phẩm thành công
    header("Location: index_product.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        h2 {
            color: #333;
        }

        form {
            max-width: 400px;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #333;
        }

        input[type="text"],
        select {
            width: 100%;
            padding: 8px;
            margin-bottom: 12px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        input[type="submit"] {
            background-color: #4caf50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        a {
            display: inline-block;
            margin-top: 20px;
            text-decoration: none;
            background-color: #333;
            color: #fff;
            padding: 10px 15px;
            border-radius: 4px;
        }

        a:hover {
            background-color: #555;
        }
    </style>
</head>
<body>

<h2>Edit Product</h2>

<a href="index_product.php">Back to Product List</a>

<form method="post" action="edit_product.php?id=<?php echo $productId; ?>">
    <label for="productName">Product Name:</label>
    <input type="text" name="productName" value="<?php echo $product['products_name']; ?>" required><br>

    <label for="categoryId">Category:</label>
    <select name="categoryId" required>
        <?php
        while ($categoryRow = mysqli_fetch_assoc($categoryResult)) {
            $selected = ($categoryRow['id'] == $product['category_ID']) ? 'selected' : '';
            echo "<option value='{$categoryRow['id']}' $selected>{$categoryRow['category_name']}</option>";
        }
        ?>
    </select><br>

    <label for="description">Description:</label>
    <input type="text" name="description" value="<?php echo $product['description']; ?>"><br>

    <label for="imageUrl">Image URL:</label>
    <input type="text" name="imageUrl" value="<?php echo $product['image_url']; ?>"><br>

    <label for="size">Size:</label>
    <input type="text" name="size" value="<?php echo $product['size']; ?>"><br>

    <label for="base">Base:</label>
    <input type="text" name="base" value="<?php echo $product['base']; ?>"><br>

    <label for="cheese">Cheese:</label>
    <select name="cheese" required>
        <option value="Mozzarella">Mozzarella</option>
        <option value="Cheddar">Cheddar</option>
    </select><br>

    <input type="submit" value="Update Product">
</form>

<?php
// Đóng kết nối cơ sở dữ liệu
db_disconnect($db);
?>

</body>
</html>
