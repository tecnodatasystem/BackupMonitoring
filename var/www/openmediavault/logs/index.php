<?php
session_start();
include('code.php');
?>
<!DOCTYPE html>
<html lang="it">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Log Backup</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="css/font.css" rel="stylesheet" type="text/css">
<?php if(!isset($_GET['id'])){ include("header_chart.php"); }?>
    <!-- Custom CSS -->
    <style>
    body {
        padding-top: 70px;
        /* Required padding for .navbar-fixed-top. Remove if using .navbar-static-top. Change if height of navigation changes. */
    }
    </style>


</head>

<body>
<?php  ?>
    <!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="<?php echo dirname($_SERVER['PHP_SELF']); ?>">LOG BLACKBOX</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <ul class="nav navbar-nav navbar-right">
                <li>
                    <a href="<?php echo dirname($_SERVER['PHP_SELF']); ?>/index.php" title="Dashboard">DASHBOARD</a>
                </li>
                <!--<li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" title="Computer" aria-expanded="true"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> <?php if(isset($_GET['id'])){echo $_GET['id'];}else{echo "Nessun computer selezionato";} ?> <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                    <?php foreach($nomeComputer as $computer): ?>
                        <li>
                            <a href="?id=<?php echo $computer; ?>"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> <?php echo $computer; ?></a>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </li>-->
                <li>
                    <a href="<?php echo dirname($_SERVER['PHP_SELF']); ?>/index.php?computer=show" title="Computers">COMPUTERS</a>
                </li>
            </ul>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>

    <!-- Page Content -->
    <div class="container">

        <div class="row">
            <div class="col-lg-12 <?php if(!isset($_GET['computer']) && !$_GET['computer']){ echo "text-center"; } ?>">
            
            <?php if(isset($_GET['computer']) && $_GET['computer'] == 'show'): ?>
            
                <h1 style="margin-bottom: 30px;">Log dei backup</h1>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Nome Computer</th>
                            <th>Dimensione della cartella</th>
                            <th>Ultimo accesso</th>
                            <th>Ultima modifica</th>
                            <th>Stato</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php $i = 0; foreach($results as $comp): ?>
                        <tr <?php if($error[$i] == 1){echo 'class="danger"';}else{ echo 'class="success"'; } ?>>
                            <th scope="row"><?php echo $nomeComputer[$i]; ?></th>
                            <td><?php echo $size[$i] . " " . $checkLetteraDim[$i]; ?>B</td>
                            <td><?php echo $last_access[$i]; ?></td>
                            <td><?php echo $last_modify[$i]; ?></td>
                            <td><?php if($error[$i] == 2){echo '<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>'; }else{echo '<span class="glyphicon glyphicon-warning-sign" aria-hidden="true"></span>';} ?></td>
                        </tr>
                    <?php $i++; endforeach; ?>
                    </tbody>
                </table>
				<!--<div class="col-lg-6 alert alert-success" style="margin-right: 10px; margin-left: -10px;"><h3><strong>Nome computer:</strong></h3><h3><?php echo $_GET['id']; ?></h3></div>
                <div class="col-lg-6 alert alert-success" style="margin-left: 10px; margin-right: -10px;"><h3><strong>Dimensione della cartella:</strong></h3><h3><?php echo $dimensione . " " . $checkLetteraDim;?>B (<?php echo number_format($folder_precent,2,",","."); ?>%)</h3></div>
            </div>
            <div class="col-lg-12 text-center">
				<div class="col-lg-6 alert alert-success" style="margin-right: 10px; margin-left: -10px;"><h3><strong>Ultimo accesso effettuato il:</strong></h3><h3><?php echo $accesso; ?></h3></div>
                <div class="col-lg-6 alert alert-success" style="margin-left: 10px; margin-right: -10px;"><h3><strong>Ultima modifica effettuata il:</strong></h3><h3><?php echo $ultimaModifica; ?> (<?php if($days == 1){echo $days." giorno fa";}elseif($days == 0){echo "oggi";}else{echo $days." giorni fa";} ?>)</h3>--></div>
            </div>
            
            <?php else:
			$txt_file    = file_get_contents('output.txt');
			$rows        = explode("\n", $txt_file);
			
			$searchword = "media";
			$matches = array();
			foreach($rows as $key => $value)
			{
				if(preg_match("/\b$searchword\b/i", $value)) {
					$matches[$key] = $value;
				}
			}
			$row = implode(" ",$matches);
			$row = explode(" ",$row);
			$row = array_filter( $row );
			$row = array_slice($row,0);
			/*Tutti i calcoli devono essere fatti in GB quindi vengono trasformati i valori in TB e in MB
			SPAZIO USATO*/
			switch(substr($row[2],-1)){
				case "T":
				$spazioUsato = substr($row[2],0,-1)*1024;
				break;
				
				case "M":
				$spazioUsato = number_format(substr($row[2],0,-1)/1024,2);
				break;
				
				default:
				$spazioUsato = substr($row[2],0,-1);
			}
			/*Tutti i calcoli devono essere fatti in GB quindi vengono trasformati i valori in TB e in MB
			SPAZIO RIMASTO*/
			switch($_SESSION['checkLetter'] = substr($row[3],-1)){
				case "T":
				$spazioRimasto = substr($row[3],0,-1)*1024;
				break;
				
				case "M":
				$spazioRimasto = number_format(substr($row[3],0,-1)/1024,2);
				break;
				
				default:
				$spazioRimasto = substr($row[3],0,-1);
			}
			$_SESSION['totalSpace'] = substr($row[1],0,-1); 
			?>
  <h1>Dashboard</h1>
  <div class="col-sm-6 col-md-6">
    <div class="thumbnail">
      <div id="doughnutChart" class="chart"></div>
      <div class="caption">
        <h3>Grafico del disco corrente</h3>
        <h3 style="margin-top: 530px;">Legenda:</h3>
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6 center-block">
            	<h4 class="legenda red">Spazio utilizzato in GB</h4>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 center-block">
                <h4 class="legenda green">Spazio rimasto in GB</h4>
            </div>
         </div>
      </div>
    </div>
  </div>
  <?php $percent_used = number_format(($spazioUsato / ($spazioRimasto+$spazioUsato))*100,2);
  $percent_remain = number_format(($spazioRimasto / ($spazioRimasto+$spazioUsato))*100,2); ?>
  <div class="col-sm-6 col-md-6">
  <div class="thumbnail">
      <div class="caption">
          <h3>Stato dell'attività</h3>
          <div class="row">
            <div class="col-lg-12">
            <?php if(in_array(1,$error)): ?>
            	<img src="img/close.png" class="img-responsive center-block" />
			<?php else: ?>
            	<img src="img/checkmark.png" class="img-responsive center-block" />
			<?php endif; ?>
            </div>
            <div class="col-lg-12">
            <?php if(in_array(1,$error)): 
			$combine = array_combine($computers, $error);
			$first = NULL;
			while ($error2 = current($combine)) {
				if ($error2 == 1) {
					$first .= trim(key($combine)).', ';
				}
				next($combine);
			}
			?>
            	<div class="alert alert-danger">Errori nei computer di: <?php echo substr($first,0,-3); ?>.</div>
			<?php else: ?>
            	<div class="alert alert-success">Nessun errore riscontrato finora.</div>
			<?php endif; ?>
            <?php if($percent_remain < 15): ?>
            	<div class="alert alert-warning">Lo spazio nel tuo disco sta finendo. Provvedi a liberarlo.</div>
            <?php endif; ?>
            </div>
          </div>
      </div>
  </div>
    <div class="thumbnail">
      <div class="caption">
        <h3>Valori del disco in Gigabyte</h3>
        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-6 center-block">
            	<h4>Spazio totale</h4>
                <h4><b><?php echo number_format($spazioRimasto + $spazioUsato,2,",","."); ?></b></h4>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-6 center-block">
                <h4>Spazio utilizzato</h4>
                <h4><b><?php echo number_format($spazioUsato,2,",","."); ?></b></h4>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-6 center-block">
                <h4>Spazio rimasto</h4>
                <h4><b><?php echo number_format($spazioRimasto,2,",","."); ?></b></h4>
            </div>
         </div>
      </div>
    </div>
    <div class="thumbnail">
      <div class="caption">
        <h3>Valori del disco in percentuale</h3>
        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-6 center-block">
            	<h4>Spazio totale</h4>
                <h4><b>100,00%</b></h4>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-6 center-block">
                <h4>Spazio utilizzato</h4>
                <h4><b><?php echo $percent_used; ?>%</b></h4>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-6 center-block">
                <h4>Spazio rimasto</h4>
                <h4><b><?php echo $percent_remain; ?>%</b></h4>
            </div>
         </div>
      </div>
    </div>
  </div>
  
            <?php endif; ?>
            
        </div>
        
        <!-- /.row -->

    </div>
    <!-- /.container -->
    <!-- Bootstrap Core JavaScript -->
    
	<script src='js/jquery.min.js'></script>
