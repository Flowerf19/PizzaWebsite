<?php
// Kết nối đến database
require_once('Lib/intialize.php');
require_once('SQL/Connect.php');
require_once('SQL/Function.php');
require_once('header.php');

// Check if the category_id is provided in the URL
if (isset($_GET['category_id'])) {
    $category_id = $_GET['category_id'];

    // Retrieve category information
    $category = find_category_by_id($category_id);

    // Retrieve products by category
    $products_set = find_products_by_category($category_id);
} else {
    // Handle the case when no category_id is provided
    echo "Category not specified";
    exit();
}
?>

<body>

    <div class="container">
        <h2><?php echo $category['category_name']; ?> Pizzas</h2>

        <div class="row">
            <?php
            // Loop through products if available
            if ($products_set && mysqli_num_rows($products_set) > 0) {
                while ($product = mysqli_fetch_assoc($products_set)) :
            ?>
                    <div class="col-md-4">
                        <div class="card mb-4">
                            <img src="<?php echo $product['image_url']; ?>" class="card-img-top" alt="<?php echo $product['products_name']; ?>">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $product['products_name']; ?></h5>
                                <p class="card-text"><?php echo $product['description']; ?></p>
                                <p class="card-text"><strong>Price:</strong> $<?php echo $product['price']; ?></p>
                                <!-- Add to cart button or other actions if needed -->
                            </div>
                        </div>
                    </div>
            <?php
                endwhile;
            } else {
                // Handle no products found for the category
                echo "<p>No products found for this category.</p>";
            }
            ?>
        </div>
    </div>

    <!-- Your footer code here -->
</body>

</html>
