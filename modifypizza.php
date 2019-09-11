<?php
header("Content-type: text/html; charset=UTF-8");

// Récupération des données de la requête AJAX du formulaire de 'admin.html'

$nom = $_POST['bcknom'];
$taille = $_POST['bcktaille'];
$description = $_POST['bckdescri'];
$prix = $_POST['bckprix'];
$imageurl = $_POST['bckimage'];

// Vérification de ce que toutes les données ont été transmises

if (!$nom || !$taille || !$description || !$prix || !$imageurl) {
    echo "Il manque des éléments dans le formulaire de création des pizzas!";
    exit(); // Le programme prend fin
}

// Vérification de ce que $prix contient bien une valeur 'float'

if (!filter_var($prix, FILTER_VALIDATE_FLOAT)) {
    echo "Le prix doit être une valeur numérique de type 'float', pour mémoire!";
    exit(); // Le programme prend fin
}

// Vérification et nettoyage de $imageurl, qui doit contenir une url valide

$imageurl = filter_var($imageurl, FILTER_SANITIZE_URL);
if (!filter_var($imageurl, FILTER_VALIDATE_URL)) {
    echo "L'url pour la photo de la pizza n'est pas valide, 'bécile!";
    exit(); // Le programme prend fin
}

// Nettoyage des variables contenant du texte libre

$nom = filter_var($nom, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
$nom = filter_var($nom, FILTER_SANITIZE_SPECIAL_CHARS);
$taille = filter_var($taille, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
$taille = filter_var($taille, FILTER_SANITIZE_SPECIAL_CHARS);
$description = filter_var($description, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
$description = filter_var($description, FILTER_SANITIZE_SPECIAL_CHARS);

// Etablissement d'une connexion à la base de données

$connex = new mysqli("localhost", "root", "", "pizzeria");
if ($connex->connect_error) {
    die("La connexion à la bdd 'pizzeria' a échoué : " . $connex->connect_error);
}

// Forçage du charset UTF-8

$connex->set_charset("utf8");
$connex->query("SET NAMES utf8");

// Préparation de la requête SQL

$requete = $connex->prepare("INSERT INTO pizza (nom, taille, description, prix, image_url) VALUES (?, ?, ?, ?, ?");

// Renseignement des valeurs dynamiques de la requête

$requete->bind_param("sssds", $nom, $taille, $description, $prix, $imageurl);

// Exécution de la requête

$requete->execute();

// Fermeture de la requête et de la connexion

$requete->close();
$connex->close();

echo "La nouvelle pizza a bien été enregistrée dans la base de données!";

?>