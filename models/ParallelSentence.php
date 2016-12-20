<?

class ParallelSentence{

	public static function getHtml2($word,$xml,$num)
	{
		$err = 0;
		$punc=array("·",",",".");

		$xml=simplexml_load_string("<xml>".str_replace(array("aligned-text","xml:lang"),array("alignedtext","xmllang"),$xml)."</xml>");

		if(!$xml) $err++;
		else
		{
			$language = $xml->alignedtext->language;
			$temp = $language[0]->attributes();
			$languages[0]=$temp["xmllang"];
			$temp = $language[1]->attributes();
			$languages[1]=$temp["xmllang"];

			$wds=$xml->alignedtext->sentence->wds;
			//print_r($wds);
			$lang1=$wds[0];
			$lang2=$wds[1];

			$uri1 = "".$wds[0]->commet;
			$uri2 = "".$wds[1]->commet; ;
			$uri1 = explode("/urn:cts:",$uri1);
			$uri1 = "urn:cts:".$uri1[1];
			$uri2 = explode("/urn:cts:",$uri2);
			$uri2 = "urn:cts:".$uri2[1];
			$first_sentence="";
			$second_sentence="";


			foreach($lang1->w as $k) {
				$id=$k->attributes()->n;


				//print_r($ref);
				if($k->refs){
					$ref = $k->refs->attributes();
					$ref = $ref['nrefs'];
					if($ref!="")
						$ref=" onmouseout=\"reset('".$id."','".$ref."',$num)\" onmouseover=\"highlight('".$id."','".$ref."',$num)\"";
					else
						$ref = " class='notAligned'";

				}else
					$ref = " class='notAligned'";
				if($k->text == "###" || $k->text == "***" )
					$first_sentence.= "<br>";
				else
					$first_sentence.="<span id='A_".$num."_".$id."'  $ref >".$k->text."</span>";
				if(!in_array($k->text,$punc))
					$first_sentence.=" ";

			}

			foreach($lang2->w as $k) {
				$id=$k->attributes()->n;
				if($k->refs){
					$ref = $k->refs->attributes();
					$ref = $ref['nrefs'];
					if($ref!="")
						$ref = " onmouseout=\"reset('".$ref."','".$id."',$num)\" onmouseover=\"highlight('".$ref."','".$id."',$num)\"";
					else
						$ref = " class='notAligned'";

				}else
					$ref = " class='notAligned'";
				if($k->text == "###" || $k->text == "***" )
					$second_sentence.= "<br>";
				else
					$second_sentence.="<span id='B_".$num."_".$id."'  $ref >".$k->text."</span>";
				if(!in_array($k->text,$punc))
					$second_sentence.=" ";

			}

			return "<div class='row'><div class='col-md-6'>".$uri1."</div><div class='col-md-6'>".$uri2."</div></div>
					<div class='row'><div class='col-md-6'>".$first_sentence."</div><div class='col-md-6'>".$second_sentence."</div></div>";
			//return array($first_sentence,$languages, $second_sentence,$languages[1]);
		}


	}

	public static function styleEditors($editors){
		$ed = explode("||", $editors);
		$ret=array();

		foreach ($ed as $k=>$v)
			$ret[$k] = "<i class='fa fa-user'></i> $v ";
		return implode(" , ",$ret);

	}

