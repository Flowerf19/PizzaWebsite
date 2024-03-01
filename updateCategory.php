<?php
require_once('Lib/intialize.php');
require_once('SQL/Function.php');
$errors = [];

function isFormValidated()
{
    global $errors;
    return count($errors) == 0;
}

function checkForm()
{
    global $errors;
    if (empty($_POST['name'])) {
        $errors[] = 'Category name is required';
    }

    if (empty($_POST['description'])) {
        $errors[] = 'Description is required';
    }
}

if ($_SERVER["REQUEST_METHOD"] == 'POST') {
    checkForm();
    if (isFormValidated()) {
        // Do update
        $category = [];
        $category['id'] = $_POST['id'];
        $category['category_name'] = $_POST['name'];
        $category['description'] = $_POST['description'];

        update_category($category);
        redirect_to('index.php');
    }
} else { // Form loaded
    if (!isset($_GET['id'])) {
        redirect_to('index.php');
    }
    $id = $_GET['id'];
    $category = find_category_by_id($id);
}

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Edit category</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <?php if ($_SERVER["REQUEST_METHOD"] == 'POST' && !isFormValidated()) : ?>
        <div class="error">
            <span>Please fix the following errors</span>
            <ul>
                <?php foreach ($errors as $error) : ?>
                    <li><?php echo $error; ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <br><br>
    <?php endif; ?>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <input type="hidden" name="id" value="<?php echo isset($category['id']) ? $category['id'] : ''; ?>">

        <label for="name">Category name</label> <!--required-->
        <input type="text" id="name" name="name" value="<?php echo isset($category['category_name']) ? htmlspecialchars($category['category_name']) : ''; ?>">
        <br><br>

        <label for="description">Description</label> <!--required-->
        <input type="text" id="description" name="description" value="<?php echo isset($category['Description']) ? htmlspecialchars($category['Description']) : ''; ?>">
        <br><br>

        <input type="submit" name="submit" value="Submit">
        <input type="reset" name="reset" value="Reset">
    </form>

    <br><br>
    <a href="index.php">Back to index</a>
</body>

</html>

<?php
db_disconnect($db);
?>
