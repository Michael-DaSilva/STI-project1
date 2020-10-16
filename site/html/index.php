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
    include('header.php');
?>
<?php if(isset($_SESSION['messageDeleted']) && $_SESSION['messageDeleted'] === true)
    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                  Message supprimé !
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>';
else if(isset($_SESSION['messageDeleted']) && $_SESSION['messageDeleted'] === false)
    echo '<div class="alert alert-alert alert-dismissible fade show" role="alert">
                  <strong>Erreur: </strong> le message n'."'".'a pas pu être supprimé. Veuillez réessayer plus tard.
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>';
unset($_SESSION['messageDeleted']) ?>
<table id="t01" class="table">
    <thead class="thead-light">
        <tr>
            <th scope="col">Date</th>
            <th scope="col">Expediteur</th>
            <th scope="col">Sujet</th>
            <th scope="col">Actions</th>
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
        echo '<div class="btn-group-vertical btn-group-sm btn-outline-dark pt-1">
                <a href="details.php?id='.$m['id'].'" class="btn btn-secondary" role="button">Details</a>
                <a href="newEmail.php?id='.$m['id'].'" class="btn btn-secondary" role="button">Repondre</a>
                <a href="delMessage.php?id='.$m['id'].'" class="btn btn-secondary" role="button">Supprimer</a>
            </div>';
        echo "</td>";
        echo "</tr>";
    }
    ?>
    </tbody>
</table>
<?php include('footer.php');?>
