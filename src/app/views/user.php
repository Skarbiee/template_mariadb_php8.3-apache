<?php
// Affichage des données utilisateur
if($user){
    echo "<h1>{$user['username']}</h1>";
    echo "<p>Email : {$user['email']}</p>";
} else {
    echo "<p>Aucun utilisateur trouvé.</p>";
}


echo htmlspecialchars($user['name']);  
?>