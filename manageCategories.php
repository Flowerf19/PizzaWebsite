<?php
require_once('Lib/intialize.php');
require_once('SQL/Connect.php');
require_once('SQL/Function.php');
require_once('header.php');
authenticated();
?>
<body>
    <div class="categories-container">
        <a href="newCategory.php" class="btn btn-primary">Create new category</a>
        <br><br>
        <table class="categories-list">
            <tr>
                <th class="category-header">Name</th>
                <th class="category-header">Description</th>
                <th class="category-header">&nbsp;</th>
                <th class="category-header">&nbsp;</th>
            </tr>

            <?php  
            $category_set = find_all_categories();
            $count = mysqli_num_rows($category_set);
            for ($i = 0; $i < $count; $i++):
                $category = mysqli_fetch_assoc($category_set); 
                //alternative: mysqli_fetch_row($category_set) returns indexed array
            ?>
                <tr class="category-row">
                    <td class="category-data"><?php echo $category['category_name']; ?></td>
                    <td class="category-data"><?php echo $category['Description']; ?></td>
                    <td class="category-data"><a href="<?php echo 'updateCategory.php?id='.$category['id']; ?>" class="btn btn-secondary">Edit</a></td>
                    <td class="category-data"><a href="<?php echo 'deleteCategory.php?id='.$category['id']; ?>" onclick="return confirm('Are you sure you want to delete this category?')" class="btn btn-danger">Delete</a></td>
                </tr>
            <?php 
            endfor; 
            mysqli_free_result($category_set);
            ?>
        </table>
    </div>
</body>


<?php
require_once('footer.php');
db_disconnect($db);
?>
?>