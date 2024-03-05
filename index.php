<?php
require_once('header.php');
require_once('SQL/Function.php');
?>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>NEW PIZZA</h2>
            </div>
        </div>
        <div class="row">
            <?php
            $latest_products_set = find_latest_pizzas(8); // Lấy 8 sản phẩm pizza mới nhất
            $count = mysqli_num_rows($latest_products_set);
            $products_per_row = 4; // Số lượng sản phẩm trên mỗi hàng
            $product_count = 0; // Đếm số lượng sản phẩm đã được hiển thị

            while ($product_count < $count) {
                echo '<div class="row">';
                // Hiển thị mỗi hàng chứa 4 sản phẩm
                for ($i = 0; $i < $products_per_row; $i++) {
                    if ($product_count >= $count) {
                        break; // Đã hiển thị hết tất cả sản phẩm
                    }
                    $product = mysqli_fetch_assoc($latest_products_set);
                    echo '<div class="col-md-3">';
                    echo '<div class="product">';
                    echo '<h4>' . $product['products_name'] . '</h4>';
                    echo '<img src="' . $product['image_url'] . '" alt="' . $product['products_name'] . '">';
                    echo '<p>Price: ' . $product['price'] . '</p>';
                    echo '<a href="productDetails.php?id=' . $product['id'] . '"><i class="fa-solid fa-cart-shopping"></i></a>';
                    echo '<a href="productDetails.php?id=' . $product['id'] . '">Details</a>';
                    echo '</div>';
                    echo '</div>';
                    $product_count++;
                }
                echo '</div>';
            }

            mysqli_free_result($latest_products_set);
            ?>
        </div>
    </div>

    <div class="container">
        <h2>ALL PIZZA</h2>
        <div class="row">
            <?php
            // Định nghĩa các biến phân trang
            $current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Trang hiện tại
            $products_per_page = 16; // Số lượng sản phẩm trên mỗi trang

            // Tính toán offset
            $offset = ($current_page - 1) * $products_per_page;

            // Lấy sản phẩm cho trang hiện tại
            $result_set = find_products_pagination($products_per_page, $offset);
            if ($result_set) {
                $product_set = $result_set[0]; // Get the product set
                $count = $result_set[1]; // Get the total count of products
                $product_count = 0; // Đếm số lượng sản phẩm đã được hiển thị

                while ($product_count < $count && $product = mysqli_fetch_assoc($product_set)) {
                    echo '<div class="row">';
                    // Hiển thị mỗi hàng chứa 4 sản phẩm
                    for ($i = 0; $i < $products_per_row; $i++) {
                        if ($product_count >= $count) {
                            break; // Đã hiển thị hết tất cả sản phẩm
                        }
                        echo '<div class="col-md-3">';
                        echo '<div class="product">';
                        echo '<h4>' . $product['products_name'] . '</h4>';
                        echo '<img src="' . $product['image_url'] . '" alt="' . $product['products_name'] . '">';
                        echo '<p>Price: ' . $product['price'] . '</p>';
                        echo '<a href="productDetails.php?id=' . $product['id'] . '"><i class="fa-solid fa-cart-shopping"></i></a>';
                        echo '<a href="productDetails.php?id=' . $product['id'] . '">Details</a>';
                        echo '</div>';
                        echo '</div>';
                        $product_count++;
                    }
                    echo '</div>';
                }

                mysqli_free_result($product_set);

                // Tạo các nút phân trang
                $total_pages = ceil($count / $products_per_page); 
                echo '<div class="pagination">';
                if ($current_page > 1) {
                    echo '<a href="?page=' . ($current_page - 1) . '">Previous</a>';
                }
                for ($i = 1; $i <= $total_pages; $i++) {
                    echo '<a href="?page=' . $i . '">' . $i . '</a>';
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
