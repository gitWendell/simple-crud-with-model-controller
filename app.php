<?php
include("include/autoload.php");

use app\controller\UserController;

$user = new UserController;

// Create
if(isset($_POST['firstname']) && isset($_POST['lastname']) && isset($_POST['age']) && isset($_POST['create'])) {
    $data = [
        'firstname' => $_POST['firstname'],
        'lastname' => $_POST['lastname'],
        'age' => $_POST['age'],
    ];

    $user->create($data);
}

// Delete
if(isset($_GET['delete'])) $user->delete($_GET['delete']);

// Update
if(isset($_POST['e_firstname']) && isset($_POST['e_lastname']) && isset($_POST['e_age']) && isset($_POST['edit']) && isset($_GET['id'])) {
    $data = [
        'firstname' => $_POST['e_firstname'],
        'lastname' => $_POST['e_lastname'],
        'age' => $_POST['e_age'],
    ];

    $user->update($data, $_GET['id']);
}

// Read
$users = $user->read();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <table>
        <tr>
            <th>ID</th>
            <th>Firstname</th>
            <th>Lastname</th>
            <th>Age</th>
            <th colspan="2">Actions</th>
        </tr>
        <?php foreach($users as $user): ?>
            <form action="app.php?id=<?= $user['id']?>" method="POST">
                <tr>
                    <td><?= $user['id']?></td>
                    <td><input type="text" name="e_firstname" value="<?= $user['firstname']?>"></td>
                    <td><input type="text" name="e_lastname" value="<?= $user['lastname']?>"></td>
                    <td><input type="number" name="e_age" value="<?= $user['age']?>"></td>
                    <td>
                        <button type="submit" name="edit">Edit</button>
                    </td>
                    <td>
                        <a href="app.php?delete=<?=$user['id']?>">Delete</a>
                    </td>
                </tr>
            </form>
        <?php endforeach?>
    </table>
    <form action="app.php" method="POST">
        <label for="">Firstname</label><br/> 
        <input type="text" name="firstname"><br/> 
          
        <label for="">Lastname</label><br/> 
        <input type="text" name="lastname"><br/>  

        <label for="">Age</label><br/> 
        <input type="number" name="age"><br/>   
        <button type="submit" name="create">Submit</button>       
    </form>
</body>
</html>