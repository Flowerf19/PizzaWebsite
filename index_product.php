<?php
// Include connect.php to establish database connection
include('SQL/Connect.php');

require_once('header.php');


// Configuration for pagination
$itemsPerPage = 10;
$current_page = isset($_GET['page']) ? $_GET['page'] : 1;
$offset = ($current_page - 1) * $itemsPerPage;

// Query to retrieve products from the database with pagination
$query = "SELECT products.id, products_name, category_name, products.description, image_url, size, base, cheese, price
          FROM products
          INNER JOIN categories ON products.category_ID = categories.id
          LIMIT $itemsPerPage OFFSET $offset";

$result = mysqli_query($db, $query);
confirm_query_result($result);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product List</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        h2 {
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        img {
            max-width: 100px;
            max-height: 100px;
        }

        .pagination {
            margin-top: 10px;
        }

        .pagination a {
            padding: 8px;
            text-decoration: none;
            color: #000;
            background-color: #f2f2f2;
            border: 1px solid #ddd;
            margin: 2px;
        }

        .pagination a.active {
            background-color: #4CAF50;
            color: white;
        }
    </style>
</head>
<body>

<h2>Product List</h2>

<a href="new_product.php">New Product</a>

<table border="1">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Category</th>
            <th>Description</th>
            <th>Image</th>
            <th>Size</th>
            <th>Base</th>
            <th>Cheese</th>
            <th>Price</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>{$row['id']}</td>";
            echo "<td>{$row['products_name']}</td>";
            echo "<td>{$row['category_name']}</td>";
            echo "<td>{$row['description']}</td>";
            echo "<td><img src='{$row['image_url']}' alt='{$row['products_name']}' style='width: 100px; height: 100px;'></td>";
            echo "<td>{$row['size']}</td>";
            echo "<td>{$row['base']}</td>";
            echo "<td>{$row['cheese']}</td>";
            echo "<td>{$row['price']}</td>";
            echo "<td>
                    <a href='edit_product.php?id={$row['id']}'>Edit</a> | 
                    <a href='delete_product.php?id={$row['id']}' onclick='return confirm(\"Are you sure?\")'>Delete</a>
                  </td>";
            echo "</tr>";
        }
        ?>
    </tbody>
</table>

<!-- Pagination links -->
<div class="pagination">
    <?php
    $totalItemsQuery = "SELECT COUNT(*) as total FROM products";
    $totalResult = mysqli_query($db, $totalItemsQuery);
    $totalRow = mysqli_fetch_assoc($totalResult);
    $totalItems = $totalRow['total'];
    $totalPages = ceil($totalItems / $itemsPerPage);

    for ($page = 1; $page <= $totalPages; $page++) {
        $activeClass = ($page == $current_page) ? 'active' : '';
        echo "<a class='$activeClass' href='index_product.php?page=$page'>$page</a>";
    }
    ?>
</div>

<?php
// Close the database connection
db_disconnect($db);
?>

</body>
</html>
