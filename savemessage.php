<?php
include "../settings/settings.php"; 
include "base.php";

$date = $_POST;
$today = date("Y-m-d H:i:s");
$id = '1fghfghf';

$array = array('', '', '');
$message = $date['message'];
$text =  trim(strip_tags($message)); 
$messagesmile = emoticonssmile($message);
  for($i = 0; $i < count($array); $i++)
  {
  $res = @substr_count($text , $array[$i]);
  if($res){$yes = true;}
  }
	if($yes){ 
		$info = 'Не матерись! ';
	}else{ 
		$info = 'Все хорошо! '; 
	$savemessage = save_otziv($today, $date['name'], $date['ip'], $id, $messagesmile);
	}

echo json_encode($messagesmile);

function emoticonssmile($message)
{
	$emoticons = array( '<img src="im/smile.gif">' => array(':-)', ':)' , ':o)'),
 '<img src="im/sad.gif">'   => array(':-(', ':(', ':-|'));
 foreach ($emoticons as $emotion => $icons)
    {
        $message = str_replace($icons, " $emotion ", $message);
      }
	return($message);
}