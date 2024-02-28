<?php
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
    $sql .= "ORDER BY category_name";
    $result = mysqli_query($db, $sql);

    return confirm_query_result($result);
}

function register_user($username, $email, $hashpassword) {
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
function login($username, $password) {
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

?>
