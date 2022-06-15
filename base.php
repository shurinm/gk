<?php 
    /*функция подключения к бд*/
    function QueryDB($strQuery) {
        $objLink = mysqli_connect(DB_HOST, DB_USER, DB_PSWD, DB_NAME); //connect к бд
        /*при ошибки вернет false иначе продолжит выполнение*/
        if (!$objLink) {
            return false;
        }

        /*проверка на кодировку*/
        if (!mysqli_query($objLink, "SET NAMES UTF8")){
            return false;
        }
        $varResult = mysqli_query($objLink, $strQuery); //выполняем запрос к бд
        /*при ошибки вернет false иначе продолжит выполнение*/
        if (!$varResult) {
            return false;
        }
        /*при ошибки закрытия ранее открытого соединение с базой, вернет false иначе продолжит выполнение*/
        if (!mysqli_close($objLink)) {
            return false;
        }
        return $varResult; //возвращаем результат выполненного запроса
    }

    function save_otziv ($date, $avtor, $ip, $id, $message) {
        $strQuery = "INSERT INTO `gostevay_kniga`(`id`, `data`, `avtor`, `ip_avtora`, `id_soobsheniy`, `text_soobsheniy`) VALUES ('','$date','$avtor','$ip','$id', '$message')"; //запрос к бд
        
        $varResult = QueryDB($strQuery); //ответ на запрос
            /*делаем проверку ответа и возвращаем результат*/
        if ($varResult == true){
            return true;
        //echo "Информация занесена в базу данных";
        }else{
        //echo "Информация не занесена в базу данных";
            return "error";
        }                
    }

    function allmessage () {
        $strQuery = "SELECT * FROM `gostevay_kniga`";

        $varResult = QueryDB($strQuery);
        while($objRow = $varResult->fetch_array(MYSQLI_ASSOC))
        {
            $arrResult[] = $objRow;
        }

        return $arrResult;                
    }
