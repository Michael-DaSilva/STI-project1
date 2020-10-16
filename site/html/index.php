<?php
    session_start();
    if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] === false){
        header('location: login.php');
    }
    include("utils.php");

    try {
        $messages = $db->query("SELECT id, messageDate, sender, subject FROM messages WHERE receiver =".'"'.$_SESSION['username'].'" ORDER BY messageDate DESC, sender');
    } catch(PDOException $e){
        echo $e->getMessage();
    }
?>
<?php if($_SESSION['isAdmin'] === true)
    echo '<a href="manageUser.php">'."Gestion d'utilisateur".'</a><br/>'
?>
<a href="profil.php">Profil</a><br/>
<a href="newEmail.php">Nouveau message</a>
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
            <th>Date</th>
            <th>Expediteur</th>
            <th>Sujet</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
    <?php
    foreach($messages as $m){
        echo "<tr>";
        echo "<td>".$m['messageDate']."</td>";
        echo "<td>".$m['sender']."</td>";
        echo "<td>".$m['subject']."</td>";
        echo "<td>";
        echo "<ul>";
        echo "<li><a href='details.php?id=".$m['id']."'>Details</a></li>";
        echo "<li><a href='newEmail.php?id=".$m['id']."'>Repondre</a></li>";
        echo "<li><a href='delMessage.php?id=".$m['id']."'>Supprimer</a></li>";
        echo "</ul>";
        echo "</td>";
        echo "</tr>";
    }
    ?>
    </tbody>
</table>
<?php if(isset($_SESSION['messageDeleted']) && $_SESSION['messageDeleted'] === true)
    echo "Message supprimé !";
else if(isset($_SESSION['messageDeleted']) && $_SESSION['messageDeleted'] === false)
    echo "Ce message ne peut être supprimer pour le moment.";
unset($_SESSION['messageDeleted']) ?>
<a href="logout.php">Logout</a>
