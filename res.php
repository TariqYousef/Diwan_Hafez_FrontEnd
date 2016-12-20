<?
$word=$_REQUEST['word'];


require_once("models/DbConnection.php");
require_once("models/HafezCorpus.php");

$con=DbConnection::getInstance();
$arr="";
$lang=$_REQUEST['language'];
if($lang=="eng" || $lang=="")
{
    $fararr=HafezCorpus::getFarsiTranslationOfEnglishWord($word,"diagram");
    $examples=HafezCorpus::getExamples($word,"html");
 } 
else if($lang=="far")
{
    $arr=HafezCorpus::getEnglishTranslationOfFarsiWord($word,"diagram");
    $examples=HafezCorpus::getExamples($word,"html");
 } 

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <title>Diwan Hafez (The Persian English Dynamic Lexicon):::: Digital Humanities - Uni Leipzig</title>
    <link href="../css/style.css" rel="stylesheet">
      <link href="css/style.css" rel="stylesheet">

      <link href='http://fonts.googleapis.com/css?family=Roboto+Condensed' rel='stylesheet' type='text/css'>    <!-- FA-Icons -->
	<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-glyphicons.css" rel="stylesheet">
    <script type="text/javascript" src="../js/script.js"></script>


    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css">    
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">  

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->      
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart","wordtree"]});
      google.setOnLoadCallback(drawCharts);

      function drawCharts() {     
		<? 
		 if($lang=="eng" || $lang=="") {
		?>
		// drawing Farsi translation chart
        var data = google.visualization.arrayToDataTable([<?=$fararr?> ]);
        var options = { title: 'Farsi Translation of (<?=$word?>)'};
        var chart = new google.visualization.PieChart(document.getElementById('TranslationChart'));

		<? } else{	// either Greek or Latin
		?>
		var data = google.visualization.arrayToDataTable([<?=$arr?> ]);
        var options = { title: 'English Translation of (<?=$word?>)'};
        var chart = new google.visualization.PieChart(document.getElementById('TranslationChart'));

		////////// First chart ////////
        <? }?>
          chart.draw(data, options);
          google.visualization.events.addListener(chart, 'select', selectHandler);
          function selectHandler(e) {

              $("#examples").html("<div style='margin: auto;text-align: center;'><img src='css/loading.gif'></div>");
              selection = chart.getSelection();
              var message = '';
              for (var i = 0; i < selection.length; i++) {
                  var item = selection[i];
                  if (item.row != null && item.column != null) {
                      var str = data.getFormattedValue(item.row, item.column);
                      message += str + '\n';
                  } else if (item.row != null) {
                      var str = data.getFormattedValue(item.row, 0);
                      message += str + '\n';
                  } else if (item.column != null) {
                      var str = data.getFormattedValue(0, item.column);
                      message +=  str + '\n';
                  }
              }
              $("#ExamplePanelTitle").html("Examples of [ <?=$word?> = "+message.trim()+" ]");

              var url = "loadExamples.php?w1=<?=$word?>&w2="+message.trim();
              <? if($lang=="eng" || $lang=="") { ?>
              url = "loadExamples.php?w1="+message.trim()+"&w2=<?=$word?>";
              <? }  ?>
              console.log(url);
              $("#examples").load(url.replace(/ /g, "%20"));
          }
      }

    </script>
  </head>

  <body style="font-family: 'Roboto Condensed', sans-serif;">
  
        <!-- Wrapper Class for Responsive Footer -->
        <div class="wrapper left">
                
			<nav class="navbar navbar-default">
			  <div class="container-fluid">
				<div class="navbar-header" style="height:100px; width:320px">
				  <a class="navbar-brand" href="index.php">
					<img alt="Brand" src="../images/logo_dh_wid-300x57.png"><br><p style="padding-top:15px;font-size:18px">Diwan Hafez - <span style="font-family: IranNastaliq; font-size: 20pt"> ديوان حافظ</p>
				  </a>
				</div> <!-- /navbar-header -->
                <div class="col-sm-4" style="padding-top:25px;">
                    <form class="res-form" role="form" method="get" name="frm" action="res.php">
                        <div class="input-group">
                            <input id="searchfieldLexicon" type="text" class="form-control" value="<?=$_REQUEST['word']?>" name="word" autocomplete="off" value="" onkeyup="autoComplete()">
                            <span class="input-group-btn">
                                <button class="btn btn-primary" type="submit" value="Submit">
                                    <i class="fa fa-search"></i>
                                </button>                            
                           </span>                            
                        </div> <!-- /input-group -->
						<label class="radio-inline">
						  <input type="radio" name="language" id="english" value="eng" <? if($lang=='eng') echo 'checked';?> > English
						</label>
						<label class="radio-inline">
						  <input type="radio" name="language" id="latin" value="far" <? if($lang=='far') echo 'checked';?>> Farsi
						</label>
						 <a class ="navbar-btn btn btn-sm"  data-toggle="modal" data-target="#myModal2">
                    <i class="fa fa-keyboard-o"></i>  Persian Keyboard </a>
                   </form>  
                    <span id="lexicaAutoComplere" style="margin: auto"><br></span>
				</div> <!-- /col-sm-4 -->
  			</div><!-- /container-fluid -->
		</nav> <!-- /navbar -->


