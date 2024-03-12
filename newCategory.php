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


<body>
    <div class="login-container">
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
            <h2 class="text-center mb-4">New Category</h2>
            <div class="mb-3">
                <label for="name">Category name: </label> <!--required-->
                <input type="text" id="name" name="name" value="<?php echo isFormValidated() ? '' : $_POST['name'] ?>">
                <br><br>
            </div>
            <div class="mb-3">
                <label for="description">Description:</label> <!--required-->
                <input type="text" id="description" name="description" value="<?php echo isFormValidated() ? '' : $_POST['description'] ?>">
                <br><br>
            </div>
            <div class="text-center mt-3">
                <input class="btn btn-primary" type="submit" name="submit" value="Submit">
                <input class="btn btn-secondary" type="reset" name="reset" value="Reset">
            </div>
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
    </div>
</body>

</html>


<?php
require_once('footer.php');
db_disconnect($db);
?>