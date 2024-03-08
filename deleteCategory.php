<?php
require_once('Lib/intialize.php');
require_once('SQL/Connect.php');
require_once('SQL/Function.php');
require_once('header.php');
authenticated();


// Check if the category ID is provided in the URL
if (isset($_GET['id'])) {
    $category_id = $_GET['id'];
    
    // Check if the user confirmed the deletion
    if (isset($_GET['confirm']) && $_GET['confirm'] == 'true') {
        // Call the delete_category function
        if (delete_category($category_id)) {
            echo "Category deleted successfully.";
        } else {
            echo "Failed to delete category.";
        }
        
        // Redirect back to the categories list page
        redirect_to('manageCategories.php');
    } else {
        // If the user hasn't confirmed, redirect to the same page with a confirmation parameter
        redirect_to('deleteCategory.php?id=' . $category_id . '&confirm=true');
    }
} else {
    echo "Category ID not provided.";
}
?>
<?php
require_once('footer.php');
db_disconnect($db);
?>