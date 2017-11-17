$(document).ready(function () {
    // Cacher la div contenant les horaires
    $('#div-book').hide();

    // Active les menus déroulants
    $('select').material_select();

    // Active les modals
    $('.modal').modal();

    // Active les dropdowns
    $('.dropdown-button').dropdown();

    // Cache les détails de la ligne
    $('[id^="staggered-line-"]').hide();

    // Cacher les détails de la zone
    $('[id^="staggered-zone-"]').hide();

    // Initialisation des tooltips
    $('.tooltipped').tooltip({delay: 50});

    // Initialisation du menu sur le côté
    $(".button-collapse").sideNav();

    // Anime le timepicker
    $('.timepicker').pickatime({
        default: 'now', // Set default time: 'now', '1:30AM', '16:30'
        fromnow: 0,       // set default time to * milliseconds from now (using with default = 'now')
        twelvehour: false, // Use AM/PM or 24-hour format
        donetext: 'OK', // text for done-button
        cleartext: 'Clear', // text for clear-button
        canceltext: 'Cancel', // Text for cancel-button
        autoclose: false, // automatic close timepicker
        ampmclickable: true, // make AM PM clickable
    });

    // Anime le datepicker
    $('.datepicker').pickadate({
        selectMonths: true, // Creates a dropdown to control month
        selectYears: 15, // Creates a dropdown of 15 years to control year,
        today: 'Today',
        clear: 'Clear',
        close: 'Ok',
        closeOnSelect: false // Close upon selecting a date,
    });

    // Affiche ou cache la div pour changer de mot de passe
    $('#rowPass').hide();
    var html = $('#btnChangePass').text();

    // Active le changement de mot de passe
    $('#btnChangePass').click(function () {
        $('#rowPass').toggle();

        if ($('#rowPass').is(':visible')) {
            $('#btnChangePass').html(__("Cancel password change"));
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

    // Cache le select des zones lorsque le role choisi est "Administrateur système"
    $('#select-add-role').change(function () {
        if ($('#select-add-role option:selected').val() == 3) {
            $('#select-add-zone').hide();
        } else {
            $('#select-add-zone').show();
        }
    });

    //Cache le tableau contenant les lignes à ajouter
    $('#table-add-line').hide();

    // Gère la recherche des lignes à ajouter depuis l'API
    $('#searchLine').click(function () {
        var stations = {};
        var inputStart = $('#search-input-startStation').val();
        var inputEnd = $('#search-input-endStation').val();
        getLinesFromApi(inputStart, inputEnd, stations);
    });

    // Gère l'autocompletion depuis l'API
    $('.autocompleteApi').on("input", function () {
        var stations = {};
        var input = $(this).val();
        autocompletionFromApi(input, stations);
    });

    // Gère l'autocompletion depuis la DB
    $('.autocompleteDB').on("input", function () {
        var stations = {};
        var input = $(this).val();
        autocompletionFromDB(input, stations);
    });

    // Cache le tableau contenant les horaires
    $('#div-timetable').hide();

    // Active le bouton de recherche lorsque tous les champs sont remplis
    $('#input-book-from, #input-from-to').on("input", enableSearchButton);
    $('#input-book-date, #input-book-hour').on("change", enableSearchButton);

    //Affiche le tableau des horaires lorsqu'on clique sur le bouton
    $('#btn-search-timetable').click(function () {
        var from = $('#input-book-from').val();
        var to = $('#input-book-to').val();
        var oldDate = $('#input-book-date').val();
        var hour = $('#input-book-hour').val();

        var date = myDateFormatter(oldDate);

        getTimetableFromApi(from, to, date, hour);
    });

    // Accepte une réservation
    $('[id^="btn-acceptBook-"]').click(function () {
        var id = this.id.replace(/^\D+/g, '');
        $.ajax({
            url: ABSURL+'/books/acceptBook',
            data: {
                'id': id,
                'accepted': $(this).data('accepted')
            },
            type: 'Get',
            success: function (result) {
                var idLabel = "#td-manageBook-" + id;
                $(idLabel).html(result);
            }
        });
    });

    // Refuse une réservation
    $('[id^="btn-denyBook-"]').click(function () {
        var id = this.id.replace(/^\D+/g, '');
        $.ajax({
            url: ABSURL+'/books/denyBook',
            data: {
                'id': id,
                'accepted': $(this).data('accepted')
            },
            type: 'Get',
            success: function (result) {
                var idLabel = "#td-manageBook-" + id;
                console.log(result);
                $(idLabel).html(result);
            }
        });
    })
});

/**
 * Méthode pour activant le bouton de recherche de réservation lorsque tous les champs sont remplis
 */
function enableSearchButton() {
    if ($('#input-book-from').val() != "" && $('#input-book-to').val() != "" && $('#input-book-date').val() != "" && $('#input-book-hour').val() != "") {
        $('#btn-search-timetable').removeClass('disabled');
    } else {
        $('#btn-search-timetable').addClass('disabled');
    }
}

/**
 * Méthode permettant l'autocompletion depuis la base de données en fonction de la valeur entrée
 * @param input     La valeur entrée dans le champ
 * @param stations  La liste des stations
 */
function autocompletionFromDB(input, stations) {
    $.ajax({
        url: ABSURL+'/index/getStations',
        data: {
            'input': input
        },
        type: 'GET',
        success: function (resultJSON) {
            var result = JSON.parse(resultJSON);

            $.each(result, function (id, val) {
                stations[val.name] = null;
            });

            $('input.autocompleteDB').autocomplete({
                data: stations,
                limit: 5, // The max amount of results that can be shown at once. Default: Infinity.
                minLength: 1, // The minimum length of the input for the autocomplete to start. Default: 1.
            });
        }
    });
}

/**
 * Méthode permettant l'autocompletion depuis l'API en fonction de la valeur entrée
 * @param input     La valeur entrée dans le champ
 * @param stations  La liste des stations
 */
function autocompletionFromApi(input, stations) {
    $.ajax({
        url: "https://timetable.search.ch/api/completion.en.json?nofavorites=0&term=" + input,
        type: 'Get',
        dataType: 'json',
        success: function (result) {

            $.each(result, function (id, val) {
                stations[val.label] = null;
            });

            $('input.autocompleteApi').autocomplete({
                data: stations,
                limit: 5, // The max amount of results that can be shown at once. Default: Infinity.
                minLength: 1, // The minimum length of the input for the autocomplete to start. Default: 1.
            });
        }
    })
}

/**
 * Méthode permettant de récupérer les horaires depuis l'API en fonction de la station de départ,
 * d'arrivée, de la date et de l'heure
 * @param from      Station de départ
 * @param to        Station d'arrivée
 * @param date      Date de départ
 * @param hour      Heure de départ
 */
function getTimetableFromApi(from, to, date, hour) {
    // from = 'Sierre, poste/gare';
    // to = 'Vissoie, poste';
    // date = '10/17/2017';
    // hour = '14:30';
    var arrHour = hour.split(':');
    if (arrHour[0] == 23)
        hour = '00:' + arrHour[1];
    else
        hour = (Number(arrHour[0]) + 1) + ':' + arrHour[1];

    $.ajax({
        url: "https://timetable.search.ch/api/route.en.json?from=" + from + "&to=" + to + "&date=" + date + "&time=" + hour,
        type: 'Get',
        dataType: 'json',
        success: function (result) {
            var trip = [];
            for (var i = 0; i < result.connections.length; i++) {
                var lines = [];
                for (var j = 0; j < result.connections[i].legs.length; j++) {
                    var leg = result.connections[i].legs[j];
                    if (leg.type == "bus" || leg.type == "post") {
                        lines.push(leg.line);
                        var from = result.connections[i].legs[0].name;
                        var to = leg.exit.name;
                        var departure = result.connections[i].legs[0].departure;
                        var arrival = leg.exit.arrival;
                    }

                    var legDetails = {
                        lines: lines,
                        from: from,
                        to: to,
                        departure: departure,
                        arrival: arrival
                    }
                }

                trip.push(legDetails);
            }

            fillHoursTab(trip);
            $('#p-warning').hide();
            $('#div-timetable').show();
        }
    })
}

/**
 * Méthode permettant de remplir le tableau de horaires
 * @param trips     Horaires récupérés par la méthode getTimetableFromApi
 */
function fillHoursTab(trips) {
    var html = "";

    for (var i = 0; i < trips.length; i++) {
        getNbBikes(trips, i);
        html +=
            '<tr>' +
            '<td>' + trips[i].from + '</td>' +
            '<td>' + trips[i].to + '</td>' +
            '<td>' + trips[i].departure + '</td>' +
            '<td>' + trips[i].arrival + '</td>' +
            '<td id="nbBikes-' + i + '"></td>' +
            '<td><button type="button" class="waves-effect waves-light btn resa-btn" id="btn-book-' + i + '">' + __("Book") + '</button></td>' +
            '</tr>';

        $('#tbody-timetable').html(html);

        $('[id^="btn-book-"]').click(function () {
            var id = this.id.substring(this.id.length - 1, this.id.length);
            formHtml = '' +
                '<form id="form-book" method="post" action="'+ABSURL+'/index/booking">' +
                '<input type="text" name="from" value="' + trips[id].from + '">' +
                '<input type="text" name="to" value="' + trips[id].to + '">' +
                '<input type="text" name="departure" value="' + trips[id].departure + '">' +
                '<input type="text" name="arrival" value="' + trips[id].arrival + '">' +
                '<input type="text" name="lines" value="' + trips[id].lines.join(';') + '">' +
                '<button type="submit" name="submitBook" id="submit-book"></button>' +
                '</form>';

            $('#div-book').html(formHtml);
            $('#submit-book').click();
        });
    }
}

/**
 * Méthode permettant de compter le nombre de vélos déjà réservés sur un trajet
 * @param trips     Horaires récupérés par la méthode getTimetableFromApi
 * @param i         Index représentant la réservation pour laquelle on recherche le nombre de vélos
 */
function getNbBikes(trips, i) {
    $.ajax({
        url: ABSURL+'/index/getNbBikes',
        data: {
            'lines': trips[i].lines.join(';'),
            'departure': trips[i].departure,
            'from': trips[i].from
        },
        type: 'GET',
        success: function (result) {
            var resultToDisplay = 6 - result;
            var text = "";
            if (resultToDisplay <= 0) {
                resultToDisplay = 0;
                text = resultToDisplay + ' <i class="tiny material-icons tooltipped resa-i-warning">warning</i>';
                if ($('#p-warning').hide())
                    $('#p-warning').show();
            } else {
                text = resultToDisplay;
            }
            document.getElementById('nbBikes-' + i).innerHTML = text;
        }
    });
}

/**
 * Méthode permettant la récupération des lignes depuis l'API
 * @param inputStart
 * @param inputEnd
 * @param stations
 */
function getLinesFromApi(inputStart, inputEnd, stations) {
    // inputStart = "Sierre, poste/gare";
    // inputEnd = "Montana, Barzettes";
    inputStart = inputStart.replace(" ", "%20");
    inputEnd = inputEnd.replace(" ", "%20");
    //Première requête ajax, on affiche les trajets entre inputStart et inputEnd
    $.ajax({
        url: "https://timetable.search.ch/api/route.en.json?from=" + inputStart + "&to=" + inputEnd,
        type: 'Get',
        dataType: 'json',
        success: function (result) {
            var html = $('#tbody-add-line').html("");
            var i = 0;
            var index = 0;
            //Boucle sur tous les legs contenant bus et post
            $.each(result.connections[0].legs, function (id, val) {
                if (val.type == "bus" || val.type == "post") {
                    var start = "";
                    //Deuxième requête ajax, on récupère le nom du terminal
                    $.ajax({
                        url: 'https://timetable.search.ch/api/stationboard.en.json?stop=' + val.terminal.replace(" ", "%20"),
                        dataType: 'json',
                        type: 'GET',
                        success: function (result) {
                            start = result.connections[0].terminal.name;
                            $.ajax({
                                url: "https://timetable.search.ch/api/route.en.json?from=" + start + "&to=" + inputEnd,
                                dataType: 'json',
                                type: 'GET',
                                success: function (resultat) {
                                    $.each(resultat.connections[0].legs, function (id, value) {
                                        if (value.type == "bus" || value.type == "post") {
                                            //Récupération de
                                            stations[index] = {};
                                            //numéro de ligne
                                            stations[index]["line"] = value.line;
                                            //noms arrêts intermédiaires
                                            stations[index]["stops"] = [];
                                            var j = 0;
                                            $.each(resultat.connections[0].legs[0].stops, function (id, value) {
                                                stations[index]["stops"][j] = value.name;
                                                j++;
                                            });
                                            // nom arrêt départ
                                            stations[index]["name"] = value.name;
                                            //nom arrêt de fin
                                            stations[index]["terminal"] = value.terminal;

                                            var idString = stations[index]["line"] + '-' + getParameterByName('zone');

                                            //Création des lignes du tableau
                                            html = $('#tbody-add-line').html();
                                            $('#tbody-add-line').html(html +
                                                '<tr>' +
                                                '<td>' + stations[index]["line"] + '</td>' +
                                                '<td>' + stations[index]["name"] + '</td>' +
                                                '<td>' + stations[index]["terminal"] + '</td>' +
                                                '<td id="td-addLine-' + idString + '">' +
                                                '<a href="#" class="waves-effect waves-light btn resa-btn" id="btn-addLine-' + idString + '" ' +
                                                'data-id="' + stations[index]["line"] + '" data-start="' + stations[index]["name"] + '" ' +
                                                'data-stops="' + stations[index]["stops"].join(";") + '" data-end="' + stations[index]["terminal"] + '" ' +
                                                'data-zone="' + getParameterByName('zone') + '">' + __("Add") +
                                                '</a>' +
                                                '</td>' +
                                                '</tr>'
                                            );

                                            //Clic sur le bouton d'ajout
                                            $('[id^="btn-addLine-"]').click(function () {
                                                $.ajax({
                                                    url: ABSURL+'/lines/addLine',
                                                    data: {
                                                        'id': $(this).data('id'),
                                                        'startStation': $(this).data('start'),
                                                        'stops': $(this).data('stops'),
                                                        'endStation': $(this).data('end'),
                                                        'idZone': $(this).data('zone')
                                                    },
                                                    type: 'GET'
                                                }).done(function (res) {
                                                    var idLabel = "#td-addLine-" + idString;
                                                    $(idLabel).html(res);
                                                })
                                            });

                                            index++;
                                        }
                                    });
                                }
                            });
                        }
                    });
                }
                i++;
            });

            // Affiche le tableau d'ajout des lignes
            $('#table-add-line').show();
        }
    })
}

// Méthode permettant de récupérer un paramètre dans l'URL
function getParameterByName(name, url) {
    if (!url) url = window.location.href;
    name = name.replace(/[\[\]]/g, "\\$&");
    var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
        results = regex.exec(url);
    if (!results) return null;
    if (!results[2]) return '';
    return decodeURIComponent(results[2].replace(/\+/g, " "));
}

function myDateFormatter(dateToConvert) {
    var d = new Date(dateToConvert);
    var day = d.getDate();
    var month = d.getMonth() + 1;
    var year = d.getFullYear();
    if (day < 10) {
        day = "0" + day;
    }
    if (month < 10) {
        month = "0" + month;
    }
    var date = month + "/" + day + "/" + year;

    return date;
};

