<?php
require_once('Lib/intialize.php');
require_once('SQL/Connect.php');
require_once('SQL/Function.php');
require_once('header.php');
authenticated();

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $productName = $_POST['productName'];
    $categoryId = $_POST['categoryId'];
    $description = $_POST['description'];
    $imageUrl = $_POST['imageUrl'];
    $size = $_POST['size'];
    $base = $_POST['base'];
    $cheese = $_POST['cheese'];
    $price = $_POST['price'];


    // Initialize errors array
    $errors = [];


    // Validate product name
    if (empty($productName)) {
        $errors['productName'] = 'Product name is required';
    }


    // Validate description
    if (empty($description)) {
        $errors['description'] = 'Description is required';
    }
    if (empty($imageUrl)) {
        $errors['imageUrl'] = 'imageUrl is required';
    }
    if (empty($size)) {
        $errors['size'] = 'size is required';
    }
    if (empty($base)) {
        $errors['base'] = 'base is required';
    }
    if (empty($price)) {
        $errors['price'] = 'price is required';
    }


    // Validate other fields as needed...


    // Check if there are any errors before proceeding
    if (empty($errors)) {
        // Perform the query to add the product to the database
        $query = "INSERT INTO products (products_name, category_ID, description, price, image_url, size, base, cheese)
        VALUES ('$productName', '$categoryId', '$description', '$price', '$imageUrl', '$size', '$base', '$cheese')";
       
        $result = mysqli_query($db, $query);


        // Check for query success
        if ($result) {
            // Redirect the user to the product list page after successful addition
            header("Location: index_product.php");
            exit;
        } else {
            // Display an error message if the query fails
            $databaseError = 'Error adding product to the database';
        }
    }
}


// Lấy danh sách các danh mục từ cơ sở dữ liệu
$categoryQuery = "SELECT id, category_name FROM categories";
$categoryResult = mysqli_query($db, $categoryQuery);
confirm_query_result($categoryResult);


// Fetch categories and store them in an array
$categories = [];
while ($categoryRow = mysqli_fetch_assoc($categoryResult)) {
    $categories[] = $categoryRow;
}


// Close the database connection
db_disconnect($db);
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


        .error {
            color: red;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>


<h2>Add New Product</h2>


<a href="index_product.php">Back to Product List</a>


<?php if ($_SERVER["REQUEST_METHOD"] == 'POST' && !empty($errors)) : ?>
    <div class="error">
        <span>Please fix the following errors:</span>
        <ul>
            <?php foreach ($errors as $key => $error) : ?>
                <li><?= $error; ?></li>
            <?php endforeach; ?>
        </ul>
        <?php if (isset($databaseError)) : ?>
            <p><?= $databaseError; ?></p>
        <?php endif; ?>
    </div>
<?php endif; ?>


<form method="post" action="new_product.php">
    <label for="productName">Product Name:</label>
    <input type="text" id="productName" name="productName" value="<?php echo isset($_POST['productName']) ? $_POST['productName'] : ''; ?>">
    <?php if (isset($errors['productName'])) : ?>
        <p class="error"><?= $errors['productName']; ?></p>
    <?php endif; ?>


    <label for="description">Description:</label>
    <input type="text" id="description" name="description" value="<?php echo isset($_POST['description']) ? $_POST['description'] : ''; ?>">
    <?php if (isset($errors['description'])) : ?>
        <p class="error"><?= $errors['description']; ?></p>
    <?php endif; ?>


    <!-- Add labels and error messages for other fields as needed -->


    <label for="categoryId">Category:</label>
    <select name="categoryId" required>
        <?php foreach ($categories as $category) : ?>
            <option value="<?= $category['id']; ?>"><?= $category['category_name']; ?></option>
        <?php endforeach; ?>
    </select>
    <label for="imageUrl">imageUrl:</label>
    <input type="text" id="imageUrl" name="imageUrl" value="<?php echo isset($_POST['imageUrl']) ? $_POST['imageUrl'] : ''; ?>">
    <?php if (isset($errors['imageUrl'])) : ?>
        <p class="error"><?= $errors['imageUrl']; ?></p>
    <?php endif; ?>
    <label for="size">size:</label>
    <input type="text" id="size" name="size" value="<?php echo isset($_POST['size']) ? $_POST['size'] : ''; ?>">
    <?php if (isset($errors['size'])) : ?>
        <p class="error"><?= $errors['size']; ?></p>
    <?php endif; ?>
    <label for="base">base:</label>
    <input type="text" id="base" name="base" value="<?php echo isset($_POST['base']) ? $_POST['base'] : ''; ?>">
    <?php if (isset($errors['base'])) : ?>
        <p class="error"><?= $errors['base']; ?></p>
    <?php endif; ?>
    <label for="cheese">Cheese:</label>
    <select id="cheese" name="cheese" required>
    <option value="" <?php echo empty($_POST['cheese']) ? 'selected' : ''; ?>>Select Cheese</option>
    <option value="Mozzarella" <?php echo ($_POST['cheese'] === 'Mozzarella') ? 'selected' : ''; ?>>Mozzarella</option>
    <option value="Cheddar" <?php echo ($_POST['cheese'] === 'Cheddar') ? 'selected' : ''; ?>>Cheddar</option>
    </select>
     <?php if (isset($errors['cheese'])) : ?>
     <p class="error"><?= $errors['cheese']; ?></p>
    <?php endif; ?>
    <label for="price">price:</label>
    <input type="text" id="price" name="price" value="<?php echo isset($_POST['price']) ? $_POST['price'] : ''; ?>">
    <?php if (isset($errors['cheese'])) : ?>
        <p class="error"><?= $errors['price']; ?></p>
    <?php endif; ?>


    <!-- Add other form fields as needed -->


    <input type="submit" value="Add Product">
</form>


</body>
</html>
