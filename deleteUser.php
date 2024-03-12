<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Information</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f5f5f5;
        }
        .container {
            text-align: center;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            margin-top: 0;
        }
        form {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 20px;
        }
        button {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        button:hover {
            background-color: #f0f0f0;
        }
        .btn-yes {
            background-color: #4caf50;
            color: #fff;
            margin-right: 10px;
        }
        .btn-no {
            background-color: #f44336;
            color: #fff;
        }
    </style>
</head>
<body>

<?php
require_once('SQL/Function.php');

// Xác định hàm để xóa người dùng
function delete_user($user_id) {
    global $db;

    // Thực hiện truy vấn xóa người dùng với ID tương ứng
    $sql = "DELETE FROM users WHERE id = {$user_id}";
    $result = mysqli_query($db, $sql);
    return $result;// them cai nay
}

// Xử lý yêu cầu xóa người dùng nếu có
if (isset($_GET['id'])) {
    $user_id = $_GET['id'];
    // echo $user_id
    if (isset($_POST['confirm'])) {
        $deleted = delete_user($user_id);
        if ($deleted) {
            echo "Delete Successful";
            header("Location: /PizzaWebsite/manageUsers.php"); // them cai  nay 
        } else {
        // echo $deleted;
            echo "Delete Fail";
        }
    } else {
        // Hiển thị form xác nhận
        echo "<div class='container'>";
        echo "<h2>Are you sure you want to delete?</h2>";
        echo "<form action='deleteUser.php?id={$user_id}' method='post'>";
        echo "<button class='btn-yes' type='submit' name='confirm' value='Yes'>Yes</button>";
        echo "<button class='btn-no' type='button' onclick='history.go(-1)'>No</button>";
        echo "</form>";
        echo "</div>";
    }
}
?>

</body>
</html>