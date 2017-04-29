<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

if (!function_exists("mapa_punts_header")) {

    /**
     * 
     * @param type $data Array (0=> ('lat' = 1, 'lng' = 2, 'nom' = 'asd'), 1 => ...
     */
    function mapa_punts($data,$pos = array('lat'=>'41.5','lng'=>'1.51')) {
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
                center: new google.maps.LatLng(<?php echo $pos['lat']. ", ".$pos['lng'] ?>),
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
        
        return array('lat'=>$lat,'lng'=>$lng);
    }

}