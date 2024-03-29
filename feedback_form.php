<?php
require_once('SQL/Connect.php');
require_once('header.php');

$errors = [];
$success_message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = db_connect();

    $name = mysqli_real_escape_string($conn, $_POST["name"]);
    $email = mysqli_real_escape_string($conn, $_POST["email"]);
    $message = mysqli_real_escape_string($conn, $_POST["message"]);

    if (empty($name)) {
        $errors['name'] = 'Name is required';
    }

    if (empty($email)) {
        $errors['email'] = 'Email is required';
    }

    if (empty($message)) {
        $errors['message'] = 'Message is required';
    }

   

    if (empty($errors)) {
        $sql = "INSERT INTO feedback (name, email, message) VALUES ('$name', '$email', '$message')";
        $result = mysqli_query($conn, $sql);
    
        if (!$result) {
            $errors['database'] = 'Lỗi cơ sở dữ liệu: ' . mysqli_error($conn);
        } else {
            // Xóa các trường nhập khi gửi thành công
            $name = $email = $message = '';
            $success_message = 'Gửi phản hồi thành công!';
    
            // Chuyển hướng người dùng trở lại trang hiện tại
            header('Location: ' . $_SERVER['PHP_SELF']);
            exit;
        }
    }

    db_disconnect($conn);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Your existing head content here -->
</head>
<body>
    <h2 class="feedback-heading">Feedback Form</h2>

    <?php if ($_SERVER["REQUEST_METHOD"] == 'POST' && !empty($errors)) : ?>
        <div class="error">
            <span>Please fix the following errors:</span>
            <ul>
                <?php foreach ($errors as $key => $error) : ?>
                    <li><?= $error; ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="feedback-form">
        <label for="name" class="form-label">Name:</label>
        <input type="text" id="name" name="name" value="<?php echo isset($_POST['name']) ? $_POST['name'] : ''; ?>" class="form-input <?php echo isset($errors['name']) ? 'error-input' : ''; ?>">
        <?php if (isset($errors['name'])) : ?>
            <p class="error"><?= $errors['name']; ?></p>
        <?php endif; ?>

        <label for="email" class="form-label">Email:</label>
        <input type="text" id="email" name="email" value="<?php echo isset($_POST['email']) ? $_POST['email'] : ''; ?>" class="form-input <?php echo isset($errors['email']) ? 'error-input' : ''; ?>">
        <?php if (isset($errors['email'])) : ?>
            <p class="error"><?= $errors['email']; ?></p>
        <?php endif; ?>

        <label for="message" class="form-label">Message:</label>
        <textarea id="message" name="message" class="form-input <?php echo isset($errors['message']) ? 'error-input' : ''; ?>"><?php echo isset($_POST['message']) ? $_POST['message'] : ''; ?></textarea>
<?php if (isset($errors['message'])) : ?>
            <p class="error"><?= $errors['message']; ?></p>
        <?php endif; ?>

        <button type="submit" class="submit-button">Submit Feedback</button>
    </form>
</body>
</html>