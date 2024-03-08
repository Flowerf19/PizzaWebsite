<?php
require_once('Lib/intialize.php');
require_once('SQL/Connect.php');
require_once('SQL/Function.php');
require_once('header.php');
authenticated();
require_once('SQL/Function.php');
// Xác định hàm để xóa người dùng
function delete_user($user_id) {
    global $db;

    // Thực hiện truy vấn xóa người dùng với ID tương ứng
    $sql = "DELETE FROM users WHERE id = {$user_id}";
    $result = mysqli_query($db, $sql);
}

// Xử lý yêu cầu xóa người dùng nếu có
if (isset($_GET['id'])) {
    $user_id = $_GET['id'];
    if (isset($_POST['confirm'])) {
        $deleted = delete_user($user_id);
        if ($deleted) {
            echo "Delete Successful";
        } else {
            echo "Delete Fail";
        }
    } else {
        // Hiển thị form xác nhận
        echo "<h2>Are you sure you want to delete?</h2>";
        echo "<form action='deleteUser.php?id={$user_id}' method='post'>";
        echo "<input type='submit' name='confirm' value='Yes'>";
        echo "<a href='javascript:history.go(-1)'>No</a>";
        echo "</form>";
    }
}
?>

</body>
</html>
<?php
require_once('footer.php');
db_disconnect($db);
?>