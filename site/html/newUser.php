<?php
    session_start();
    if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] === false){
        header('location: login.php');
    }

    $user = $password = $validity = $role = "";
    $user_err = $password_err = "";

    include("utils.php");

    if(isset($_POST['submitNewUser'])){
        $checkuser = $db->query("SELECT * FROM account WHERE username=".'"'.$_POST['user'].'"')->fetch();
        if(!empty($_POST['user'])){
            if(!$checkuser){
                $user = $_POST['user'];
            } else {
                $user_err = "Utilisateur déjà existant !";
            }
        } else {
            $user_err = "Nom d'utilisateur requis !";
        }

        if(!empty($_POST['password'])){
            $password = $_POST['password'];
        } else {
            $password_err = "Mot de passe requis !";
        }

        $validity = $_POST['validity'];
        $role = $_POST['role'];

        if(empty($user_err) && empty($password_err)){
            $_SESSION['newUsername'] = $user;
            $_SESSION['newUserpass'] = $password;
            $_SESSION['newUservalidity'] = $validity;
            $_SESSION['newUserrole'] = $role;
        }
        header("location: addUser.php");
    }
?>

<form method="post">
    Nom d'utilisateur: <input type="text" name="user"><?php echo $user_err; ?><br>
    Password: <input type="password" name="password"><?php echo $password_err; ?><br>
    Validité du compte: <input type="radio" name="validity" value="1">Compte actif   <input type="radio" name="validity" value="0" checked>Compte inactif<br/>
    Rôle du compte: <input type="radio" name="role" value="1" checked>Collaborateur   <input type="radio" name="role" value="2">Administrateur<br/>
    <input type="submit" name="submitNewUser" value="Ajouter">
</form>
<?php if(isset($_SESSION['userAdded']) && $_SESSION['userAdded'] === true){
    echo "<h4>Nouvel utilisateur ajouté !</h4>";
    unset($_SESSION['userAdded']);
} ?>
<a href="manageUser.php">Retour</a>