<!-- Start NON English -->
    <div class="panel panel-default" style="margin-left:1%;margin-right:1%">
      <div class="panel-heading" data-toggle="collapse" data-target="#demo">
        <div class="panel-title"><?=$_REQUEST['word']?> </div>
      </div>
      <div class="panel-body" >
      <div style="width:100%;margin-left:2%;margin-right:2%;overflow: hidden; padding:0px">
       	<div id="TranslationChart" style="display: inline-block;width: 100%; height:500px"></div>
	   </div> 
	</div>
    </div>  

<!-- End NON English
<div class="panel panel-default" style="margin-left:1%;margin-right:1%">
   <div class="panel-heading" data-toggle="collapse" >
        <div class="panel-title"><?=$_REQUEST['word']?> </div>
   </div>
   <div class="panel-body" >
      <div style="width:100%;margin-left:2%;margin-right:2%;overflow: hidden;">
		<div id="wordtree_explicit" style="width: 100%; height: 500px;"></div>
	  </div>	
   </div>
</div>
-->
<!-- Start The example box -->
    <div class="panel panel-default" style="margin-left:1%;margin-right:1%">
      <div class="panel-heading" data-toggle="collapse" >
        <div class="panel-title" id="ExamplePanelTitle">Sentence Examples of <?=$_REQUEST['word']?> </div>
      </div>
      <div class="panel-body" id="examples" style="margin: auto;">
      <?=$examples?>
 
	</div>
    </div>  
