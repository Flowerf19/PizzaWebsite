<?php
require_once('Lib/intialize.php');

require_once('SQL/Function.php');
require_once('SQL/Connect.php');
require_once('header.php');


$errors = [];

function isFormValidated()
{
    global $errors;
    return count($errors) == 0;
}

function checkForm()
{
    global $errors;
    if (empty($_POST['username'])) {
        $errors[] = 'Username is required';
    }

    if (empty($_POST['pwd'])) {
        $errors[] = 'Password is required';
    }
}

if ($_SERVER["REQUEST_METHOD"] == 'POST') {
    checkForm();
    if (isFormValidated()) {
        $username = isset($_POST['username']) ? $_POST['username'] : '';
        $password = isset($_POST['pwd']) ? $_POST['pwd'] : '';

        // Ensure $db is initialized before using it
        if (!$db) {
            echo "Database connection error.";
            exit; // or handle the error in a better way
        }

        // Gọi hàm đăng nhập để xác thực người dùng
        if (login($username, $password)) {
            // Đăng nhập thành công, lưu tên người dùng vào session và chuyển hướng đến trang chính
            $_SESSION['username'] = $username;
            redirect_to('index.php');
        } else {
            // Đăng nhập không thành công, hiển thị thông báo lỗi
            $errors[] = 'Invalid username or password.';
        }
    }
} else { //form load

}

?>

<body>
    <div class="login-container">
        <form class="login-form" action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
            <h2 class="text-center mb-4">Login</h2>
            <?php if ($_SERVER["REQUEST_METHOD"] == 'POST' && !isFormValidated()) : ?>
                <div class="error">
                    <ul>
                        <?php foreach ($errors as $error) : ?>
                            <li><?php echo $error; ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" value="<?php echo isFormValidated() ? '' : $_POST['username']; ?>">
            </div>
            <br>
            <br>
            <div class="mb-3">
                <label for="pwd" class="form-label">Password</label>
                <input type="password" class="form-control" id="pwd" name="pwd" value="<?php echo isFormValidated() ? '' : $_POST['pwd']; ?>">
            </div>
            <div class="text-center mt-3">
                <button type="submit" class="btn btn-primary">Login</button>
            </div>
            <div class="text-center mt-3">
                <a href="register.php">Don't have an account? Register here.</a>
            </div>
        </form>
    </div>
    <br>
    <?php
    require_once('footer.php');
    ?>
</body>

</html>