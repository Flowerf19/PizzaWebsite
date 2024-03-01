<?php
require_once('header.php');
?>
<body>
    <h2>Admin's Information</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>username</th>
            <th>email</th>
        </tr>

        <?php


        $users_set = find_all_users();

        // Loop through categories if available
        if ($users_set) {
            while ($users = mysqli_fetch_assoc($users_set)) :
                echo "<tr>";
                echo "<td>" . $users["id"] . "</td>";
                echo "<td>" . $users["username"] . "</td>";
                echo "<td>" . $users["email"] . "</td>";
                echo "<td>
                        <a href='edit.php?id=" . $users["id"] . "'>Edit</a>
                        <a href='deleteUser.php?id=" . $users["id"] . "'>Delete</a>
                      </td>";
                echo "</tr>";
        ?>

        <?php
            endwhile;
        } else {
            // Handle no categories found
            echo "<li>No users found</li>";
        }
        ?>

</html>