	public static function getHtml($word,$xml,$num){
	  $punc=array("·",",",".");
	  $xml=simplexml_load_string($xml);
	  if(!$xml) $return="";
	  else
	  {
  	   	$wds=$xml->wds;
		$original=$wds[0];
		$english=$wds[1];
		$words1 = array();
		$words2 = array();
		$uri1 = explode("/urn:cts:","".$wds[0]->comment);
		$uri1 = "urn:cts:".$uri1[1];
		$uri2 = explode("/urn:cts:","".$wds[1]->comment);
		$uri2 = "urn:cts:".$uri2[1];
		$english_sentence="";
		$original_sentence="";

		foreach($original->w as $k) {
		   $id=$k->attributes()->n;
			if($k->refs) {
				$ref = $k->refs->attributes()->nrefs;
				if ($ref != "")
					$ref = " onmouseout=\"reset('" . $id . "','" . $ref . "',$num)\" onmouseover=\"highlight('" . $id . "','" . $ref . "',$num)\"";
				else
					$ref = " class='notAligned'";
			}else
				$ref = " class='notAligned'";
			if($k->text == "###" || $k->text == "***" )
				$original_sentence.="<br>";
			else
				$original_sentence.="<span id='A_".$num."_".$id."'  $ref >".$k->text."</span>";
		   if(!in_array($k->text,$punc))  
		   		$original_sentence.=" ";  
	   }  
	   foreach($english->w as $k) {
		   $id=$k->attributes()->n;
		   if($k->refs) {
			   $ref = $k->refs->attributes()->nrefs;
			   if ($ref != "")
				   $ref = " onmouseout=\"reset('" . $ref . "','" . $id . "',$num)\" onmouseover=\"highlight('" . $ref . "','" . $id . "',$num)\"";
			   else
				   $ref = " class='notAligned'";
		   }else
			   $ref = " class='notAligned'";
		   if($k->text == "###" || $k->text == "***" )
			   $english_sentence.="<br>";
		   else
		   		$english_sentence.="<span id='B_".$num."_".$id."'  $ref >".$k->text."</span>";
		   if(!in_array($k->text,$punc))  
		   		$english_sentence.=" ";  
	   }   

	   $return= "<div class='row'><div class='col-md-6'><span class='urn'>".$uri1."</span></div><div class='col-md-6'><span class='urn'>".$uri2."</span></div></div>
					<div class='row'><div class='col-md-6' style='direction:rtl;font-family: IranNastaliq; font-size: 20pt;font-weight: lighter;'>".self::highLight($word,$original_sentence)."</div>
	   							  <div class='col-md-6' style='line-height: 275%;'>".self::highLight($word,$english_sentence)."</div></div>";
	  
	  }// /else

	return $return;
	}

	public static function getHtml3($word,$xml,$num){
		$punc=array("·",",",".");
		$xml=simplexml_load_string($xml);
		if(!$xml) $return="";
		else
		{
			$wds=$xml->wds;
			$original=$wds[0];
			$english=$wds[1];

			$uri1 = explode("/urn:cts:","".$wds[0]->comment);
			$uri1 = "urn:cts:".$uri1[1];
			$uri2 = explode("/urn:cts:","".$wds[1]->comment);
			$uri2 = "urn:cts:".$uri2[1];
			$english_sentence="";
			$original_sentence="";
			$highlighted1 = array();
			$highlighted2 = array();
			foreach($original->w as $k) {
				$id=$k->attributes()->n;

				if($k->text == $word){
					$ref = $k->refs->attributes()->nrefs;
					$highlighted1[] = "".$id;
					$temp = explode(" ",trim("".$ref));
					foreach ($temp as $s=>$t){
						$highlighted2[] = $t;
					}

				}
		}
			foreach($english->w as $k) {
				$id=$k->attributes()->n;

				if($k->text == $word){
					$ref = $k->refs->attributes()->nrefs;
					$highlighted2[] = "".$id;
					$temp = explode(" ",trim("".$ref));
					foreach ($temp as $s=>$t){
						$highlighted1[] = $t;
					}
				}
			}
			//print_r($highlighted1); print_r($highlighted2);echo "===============";
			foreach($original->w as $k) {
				$id=$k->attributes()->n;
				if($k->refs) {
					$ref = $k->refs->attributes()->nrefs;

					if ($ref != ""){
						if(in_array($id,$highlighted1)){
							$ref = " onmouseout=\"reset('" . $id . "','" . $ref . "',$num)\" onmouseover=\"highlight('" . $id . "','" . $ref . "',$num)\" style=\"background-color:#FF4466;padding:2px;border: 2px solid;border-radius: 5px;color:#FFF\"";
						}else
							$ref = " onmouseout=\"reset('" . $id . "','" . $ref . "',$num)\" onmouseover=\"highlight('" . $id . "','" . $ref . "',$num)\"";
					}

					else
						$ref = " class='notAligned'";
				}else
					$ref = " class='notAligned'";
				if($k->text == "###" || $k->text == "***" )
					$original_sentence.="<br>";
				else
					$original_sentence.="<span id='A_".$num."_".$id."'  $ref >".$k->text."</span>";
				if(!in_array($k->text,$punc))
					$original_sentence.=" ";
			}
			foreach($english->w as $k) {
				$id=$k->attributes()->n;
				if($k->refs) {
					$ref = $k->refs->attributes()->nrefs;
					if ($ref != ""){
						if(in_array($id,$highlighted2)){
							$ref = " onmouseout=\"reset('" . $ref . "','" . $id . "',$num)\" onmouseover=\"highlight('" . $ref . "','" . $id . "',$num)\" style=\"background-color:#FF4466;padding:2px;border: 2px solid;border-radius: 5px;color:#FFF\"";
						}else{
							$ref = " onmouseout=\"reset('" . $ref . "','" . $id . "',$num)\" onmouseover=\"highlight('" . $ref . "','" . $id . "',$num)\"";
						}
					}

					else
						$ref = " class='notAligned'";
				}else
					$ref = " class='notAligned'";
				if($k->text == "###" || $k->text == "***" )
					$english_sentence.="<br>";
				else
					$english_sentence.="<span id='B_".$num."_".$id."'  $ref >".$k->text."</span>";
				if(!in_array($k->text,$punc))
					$english_sentence.=" ";
			}

			$return= "<div class='row'><div class='col-md-6'><span class='urn'>".$uri1."</span></div><div class='col-md-6'><span class='urn'>".$uri2."</span></div></div>
					<div class='row'><div class='col-md-6' style='direction:rtl;font-family: IranNastaliq; font-size: 20pt;font-weight: lighter;'>".$original_sentence."</div>
	   							  <div class='col-md-6' style='line-height: 275%;'>".$english_sentence."</div></div>";

		}// /else

		return $return;
	}


