<?php

include_once '../app/controller/serviceController.php';

$serviceController = new ServiceController();

$idParada = 8;

$cidades = $serviceController->recuperaCidades();

?>


<!DOCTYPE HTML>
<html>
    <head>
        <!-- start: Meta -->
        <meta charset="utf-8">
        <title>S2itp</title>
        <meta name="description" content="S2ITP.">
        <meta name="author" content="Mobilidade Urbana DF">
        <meta name="keyword" content="Mobilidade urbana">
        <!-- end: Meta -->

        <!-- start: Mobile Specific -->
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- end: Mobile Specific -->

        <!-- start: CSS -->
        <link href="assets/css/bootstrap.min.css" rel="stylesheet">
        <link href="assets/css/style.css" rel="stylesheet">
        <link href="assets/css/retina.min.css" rel="stylesheet">
        <link href="assets/css/customise.css" rel="stylesheet">

        <!-- end: CSS -->

        <!--GMAPS-->
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js"></script>
        <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=true"></script>
        <script type="text/javascript" src="../gmaps.js"></script>
        <link rel="stylesheet" type="text/css" href="css/examples.css" /> <!--esse causa aquele problema do topo descer -->

        <!--script type="text/javascript">
            var map;
            $(document).ready(function() {
                var map = new GMaps({
                    el: '#map',
                    lat: <?php echo $latitude; ?>,
                    lng: <?php echo $longitude; ?>
                });
                map.addMarker({
                    lat: <?php echo $latitude; ?>,
                    lng: <?php echo $longitude; ?>,
                    title: 'Brasília',
                    infoWindow: {
                        content: '<p>HTML Content</p>'
                    }
                });

            });
            
        </script!-->

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

            var origin1 = new google.maps.LatLng(-15.9857, -48.042293);
            var destinationA = new google.maps.LatLng(-15.9968, -48.05800);


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
                            outputDiv.innerHTML += origins[i] + ' to ' + destinations[j]
                                    + ': ' + results[j].distance.text + ' in '
                                    + results[j].duration.text + '<br>';
                        }
                    }
                }
            }

            function addMarker(location, isDestination) {
                var icon;
                var desc;
                if (isDestination) {
                    icon = destinationIcon;
                    desc = 'xpto';
                } else {
                    icon = originIcon;
                    desc = 'xpto';
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

        </script>


        <!--[if lt IE 9]>
                <script src="js/html5shiv.js"></script>
                <script src="js/respond.src.js"></script>
        <![endif]-->

        <script type="text/javascript">
            $(document).ready(function() {
                $("#ajax-contact-form").submit(function() {
                    var str = $(this).serialize();
                    $.ajax({
                        type: "POST",
                        url: "contact_form/contact_process.php",
                        data: str,
                        success: function(msg) {
                            // Message Sent - Show the 'Thank You' message and hide the form
                            if (msg == 'OK') {
                                result = '<div class="notification_ok">Your message has been sent. Thank you!</div>';
                                $("#fields").hide();
                            } else {
                                result = msg;
                            }
                            $('#note').html(result);
                        }
                    });
                    return false;
                });

            });

            function buscar_linha() {
                var idCidade = $('#cidade').val();
                
                if (idCidade) {
                    var url = 'ajax_buscar.php?linha=true&idCidade='+idCidade;
                    $.get(url, function(dataReturn) {
                        $('#load_linhas').html(dataReturn);
                    });
                }
            }
            
            function buscar_parada() {
                var idCidade = $('#cidade').val();
                
                if (idCidade) {
                    var url = 'ajax_buscar.php?parada=true&idCidade='+idCidade;
                    $.get(url, function(dataReturn) {
                        $('#load_paradas').html(dataReturn);
                    });
                }
            }

        </script>

        <script type="text/javascript">/*$($.date_input.initialize);*/</script>

    </head>

    <body>

        <!-- start: Header -->
        <header class="navbar">
            <div class="container">
                <button class="navbar-toggle" type="button" data-toggle="collapse" data-target=".sidebar-nav.nav-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a id="main-menu-toggle" class="hidden-xs open"><i class="icon-reorder"></i></a>		
                <a class="navbar-brand col-lg-4 col-sm-3 col-xs-12" href="index.html"><span>S2ITP</span></a>
                <!-- start: Header Menu -->
                <div class="nav-no-collapse header-nav">
                    <ul class="nav navbar-nav pull-right">
                        <li class="dropdown hidden-xs">
                            <a class="btn dropdown-toggle" data-toggle="dropdown" href="index.html#">
                                <i class="icon-warning-sign"></i>
                            </a>
                            <ul class="dropdown-menu notifications">
                                <li class="dropdown-menu-title">
                                    <span>Notificações</span>
                                </li>	
                                <li>
                                    <a href="index.html#">
                                        <span class="icon blue"><i class="icon-comment-alt"></i></span>
                                        <span class="message">Linha 205 - Gama/Taguatinga</span>
                                        <span class="time">1 min</span> 
                                    </a>
                                </li>
                                <li>
                                    <a href="index.html#">
                                        <span class="icon green"><i class="icon-comment-alt"></i></span>
                                        <span class="message">Linha 205.1 - Gama/Taguatinga</span>
                                        <span class="time">7 min</span> 
                                    </a>
                                </li>
                                <li>
                                    <a href="index.html#">
                                        <span class="icon green"><i class="icon-comment-alt"></i></span>
                                        <span class="message">Linha 200.1 - Gama/Plano Piloto</span>
                                        <span class="time">8 min</span> 
                                    </a>
                                </li>
                                <li>
                                    <a href="index.html#">
                                        <span class="icon green"><i class="icon-comment-alt"></i></span>
                                        <span class="message">Linha 217.2 - Gama/Asa Norte</span>
                                        <span class="time">16 min</span> 
                                    </a>
                                </li>

                                <li class="dropdown-menu-sub-footer">
                                    <a>Ver todas as notificações</a>
                                </li>	
                            </ul>
                        </li>

                        <li>
                            <a class="btn" href="index.html#">
                                <i class="icon-wrench"></i>
                            </a>
                        </li>
                        <!-- start: User Dropdown -->
                        <li class="dropdown">
                            <a class="btn account dropdown-toggle" data-toggle="dropdown" href="informativo.html">
                                <div class="avatar"><img src="assets/img/avatar.jpg" alt="Avatar"></div>
                                <div class="user">
                                    <span class="hello">Bem Vindo</span>
                                    <span class="name">Jônatas Medeiros</span>
                                </div>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="dropdown-menu-title">

                                </li>
                                <li><a href="index.html#"><i class="icon-user"></i> Profile</a></li>
                                <li><a href="index.html#"><i class="icon-cog"></i> Settings</a></li>
                                <li><a href="index.html#"><i class="icon-envelope"></i> Messages</a></li>
                                <li><a href="login.html"><i class="icon-off"></i> Logout</a></li>
                            </ul>
                        </li>
                        <!-- end: User Dropdown -->
                    </ul>
                </div>
                <!-- end: Header Menu -->

            </div>	
        </header>
        <!-- end: Header -->

        <div class="container">
            <div class="row">

                <!-- start: Main Menu -->
                <div id="sidebar-left" class="col-lg-4 col-sm-3">

                    <div class="sidebar-nav">
                        <img class="icon_img" src="images/map-pin2x.png" />
                        <h3>Para onde você deseja ir?</h3>
                        <div class="clear"></div>
                    </div>

                    <form method="post" action="">

                        <div>
                            <label>Cidade:</label>
                            <select name="cidade" id='cidade' onchange="buscar_parada()">
                                <option value="...:::Selecione a Cidade:::...">...:::Selecione a Cidade:::...</option>
                                <?php
                                foreach ($cidades as $cidade) {
                                    echo "<option value='".utf8_encode($cidade['id'])."'>".utf8_encode($cidade['nome'])."</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div id="load_paradas">
                            <label>Paradas:</label>
                            <select name="parada" id="parada" onchange="buscar_linha()">
                                <option value="...::Selecione a Parada:::...">...::Selecione a Parada:::...</option>
                            </select>
                        </div>
                        <div id="load_linhas">
                            <label>Linhas:</label>
                            <select name="linha" id="linha">
                                <option value="...::Selecione a Linha:::...">...::Selecione a Linha:::...</option>
                            </select>
                        </div>
                    </form>

                    <p><button class="btn space-top" type="button" onclick="calculateDistances();">Calculate
                            distances</button></p>

                    <div id="outputDiv"></div>

                </div>
                <!-- end: Main Menu -->

                <!-- start: Content -->
                <div id="content" class="col-lg-8 col-sm-9">

                    <div class="row">

                        <div class="col-xs-12 alpha omega">

                            <div id="map"></div>

                        </div><!--/col-->	

                    </div><!--/row-->					


                </div>
                <!-- end: Content -->

            </div><!--/row-->		

        </div><!--/container-->



        <div class="modal fade" id="myModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Modal title</h4>
                    </div>
                    <div class="modal-body">
                        <p>Here settings can be configured...</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Save changes</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

        <div class="clearfix"></div>

        <footer>
            <p>
                <span style="text-align:left;float:left">S2ITP - Sistema de Informação Interativa de Transporte Público</span>
                <span class="hidden-phone" style="text-align:right;float:right">Mobilidade Urbana - DF</span>
            </p>

        </footer>

        <!-- start: JavaScript-->
        <!--[if !IE]>-->

        <script src="assets/js/jquery-2.0.3.min.js"></script>

        <!--<![endif]-->

        <!--[if IE]>
        
                <script src="assets/js/jquery-1.10.2.min.js"></script>
        
        <![endif]-->

        <!--[if !IE]>-->

        <script type="text/javascript">
            window.jQuery || document.write("<script src='assets/js/jquery-2.0.3.min.js'>" + "<" + "/script>");
        </script>

        <!--<![endif]-->

        <!--[if IE]>
        
                <script type="text/javascript">
                window.jQuery || document.write("<script src='assets/js/jquery-1.10.2.min.js'>"+"<"+"/script>");
                </script>
                
        <![endif]-->
        <script src="assets/js/jquery-migrate-1.2.1.min.js"></script>
        <script src="assets/js/bootstrap.min.js"></script>




        <!-- page scripts -->
        <script src="assets/js/jquery-ui-1.10.3.custom.min.js"></script>
        <script src="assets/js/jquery.ui.touch-punch.min.js"></script>
        <script src="assets/js/jquery.sparkline.min.js"></script>
        <script src="assets/js/fullcalendar.min.js"></script>
        <!--[if lte IE 8]><script language="javascript" type="text/javascript" src="assets/js/excanvas.min.js"></script><![endif]-->
        <script src="assets/js/jquery.flot.min.js"></script>
        <script src="assets/js/jquery.flot.pie.min.js"></script>
        <script src="assets/js/jquery.flot.stack.min.js"></script>
        <script src="assets/js/jquery.flot.resize.min.js"></script>
        <script src="assets/js/jquery.flot.time.min.js"></script>
        <script src="assets/js/jquery.autosize.min.js"></script>
        <script src="assets/js/jquery.placeholder.min.js"></script>

        <!-- theme scripts -->
        <script src="assets/js/custom.min.js"></script>
        <script src="assets/js/core.min.js"></script>

        <!-- inline scripts related to this page -->
        <script src="assets/js/pages/index.js"></script>

        <!--novos JS --> 

        <!-- end: JavaScript-->
    </body>
</html>
