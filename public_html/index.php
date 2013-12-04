<?php

include('conexao.php');
$sql = "SELECT * FROM city ORDER BY city_name";
$res = mysql_query($sql, $conexao);
$num = mysql_num_rows($res);
for ($i = 0; $i < $num; $i++) {
  $dados = mysql_fetch_array($res);
  $arrEstados[$dados['idCity']] = $dados['city_name'];
}

include_once '../app/controller/serviceController.php';
$serviceController = new ServiceController();
$infoBus = $serviceController->getBusInfo(1);
@$latitude = $infoBus[0]['latitude'];
@$longitude = $infoBus[0]['longitude'];
/* echo '<pre>';
  print_r($infoBus);
  echo '</pre>';
  die; */
$infoCidades = $serviceController->getCities();
$infoLines = $serviceController->getLines();
$infoPointers = $serviceController->getPointers();
?>


<!DOCTYPE HTML>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale = 1.0, user-scalable = no">
        <title>S2ITP - Sistema de Informação Interativa de Transporte</title>
        <link rel="stylesheet" href="css/style.css" type="text/css" media="screen">
        <link rel="stylesheet" href="css/jquery-ui-1.10.1.custom.css" type="text/css" media="screen">
        <link rel="stylesheet" href="css/normalize.css" type="text/css" media="screen">
        <link rel="stylesheet" id="camera-css"  href="css/flexslider.css" type="text/css" media="all">
        <link rel="stylesheet" href="css/grid.css" type="text/css" media="screen">
        <link rel="stylesheet" href="css/bootstrap-redu.css" type="text/css" media="screen">


        <link href='http://fonts.googleapis.com/css?family=Droid+Sans:400,700' rel='stylesheet' type='text/css'>
        <link href='http://fonts.googleapis.com/css?family=Anton' rel='stylesheet' type='text/css'>

        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
        <script type="text/javascript" src="js/jquery.easing.1.3.js"></script>
        <script src="js/jquery-ui-1.10.1.custom.min.js"></script>
        <script type="text/javascript" src="js/slider/jquery.flexslider-min.js"></script>
        <script src="js/slider/functions.js" type="text/javascript"></script>
        <script src="js/slider/script.js" type="text/javascript"></script>
        <script type="text/javascript" src="js/radio.js"></script>
        <script type="text/javascript" src="js/js.js"></script>
        <script type="text/javascript" src="js/jquery.stellar.min.js"></script>
        <script type="text/javascript" src="js/waypoints.min.js"></script>
        <script type="text/javascript" src="js/vendor/bootstrap-redu.js"></script>

        <!--GMAPS-->
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js"></script>
        <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=true"></script>
        <script type="text/javascript" src="../gmaps.js"></script>
        <link rel="stylesheet" type="text/css" href="css/examples.css" />

        <script type="text/javascript">
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
                var cidade = $('#cidade').val();
                if (cidade) {
                    var url = 'ajax_buscar_linha.php?cidade=' + cidade;
                    $.get(url, function(dataReturn) {
                        $('#load_linhas').html(dataReturn);
                    });
                }
            }
            
        </script>

        <script type="text/javascript">/*$($.date_input.initialize);*/</script>

    </head>

    <body>

        <div class="menu">	
            <div class="clearfix">

                <div id="logo" class="fleft">
                        <!--a href="javascript:void(0);"><img src="images/logo.png" /></a-->
                    <h5>S2ITP - Sistema de Informação Interativa de Transporte</h5>
                </div>

                <div id="nav" class="fright">
                    <ul class="navigation">
                        <li data-slide="1">Home</li>
                        <li data-slide="2">Sobre</li>
                        <li data-slide="4">Ônibus</li>
                        <li data-slide="6">Paradas</li>
                        <div class="clear"></div>
                    </ul>
                </div>

            </div>
        </div>


        <div class="slide" id="slide8" data-slide="8" data-stellar-background-ratio="0.5">
            <div class="padding_slide8">
                <div class="grid_3">
                    <div id="content" class="left">
                        <img class="icon_img" src="images/icon1.jpg" />
                        <h4>Para onde você deseja ir?</h4>
                        <div class="clear"></div>
                    </div>
                    <div class="order_block left">
                        <form method="post" action="">
                        
                            <div>
      <label>Cidade:</label>
      <select name="cidade" id="cidade" onchange="buscar_linha()">
        <option value="">...:::Selecione:::...</option>
        <?php foreach ($arrEstados as $value => $name) {
          echo "<option value='{$value}'>{$name}</option>";
        }?>
      </select>
      </div>
      <div id="load_linhas">
        <label>Linhas:</label>
        <select name="linha" id="linha">
          <option value="">...:::Selecione a linha:::...</option>
        </select>
      </div>
                            
                        </form>
                    </div>
                </div>

                <div class="grid_9 alpha omega">
                    <div id="map"></div>
                </div>
            </div>
        </div>



    </div>


    <div id="footer">
        <div class="container clearfix">
            <div class="copyright">S2ITP - Sistema de Informação Interativa de Transporte &copy; 2013 | <a href="javascript:void(0);">Política de Privacidade</a></div>
            <div id="back_top"><a class="button" title="" data-slide="1"></a></div>
        </div>
    </div>


</body>
</html>
