<?php

require_once('Connect.php');

require_once('SQL/Connect.php');
function find_all_users()
{
    global $db;

    $sql = "SELECT * FROM users ";
    $sql .= "ORDER BY username";

    // Check if $db is set and is a valid mysqli connection
    if (!$db || !($db instanceof mysqli)) {
        // Handle the error gracefully      
        return false;
    }

    $result = mysqli_query($db, $sql);

    return confirm_query_result($result);
}
function find_all_categories()
{
    global $db;

    $sql = "SELECT * FROM categories ";
    $result = mysqli_query($db, $sql);

    return confirm_query_result($result);
}
function insert_category($category)
{
    global $db;

    // Escape input to prevent SQL injection
    $category_name = mysqli_real_escape_string($db, $category['category_name']);
    $description = mysqli_real_escape_string($db, $category['description']);

    $sql = "INSERT INTO categories ";
    $sql .= "(category_name, Description) ";
    $sql .= "VALUES (";
    $sql .= "'" . $category_name . "',";
    $sql .= "'" . $description . "'";
    $sql .= ")";

    $result = mysqli_query($db, $sql);
    if (!$result) {
        // Error handling if query fails
        echo "Error: " . mysqli_error($db);
        return false;
    } else {
        return true;
    }
}


function find_category_by_id($id)
{
    global $db;

    $sql = "SELECT * FROM categories ";
    $sql .= "WHERE id='" . $id . "'";
    $result = mysqli_query($db, $sql);
    confirm_query_result($result);
    $category = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return $category; // returns an assoc. array
}
function update_category($category)
{
    global $db;

    $sql = "UPDATE categories SET ";
    $sql .= "category_name='" . $category['category_name'] . "', ";
    $sql .= "Description='" . $category['description'] . "' ";
    $sql .= "WHERE id='" . $category['id'] . "' ";
    $sql .= "LIMIT 1";

    $result = mysqli_query($db, $sql);
    return confirm_query_result($result);
}

function delete_category($category_id)
{
    global $db;

    // Sanitize the input to prevent SQL injection
    $category_id = mysqli_real_escape_string($db, $category_id);

    // Construct the SQL query
    $sql = "DELETE FROM categories ";
    $sql .= "WHERE id = '{$category_id}' ";
    $sql .= "LIMIT 1";

    // Perform the deletion
    $result = mysqli_query($db, $sql);

    // Check if the deletion was successful
    if ($result && mysqli_affected_rows($db) == 1) {
        return true; // Deletion successful
    } else {
        return false; // Deletion failed
    }
}

function register_user($username, $email, $hashpassword)
{
    global $db;

    // Escape các giá trị để tránh SQL Injection
    $escaped_username = mysqli_real_escape_string($db, $username);
    $escaped_email = mysqli_real_escape_string($db, $email);

    // Kiểm tra xem người dùng đã tồn tại chưa
    $query = "SELECT * FROM users WHERE username = '$escaped_username' OR email = '$escaped_email'";
    $result = mysqli_query($db, $query);

    if (mysqli_num_rows($result) > 0) {
        // Người dùng đã tồn tại
        return false;
    } else {
        // Thêm người dùng mới vào cơ sở dữ liệu
        $query = "INSERT INTO users (username, email, hashpassword) VALUES ('$escaped_username', '$escaped_email', '$hashpassword')";
        $result = mysqli_query($db, $query);

        // Kiểm tra xem câu lệnh INSERT có thành công không
        if ($result) {
            return true; // Đăng ký thành công
        } else {
            return false; // Đăng ký thất bại
        }
    }
}

// Thêm hàm đăng nhập vào mã PHP hiện tại
function login($username, $password)
{
    global $db;

    // Escape tên người dùng để tránh SQL Injection
    $escaped_username = mysqli_real_escape_string($db, $username);

    // Tạo truy vấn SQL để lấy mật khẩu băm từ cơ sở dữ liệu
    $query = "SELECT * FROM users WHERE username = '{$escaped_username}' LIMIT 1";
    $result = mysqli_query($db, $query);

    // Kiểm tra xem có kết quả hay không
    if ($result && mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);
        $hashed_password = $user['hashpassword'];

        // Kiểm tra xem mật khẩu đã nhập có khớp với mật khẩu đã băm không
        if (password_verify($password, $hashed_password)) {
            // Nếu khớp, lưu thông tin người dùng vào session và trả về true
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];

            // Kiểm tra nếu userrole = 1 thì đặt authenticated thành true, ngược lại là false
            $_SESSION['authenticated'] = ($user['role'] == 1) ? true : false;
            return true;
        }
    }

    // Trả về false nếu không tìm thấy người dùng hoặc mật khẩu không khớp
    return false;
}
function find_all_products()
{
    global $db;

    $sql = "SELECT * FROM products ";
    $sql .= "ORDER BY products_name";
    $result = mysqli_query($db, $sql);

    return confirm_query_result($result);
}

function find_latest_pizzas($limit)
{
    global $db;

    $sql = "SELECT * FROM products ";
    $sql .= "ORDER BY id DESC "; // Sắp xếp theo ID giảm dần để lấy sản phẩm mới nhất
    $sql .= "LIMIT " . $limit; // Giới hạn số lượng sản phẩm lấy ra

    $result = mysqli_query($db, $sql);

    return confirm_query_result($result);
}


// Define a function to find products for the current page
function find_products_pagination($limit, $offset)
{
    global $db; // Assuming $db is your database connection

    $query = "SELECT * FROM products LIMIT $limit OFFSET $offset";
    $result = mysqli_query($db, $query);

    if (!$result) {
        die("Product query failed: " . mysqli_error($db));
    }

    return $result;
}

// lỗi
function insertFeedback()
{

    global $db;

    // Escape input to prevent SQL injection
    $feedback = mysqli_real_escape_string($db, $feedback['title']);
    $feedback = mysqli_real_escape_string($db, $feedback['name']);
    $feedback = mysqli_real_escape_string($db, $feedback['title']);
    $feedback = mysqli_real_escape_string($db, $feedback['name']);


    $sql = "INSERT INTO categories ";
    $sql .= "(category_name, Description) ";
    $sql .= "VALUES (";
    $sql .= "'" . $category_name . "',";
    $sql .= "'" . $description . "'";
    $sql .= ")";

    $result = mysqli_query($db, $sql);
    if (!$result) {
        // Error handling if query fails
        echo "Error: " . mysqli_error($db);
        return false;
    } else {
        return true;
    }
}

function find_products_by_category($category_id)
{
    global $db; // Assuming $db is your database connection variable

    $query = "SELECT * FROM products WHERE category_ID = {$category_id}";
    $result = mysqli_query($db, $query);

    if (!$result) {
        die("Database query failed: " . mysqli_error($db));
    }

    return $result;
}
function function_details_Product($db, $product_id)
{
    $product_id = mysqli_real_escape_string($db, $product_id);
    $query = "SELECT * FROM products WHERE id = $product_id";
    $result = mysqli_query($db, $query);
    return $result;
}


function search_all_product($db, $search_query)
{
    $search_query = mysqli_real_escape_string($db, $search_query);
    $query = "SELECT * FROM products WHERE products_name LIKE '%$search_query%' OR description LIKE '%$search_query%' OR price LIKE '%$search_query%' OR size LIKE '%$search_query%' OR base LIKE '%$search_query%' OR cheese LIKE '%$search_query%'";
    $result = mysqli_query($db, $query);
    return $result;
}
