<?php
  include "../settings/settings.php";
  include "base.php";

if (isset($_GET['posts']) ){  //если пришел GET запрос с идентификатором p выполняем код ниже 
	$all1 = allmessage();
	$all = array_reverse($all1);
	$strHtml = '<table>';
	for ($i=0; $i < count($all); $i++) { 
		$strHtml .= '<tr><td> Автор: '  .$all[$i]["avtor"].'</td><td> Дата: '.$all[$i]["data"].'</td></tr><tr><td> Сообщение: '.$all[$i]["text_soobsheniy"].'</td></tr>'; 
	}
 	$strHtml .= '</table>';


echo $strHtml;
  }