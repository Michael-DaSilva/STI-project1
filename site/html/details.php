<?php
    session_start();
    if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] === false){
        header('location: login.php');
    }

    include("utils.php");

    try {
        $message = $db->query("SELECT messageDate, sender, subject, messageContent FROM messages WHERE id=".$_GET['id'])->fetch();
    } catch(PDOException $e){
        echo $e->getMessage();
    }
?>
<table>
    <tr>
        <th>Date de reception:</th>
        <td><?php echo $message['messageDate'];?></td>
    </tr>
    <tr>
        <th>Expediteur:</th>
        <td><?php echo $message['sender'];?></td>
    </tr>
    <tr>
        <th>Sujet:</th>
        <td><?php echo $message['subject'];?></td>
    </tr>
    <tr>
        <th>Message:</th>
        <td><pre><?php echo $message['messageContent']?></pre></td>
    </tr>
</table>
<a href="newEmail.php?id=<?php echo $_GET['id'] ?>">Repondre</a><br/>
<a href="delMessage.php?id=<?php echo $_GET['id']?>">Supprimer</a><br/>
<a href="index.php">Retour</a>