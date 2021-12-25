<?php
function readUsers($usersDatabase){
    $f = fopen($usersDatabase, 'r');
    $read = fread($f,filesize($usersDatabase));
    $users = explode(PHP_EOL, $read);
    foreach($users as $key => $user){
        $user = explode(':', $user);
        $credentials[$key] = array(
                'user' => $user[0],
                'pass' => $user[1],
                'privlage' => $user[2]
    );
    }
    fclose($f);
    return $credentials;
}
function checkCred($users, $userCredts, $password){
    foreach($users as $key => $user){
        if($user['user'] == $userCredts && $user['pass'] == $password){
            return array(True, $key);
        }
    }
}

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    if(!empty($_POST['user']) && !empty($_POST['pass'])){
        $userCredts = $_POST['user'];
        $password = $_POST['pass'];
        $users = readUsers('users.txt');
        $check = checkCred($users, $userCredts, $password);
        if($check[0]){
            echo "Welcome $userCredts You are ".$users[$check[1]]['privlage'];
        }else{
            echo "Wrong Credts";
        }
    }else{
        echo "user or password is missing";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <form action="" method="POST">
        <input type="text" name="user">
        <input type="password" name="pass">
        <input type="submit" name="submit">
    </form>
</body>
</html>