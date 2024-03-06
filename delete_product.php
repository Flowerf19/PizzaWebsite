<?php
include('SQL/Connect.php');

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // Kiểm tra xem có ID được chuyển qua không
    if (isset($_GET['id']) && is_numeric($_GET['id'])) {
        $product_id = $_GET['id'];

        // Truy vấn để lấy thông tin sản phẩm từ cơ sở dữ liệu
        $query = "SELECT * FROM products WHERE id = $product_id";
        $result = mysqli_query($db, $query);
        confirm_query_result($result);

        // Lấy dữ liệu sản phẩm từ kết quả truy vấn
        $product = mysqli_fetch_assoc($result);
    } else {
        // Nếu không có ID, chuyển hướng về trang sản phẩm
        header("Location: index_product.php");
        exit();
    }
} elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Kiểm tra xem có dữ liệu POST được gửi đi không
    if (isset($_POST['submit'])) {
        $product_id = $_POST['product_id'];

        // Truy vấn để xóa sản phẩm từ cơ sở dữ liệu
        $query = "DELETE FROM products WHERE id = $product_id";
        $result = mysqli_query($db, $query);
        confirm_query_result($result);

        // Chuyển hướng về trang sản phẩm sau khi xóa
        header("Location: index_product.php");
        exit();
    }
} else {
    // Nếu không phải là GET hoặc POST, chuyển hướng về trang sản phẩm
    header("Location: index_product.php");
    exit();
}

// Đóng kết nối đến cơ sở dữ liệu
db_disconnect($db);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Product</title>

    <style>
        /* CSS styles go here */
    </style>
</head>
<body>

<h2>Delete Product</h2>

<p>Are you sure you want to delete the product "<?php echo $product['products_name']; ?>"?</p>

<form action="delete_product.php" method="post">
    <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
    <input type="submit" name="submit" value="Delete">
</form>

<!-- ... Rest of your HTML code ... -->

</body>
</html>


