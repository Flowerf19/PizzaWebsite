<?php
require_once('Lib/intialize.php');

// Nếu người dùng đã đăng nhập, chuyển hướng đến trang chính
if (isset($_SESSION['username'])) {
    header("Location: index.php");
    exit;
}

// Bao gồm tệp kết nối cơ sở dữ liệu và các chức năng

require_once('SQL/Connect.php');
require_once('SQL/Function.php');

// Biến lưu trữ lỗi
$errors = [];

// Kiểm tra nếu biểu mẫu đã được gửi
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Kiểm tra dữ liệu biểu mẫu
    if (empty($_POST['username'])) {
        $errors[] = 'Username is required';
    }

    if (empty($_POST['email'])) {
        $errors[] = 'Email is required';
    } elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Invalid email format';
    }

    if (empty($_POST['password'])) {
        $errors[] = 'Password is required';
    }

    if (empty($_POST['confirm_password'])) {
        $errors[] = 'Confirm Password is required';
    }

    // Kiểm tra xác nhận mật khẩu
    if ($_POST['password'] !== $_POST['confirm_password']) {
        $errors[] = 'Password and Confirm Password do not match';
    }

    // Nếu không có lỗi, thực hiện đăng ký
    if (empty($errors)) {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];

        // Hash mật khẩu
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Thực hiện đăng ký
        if (register_user($username, $email, $hashed_password)) {
            // Chuyển hướng đến trang đăng nhập sau khi đăng ký thành công
            header("Location: login.php");
            exit;
        } else {
            $errors[] = 'Registration failed. Please try again later.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
</head>
<body>
    <h2>Register</h2>
    <?php if (!empty($errors)): ?>
        <div class="error">
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?php echo $error; ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" value="<?php echo isset($_POST['username']) ? $_POST['username'] : ''; ?>"><br><br>
        <label for="email">Email:</label>
        <input type="text" id="email" name="email" value="<?php echo isset($_POST['email']) ? $_POST['email'] : ''; ?>"><br><br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password"><br><br>
        <label for="confirm_password">Confirm Password:</label>
        <input type="password" id="confirm_password" name="confirm_password"><br><br>
        <input type="submit" value="Register">
    </form>
</body>
</html>
