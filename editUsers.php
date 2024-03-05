<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User Information</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        .container {
            max-width: 500px;
            margin: 50px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            margin-top: 0;
            color: #333;
        }

        label {
            font-weight: bold;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        input[type="submit"],
        button {
            background-color: #4caf50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-right: 10px;
        }

        button {
            background-color: #f44336;
        }

        a {
            color: #4caf50;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Edit User Information</h2>
        <form action="editUsers.php?id=<?php echo $user_id; ?>" method="post">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" value="<?php echo isset($user['username']) ? $user['username'] : ''; ?>" required><br><br>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo isset($user['email']) ? $user['email'] : ''; ?>" required><br><br>
            <label for="old_password">Old Password:</label>
            <input type="password" id="old_password" name="old_password" required><br><br>
            <label for="password">New Password:</label>
            <input type="password" id="password" name="password" required><br><br>
            <h2>Are you sure you want to Update?</h2>
            <input type="submit" name="submit" value="Update">
            <button type='button' onclick='history.go(-1)'>No</button>
        </form>
    </div>
</body>
</html>
