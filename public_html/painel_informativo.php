<?php 
include_once '../app/controller/serviceController.php';
include_once '../app/model/onibus.php';

$serviceController = new ServiceController();

$dados = $serviceController->populaInformativo(1);

date_default_timezone_set("Brazil/East");

?>

﻿<!DOCTYPE html>
<html>
    <head>

<meta http-equiv="refresh" content="5" >
        <!-- start: Meta -->
        <meta charset="utf-8">
        <title>Painel de Informações - S2ITP</title>
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
        
   </head>

    <body>
        <div class="col-lg-12">
            <div class="box">
                <div class="box-header">
                    <h2><i class="icon-align-justify"></i><span class="break"></span>Parada: UnB Campus Gama</h2>
                    <div class="box-icon">
                        <h2><?php echo date('H:i'); ?></h2>

                    </div>
                </div>

                <div class="box-content">
                    
                    <table class="table table-striped">
                                        <?php        foreach ($dados as $dado){ ?>   
                        <thead>
                            <tr>
                                <th>Linha</th>
                                <th>Destino</th>
                                <th>Tempo de Chegada Estimado</th>

                            </tr>
                        </thead>   
                        <tbody>
                            <tr>
                             
                                <td><span class="label label-success"><?php echo utf8_encode($dado['numeroLinha']); ?></span></td>
                                <td class="center"><?php echo utf8_encode($dado['destino']); ?></td>
                                <td class="center"><?php echo $serviceController->distanciaParadas(-15.985682, -48.042181, $dado['latitude'], $dado['longitude']);?></td>
<?php }?>
                    
                            </tr>
      
                        </tbody>
                    </table>  

                </div>
            </div>
        </div><!--/col-->
    </div><!--/row-->

</body>

</html>