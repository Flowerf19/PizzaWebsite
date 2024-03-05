<?php
require_once('Lib/intialize.php');
require_once('SQL/Connect.php');
require_once('SQL/Function.php');
require_once('header.php');

// Nếu người dùng đã đăng nhập, chuyển hướng đến trang chính
if (isset($_SESSION['username'])) {
    header("Location: index.php");
    exit;
}

// Bao gồm tệp kết nối cơ sở dữ liệu và các chức năng



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

<body>
    <div class="login-container">
        <form class="login-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <h2 class="text-center mb-4">Register</h2>
            <?php if (!empty($errors)) : ?>
                <div class="error">
                    <ul>
                        <?php foreach ($errors as $error) : ?>
                            <li><?php echo $error; ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <div class="mb-3">
                <label for="username" class="form-label">Username:</label>
                <input type="text" id="username" name="username" class="form-control" value="<?php echo isset($_POST['username']) ? $_POST['username'] : ''; ?>">
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="text" id="email" name="email" class="form-control" value="<?php echo isset($_POST['email']) ? $_POST['email'] : ''; ?>">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password:</label>
                <input type="password" id="password" name="password" class="form-control">
            </div>
            <div class="mb-3">
                <label for="confirm_password" class="form-label">Confirm Password:</label>
                <input type="password" id="confirm_password" name="confirm_password" class="form-control">
            </div>
            <div class="text-center mt-3">
                <button type="submit" class="btn btn-primary">Register</button>
            </div>
        </form>
    </div>
    <?php
    require_once('footer.php');
    db_disconnect($db);
    ?>

    </html>
</body>

<?php
require_once('footer.php');
db_disconnect($db);
?>

</html>