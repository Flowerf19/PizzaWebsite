<?php
require_once('Lib/intialize.php');

require_once('SQL/Function.php');
require_once('SQL/Connect.php');

$errors = [];

function isFormValidated(){
    global $errors;
    return count($errors) == 0;
}

function checkForm(){
    global $errors;
    if (empty($_POST['username'])){
        $errors[] = 'Username is required';
    }

    if (empty($_POST['pwd'])){
        $errors[] = 'Password is required';
    }
}

if($_SERVER["REQUEST_METHOD"] == 'POST') {
    checkForm();
    if (isFormValidated()){
        $username = isset($_POST['username'])? $_POST['username']: '';
        $password = isset($_POST['pwd'])? $_POST['pwd']: '';

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

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Login</title>
</head>
<body class = "login_body">
    <?php if ($_SERVER["REQUEST_METHOD"] == 'POST' && !isFormValidated()): ?> 
        <div class="error">
            <span> Please fix the following errors </span>
            <ul>
                <?php
                foreach ($errors as $key => $value){
                    if (!empty($value)){
                        echo '<li>', $value, '</li>';
                    }
                }
                ?>
            </ul>
        </div><br><br>
    <?php endif; ?>
    <form action="<?php echo $_SERVER["PHP_SELF"];?>" method="post">
        <label for="username">Username</label> <!--required-->
        <input type="text" id="username" name="username"  
        value="<?php echo isFormValidated()? '': $_POST['username'] ?>">
        <br><br>

        <label for="pwd">Password</label> <!--required-->
        <input type="password" id="pwd" name="pwd"  
        value="<?php echo isFormValidated()? '': $_POST['pwd'] ?>">
        <br><br>

        <input type="submit" name="submit" value="Login" />   
    </form>
</body>
</html>
