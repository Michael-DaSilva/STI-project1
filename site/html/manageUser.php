<?php
    session_start();
    if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] === false ){
        header('location: login.php');
    }

    include("utils.php");

    try {
        $users = $db->query("SELECT username FROM account");
    } catch(PDOException $e){
        echo $e->getMessage();
    }
?>
<a href="newUser.php">Créer un nouvel utilisateur</a>
<style>
    #t01 tbody tr:nth-child(even) {
        background-color: #eee;
    }
    #t01 tbody tr:nth-child(odd) {
        background-color: #fff;
    }
    #t01 thead {
        background-color: black;
        color: white;
    }
</style>
<table id="t01">
    <thead>
    <tr>
        <th>Utilisateur</th>
        <th>Actions</th>
    </tr>
    </thead>
    <tbody>
    <?php
    foreach($users as $u){
        echo "<tr>";
        echo "<td>".$u['username']."</td>";
        echo "<td>";
        echo "<ul>";
        echo "<li><a href='modifyUser.php?username=".$u['username']."'>Modifier l'utilisateur</a></li>";
        echo "<li><a href='delUser.php?username=".$u['username']."'>Supprimer l'utilisateur</a></li>";
        echo "</ul>";
        echo "</td>";
        echo "</tr>";
    }
    ?>
    </tbody>
</table>
<?php if(isset($_SESSION['userModified']) && $_SESSION['userModified'] === true)
    echo "<br/>Utilisateur modifié !<br/>";
else if(isset($_SESSION['userModified']) && $_SESSION['userModified'] === false)
    echo "<br/>Erreur: impossible de modifier cet utilisateur.<br/>";
unset($_SESSION['userModified']); ?>

<?php if(isset($_SESSION['userDeleted']) && $_SESSION['userDeleted'] === true)
    echo "<br/>Utilisateur supprimé !<br/>";
else if(isset($_SESSION['userDeleted']) && $_SESSION['userDeleted'] === false)
    echo "<br/>Erreur: impossible de supprimer cet utilisateur.<br/>";
unset($_SESSION['userDeleted']); ?>
<a href="index.php">Retour aux messages</a>
