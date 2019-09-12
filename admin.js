$(document).ready(function() {

    let nom_piz = '';
    let taille_piz = '';
    let description_piz = '';
    let prix_piz = 0.0;
    let image_url_piz = '';
    let seuil_fidelite = 0;
    let pourcent_reduction = 0;
    let ausweis = null;
    
        $('#validate1').click(function() {

            ausweis = 0;
            nom_piz = $('#ecriture').val();
            taille_piz = $('#taillepizza').val();
            description_piz = $('#desctext').val();
            prix_piz = $('#prix1').val();
            image_url_piz = $('#imgpizza').val();

            if (nom_piz == '') {$('#ecriture').addClass('badentry'); ausweis = 0;}
                else {ausweis++; $('#ecriture').removeClass('badentry');}
            
            if (taille_piz == '') {$('#taillepizza').addClass('badentry'); ausweis = 0;}
                else {ausweis++; $('#taillepizza').removeClass('badentry');}
            
            if (description_piz == '') {$('#desctext').addClass('badentry'); ausweis = 0;}
                else {ausweis++; $('#desctext').removeClass('badentry');}

            if (prix_piz == '') {$('#prix1').addClass('badentry'); ausweis = 0;}
                else {ausweis++; $('#prix1').removeClass('badentry');}

            if (image_url_piz == '') {$('#imgpizza').addClass('badentry'); ausweis = 0;}
                else {ausweis++; $('#imgpizza').removeClass('badentry');}

            if (ausweis == 5) {
                addpizza(nom_piz, taille_piz, description_piz, prix_piz, image_url_piz);
            }
                else {alert("Formulaire invalide, wtf, call the police!");}
        });

        function addpizza(nom, taille, descri, prix, image) {

            console.log(nom);
            console.log(taille);
            console.log(descri);
            console.log(prix);
            console.log(image);

            $.ajax({
                url: "http://localhost/modifypizza.php",
                type: 'POST',
                data: {bcknom: nom, bcktaille: taille, bckdescri: descri, bckprix: prix, bckimage: image},
                success: myHandler,
                error: function () {
                    alert("Something's rotten in the Kingdom... Impossible de créer la pizza...");
                }
            });

            function myHandler (result) {
                alert(result);
            }
        }

        $('#validate2').click(function() {

            ausweis = 0;
            seuil_fidelite = $('#nbrpizza').val();
            pourcent_reduction = $('#pourcentage').val();

            if (seuil_fidelite == '') {$('#nbrpizza').addClass('badentry'); ausweis = 0;}
                else {ausweis++; $('#nbrpizza').removeClass('badentry');}
            
            if (pourcent_reduction == '') {$('#pourcentage').addClass('badentry'); ausweis = 0;}
                else {ausweis++; $('#pourcentage').removeClass('badentry');}

            if (ausweis == 2) {
                changeconfig(seuil_fidelite, pourcent_reduction);
            }
                else {alert("Formulaire invalide, wtf, call fbi!");}
        });

        function changeconfig(seuilfidelite, pourcentreduction) {

            console.log(seuilfidelite);
            console.log(pourcentreduction);
            
            $.ajax({
                url: "http://localhost/setreductionseuil.php",
                type: 'POST',
                data: {bckseuil: seuilfidelite, bckpourc: pourcentreduction},
                success: myHandler,
                error: function () {
                    alert("Something's rotten in the Kingdom... Impossible de modifier la configuration...");
                }
            });

            function myHandler (result) {
                alert(result);
            }
        }
});