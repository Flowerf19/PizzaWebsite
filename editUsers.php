<?php
require_once('header.php');

if(isset($_GET['id'])) {
    $user_id = $_GET['id'];

    // Lấy thông tin người dùng từ ID
    $user = find_user_by_id($user_id);
    if(!$user) {
        echo "User not found";
        exit;
    }
    //$user_password = isset($user['password']) ? $user['password'] : ''; sửa thành dòng dưới, vì trong database k có trường nào tên là password 
    $user_password = isset($user['hashpassword']) ? $user['hashpassword'] : ''; // Kiểm tra xem $user['password'] có tồn tại không 
    if(isset($_POST['submit'])) {
        // Lấy thông tin cập nhật từ form
        $updated_username = $_POST['username'];
        $updated_email = $_POST['email'];
        $old_password = $_POST['old_password']; // Thêm trường password cũ
        $updated_password = $_POST['password']; // Thêm trường password mới
        $confirm_password = $_POST['confirm_password']; // Thêm trường confirm password
    }
        $errors = [];

function isFormValidated()
{
    global $errors;
    return count($errors) == 0;
}

if ($_SERVER["REQUEST_METHOD"] == 'POST') {
    if (empty($_POST['username'])) {
        $errors[] = 'username is required';
    }

    if (empty($_POST['email'])) {
        $errors[] = 'email is required';
    }  

    if (empty($_POST['old_password'])) {
        $errors[] = 'old_password is required';
    }  
        // Kiểm tra mật khẩu cũ
        $hashed_old_password = $user_password;
        if(password_verify($old_password, $hashed_old_password)) {
            // Mật khẩu cũ trùng khớp
            // Kiểm tra mật khẩu mới và confirm password
            if($updated_password !== $confirm_password) {
                echo "New password and confirm password do not match.";
            } else {
                // Mật khẩu mới và confirm password khớp
                // Nếu mật khẩu mới được cung cấp, hãy băm nó và cập nhật vào cơ sở dữ liệu
                $hashed_new_password = password_hash($updated_password, PASSWORD_DEFAULT);
                $updated = update_user($user_id, $updated_username, $updated_email, $hashed_new_password);

                if($updated) {
                    echo "Update Successful"; 
                } else {
                    echo "Update Failed";
                }
            }
        } else {
            echo "Old password is incorrect.";
        }
    }    

    if(isset($_POST['cancel'])) {
        // Redirect hoặc thực hiện các hành động khác khi người dùng nhấn "No"
        header("Location: somepage.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User Information</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        .container {
            max-width: 500px;
            margin: 50px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            margin-top: 0;
            color: #333;
        }

        label {
            font-weight: bold;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        input[type="submit"],
        button {
            background-color: #4caf50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-right: 10px;
        }

        button {
            background-color: #f44336;
        }

        a {
            color: #4caf50;
            text-decoration: none;
        }
    </style>
</head>
<body>

<?php if ($_SERVER["REQUEST_METHOD"] == 'POST' && !isFormValidated()) : ?>
        <div class="error">
            <span> Please fix the following errors </span>
            <ul>
                <?php
                foreach ($errors as $key => $value) {
                    if (!empty($value)) {
                        echo '<li>', $value, '</li>';
                    }
                }
                ?>
            </ul>
        </div><br><br>
    <?php endif; ?>

    <h2>Edit User Information</h2>
    <form action="editUsers.php?id=<?php echo $user_id; ?>" method="post">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" value="<?php echo isset($user['username']) ? $user['username'] : ''; ?>" ><br><br>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo isset($user['email']) ? $user['email'] : ''; ?>" ><br><br>
        <label for="old_password">Old Password:</label> <!-- Thêm trường nhập mật khẩu cũ -->
        <input type="password" id="old_password" name="old_password" ><br><br>
        <label for="password">New Password:</label>
        <input type="password" id="password" name="password" ><br><br> <!-- Thêm trường nhập mật khẩu mới -->
        <label for="confirm_password">Confirm Password:</label>
        <input type="password" id="confirm_password" name="confirm_password" ><br><br> <!-- Thêm trường nhập xác nhận mật khẩu -->
        <h2>Are you sure you want to Update?</h2>
        <input type="submit" name="submit" value="Update">
        <button type='button' onclick='history.go(-1)'>No</button>
        <a href='manageUsers.php?id=<?php echo $user_id; ?>'>Back to list</a> <!-- Sửa đoạn href -->
    </form>
</body>
</html>