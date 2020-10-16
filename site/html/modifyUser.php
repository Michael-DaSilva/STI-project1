<?php
    session_start();
    if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] === false){
        header('location: login.php');
    }

    $user = $password = $validity = $role = "";

    include("utils.php");

    if(isset($_POST['submitModifiedUser'])){
        if(!empty($_POST['password'])){
            $db->query("UPDATE account SET password=".'"'.$_POST['password'].'" WHERE username='.'"'.$_SESSION['user'].'"');
        }
        $db->query("UPDATE account SET validity=".$_POST['validity']." WHERE username=".'"'.$_SESSION['user'].'"');
        $db->query("UPDATE account SET role_id=".$_POST['role']." WHERE username=".'"'.$_SESSION['user'].'"');
        unset($_SESSION['user']);
        $_SESSION['userModified'] = true;
        header("location: manageUser.php");
    }

    if(isset($_GET['username'])){
        $checkuser = $db->query("SELECT validity, role_id FROM account WHERE username=".'"'.$_GET['username'].'"')->fetch();
        $user = $_GET['username'];
        $validity = $checkuser['validity'];
        $role = $checkuser['role_id'];
    }
?>

<form method="post">
    Nom d'utilisateur: <?php echo $user; $_SESSION['user'] = $user ?><br>
    Password: <input type="password" name="password"><br>
    Validité du compte: <input type="radio" name="validity" value="1" <?php if($validity == 1) echo "checked"?>>Compte actif   <input type="radio" name="validity" value="0" <?php if($validity == 0) echo "checked"?>>Compte inactif<br/>
    Rôle du compte: <input type="radio" name="role" value="1" <?php if($role == 1) echo "checked"?>>Collaborateur   <input type="radio" name="role" value="2" <?php if($role == 2) echo "checked"?>>Administrateur<br/>
    <input type="submit" name="submitModifiedUser" value="Modifier">
</form>
<a href="manageUser.php">Retour</a>