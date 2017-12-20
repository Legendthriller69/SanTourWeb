$(document).ready(function () {
    // Active les menus déroulants
    $('select').material_select();

    // Active les modals
    $('.modal').modal();

    // Active les dropdowns
    $('.dropdown-button').dropdown();

    // Cache les détails de la ligne
    $('[id^="staggered-pod-"]').hide();
    $('[id^="staggered-poi-"]').hide();

    // Initialisation des tooltips
    $('.tooltipped').tooltip({delay: 50});

    // Initialisation du menu sur le côté
    $(".button-collapse").sideNav();

    // Affiche ou cache la div pour changer de mot de passe
    $('#rowPass').hide();
    var html = $('#btnChangePass').text();

    // Active le changement de mot de passe
    $('#btnChangePass').click(function () {
        $('#rowPass').toggle();

        if ($('#rowPass').is(':visible')) {
            $('#btnChangePass').html(__('Cancel password change'));
            $('#changePass').val('true');
            $('#password').attr('required', 'required');
            $('#passwordConf').attr('required', 'required');
        } else {
            $('#btnChangePass').html(html);
            $('#changePass').val('false');
            $('#password').removeAttr('required');
            $('#passwordConf').removeAttr('required');
        }
    });
});

