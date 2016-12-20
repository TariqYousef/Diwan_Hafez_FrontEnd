<?php

require_once ("DbConnection.php");
require_once ("ParallelSentence.php");

//TODO List:
// 1 - many-to-many aligbment highlighting
// 2 - 


class HafezCorpus{
    static $pairsTable = "hafezTranslationPairs";
    static $sentencesTable = "hafezSentences";

    public static function getEnglishTranslationOfFarsiWord($word, $format="diagram"){
        $con = DbConnection::getInstance();
        $q = "select * from ".self::$pairsTable." where far='".addslashes($word)."' order by freq DESC limit 0,10";
        $res = $con->query($q);


        $diagram[]="['".$word."','Translations']";
        $txt=array();
        $json=array();

        // iterate through the query results
        while($w=$res->fetch_array())
        {
            $freq=$w['freq'];
            $diagram[]="['".addslashes($w['eng'])."',".$freq."]";
            $txt[]=$w['far']."\t".$w['eng']."\t".$freq;
            $json[]=array("Farsi"=>$w['far'],"English"=>$w['eng'],"freq"=>$w['freq']);
        }


        // return the results
        if(strtolower($format)=="diagram")
            $return = implode(",",$diagram);
        else if(strtolower($format)=="json")
            $return = json_encode($json);	//return the results json format
        else
            $return = implode("\n",$txt); // return the results in tabular csv

        return $return;
    }

    public static function prefixAutoCommplete($word,$lang)
    {
        $con=DbConnection::getInstance(); $return=array();

        $search="eng";
        $where="eng like '".$word."%'";
        
        if($lang=="far") {
            $search = "far";
            $where = "far like '" . $word . "%'";
        }
        
        $q="select distinct($search) from ".self::$pairsTable." where $where   order by freq DESC limit 0,10";
        $res=$con->query($q);
        while($row=$res->fetch_array())
            $return[$row[0]]="<a href='res.php?language=".$lang."&word=".$row[0]."' class='label label-success' style='font-size:16px'>".$row[0]."</a>";
        return $return;
    }

    public static function getFarsiTranslationOfEnglishWord($word,$format="diagram"){
        
        $con = DbConnection::getInstance();
        $q = "select * from ".self::$pairsTable." where eng='".addslashes($word)."' order by freq DESC limit 0,10";
        $res = $con->query($q);
        

        $diagram[]="['".$word."','Translations']";
        $txt=array();
        $json=array();
        
        // iterate through the query results
        while($w=$res->fetch_array())
        {
            $freq=$w['freq'];
            $diagram[]="['".addslashes($w['far'])."',".$freq."]";
            $txt[]=$w['far']."\t".$w['eng']."\t".$freq;
            $json[]=array("Farsi"=>$w['far'],"English"=>$w['eng'],"freq"=>$w['freq']);
        }

        
        // return the results
        if(strtolower($format)=="diagram")
            $return = implode(",",$diagram);
        else if(strtolower($format)=="json")
            $return = json_encode($json);	//return the results json format
        else
            $return = implode("\n",$txt); // return the results in tabular csv

        return $return;

    }

    public static function getExamples($word,$format="html"){
        $con=DbConnection::getInstance();
        $words = explode(" ",trim($word));
        $like = "<text>".addslashes(($word))."</text>";
        if(sizeof($words) > 1){
            $temp = array();
            foreach ($words as $k=>$v)
                $temp[$k] = "<text>".addslashes(($v))."</text>";
            $like = implode("%",$temp);
        }
        $q="select * from ".self::$sentencesTable." where xml like'%$like%' limit 0,12";
        $lt=$con->query($q);
        $html=array();$txt=array();
        $i=0;
        while($w=$lt->fetch_array()){
            $i++;
            $html[]=ParallelSentence::getHtml3($word,$w['xml'],$i)." ".ParallelSentence::styleEditors($w['prov']);
            $txt[]=ParallelSentence::getTxt($w['xml']);
            $json[]=ParallelSentence::getJSON($w['xml']);
        }
        // return the results
        if(strtolower($format)=="html")
            $return=implode("<hr>",$html);
        else if(strtolower($format)=="json")
            $return=json_encode($json);	//return the results json format
        else
            $return=implode("\n",$txt); // return the results in tabular csv

        return $return;
    }

    public static function getExamplesTwoWords($wordFar,$wordEng,$format="html"){
        $con=DbConnection::getInstance();

        $q="select * from ".self::$sentencesTable." where xml like'%<text>".addslashes(($wordFar))."</text>%<text>".addslashes(($wordEng))."</text>%' limit 0,12";
        $lt=$con->query($q);
        $html=array();
        $txt=array();
        $i=0;
        while($w=$lt->fetch_array()){
            $i++;
            $html[$i]=ParallelSentence::getHtml($wordFar,$w['xml'],$i)." ".ParallelSentence::styleEditors($w['prov']);
            $txt[$i]=ParallelSentence::getTxt($w['xml']);
            $json[$i]=ParallelSentence::getJSON($w['xml']);
        }
        // return the results
        if(strtolower($format)=="html")
            $return=implode("<hr>",$html);
        else if(strtolower($format)=="json")
            $return=json_encode($json);	//return the results json format
        else
            $return=implode("\n",$txt); // return the results in tabular csv

        return $return;
    }

}

/* testing
$test =  HafezCorpus::getFarsiTranslationOfEnglishWord("god","json");
print_r($test);
$test =  HafezCorpus::getFarsiTranslationOfEnglishWord("god","txt");
print_r($test);
$test =  HafezCorpus::getFarsiTranslationOfEnglishWord("god");
print_r($test);
$test =  HafezCorpus::getEnglishTranslationOfFarsiWord("شما","json");
print_r($test);
$test =  HafezCorpus::getEnglishTranslationOfFarsiWord("شما","txt");
print_r($test);
$test =  HafezCorpus::getEnglishTranslationOfFarsiWord("شما");
print_r($test); */
?>