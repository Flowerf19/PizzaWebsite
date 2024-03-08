<?php

require_once('Lib/intialize.php');
require_once('SQL/Connect.php');
require_once('SQL/Function.php');
require_once('header.php');
$errors = [];

function isFormValidated()
{
    global $errors;
    return count($errors) == 0;
}

if ($_SERVER["REQUEST_METHOD"] == 'POST') {
    if (empty($_POST['name'])) {
        $errors[] = 'Your name is required';
    }

    if (empty($_POST['email'])) {
        $errors[] = 'Your email is required';
    } elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Invalid email format';
    }

    if (empty($_POST['message'])) {
        $errors[] = 'Message is required';
    }
}

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Feedback Form</title>
</head>

<body>
    <?php if ($_SERVER["REQUEST_METHOD"] == 'POST' && !isFormValidated()) : ?>
        <div class="error">
            <span>Please fix the following errors</span>
            <ul>
                <?php
                foreach ($errors as $error) {
                    echo '<li>', $error, '</li>';
                }
                ?>
            </ul>
        </div><br><br>
    <?php endif; ?>

    <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
    <label for="feedbackName">Title</label> <!--required-->
        <input type="text" id="name" name="name" value="<?php echo isFormValidated() ? '' : $_POST['name'] ?>">
        <br><br>
        <label for="name">Your Name</label> <!--required-->
        <input type="text" id="name" name="name" value="<?php echo isFormValidated() ? '' : $_POST['name'] ?>">
        <br><br>

        <label for="email">Your Email</label> <!--required-->
        <input type="email" id="email" name="email" value="<?php echo isFormValidated() ? '' : $_POST['email'] ?>">
        <br><br>

        <label for="message">Message</label> <!--required-->
        <textarea id="message" name="message"><?php echo isFormValidated() ? '' : $_POST['message'] ?></textarea>
        <br><br>

        <input type="submit" name="submit" value="Submit">
        <input type="reset" name="reset" value="Reset">
    </form>

    <?php if ($_SERVER["REQUEST_METHOD"] == 'POST' && isFormValidated()) : ?>
        <?php
        $feedback = [];
        $feedback['name'] = $_POST['name'];
        $feedback['email'] = $_POST['email'];
        $feedback['message'] = $_POST['message'];
        $result = insertFeedback($feedback);
        ?>
        <h2>Thank you for your feedback!</h2>
        <p>We have received the following information:</p>
        <ul>
            <li>Name: <?php echo $feedback['name']; ?></li>
            <li>Email: <?php echo $feedback['email']; ?></li>
            <li>Message: <?php echo $feedback['message']; ?></li>
        </ul>
    <?php endif; ?>

    <br><br>
    <a href="index.php">Back to Home</a>
</body>

</html>

<?php
require_once('footer.php');
db_disconnect($db);
?>
