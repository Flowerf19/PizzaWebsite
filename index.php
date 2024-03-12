<?php
require_once('header.php');
require_once('SQL/Function.php');

if (isset($_GET['query'])) {
    $search_query = $_GET['query'];
    $result = search_all_product($db, $search_query);
}

?>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>New pizza now available!</h2>
            </div>
        </div>
        <div class="row">
            <?php
            $latest_products_set = find_latest_pizzas(4);
            $count = mysqli_num_rows($latest_products_set);
            $products_per_row = 4; // Số lượng sản phẩm trên mỗi hàng

            $product_count = 0; // Đếm số lượng sản phẩm đã được hiển thị

            while ($product_count < $count && $product = mysqli_fetch_assoc($latest_products_set)) {
                if ($product_count % $products_per_row == 0) {
                    echo '<div class="row">';
                }
                echo '<div class="col-md-3">';
                echo '<div class="product">';
                echo '<a href="productDetails.php?id=' . $product['id'] . '">';
                echo '<h4>' . $product['products_name'] . '</h4>';
                echo '<img src="' . $product['image_url'] . '" alt="' . $product['products_name'] . '">';
                echo '<p>Price: ' . $product['price'] . '</p>';
                echo '</a>';
                echo '<div class="text-center mt-3">';
                echo '<a href="productDetails.php?id=' . $product['id'] . '"><i class="fa-solid fa-cart-shopping"></i></a>';
                echo '</div>';

                echo '</div>';
                echo '</div>';
                $product_count++;
                if ($product_count % $products_per_row == 0 || $product_count == $count) {
                    echo '</div>'; // Close the row after displaying 4 products or when reaching the end
                }
            }

            mysqli_free_result($latest_products_set);
            ?>
        </div>
    </div>

    <div class="container">
        <div class="col-md-12">
            <h2>All pizza varieties are now available!</h2>
        </div>
        <div class="row">
            <?php
            // Define pagination variables
            $current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
            $products_per_page = 12;
            $products_per_row = 4;

            // Calculate offset
            $offset = ($current_page - 1) * $products_per_page;

            // Get products for the current page
            $result_set = find_products_pagination($products_per_page, $offset);


            // Display Products & Create Pagination
            if ($result_set) {
                // Output products
                while ($product = mysqli_fetch_assoc($result_set)) {
                    echo '<div class="col-md-3">';
                    echo '<div class="product">';
                    echo '<a href="productDetails.php?id=' . $product['id'] . '">';
                    echo '<h4>' . $product['products_name'] . '</h4>';
                    echo '<img src="' . $product['image_url'] . '" alt="' . $product['products_name'] . '">';
                    echo '<p>Price: ' . $product['price'] . '</p>';
                    echo '</a>';
                    echo '<div class="text-center mt-3">';
                    echo '<a href="productDetails.php?id=' . $product['id'] . '"><i class="fa-solid fa-cart-shopping"></i></a>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                }
                echo'<br>';
                // Calculate total pages
                $total_pages_query = "SELECT CEIL(COUNT(*) / $products_per_page) AS total_pages FROM products";
                $total_pages_result = mysqli_query($db, $total_pages_query);
                $total_pages_row = mysqli_fetch_assoc($total_pages_result);
                $total_pages = $total_pages_row['total_pages'];

                // Corrected Pagination
                echo '<div class="pagination">';
                if ($current_page > 1) {
                    echo '<a href="?page=' . ($current_page - 1) . '">Previous</a>';
                }
                for ($i = 1; $i <= $total_pages; $i++) {
                    echo '<a href="?page=' . $i . '" ' . ($current_page == $i ? 'class="active"' : '') . '>' . $i . '</a>';
                }
                if ($current_page < $total_pages) {
                    echo '<a href="?page=' . ($current_page + 1) . '">Next</a>';
                }
                echo '</div>';
            } else {
                echo "No products found.";
            }
            ?>
        </div>
    </div>

    <?php
    require_once('footer.php');
    db_disconnect($db);
    ?>
</body>

</html>