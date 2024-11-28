<?php
    require('./read-admin.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Index</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .main {
            width: 90%;
            max-width: 1200px;
            background: #fff;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            padding: 20px;
        }

        .create-main {
            background-color: #e3f2fd;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 30px;
            text-align: center;
        }

        .create-main h3 {
            font-size: 24px;
            color: #1976d2;
            margin-bottom: 20px;
        }

        .create-main input[type="text"],
        .create-main input[type="email"],
        .create-main input[type="password"],
        .create-main input[type="submit"] {
            display: block;
            width: 80%;
            max-width: 400px;
            margin: 10px auto;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        .create-main input[type="submit"] {
            background-color: #1976d2;
            color: #fff;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .create-main input[type="submit"]:hover {
            background-color: #155a9d;
        }

        .read-main {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
        }

        .read-main th, .read-main td {
            padding: 15px;
            border-bottom: 1px solid #ddd;
        }

        .read-main th {
            background-color: #1976d2;
            color: #fff;
        }

        .read-main tr:hover {
            background-color: #f1f1f1;
        }

        .read-main td {
            font-size: 14px;
        }

        .read-main form {
            display: inline-block;
        }

        .read-main input[type="submit"] {
            background-color: #d32f2f;
            color: #fff;
            border: none;
            padding: 5px 10px;
            font-size: 14px;
            cursor: pointer;
            border-radius: 5px;
            margin: 2px;
        }

        .read-main input[type="submit"]:hover {
            background-color: #b71c1c;
        }

        .read-main input[name="edit"] {
            background-color: #0288d1;
        }

        .read-main input[name="edit"]:hover {
            background-color: #01579b;
        }
    </style>
    </style>
</head>
<body>
    <div class="main">
        <form class="create-main" action="create-admin.php" method="post">
            <h3>Create Client User</h3>
            <input type="text" name="name" placeholder="Fullname"/>
            <input type="email" name="email" placeholder="Email Address"/>
            <input type="password" name="password" placeholder="Password"/>
            <input type="submit" name="create" value="Create Client Account"/>
        </form>

        <table class="read-main">
            <tr>
                <th>User ID</th>
                <th>Fullname</th>
                <th>Email Address</th>
                <th>Password Hash</th>
                <th>Actions</th>
            </tr>
            <?php while($results = mysqli_fetch_array($sqlAccounts)) {  ?>
            <tr>
                <td><?php echo $results['id']?></td>
                <td><?php echo $results['fullname']?></td>
                <td><?php echo $results['email']?></td>
                <td><?php echo $results['password_hash']?></td>
                <td>
                    <form action="update-admin.php" method="post">
                        <input type="submit" name="edit" value="Edit">
                        <input type="hidden" name="editId" value="<?php echo $results['id'] ?>">
                        <input type="hidden" name="editFullname" value="<?php echo $results['fullname'] ?>">
                        <input type="hidden" name="editEmail" value="<?php echo $results['email'] ?>">
                        <input type="hidden" name="editPassword" value="<?php echo $results['password_hash'] ?>">
                    </form>
                    <form action="delete-admin.php" method="post">
                        <input type="submit" name="delete" value="Delete">
                        <input type="hidden" name="deleteId" value="<?php echo $results['id'] ?>">
                    </form>
                </td>
            </tr>
            <?php } ?>
        </table>   
    </div>
</body>
</html>