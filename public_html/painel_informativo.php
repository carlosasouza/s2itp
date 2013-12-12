<?php 
include_once '../app/controller/serviceController.php';
include_once '../app/model/onibus.php';
$serviceController = new ServiceController();

/*
$infoParadas = $serviceController->recuperaParadas(1);
@$latitudeParada = $infoParadas[0]['latitude'];
@$longitudeParada = $infoParadas[0]['longitude'];
@$descParada = $infoParadas[0]['nome'];
*/

/*
$infoOnibus = $serviceController->recuperaOnibus(1);
@$latitudeOnibus = Onibus::;
@$longitudeOnibus = $infoOnibus[0]['longitude'];
@$linhaOnibus = $infoOnibus[0]['linha_id'];
*/

$infoLinha = $serviceController->recuperaLinhas(1);
$numeroLinha = $infoLinha[0]['numeroLinha']."<br>";
$destino = $infoLinha[0]['destino']."<br>";

$infoLinha2 = $serviceController->recuperaLinhas(2);
$numeroLinha2 = $infoLinha2[0]['numeroLinha']."<br>";
$destino2 = $infoLinha2[0]['destino']."<br>";

$infoPosicao = $serviceController->recuperaPosicao(1);
$nomeParada = $infoPosicao[0]['parada_nome']."<br>";
$latitudeParada = $infoPosicao[0]['parada_latitude']."<br>";
$longitudeParada = $infoPosicao[0]['parada_longitude']."<br>";
$latitudePosicao = $infoPosicao[0]['posicao_latitude']."<br>";
$longitudePosicao = $infoPosicao[0]['posicao_longitude']."<br>";


?>

﻿<!DOCTYPE html>
<html>
    <head>

        <!-- start: Meta -->
        <meta charset="utf-8">
        <title>Painel de Informações</title>
        <meta name="description" content="Painel de Informações.">
        <meta name="keyword" content="Painel de Informações">
        <!-- end: Meta -->

        <!-- start: Mobile Specific -->
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- end: Mobile Specific -->

        <!-- start: CSS -->
        <link href="assets/css/bootstrap.min.css" rel="stylesheet">
        <link href="assets/css/style.min.css" rel="stylesheet">
        <link href="assets/css/retina.min.css" rel="stylesheet">
        <!-- end: CSS -->


        <!-- The HTML5 shim, for IE6-8 support of HTML5 elements -->
        <!--[if lt IE 9]>
        
                <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
                <script src="assets/js/respond.min.js"></script>
                <script src="assets/css/ie6-8.css"></script>
                
        <![endif]-->

        <!-- start: Favicon and Touch Icons -->
        <link rel="apple-touch-icon-precomposed" sizes="144x144" href="assets/ico/apple-touch-icon-144-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="assets/ico/apple-touch-icon-114-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="assets/ico/apple-touch-icon-72-precomposed.png">
        <!-- end: Favicon and Touch Icons -->	

        <script>
            var map;
            var geocoder;
            var bounds = new google.maps.LatLngBounds();
            var markersArray = [];

            var directionsService;
            var directionsRenderer;

            directionsService = new google.maps.DirectionsService();

            directionsRenderer = new google.maps.DirectionsRenderer();
            //directionsRenderer.setMap(map);

            var origin1 = new google.maps.LatLng(<?php echo $latitudePosicao; ?>, <?php echo $longitudePosicao; ?>);
            var destinationA = new google.maps.LatLng(<?php echo $latitudeParada; ?>, <?php echo $longitudeParada; ?>);


            var destinationIcon = 'http://www.clker.com/cliparts/5/3/f/1/123756068293974412milovanderlinden_Funny_Bus_stop.svg';
            var originIcon = 'http://www.umb.edu/editor_uploads/maps-icons/Transit_Bus_icon.png';

            function initialize() {
                var opts = {
                    center: new google.maps.LatLng(-15.792254, -47.919831),
                    zoom: 10
                };
                map = new google.maps.Map(document.getElementById('map'), opts);
                geocoder = new google.maps.Geocoder();
            }

            function calculateDistances() {
                var service = new google.maps.DistanceMatrixService();
                service.getDistanceMatrix(
                        {
                            origins: [origin1],
                            destinations: [destinationA],
                            travelMode: google.maps.TravelMode.DRIVING,
                            unitSystem: google.maps.UnitSystem.METRIC,
                            avoidHighways: false,
                            avoidTolls: false
                        }, callback);
                directionsService.route(request, function(response, status) {
                    if (status == google.maps.DirectionsStatus.OK) {
                        directionsRenderer.setDirections(response);
                    }
                });
            }

            function callback(response, status) {
                if (status != google.maps.DistanceMatrixStatus.OK) {
                    alert('Error was: ' + status);
                } else {
                    var origins = response.originAddresses;
                    var destinations = response.destinationAddresses;
                    var outputDiv = document.getElementById('outputDiv');
                    outputDiv.innerHTML = '';
                    deleteOverlays();

                    for (var i = 0; i < origins.length; i++) {
                        var results = response.rows[i].elements;
                        addMarker(origins[i], false);
                        for (var j = 0; j < results.length; j++) {
                            addMarker(destinations[j], true);
                            outputDiv.innerHTML += results[j].duration.text;
                        }
                    }
                }
            }

            function addMarker(location, isDestination) {
                var icon;
                var desc;
                if (isDestination) {
                    icon = destinationIcon;
                    desc = '<?php echo $destino; ?>';
                } else {
                    icon = originIcon;
                    desc = '<?php echo $numeroLinha; ?>';
                }
                geocoder.geocode({'address': location}, function(results, status) {
                    if (status == google.maps.GeocoderStatus.OK) {
                        bounds.extend(results[0].geometry.location);
                        map.fitBounds(bounds);
                        var marker = new google.maps.Marker({
                            map: map,
                            position: results[0].geometry.location,
                            icon: icon,
                            title: desc
                        });
                        markersArray.push(marker);
                    } else {
                        alert('Geocode was not successful for the following reason: '
                                + status);
                    }
                });

            }

            function deleteOverlays() {
                for (var i = 0; i < markersArray.length; i++) {
                    markersArray[i].setMap(null);
                }
                markersArray = [];
            }

            google.maps.event.addDomListener(window, 'load', initialize);
            window.setTimeout(calculateDistance(), 50);

        </script>
        
    </head>

    <body>

        <div class="col-lg-12">
            <div class="box">
                <div class="box-header">
                    <h2><i class="icon-align-justify"></i><span class="break"></span>Parada: <?php echo $nomeParada; ?></h2>
                    <div class="box-icon">
                        <h2>10:50</h2>

                    </div>
                </div>
                <div class="box-content">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Linha</th>
                                <th>Destino</th>
                                <th>Tempo de Chegada</th>

                            </tr>
                        </thead>   
                        <tbody>
                            <tr>
                                <td><span class="label label-success"><?php echo $numeroLinha; ?></span></td>
                                <td class="center"><?php echo $destino; ?></td>
                                <td class="center"><div id="outputDiv"><script>document.write("Teste"+calculateDistance());</script></div></td>

                    
                            </tr>
                            <tr>
                                <td><span class="label label-success"><?php echo $numeroLinha2; ?></span></td>
                                <td class="center"><?php echo $destino2; ?></td>
                                <td class="center"><div id="outputDiv"></div></td>

                            </tr>               
                        </tbody>
                    </table>  

                </div>
            </div>
        </div><!--/col-->
    </div><!--/row-->

</body>

</html>