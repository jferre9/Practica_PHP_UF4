<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

if (!function_exists("mapa_punts")) {

    /**
     * 
     * @param type $data Array (0=> ('lat' = 1, 'lng' = 2, 'nom' = 'asd'), 1 => ...
     */
    function mapa_punts($data, $pos = array('lat' => '41.5', 'lng' => '1.51')) {
        ?>
        <div id="map" class="mapa-punts"></div>
        <script type="text/javascript">
            var locations = [
        <?php
        for ($i = 0; $i < count($data); $i++) {
            if ($i !== 0)
                echo ", ";
            echo "['" . $data[$i]['nom'] . "', " . $data[$i]['lat'] . ", " . $data[$i]['lng'] . "]";
        }
        ?>
            ];
                    var map = new google.maps.Map(document.getElementById('map'), {
                    zoom: 8,
                            center: new google.maps.LatLng(<?php echo $pos['lat'] . ", " . $pos['lng'] ?>),
                            mapTypeId: google.maps.MapTypeId.ROADMAP
                    });
                    var infowindow = new google.maps.InfoWindow();
                    var marker, i;
                    for (i = 0; i < locations.length; i++) {
            marker = new google.maps.Marker({
            position: new google.maps.LatLng(locations[i][1], locations[i][2]),
                    map: map
            });
                    google.maps.event.addListener(marker, 'click', (function (marker, i) {
                    return function () {
                    infowindow.setContent(locations[i][0]);
                            infowindow.open(map, marker);
                    }
                    })(marker, i));
            }
        </script>
        <?php
    }

}

if (!function_exists('get_coordenades')) {

    /**
     * Retorna la primera parella de coordenades
     * @param type $direccio
     * @return boolean
     */
    function get_coordenades($direccio) {
        $url = "https://maps.googleapis.com/maps/api/geocode/json?address=" . urlencode($direccio) . "&key=AIzaSyD4fmxGwJe-QBjRth6f3XDwYS1DhDNiPkA";

        $output = file_get_contents($url);

        $json = json_decode($output);

        if (count($json->results) === 0) {
            return FALSE;
        }

        $lat = $json->results[0]->geometry->location->lat;
        $lng = $json->results[0]->geometry->location->lng;

        return array('lat' => $lat, 'lng' => $lng);
    }

}

if (!function_exists('mapa_waypoints')) {

    function mapa_waypoints($inici, $final, $waypoints, $pos = array('lat' => '41.5', 'lng' => '1.51')) {
        ?>
        <script>
            function initMap() {
            var directionsService = new google.maps.DirectionsService;
                    var directionsDisplay = new google.maps.DirectionsRenderer;
                    var map = new google.maps.Map(document.getElementById('map'), {
                    zoom: 8,
                            center: {lat: 41.5, lng: 1.51}
                    });
                    directionsDisplay.setMap(map);
                    calculateAndDisplayRoute(directionsService, directionsDisplay);
            }

            function calculateAndDisplayRoute(directionsService, directionsDisplay) {
            var waypts = [
                <?php foreach ($waypoints as $wp): ?>
                {
                    location: '<?php echo $wp ?>',
                    stopover: true
                },
                <?php endforeach; ?>
                ];
                directionsService.route({
                    origin: '<?php echo $inici ?>',
                    destination: '<?php echo $final ?>',
                    waypoints: waypts,
                    optimizeWaypoints: true,
                    travelMode: 'DRIVING'
                }, function(response, status) {
                    if (status === 'OK') {
                        directionsDisplay.setDirections(response);
                    } else {
                        window.alert('Directions request failed due to ' + status);
                    }
                });
            }
        </script>
        <script async defer
                src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCZPkegXzyFwgTb83GmaCKgzImVDSF1SUE&callback=initMap">
        </script>
        <?php
    }

}