<?php if(!isset($_GET['id'])): ?>
	<script>
    $(function(){
  $("#doughnutChart").drawDoughnutChart([
    { title: "Disco usato in GB",         value : <?php echo $spazioUsato; ?>,  color: "#FC4349" },
    { title: "Disco rimasto in GB",        value : <?php echo $spazioRimasto; ?>,   color: "#57EF1E" }
  ]);
});
/*!
 * jquery.drawDoughnutChart.js
 * Version: 0.4.1(Beta)
 * Inspired by Chart.js(http://www.chartjs.org/)
 *
 * Copyright 2014 hiro
 * https://github.com/githiro/drawDoughnutChart
 * Released under the MIT license.
 * 
 */
;(function($, undefined) {
  $.fn.drawDoughnutChart = function(data, options) {
    var $this = this,
      W = $this.width(),
      H = $this.height(),
      centerX = W/2,
      centerY = H/2,
      cos = Math.cos,
      sin = Math.sin,
      PI = Math.PI,
      settings = $.extend({
        segmentShowStroke : true,
        segmentStrokeColor : "#0C1013",
        segmentStrokeWidth : 1,
        baseColor: "rgba(0,0,0,0.5)",
        baseOffset: 4,
        edgeOffset : 10,//offset from edge of $this
        percentageInnerCutout : 75,
        animation : true,
        animationSteps : 90,
        animationEasing : "easeInOutExpo",
        animateRotate : true,
        tipOffsetX: -8,
        tipOffsetY: -45,
        tipClass: "doughnutTip",
        summaryClass: "doughnutSummary",
        summaryTitle: "TOTALE: GB ",
        summaryTitleClass: "doughnutSummaryTitle",
        summaryNumberClass: "doughnutSummaryNumber",
        beforeDraw: function() {  },
        afterDrawed : function() {  },
        onPathEnter : function(e,data) {  },
        onPathLeave : function(e,data) {  }
      }, options),
      animationOptions = {
        linear : function (t) {
          return t;
        },
        easeInOutExpo: function (t) {
          var v = t<.5 ? 8*t*t*t*t : 1-8*(--t)*t*t*t;
          return (v>1) ? 1 : v;
        }
      },
      requestAnimFrame = function() {
        return window.requestAnimationFrame ||
          window.webkitRequestAnimationFrame ||
          window.mozRequestAnimationFrame ||
          window.oRequestAnimationFrame ||
          window.msRequestAnimationFrame ||
          function(callback) {
            window.setTimeout(callback, 1000 / 60);
          };
      }();

    settings.beforeDraw.call($this);

    var $svg = $('<svg width="' + W + '" height="' + H + '" viewBox="0 0 ' + W + ' ' + H + '" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"></svg>').appendTo($this),
        $paths = [],
        easingFunction = animationOptions[settings.animationEasing],
        doughnutRadius = Min([H / 2,W / 2]) - settings.edgeOffset,
        cutoutRadius = doughnutRadius * (settings.percentageInnerCutout / 100),
        segmentTotal = 0;

    //Draw base doughnut
    var baseDoughnutRadius = doughnutRadius + settings.baseOffset,
        baseCutoutRadius = cutoutRadius - settings.baseOffset;
    $(document.createElementNS('http://www.w3.org/2000/svg', 'path'))
      .attr({
        "d": getHollowCirclePath(baseDoughnutRadius, baseCutoutRadius),
        "fill": settings.baseColor
      })
      .appendTo($svg);

    //Set up pie segments wrapper
    var $pathGroup = $(document.createElementNS('http://www.w3.org/2000/svg', 'g'));
    $pathGroup.attr({opacity: 0}).appendTo($svg);

    //Set up tooltip
    var $tip = $('<div class="' + settings.tipClass + '" />').appendTo('body').hide(),
        tipW = $tip.width(),
        tipH = $tip.height();

    //Set up center text area
    var summarySize = (cutoutRadius - (doughnutRadius - cutoutRadius)) * 2,
        $summary = $('<div class="' + settings.summaryClass + '" />')
                   .appendTo($this)
                   .css({ 
                     width: summarySize + "px",
                     height: summarySize + "px",
                     "margin-left": -(summarySize / 2) + "px",
                     "margin-top": -(summarySize / 2) + "px"
                   });
    var $summaryTitle = $('<p class="' + settings.summaryTitleClass + '">' + settings.summaryTitle + '</p>').appendTo($summary);
    var $summaryNumber = $('<p class="' + settings.summaryNumberClass + '"></p>').appendTo($summary).css({opacity: 0});

    for (var i = 0, len = data.length; i < len; i++) {
      segmentTotal += data[i].value;
      $paths[i] = $(document.createElementNS('http://www.w3.org/2000/svg', 'path'))
        .attr({
          "stroke-width": settings.segmentStrokeWidth,
          "stroke": settings.segmentStrokeColor,
          "fill": data[i].color,
          "data-order": i
        })
        .appendTo($pathGroup)
        .on("mouseenter", pathMouseEnter)
        .on("mouseleave", pathMouseLeave)
        .on("mousemove", pathMouseMove);
    }

    //Animation start
    animationLoop(drawPieSegments);

    //Functions
    function getHollowCirclePath(doughnutRadius, cutoutRadius) {
        //Calculate values for the path.
        //We needn't calculate startRadius, segmentAngle and endRadius, because base doughnut doesn't animate.
        var startRadius = -1.570,// -Math.PI/2
            segmentAngle = 6.2831,// 1 * ((99.9999/100) * (PI*2)),
            endRadius = 4.7131,// startRadius + segmentAngle
            startX = centerX + cos(startRadius) * doughnutRadius,
            startY = centerY + sin(startRadius) * doughnutRadius,
            endX2 = centerX + cos(startRadius) * cutoutRadius,
            endY2 = centerY + sin(startRadius) * cutoutRadius,
            endX = centerX + cos(endRadius) * doughnutRadius,
            endY = centerY + sin(endRadius) * doughnutRadius,
            startX2 = centerX + cos(endRadius) * cutoutRadius,
            startY2 = centerY + sin(endRadius) * cutoutRadius;
        var cmd = [
          'M', startX, startY,
          'A', doughnutRadius, doughnutRadius, 0, 1, 1, endX, endY,//Draw outer circle
          'Z',//Close path
          'M', startX2, startY2,//Move pointer
          'A', cutoutRadius, cutoutRadius, 0, 1, 0, endX2, endY2,//Draw inner circle
          'Z'
        ];
        cmd = cmd.join(' ');
        return cmd;
    };
    function pathMouseEnter(e) {
      var order = $(this).data().order;
      $tip.text(data[order].title + ": " + data[order].value)
          .fadeIn(200);
      settings.onPathEnter.apply($(this),[e,data]);
    }
    function pathMouseLeave(e) {
      $tip.hide();
      settings.onPathLeave.apply($(this),[e,data]);
    }
    function pathMouseMove(e) {
      $tip.css({
        top: e.pageY + settings.tipOffsetY,
        left: e.pageX - $tip.width() / 2 + settings.tipOffsetX
      });
    }
    function drawPieSegments (animationDecimal) {
      var startRadius = -PI / 2,//-90 degree
          rotateAnimation = 1;
      if (settings.animation && settings.animateRotate) rotateAnimation = animationDecimal;//count up between0~1

      drawDoughnutText(animationDecimal, segmentTotal);

      $pathGroup.attr("opacity", animationDecimal);

      //If data have only one value, we draw hollow circle(#1).
      if (data.length === 1 && (4.7122 < (rotateAnimation * ((data[0].value / segmentTotal) * (PI * 2)) + startRadius))) {
        $paths[0].attr("d", getHollowCirclePath(doughnutRadius, cutoutRadius));
        return;
      }
      for (var i = 0, len = data.length; i < len; i++) {
        var segmentAngle = rotateAnimation * ((data[i].value / segmentTotal) * (PI * 2)),
            endRadius = startRadius + segmentAngle,
            largeArc = ((endRadius - startRadius) % (PI * 2)) > PI ? 1 : 0,
            startX = centerX + cos(startRadius) * doughnutRadius,
            startY = centerY + sin(startRadius) * doughnutRadius,
            endX2 = centerX + cos(startRadius) * cutoutRadius,
            endY2 = centerY + sin(startRadius) * cutoutRadius,
            endX = centerX + cos(endRadius) * doughnutRadius,
            endY = centerY + sin(endRadius) * doughnutRadius,
            startX2 = centerX + cos(endRadius) * cutoutRadius,
            startY2 = centerY + sin(endRadius) * cutoutRadius;
        var cmd = [
          'M', startX, startY,//Move pointer
          'A', doughnutRadius, doughnutRadius, 0, largeArc, 1, endX, endY,//Draw outer arc path
          'L', startX2, startY2,//Draw line path(this line connects outer and innner arc paths)
          'A', cutoutRadius, cutoutRadius, 0, largeArc, 0, endX2, endY2,//Draw inner arc path
          'Z'//Cloth path
        ];
        $paths[i].attr("d", cmd.join(' '));
        startRadius += segmentAngle;
      }
    }
    function drawDoughnutText(animationDecimal, segmentTotal) {
      $summaryNumber
        .css({opacity: animationDecimal})
        .text((segmentTotal * animationDecimal).toFixed(1));
    }
    function animateFrame(cnt, drawData) {
      var easeAdjustedAnimationPercent =(settings.animation)? CapValue(easingFunction(cnt), null, 0) : 1;
      drawData(easeAdjustedAnimationPercent);
    }
    function animationLoop(drawData) {
      var animFrameAmount = (settings.animation)? 1 / CapValue(settings.animationSteps, Number.MAX_VALUE, 1) : 1,
          cnt =(settings.animation)? 0 : 1;
      requestAnimFrame(function() {
          cnt += animFrameAmount;
          animateFrame(cnt, drawData);
          if (cnt <= 1) {
            requestAnimFrame(arguments.callee);
          } else {
            settings.afterDrawed.call($this);
          }
      });
    }
    function Max(arr) {
      return Math.max.apply(null, arr);
    }
    function Min(arr) {
      return Math.min.apply(null, arr);
    }
    function isNumber(n) {
      return !isNaN(parseFloat(n)) && isFinite(n);
    }
    function CapValue(valueToCap, maxValue, minValue) {
      if (isNumber(maxValue) && valueToCap > maxValue) return maxValue;
      if (isNumber(minValue) && valueToCap < minValue) return minValue;
      return valueToCap;
    }
    return $this;
  };
})(jQuery);
    </script>
<?php endif; ?>
    <script src="js/bootstrap.min.js"></script>

</body>

</html>