	public static function highLight($w,$text)
	 {
		 $w=explode(" ",$w);
		 foreach($w as $wort){
 			 $pattern = '/(\W|^)'.$wort.'(\W|$)/u';
			 $replacement = '<b class="highlighted" style="background-color:#FF4466;padding:2px;  color:#FFF;border: 2px solid;border-radius: 5px;" >'.$wort.'</b>\2';
			 $text= preg_replace($pattern, $replacement, $text);
		 }
		 return $text;
	 }
	
	public static function getTxt($xml){
	  $punc=array("·",",",".");
	  $xml=simplexml_load_string($xml);
	
	  if(!$xml) $return="";
	
	  else
	  {
  	   	$wds=$xml->wds;
		$original=$wds[0];
		$english=$wds[1];

		$english_sentence="";
		$original_sentence="";
		
		foreach($original->w as $k) {
		   $original_sentence.=$k->text;
		   if(!in_array($k->text,$punc))  
		   		$original_sentence.=" ";  
	   }  
	   
	   foreach($english->w as $k) {
		   $english_sentence.=$k->text;
		   if(!in_array($k->text,$punc))  
		   		$english_sentence.=" ";  
	   }   

	   $return=$original_sentence."\t".$english_sentence ;  
	  }// /else

	return $return;
	}
	
	public static function getJSON($xml){
		$punc=array("·",",",".");
	  $xml=simplexml_load_string($xml);
	
	  if(!$xml) $return="";
	
	  else
	  {
  	   	$wds=$xml->wds;
		$original=$wds[0];
		$english=$wds[1];

		$english_sentence="";
		$original_sentence="";
		
		foreach($original->w as $k) {
		   $original_sentence.=$k->text;
		   if(!in_array($k->text,$punc))  
		   		$original_sentence.=" ";  
	   }  
	   
	   foreach($english->w as $k) {
		   $english_sentence.=$k->text;
		   if(!in_array($k->text,$punc))  
		   		$english_sentence.=" ";  
	   }   

	   $return=array("original"=>$original_sentence,"english"=>$english_sentence) ;  
	  }// /else

	return $return;
	}
}

?>