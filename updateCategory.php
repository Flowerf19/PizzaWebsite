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
        redirect_to('manageCategories.php');
    }
} else { // Form loaded
    if (!isset($_GET['id'])) {
        redirect_to('index.php');
    }
    $id = $_GET['id'];
    $category = find_category_by_id($id);
}

?>

<body>
    <div class="login-container">
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
            <h2 class="text-center mb-4">Edit Category</h2>
            <input type="hidden" name="id" value="<?php echo isset($category['id']) ? $category['id'] : ''; ?>">

            <div class="mb-3">
                <label for="name" class="form-label">Category Name</label>
                <input type="text" class="form-control" id="name" name="name" value="<?php echo isset($category['category_name']) ? htmlspecialchars($category['category_name']) : ''; ?>">
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <input type="text" class="form-control" id="description" name="description" value="<?php echo isset($category['Description']) ? htmlspecialchars($category['Description']) : ''; ?>">
            </div>

            <div class="text-center mt-3">
                <button type="submit" class="btn btn-primary" name="submit">Submit</button>
                <button type="reset" class="btn btn-secondary" name="reset">Reset</button>
            </div>
        </form>

        <br><br>
        <a href="manageCategories.php" class="btn btn-secondary"><i class="fa-solid fa-backward"></i> Back</a>
    </div>
</body>
</html>

<?php
require_once('footer.php');
db_disconnect($db);
?>
