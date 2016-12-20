<meta charset="utf-8">
<?
// Dynamic Lexicon :::: autocomplete
require_once("models/HafezCorpus.php");
$pre=$_REQUEST['t'];
$lang=$_REQUEST['lang'];

if($pre!='')
{
    $return=HafezCorpus::prefixAutoCommplete($pre,$lang);
    echo implode(" ",array_slice($return,0,4));
}
else
    echo "<br>";
?>