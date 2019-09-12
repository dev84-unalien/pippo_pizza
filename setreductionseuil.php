<?php

header("Access-Control-Allow-Origin: *"); // Correction erreur CORS

header("Content-type: text/html; charset=UTF-8"); // Forçage du charset UTF-8

// Récupération des données de la requête AJAX du formulaire de 'admin.html'

$seuil_fid = $_POST['bckseuil'];
$pourcent_red = $_POST['bckpourc'];

// Vérification de ce que toutes les données ont été transmises

if (!$seuil_fid || !$pourcent_red) {
    echo "Il manque des éléments dans le formulaire de réglage de la configuration!";
    exit(); // Le programme prend fin
}

// Vérification de ce que $seuil_fid contient bien une valeur entière

if (!filter_var($seuil_fid, FILTER_VALIDATE_INT)) {
    echo "Le seuil de fidélité doit être une valeur numérique de type 'entier', pour mémoire!";
    exit(); // Le programme prend fin
}

// Vérification de ce que $pourcent_red contient bien une valeur entière

if (!filter_var($pourcent_red, FILTER_VALIDATE_INT)) {
    echo "Le pourcentage de réduction doit être une valeur numérique de type 'entier', pour mémoire!";
    exit(); // Le programme prend fin
}

// Etablissement d'une connexion à la base de données

$connex = new mysqli("localhost", "root", "", "pizzeria");
if ($connex->connect_error) {
    die("La connexion à la bdd 'pizzeria' a échoué : " . $connex->connect_error);
}

// Forçage du charset UTF-8

$connex->set_charset("utf8");
$connex->query("SET NAMES utf8");

// Préparation de la requête SQL

$requete = $connex->prepare("UPDATE configuration SET seuil_fidelite = ?, pourcent_reduction = ?");

// Renseignement des valeurs dynamiques de la requête

$requete->bind_param("ii", $seuil_fid, $pourcent_red);

// Exécution de la requête

$requete->execute();

// Fermeture de la requête et de la connexion

$requete->close();
$connex->close();

echo "La configuration a bien été mise à jour dans la base de données!";

?>