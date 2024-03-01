<?php
require_once('Lib/intialize.php');
require_once('SQL/Connect.php');
require_once('SQL/Function.php');
require_once('header.php');
?>
<body>
    <a href="newCategory.php">Create new category</a> <br><br>
    <table class="list">
        <tr>
            <th>Name</th>
            <th>Description</th>
            <th>&nbsp;</th>
            <th>&nbsp;</th>
  	    </tr>

        <?php  
        $category_set = find_all_categories();
        $count = mysqli_num_rows($category_set);
        for ($i = 0; $i < $count; $i++):
            $category = mysqli_fetch_assoc($category_set); 
            //alternative: mysqli_fetch_row($category_set) returns indexed array
        ?>
            <tr>
                <td><?php echo $category['category_name']; ?></td>
                <td><?php echo $category['Description']; ?></td>
                <td><a href="<?php echo 'updateCategory.php?id='.$category['id']; ?>">Edit</a></td>
                <td><a href="<?php echo 'deleteCategory.php?id='.$category['id']; ?>" onclick="return confirm('Are you sure you want to delete this category?')">Delete</a></td>
            </tr>
        <?php 
        endfor; 
        mysqli_free_result($category_set);
        ?>
    </table>
</body>
</html>

<?php
db_disconnect($db);
?>