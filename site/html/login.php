<?php
// index.php
// Date de création : 27/09/2020
// Date de modification : 11/10/20
// Auteur : Michaël da Silva & Nenad Rajic
// Fonction : page de login
// _______________________________
session_start();
include("utils.php");

if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true){
    header('location: index.php');
    exit;
}

$user = $pass = $login = "";
$user_err = $pass_err = "";

if(isset($_POST['submitLogin'])){
    if(!empty($_POST['username'])){
        $user = $_POST['username'];
    } else {
        $user_err = "Nom d'utilisateur requis !";
    }

    if(!empty($_POST['password'])){
        $pass = $_POST['password'];
    } else {
        $pass_err = "Mot de passe incorrect !";
    }

    if(empty($user_err) && empty($pass_err)){
        try {
            $result = $db->query("SELECT * FROM account WHERE username = ".'"'.$user.'"')->fetch();
            $login_exist = !empty($result);

            if($login_exist){
                if($pass === $result['password']){
                    if($result['validity'] == 1){
                        $sql = $db->query("SELECT id FROM role WHERE name = 'Administrateur'")->fetch();
                        $admin_id = $sql['id'];

                        $_SESSION["loggedin"] = true;
                        $_SESSION['username'] = $user;
                        $_SESSION['isAdmin'] = $result['role_id'] == $admin_id ? true : false;
                        $_SESSION['role'] = $_SESSION['isAdmin'] === true ? "Administrateur" : "Collaborateur";

                        header('location: index.php');
                    } else {
                        $user_err = "Compte désactivé !";
                    }
                } else {
                    $pass_err = "Mot de passe incorrect !";
                }
            } else {
                $user_err = "Ce compte n'existe pas.";
            }
        } catch (PDOException $e){
            echo "Error : ".$e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>STI Messagerie</title>

    <link rel="stylesheet" href="../css/bootstrap.min.css">
</head>
<body class="text-center">
    <form>
        <h1 class="h3 mb-3 font-weight-normal">Accéder à STI Messagerie</h1>
        <div class="form-group">
            <label for="usernameID">Nom d'utilisateur</label>
            <input type="text" id="usernameID" name="username" class="form-control" placeholder="Nom d'utilisateur">
            <?php
            if(!empty($user_err)){
                echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                      <strong>Erreur: </strong>'.$user_err.'
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>';
            }
            ?>
        </div>
        <div class="form-group">
            <label for="passwordID" class="sr-only">Mot de passe</label>
            <input type="password" id="passwordID" name="password" class="form-control" placeholder="Mot de passe"><?php echo $pass_err ?>
            <?php
            if(!empty($pass_err)){
                echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                      <strong>Erreur: </strong>'.$pass_err.'
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>';
            }
            ?>
        </div>
        <button type="submit" class="btn btn-primary" formmethod="post" name="submitLogin">Login</button>
    </form>

    <script src="../jquery/jquery.slim.min.js"></script>
    <script src="../js/bootstrap.bundle.min.js"></script>
</body>
</html>