<!-- End The example Box -->


            <!-- keyboard Layout -->
            <div class="modal " id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                            <h4 class="modal-title center" id="myModalLabel"> <i class="fa fa-keyboard-o"></i>     Persian Keyboard</h4>
                        </div>
                        <div class="modal-body">
                            <div class="btn-group" role="group" aria-label="&#32;">
                                <button type="button" class="btn btn-default" onclick="addText('ا')">	ا</button>
                                <button type="button" class="btn btn-default"	onclick="addText('آ')" >		آ	</button>
                                <button type="button" class="btn btn-default"	onclick="addText('ب')" >		ب	</button>
                                <button type="button" class="btn btn-default"	onclick="addText('پ')" >		پ	</button>
                                <button type="button" class="btn btn-default"	onclick="addText('ت')" >		ت	</button>
                                <button type="button" class="btn btn-default"	onclick="addText('ث')" >		ث	</button>
                                <button type="button" class="btn btn-default"	onclick="addText('ج')" >		ج	</button>
                                <button type="button" class="btn btn-default"	onclick="addText('چ')" >		چ	</button>
                                <button type="button" class="btn btn-default"	onclick="addText('ح')" >		ح	</button>
                                <button type="button" class="btn btn-default"	onclick="addText('خ')" >		خ	</button>
                                <button type="button" class="btn btn-default"	onclick="addText('د')" >		د	</button>
                                <button type="button" class="btn btn-default"	onclick="addText('ذ')" >		ذ	</button>
                                <button type="button" class="btn btn-default"	onclick="addText('ر')" >		ر	</button>
                                <button type="button" class="btn btn-default"	onclick="addText('ز')" >		ز	</button>
                                <button type="button" class="btn btn-default"	onclick="addText('ژ')" >		ژ	</button>
                                <button type="button" class="btn btn-default"	onclick="addText('س')" >		س	</button>
                                <button type="button" class="btn btn-default"	onclick="addText('ش')" >		ش	</button>
                                <button type="button" class="btn btn-default"	onclick="addText('ص')" >		ص	</button>
                                <button type="button" class="btn btn-default"	onclick="addText('ض')" >		ض	</button>
                                <button type="button" class="btn btn-default"	onclick="addText('ط')" >		ط	</button>
                                <button type="button" class="btn btn-default"	onclick="addText('ظ')" >		ظ	</button>
                                <button type="button" class="btn btn-default"	onclick="addText('ع')" >		ع	</button>
                                <button type="button" class="btn btn-default"	onclick="addText('غ')" >		غ	</button>
                                <button type="button" class="btn btn-default"	onclick="addText('ف')" >		ف	</button>
                                <button type="button" class="btn btn-default"	onclick="addText('ق')" >		ق	</button>
                                <button type="button" class="btn btn-default"	onclick="addText('ک')" >		ک	</button>
                                <button type="button" class="btn btn-default"	onclick="addText('گ')" >		گ	</button>
                                <button type="button" class="btn btn-default"	onclick="addText('ل')" >		ل	</button>
                                <button type="button" class="btn btn-default"	onclick="addText('م')" >		م	</button>
                                <button type="button" class="btn btn-default"	onclick="addText('ن')" >		ن	</button>
                                <button type="button" class="btn btn-default"	onclick="addText('و')" >		و	</button>
                                <button type="button" class="btn btn-default"	onclick="addText('ه')" >		ه	</button>
                                <button type="button" class="btn btn-default"	onclick="addText('ی')" >		ی	</button>
                                <button type="button" class="btn btn-default"	onclick="addText('هٔ')" >		هٔ	</button>
                                <button type="button" class="btn btn-default"	onclick="addText('ي')" >		ي	</button>
                                <button type="button" class="btn btn-default"	onclick="addText('أ')" >		أ	</button>
                                <button type="button" class="btn btn-default"	onclick="addText('ؤ')" >		ؤ	</button>
                                <button type="button" class="btn btn-default"	onclick="addText('ئ')" >		ئ	</button>
                                <button type="button" class="btn btn-default"	onclick="addText('ء')" >		ء	</button>
                                <button type="button" class="btn btn-default"	onclick="addText(' ')" >		WHITE SPACE	</button>
                            </div>
                        </div><!-- end of modal-body-->
                    </div> <!-- end of modal-content-->
                </div><!-- end of modal-dialog-->
            </div><!-- end of modal-->					 <!-- end keyboard Layout -->


   <div class="push"> </div>
</div>
   <div id="footer">
   		<font size="2" color="#888">Alexander von Humboldt-Lehrstuhl f&uuml;r Digital Humanities -  Creative Commons Attribution-ShareAlike 4.0 International License ©	2016  </font>            
   	</div>
    
    
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
                <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
                <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
                <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
			    <script type="text/javascript">
    
		     // google.charts.load('current', {packages:['wordtree']});
			 // google.charts.setOnLoadCallback(drawSimpleNodeChart);
			  function drawSimpleNodeChart() {
				var nodeListData = new google.visualization.arrayToDataTable([<?=$array?>]);

				var options = {
				  colors: ['black', 'red', 'black'],fontName: 'Times-Roman',
				  wordtree: {
					format: 'explicit',
					type: 'suffix'
				  }
				};

				var wordtree = new google.visualization.WordTree(document.getElementById('wordtree_explicit'));
				wordtree.draw(nodeListData, options);
				}
			  </script>  
  </body>
</html>