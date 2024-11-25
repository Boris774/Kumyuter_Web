<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <title>Kumyuter Directions</title>
    <style>
      /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
      #map {
        height: 100%;
      }
      /* Optional: Makes the sample page fill the window. */
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
      #floating-panel {
        position: absolute;
        top: 10px;
        left: 25%;
        z-index: 5;
        background-color: #fff;
        padding: 5px;
        border: 1px solid #999;
        text-align: center;
        font-family: 'Roboto','sans-serif';
        line-height: 30px;
        padding-left: 10px;
      }
    </style>
  </head>
  <body>
    <?php
        include("config/config.php");
        include("config/firebaseRDB.php"); 

        $db = new firebaseRDB($databaseURL); 
        $data = $db->retrieve("history-info"); 
        $data = json_decode($data, 1);
                
        $ctr = 0;
                
        if(is_array($data)){
            foreach($data as $id => $historyinfo){
                if ($historyinfo['code'] == $_GET['id']){
                    $ctr = $ctr + 1;
                    ?>
                    <div id="floating-panel">
                        <b>Start: </b>
                        <input type="text" id="start" value="<?php echo $historyinfo['origin']; ?>" />
                        <b>End: </b>
                        <input type="text" id="end" value="<?php echo $historyinfo['destination']; ?>" />
                        </div>
                        <div id="map"></div>
                    <?php
                }
            }
        }
    ?>

    <script>
                        function initMap() {
                            var directionsService = new google.maps.DirectionsService;
                            var directionsDisplay = new google.maps.DirectionsRenderer;
                            var map = new google.maps.Map(document.getElementById('map'), {
                            zoom: 17,
                            center: {lat: 12.0675358, lng: 124.5910272}
                            });
                            directionsDisplay.setMap(map);


                            // var onChangeHandler = function() {
                            //   calculateAndDisplayRoute(directionsService, directionsDisplay);
                            // };
                            // document.getElementById('start').addEventListener('change', onChangeHandler);
                            // document.getElementById('end').addEventListener('change', onChangeHandler);

                            calculateAndDisplayRoute(directionsService, directionsDisplay);
                        }


                        function calculateAndDisplayRoute(directionsService, directionsDisplay) {
                            directionsService.route({
                            origin: document.getElementById('start').value,
                            destination: document.getElementById('end').value,
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
                        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyANIqfg9M4xBhxC238GjRiwgovR05psq7o&callback=initMap">
                        </script>
  </body>
</html>