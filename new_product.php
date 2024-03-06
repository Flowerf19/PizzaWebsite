<?php
require_once('SQL/Connect.php');

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
    $price = $_POST['price'];


    // Thực hiện truy vấn để thêm sản phẩm vào cơ sở dữ liệu
    $query = "INSERT INTO products (products_name, category_ID, description, price, image_url, size, base, cheese)
    VALUES ('$productName', '$categoryId', '$description', '$price', '$imageUrl', '$size', '$base', '$cheese')";

    
    $result = mysqli_query($db, $query);
    confirm_query_result($result);

    // Chuyển hướng người dùng đến trang index_product.php sau khi thêm sản phẩm thành công
    header("Location: index_product.php");
    exit;
}
$errors = [];

function isFormValidated()
{
    global $errors;
    return count($errors) == 0;
}

if ($_SERVER["REQUEST_METHOD"] == 'POST') {
    if (empty($_POST['name'])) {
        $errors[] = 'category name is required';
    }

    if (empty($_POST['description'])) {
        $errors[] = 'description is required';
    }  
    
    
   
   
}


// Lấy danh sách các danh mục từ cơ sở dữ liệu
$categoryQuery = "SELECT id, category_name FROM categories";
$categoryResult = mysqli_query($db, $categoryQuery);
confirm_query_result($categoryResult);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Product</title>
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

<h2>Add New Product</h2>

<a href="index_product.php">Back to Product List</a>
<?php if ($_SERVER["REQUEST_METHOD"] == 'POST' && !isFormValidated()) : ?>
        <div class="error">
            <span> Please fix the following errors </span>
            <ul>
                <?php
                foreach ($errors as $key => $value) {
                    if (!empty($value)) {
                        echo '<li>', $value, '</li>';
                    }
                }
                ?>
            </ul>
        </div><br><br>
    <?php endif; ?>

<form method="post" action="new_product.php">
    <label for="name">products name</label> <!--required-->
        <input type="text" id="name" name="name" value="<?php echo isFormValidated() ? '' : $_POST['name'] ?>">
        <br><br>

    <label for="description">description</label> <!--required-->
        <input type="text" id="description" name="description" value="<?php echo isFormValidated() ? '' : $_POST['description'] ?>">
        <br><br>

    <label for="categoryId">Category:</label>
    <select name="categoryId" required>
        <?php
        while ($categoryRow = mysqli_fetch_assoc($categoryResult)) {
            echo "<option value='{$categoryRow['id']}'>{$categoryRow['category_name']}</option>";
        }
        ?>
    </select><br>

   

    <label for="imageUrl">Image URL:</label>
    <input type="text" name="imageUrl"><br>

    <label for="size">Size:</label>
    <input type="text" name="size"><br>

    <label for="base">Base:</label>
    <input type="text" name="base"><br>

    <label for="cheese">Cheese:</label>
    <input type="text" name="cheese"><br>

    <label for="price">Price:</label>
    <input type="text" id="price" name="price" value="<?php echo isFormValidated() ? '' : $_POST['price'] ?>">


    <input type="submit" value="Add Product">
</form>

<?php
// Đóng kết nối cơ sở dữ liệu
db_disconnect($db);
?>

</body>
</html>