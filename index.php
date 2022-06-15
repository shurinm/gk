<?php
session_start(); //старт сесии
if( isset($_SESSION['logged_user'])):?>
<?if (version_compare(phpversion(), "5.3.0", ">=")  == 1)
  error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED); // Отключаем возможные предупреждения
else
  error_reporting(E_ALL & ~E_NOTICE); 

// Получаем IP посетителя
function getVisitorIP() {
    $ip = "0.0.0.0";
    if( ( isset( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ) && ( !empty( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ) ) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } elseif( ( isset( $_SERVER['HTTP_CLIENT_IP'])) && (!empty($_SERVER['HTTP_CLIENT_IP'] ) ) ) {
        $ip = explode(".",$_SERVER['HTTP_CLIENT_IP']);
        $ip = $ip[3].".".$ip[2].".".$ip[1].".".$ip[0];
    } elseif((!isset( $_SERVER['HTTP_X_FORWARDED_FOR'])) || (empty($_SERVER['HTTP_X_FORWARDED_FOR']))) {
        if ((!isset( $_SERVER['HTTP_CLIENT_IP'])) && (empty($_SERVER['HTTP_CLIENT_IP']))) {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
    }
    return $ip;
}
$ip = getVisitorIP();
$login = $_SESSION['logged_user']['login'];
?>
<!DOCTYPE html>
<html lang="ru" >
    <head>
        <meta charset="utf-8" />
        <title>Гостевая книга</title>
        <link href="css/style.css" rel="stylesheet" type="text/css" />
        <script src="js/script.js"></script>
    </head>
    <body>
        <h3 class="h3">Гостевая книга</h3>
        <div class="button"><button id='newmessage'>Добавить отзыв</button></div>
        <div class="h3" id='newmessagedisplay' style="display: none;">
        <form action="#" method="POST" id="frm1">
            <table class="table">
                <input type="text" name="name" value="<?echo $login;?>" style="display: none;"></input>
                <tr>
                    <td><label>Сообщение</label></td><td><textarea name="message" id="text" maxlength="255"></textarea></td>
                </tr>                   
            </table>
            <input type="text" name="ip" value="<?echo $ip;?>" style="display: none;"></input>
            <label>Проверочный код</label><input type="text" name="kod" id="kod"></input><label for="myalue" style="vertical-align: middle"></label>
        </form>
        <button id='otpravka'>Опубликовать</button>
        </div>
        <div id="messagegost"></div>
        <footer>
            <h2>2022</h2>
        </footer>
    </body>
    <script type="text/javascript">
                $(document).ready(function(){
                $.ajax({
                    url: "pokazmessage.php?posts"
                })
                  .done(function(html) {
                    $("#messagegost").html(html);
                });

                });
                $('#newmessage').click(function(){
                    var num = Math.floor(Math.random() * 90000) + 10000;
                    jQuery("label[for='myalue']").html(num);
                    $('#newmessagedisplay').css('display', 'block');
                });
              </script>
    <script>
  $('#otpravka').click(function(){
    $('#otpravka').attr('disabled', true);
    var kod = $('[for=myalue]').text();
    var kod2 = $("#kod").val();
    if(kod == kod2){
        var arr = $('#frm1').serializeArray();
        $.ajax({
            type: "POST",
            dataType: "JSON",
            url: "savemessage.php",
            data: arr
            })
            .done(function(msg) {
                $( '#frm1' ).each(function(){
                this.reset();
                });
                $('#newmessagedisplay').css('display', 'none');
                $('#otpravka').attr('disabled', false);
                $.ajax({
                    url: "pokazmessage.php?posts"
                })
                  .done(function(html) {
                    $("#messagegost").html(html);
                });
            })
    }else{
        alert('Не правильный код!')
        $('#otpravka').attr('disabled', false);
    }
  });
  </script>
</html>
  <?php else : ?>
    <p>Вы не авторизированы. Сейчас случится переход на главную <meta http-equiv="refresh" content="3; url=/index.php" /></p>
    <?php endif; 
    ?>