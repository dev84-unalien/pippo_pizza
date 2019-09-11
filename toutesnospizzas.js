// Au lancement de la page
$(document).ready(function() {
    start();
});

function start() {
    // On fait une requete vers la liste de pizza
    $.ajax({
        url: 'http://localhost:8888/getAllPizza.php',
        type: 'GET',
        success: function success(resultat) {
            // On transforme le JSON recuperé en tableau js
            let pizzas = JSON.parse(resultat);
            // On boucle sur notre tableau de pizza
            for (let i = 0; i < pizzas.length; i++) {
                let pizza = pizzas[i]; // On recup une pizza
                // On l'inject dans le html via append
                $("#liste").append("<img class='image' src='" + pizza.imageUrl + "'>");
            }
        },
        error: function error(erreur) {
            alert(erreur);
        }
    });
}