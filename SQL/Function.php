<?php

function find_all_categories()
{
    global $db;

    $sql = "SELECT * FROM categories ";
    $sql .= "ORDER BY category_name";
    $result = mysqli_query($db, $sql);

    return confirm_query_result($result);
}
?>
