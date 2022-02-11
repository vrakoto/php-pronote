$(function () {
    const url = window.location.pathname;
    if (url === '/etablissement') {
        getMesEtablissements();
    } else if (url === '/professeurs') {
        getLesProfesseurs();
    }
});

function messageModal(titre, message) {
    $('#message').modal('show');
    $('#message .modal-title').text(titre);
    $('#message .modal-body').text(message);
}

var idEtablissementSelectionner;

function getMesEtablissements() {
    $.ajax(
        {
            method: 'post',
            url: 'ajax/getMesEtablissements',
            success: (e) => {
                $('#mesEtablissements').empty();
                $('#mesEtablissements').append(e);
            },
            error: (e) => {
                messageModal("Erreur internal", "Erreur lors de la récupération de mes établissements")
            }
        }
    )
}

function getInfosEtablissement(idEtablissement) {
    idEtablissementSelectionner = idEtablissement;
    $.ajax(
        {
            method: 'get',
            url: 'ajax/getInfosEtablissement',
            data: 'idEtablissement=' + idEtablissement,
            success: (datas) => {
                const infos = JSON.parse(datas);
                const nom = infos.nom;
                const effectif = infos.effectif;
                const description = infos.description;
                const acces = infos.acces;

                // affiche btn supprimer etablissement
                $("#supprimerEtablissement").css("display", "inline-block");

                // affiche les cartes
                $('#cartesEtablissement').css("transform", "translateX(0)");
                
                // Modification textuelle
                $('#changerNom').val(nom);
                $('#changerEffectif').val(effectif);
                $('#changerDescription').val(description);

                // option accès
                if (acces === 'tous') {
                    $("#accesTous").prop("checked", true);
                } else if (acces === 'invitation') {
                    $("#accesInvitation").prop("checked", true);
                } else if (acces === 'selectivement') {
                    $("#accesSelection").prop("checked", true);
                }
            },
            error: (e) => {
                messageModal("Erreur internal", "Erreur lors de la récupération des informations de l'établissement");
            }
        }
    )
}

function creerEtablissement() {
    const nom = $('#nomEtablissement');
    const effectif = $('#effectif');

    $.ajax(
        {
            method: 'post',
            url: 'ajax/creerEtablissement',
            data: 'nom=' + nom.val() + '&effectif=' + effectif.val(),
            success: (e) => {
                const errors = JSON.parse(e).erreurs;
                if (errors.length <= 0) {
                    nom.val('');
                    effectif.val('');
                    getMesEtablissements();
                } else {
                    messageModal("Erreur saisie", "Erreur lors de la création de l'établissement : Le nom ne doit pas être inférieur à 2 caractères et l'effectif doit être entre 1 et 5000");
                }
            },
            error: (e) => {
                messageModal("Erreur internal", "Erreur lors de la création de l'établissement");
            }
        }
    )
}

function supprimerEtablissement() {
    $.ajax(
        {
            method: 'post',
            url: 'ajax/supprimerEtablissement',
            data: 'idEtablissement=' + idEtablissementSelectionner,
            success: (e) => {
                const errors = JSON.parse(e).erreurs;
                if (errors.length <= 0) {
                    getMesEtablissements();
                } else {
                    messageModal("Erreur saisie", "Erreur lors de la création de l'établissement : Le nom ne doit pas être inférieur à 2 caractères et l'effectif doit être entre 1 et 5000");
                }
            },
            error: (e) => {
                messageModal("Erreur internal", "Erreur lors de la création de l'établissement");
            }
        }
    )
}

function modifierTextuelleEtablissement() {
    const nom = $('#changerNom');
    const effectif = $('#changerEffectif');
    const description = $('#changerDescription');

    $.ajax(
        {
            method: 'post',
            url: 'ajax/modifierTextuelleEtablissement',
            data: 'id=' + idEtablissementSelectionner + '&nom=' + nom.val() + '&effectif=' + effectif.val() + '&description=' + description.val(),
            success: (e) => {
                const errors = JSON.parse(e).erreurs;
                if (!$.isArray(errors)) {
                    messageModal("Erreur saisie", "Erreur lors de la modification textuelle de l'établissement");
                } else {
                    getMesEtablissements();
                }
            },
            error: (e) => {
                messageModal("Erreur internal", "Erreur lors de la modification textuelle établissement");
            }
        }
    )
}

function modifierOptionsEtablissement() {
    const checkedOption = $('input:radio:checked').val();

    $.ajax(
        {
            method: 'post',
            url: 'ajax/modifierOptionsEtablissement',
            data: 'idEtablissement=' + idEtablissementSelectionner + '&option=' + checkedOption,
            success: (e) => {
                const errors = JSON.parse(e).erreurs;
                if (!$.isArray(errors)) {
                    messageModal("Erreur saisie", "Erreur lors de la modification d'intégration de l'établissement");
                }
            },
            error: (e) => {
                messageModal("Erreur internal", "Erreur modification options établissement");
            }
        }
    )
}




/* Partie Professeur */
var idProfesseurSelectionner;
function getLesProfesseurs() {
    $.ajax(
        {
            method: 'post',
            url: 'ajax/getLesProfesseurs',
            success: (e) => {
                $('#lesProfesseursAjoutes').empty();
                $('#lesProfesseursAjoutes').append(e);

                /* $('#lesProfesseursAttente').empty();
                $('#lesProfesseursAttente').append(e); */
                console.log(e);
            },
            error: (e) => {
                messageModal("Erreur internal", "Erreur lors des professeurs")
            }
        }
    )
}

function getInfosProfesseursAjoutes() {
    idProfesseurSelectionner = idProfesseur;
    $.ajax(
        {
            method: 'get',
            url: 'ajax/getInfosProfesseursAjoutes',
            data: 'idProfesseur=' + idProfesseur,
            success: (datas) => {
                const infos = JSON.parse(datas);
                const prenom = infos.prenom;
                const nom = infos.nom;
                const age = infos.age;
                const specialite = infos.specialite;
                console.log(infos);
            },
            error: (e) => {
                messageModal("Erreur internal", "Erreur lors de la récupération des professeurs");
            }
        }
    )
}