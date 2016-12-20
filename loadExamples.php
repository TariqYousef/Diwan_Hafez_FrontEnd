<meta charset="utf-8">
<?
// Dynamic Lexicon :::: autocomplete
require_once("models/HafezCorpus.php");
$w1=$_REQUEST['w1'];
$w2=$_REQUEST['w2'];
echo HafezCorpus::getExamplesTwoWords($w1,$w2);


?>