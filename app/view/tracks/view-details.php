<div class="container">
    <div class="san-title">
        <h5><?php __("Details about the track : ");
            echo '"' . $track->getName() . '"'; ?></h5>
        <a class="waves-effect waves-light btn btn-large san-btn san-btn-title"
           href="<?php echo ABSURL; ?>/tracks/export"><?php __("Export the track"); ?></a>
    </div>
    <div class="row">
        <form class="col s12" method="post">
            <div class="row">
                <div class="col s12 san-bold-span">
                    <div class="row">
                        <div class="col s12">
                            <div id="san-map"></div>
                            <div id="legend"><h5><?php echo __('Legend'); ?></h5></div>
                        </div>
                    </div>
                    <br/>
                    <?php
                    $html = '
                    <div class="row">
                          <div class="col s12 m6 l3 san-row-tracks-info">
                               <span>' . __("Type", true) . ' :</span> ' . $type->getName() . '
                          </div>
                         <div class="col s12 m6 l3 san-row-tracks-info">
                              <span>' . __("Tracker", true) . ' :</span> ' . $user->getUsername() . '
                         </div>
                          <div class="col s12 m6 l3 san-row-tracks-info">
                              <span>' . __("Distance", true) . ' :</span> ' . round_distance($track->getDistance()) . '
                          </div>
                          <div class="col s12 m6 l3 san-row-tracks-info">
                               <span>' . __("Duration", true) . ' :</span> ' . '10' . ' ' . __('minutes', true) . '
                          </div>
                         <div class="col s12 m6 l3 san-row-tracks-info">
                              <span>' . __("Description", true) . ' :</span> ' . $track->getDescription() . '
                         </div>
                    </div>
                    <br />
                    <div class="row">
                        <div class="col s12">
                            <ul id="tabs-swipe-demo" class="tabs san-tabs">
                                <li class="tab col s6"><a class="active"  href="#swipe-pod">' . __('Points of danger', true) . '</a></li>
                                <li class="tab col s6"><a href="#swipe-poi">' . __('Points of interest', true) . '</a></li>
                            </ul>
                            <div id="swipe-pod" class="col s12 san-swipe">
                                <table class="san-table-points bordered">
                                    <thead>
                                        <tr>
                                            <th>' . __("Name", true) . '</th>
                                            <th>' . __("Description", true) . '</th>
                                        </tr>
                                    </thead>
                                    <tbody>';
                    $i = 0;
                    if ($track->getPods() != null) {
                        foreach ($track->getPods() as $pod) {
                            $html .= '
                                <!-- Show details -->
                                <script>
                                    $(document).ready(function() {
                                        $("#tr-pod-' . $i . '").click(function() {
                                            $("#staggered-pod-' . $i . '").toggle();
                                        });
                                    });
                                </script>
                                
                                <tr id="tr-pod-' . $i . '">
                                    <td>' . $pod->getName() . '</td>
                                    <td>' . $pod->getDescription() . '</td>
                                </tr>
                                
                                <!-- Details -->
                                <tr id="staggered-pod-' . $i . '">
                                    <td colspan="2" class="zone-details-td">
                                        <table>
                                            <tbody>
                                            <tr>
                                                <td colspan="3" class="center-align">
                                                    <img src="https://firebasestorage.googleapis.com/v0/b/santour-e9abc.appspot.com/o/' . $pod->getPicture() . '?alt=media" width="300" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>' . __('Name', true) . ': ' . $pod->getName() . '</td>
                                                <td>' . __('Description', true) . ': ' . $pod->getDescription() . '</td>
                                                <td>' . __('Date', true) . ': ' . strftime('%e %b %Y %H:%m', strtotime($pod->getPosition()->getDateTime())) . '</td>
                                            </tr>
                                            <tr>
                                                <td>' . __('Latitude', true) . ': ' . $pod->getPosition()->getLatitude() . '</td>
                                                <td>' . __('Longitude', true) . ': ' . $pod->getPosition()->getLongitude() . '</td>
                                                <td>' . __('Altitude', true) . ': ' . $pod->getPosition()->getAltitude() . 'm</td>
                                            </tr>
                                            <tr>
                                                <td colspan="3">
                                                    <table>
                                                        <thead>
                                                        <tr>
                                                            <th>' . __('Name', true) . '</th>
                                                            <th>' . __('Value', true) . '</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>';
                            $indexCat = 0;
                            foreach ($pod->getPodCategories() as $category) {

                                $html .= '
                                                            <tr>
                                                                <td>' . $categories[$indexCat]->getName() . '</td>
                                                                <td>' . $category->getValue() . '</td>
                                                            </tr>';
                                $indexCat++;
                            }
                            $html .= '
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            ';
                            $i++;
                        }
                    } else {
                        $html .= '<tr><td colspan="2" class="san-empty-table">' . __("No POD for this track", true) . '</td></tr>';
                    }
                    $html .= '
                                        </tbody>
                                    </table>
                                </div>
                                <div id="swipe-poi" class="col s12 san-swipe">
                                <table class="san-table-points bordered">
                                    <thead>
                                        <tr>
                                            <th>' . __("Name", true) . '</th>
                                            <th>' . __("Description", true) . '</th>
                                        </tr>
                                    </thead>
                                    <tbody>';
                    $i = 0;
                    if ($track->getPois() != null) {
                        foreach ($track->getPois() as $poi) {
                            $html .= '
                                <!-- Show details -->
                                <script>
                                    $(document).ready(function() {
                                        $("#tr-poi-' . $i . '").click(function() {
                                            $("#staggered-poi-' . $i . '").toggle();
                                        });
                                    });
                                </script>
                                
                                <tr id="tr-poi-' . $i . '">
                                    <td>' . $poi->getName() . '</td>
                                    <td>' . $poi->getDescription() . '</td>
                                </tr>
                                
                                <!-- Details -->
                                <tr id="staggered-poi-' . $i . '">
                                    <td colspan="2" class="zone-details-td">
                                        <table>
                                            <tbody>
                                            <tr>
                                                <td colspan="3" class="center-align">
                                                    <img src="https://firebasestorage.googleapis.com/v0/b/santour-e9abc.appspot.com/o/' . $poi->getPicture() . '?alt=media" width="300" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>' . __('Name', true) . ': ' . $poi->getName() . '</td>
                                                <td>' . __('Description', true) . ': ' . $poi->getDescription() . '</td>
                                                <td>' . __('Date', true) . ': ' . strftime('%e %b %Y %H:%m', strtotime($poi->getPosition()->getDateTime())) . '</td>
                                            </tr>
                                            <tr>
                                                <td>' . __('Latitude', true) . ': ' . $poi->getPosition()->getLatitude() . '</td>
                                                <td>' . __('Longitude', true) . ': ' . $poi->getPosition()->getLongitude() . '</td>
                                                <td>' . __('Altitude', true) . ': ' . $poi->getPosition()->getAltitude() . 'm</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            ';
                            $i++;
                        }
                    } else {
                        $html .= '<tr><td colspan="2" class="san-empty-table">' . __("No POI for this track", true) . '</td></tr>';
                    }
                    $html .= '
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>';
                    echo $html;
                    ?>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
    function initializeMap() {
        var mapOptions = {
            zoom: 17,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };

        var map = new google.maps.Map(document.getElementById("san-map"), mapOptions);

        // Dessin des marqueurs
        // Marqueur du départ
        var latLngCenter = {
            lat: <?php echo $track->getPositions()[0]->getLatitude(); ?>,
            lng: <?php echo $track->getPositions()[0]->getLongitude(); ?>
        };

        new google.maps.Marker({
            position: latLngCenter,
            map: map,
            title: 'Départ',
            icon: pinSymbol("#0F0")
        });

        map.setCenter(latLngCenter);

        // Marqueurs pour les pod et poi
        var pointsOfCoordinates = [
            <?php
            if ($track->getPods() != null) {
                foreach ($track->getPods() as $pod) {
                    echo '{lat: ' . $pod->getPosition()->getLatitude() . ', lng: ' . $pod->getPosition()->getLongitude() . ', type: "pod", title: "' . $pod->getName() . '"},';
                }
            }
            if ($track->getPois() != null) {
                foreach ($track->getPois() as $poi) {
                    echo '{lat: ' . $poi->getPosition()->getLatitude() . ', lng: ' . $poi->getPosition()->getLongitude() . ', type: "poi", title: "' . $poi->getName() . '"},';
                }
            }
            ?>
        ];

        for (var i = 0; i < pointsOfCoordinates.length; i++) {
            var markerPO = new google.maps.Marker({
                position: pointsOfCoordinates[i],
                map: map,
                title: pointsOfCoordinates[i].title
            });

            if (pointsOfCoordinates[i].type === "pod")
                markerPO.setIcon(pinSymbol("#D30"));
            else
                markerPO.setIcon(pinSymbol("#09F"));
        }

        // Marqueur de l'arrivée
        new google.maps.Marker({
            position: {
                lat: <?php echo $track->getPositions()[count($track->getPositions()) - 1]->getLatitude(); ?>,
                lng: <?php echo $track->getPositions()[count($track->getPositions()) - 1]->getLongitude(); ?>},
            map: map,
            title: 'Arrivée',
            icon: pinSymbol("#CCC")
        });

        // Légende des marqueurs
        var types = [
            {name: 'Départ', icon: pinSymbol('#0F0')},
            {name: 'Arrivée', icon: pinSymbol('#CCC')},
            {name: 'POD', icon: pinSymbol('#F30')},
            {name: 'POI', icon: pinSymbol('#06F')}
        ];

        var legend = document.getElementById('legend');
        console.log(types);
        for (var key in types) {
            var type = types[key];
            var name = type.name;
            var icon = type.icon;
            var div = document.createElement('div');
            div.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" style="display: none;">' +
                '<symbol id="shape-icon-2" viewBox="0 26 100 48">' +
                '<path d="M 0,0 C -2,-20 -10,-22 -10,-30 A 10,10 0 1,1 10,-30 C 10,-22 2,-20 0,0 z M -2,-30 a 2,2 0 1,1 4,0 2,2 0 1,1 -4,0"/>' +
                '</symbol>' +
                '</svg>' +
                '<svg class="icon">' +
                '  <use xlink:href="#shape-icon-2" />' +
                '</svg>' + name;
            legend.appendChild(div);
        }

        map.controls[google.maps.ControlPosition.RIGHT_BOTTOM].push(legend);

        // Dessin du parcours
        var trackCoordinates = [
            <?php
            foreach ($track->getPositions() as $position) {
                echo '{lat: ' . $position->getLatitude() . ', lng: ' . $position->getLongitude() . '},';
            }
            ?>
        ];

        var trackPath = new google.maps.Polyline({
            path: trackCoordinates,
            geodesic: true,
            strokeColor: '#888',
            strokeOpacity: 1.0,
            strokeWeight: 5
        });

        trackPath.setMap(map);

    }

    function pinSymbol(color) {
        return {
            path: 'M 0,0 C -2,-20 -10,-22 -10,-30 A 10,10 0 1,1 10,-30 C 10,-22 2,-20 0,0 z M -2,-30 a 2,2 0 1,1 4,0 2,2 0 1,1 -4,0',
            fillColor: color,
            fillOpacity: 1,
            strokeColor: '#000',
            strokeWeight: 1,
            scale: 0.8
        };
    }
</script>
<script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCdztNG0nuYkiApLcpL-nnKLzV7W_s2G6Q&callback=initializeMap"></script>

<?php
function round_distance($distance)
{
    if ($distance >= 1000)
        return round($distance / 1000, 2) . ' km';
    else
        return round($distance, 2) . ' m';
}