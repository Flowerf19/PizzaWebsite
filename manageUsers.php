<?php
require_once('Lib/intialize.php');
require_once('SQL/Connect.php');
require_once('SQL/Function.php');
authenticated();
require_once('header.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin's Information</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        h2 {
            text-align: center;
            margin-top: 20px;
        }

        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #ddd;
        }

        .action-links a {
            display: inline-block;
            padding: 5px 10px;
            text-decoration: none;
            margin-right: 5px;
            color: #333;
            border: 1px solid #999;
            border-radius: 5px;
            background-color: #f2f2f2;
        }

        .action-links a:hover {
            background-color: #ddd;
        }
    </style>
</head>
<body>
    <h2>Admin's Information</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Email</th>
            <th>Actions</th>
        </tr>

        <?php
        $users_set = find_all_users();

        if ($users_set && mysqli_num_rows($users_set) > 0) {
            while ($users = mysqli_fetch_assoc($users_set)) {
                echo "<tr>";
                echo "<td>" . $users["id"] . "</td>";
                echo "<td>" . $users["username"] . "</td>";
                echo "<td>" . $users["email"] . "</td>";
                echo "<td class='action-links'>
                        <a href='editUsers.php?id=" . $users["id"] . "'>Edit</a>
                        <a href='deleteUser.php?id=" . $users["id"] . "'>Delete</a>
                      </td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='4'>No users found</td></tr>";
        }
        ?>
    </table>

<?php
// require_once('footer.php');
db_disconnect($db);
?>
</body>
</html>
