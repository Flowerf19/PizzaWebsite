<?php

require_once('Lib/intialize.php');
require_once('SQL/Connect.php');
require_once('SQL/Function.php');
require_once('header.php');
authenticated();
$errors = [];

function isFormValidated()
{
    global $errors;
    return count($errors) == 0;
}

if ($_SERVER["REQUEST_METHOD"] == 'POST') {
    if (empty($_POST['name'])) {
        $errors[] = 'category name is required';
    }

    if (empty($_POST['description'])) {
        $errors[] = 'description is required';
    }
}

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Create New category</title>
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

    <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
        <label for="name">category name</label> <!--required-->
        <input type="text" id="name" name="name" value="<?php echo isFormValidated() ? '' : $_POST['name'] ?>">
        <br><br>

        <label for="description">description</label> <!--required-->
        <input type="text" id="description" name="description" value="<?php echo isFormValidated() ? '' : $_POST['description'] ?>">
        <br><br>

        <input type="submit" name="submit" value="Submit">
        <input type="reset" name="reset" value="Reset">

    </form>

    <?php if ($_SERVER["REQUEST_METHOD"] == 'POST' && isFormValidated()) : ?>
        <?php
        $category = [];
        $category['category_name'] = $_POST['name'];
        $category['description'] = $_POST['description'];
        $result = insert_category($category);
        $newcategoryId = mysqli_insert_id($db);
        ?>
        <h2>A new category (ID: <?php echo $newcategoryId ?>) has been created:</h2>
        <ul>
            <?php
            foreach ($_POST as $key => $value) {
                if ($key == 'submit') continue;
                if (!empty($value)) echo '<li>', $key . ': ' . $value, '</li>';
            }
            ?>
        </ul>
    <?php endif; ?>

    <br><br>
    <a href="manageCategories.php"><i class="fa-solid fa-backward"> Back</i></a>
</body>

</html>


<?php
require_once('footer.php');
db_disconnect($db);
?>