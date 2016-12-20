
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Diwan Hafez (The Persian English Dynamic Lexicon):::: Digital Humanities - Uni Leipzig</title>

    <link href='http://fonts.googleapis.com/css?family=Roboto+Condensed' rel='stylesheet' type='text/css'>    <!-- FA-Icons -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css">
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
    <link href="../css/style.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body style="background-color: steelblue ">
<!-- Wrapper Class for Responsive Footer -->
<div class="wrapper center">
    <div class="container" id="header">    </div>
  

    <h3 style="color: #FFF;">Diwan Hafez - <span style="font-family: IranNastaliq; font-size: 30pt"> ديوان حافظ</span></h3>
    <h5 style="color: #FFF"> (Persian-English Dynamic Lexicon)</h5>
    <div class="col-md-6 col-sm-8 col-md-offset-3 col-sm-offset-2">
        <div class ="form-group">
            <form role ="form" method="get" name="frm" action="res.php">
                <div class="input-group">
                    <input  type="text" class="form-control" name="word" autocomplete="off"  onkeyup="autoComplete()" required onchange="autoComplete()" id="searchfieldLexicon">
                    <div class="input-group-btn">
                        <button class="btn search-btn btn-default" id="submit-search" type="submit" >
                            <i class="fa fa-search" id="searchIcon"></i>
                        </button>

                    </div><!-- /input-group-btn -->
                </div><!-- /input-group -->
                <label class="radio-inline White">
                    <input type="radio" name="language" id="english" value="eng" checked> English
                </label>
                <label class="radio-inline White">
                    <input type="radio" name="language" id="far" value="far"> Persian
                </label>

                <a class ="navbar-btn btn btn-sm"  data-toggle="modal" data-target="#myModal2" style="color:#000">
                    <i class="fa fa-keyboard-o"></i>  Persian Keyboard </a> <br>

            </form>   <!-- /Form -->
            <span id="lexicaAutoComplete" style="margin: auto"><br></span>
        </div><!-- /form-group -->
    </div><!-- /col-md-6 -->


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
    <div class="push"></div>
</div> <!-- /Wrapper -->
<div id="footer">
    <ul id="footerlist">
        <li><span style="color:#000"> Implemented by Tariq Yousef</span></li>
    </ul>
    <font size="2" color="#888">Alexander von Humboldt-Lehrstuhl f&uuml;r Digital Humanities
        - Creative Commons Attribution-ShareAlike 4.0 International License	<?=date("Y")?></font>
</div> <!-- /footer -->

<!-- Bootstrap core JavaScript
    ================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<script src="../js/script.js"></script>
<script language=javascript>
    $( document ).ready(function() {
        //$("#header").addClass("load");
        $("#header").fadeIn("slow");});

    function autoComplete()
    {
        var val=$("#searchfieldLexicon").val();
        // getr Lang Values
        var lang = "en";
        var selected = $("input[type='radio'][name='language']:checked");
        if (selected.length > 0) {
            lang = selected.val();
        }
        var url="autocomplete.php?lang="+lang+"&t="+val;
        //console.log(url);
        $("#lexicaAutoComplete").load(url);
    }
</script>
</body>
</html>