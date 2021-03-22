<?php
// Файлы phpmailer
require 'phpmailer/PHPMailer.php';
require 'phpmailer/SMTP.php';
require 'phpmailer/Exception.php';

// Переменные, которые отправляет пользователь

$back = $_SERVER['HTTP_REFERER'];

if ((isset($_POST['name'])) && (isset($_POST['phone'])) && (isset($_POST['message']))) {
//    Если в $_POST отправлены поля name, phone и message:

    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $message = $_POST['message'];
    $formActive = 2;
    $email = 'foster18@yandex.ru';

    if (($name=='') || ($phone=='') || ($message=='')) {
        echo "<meta http-equiv=\"refresh\" content='0; url=$back'>";
        exit();
    }

    // Формирование самого письма
    $title = "Новое обращение Best Tour Plan";
    $body = "
    <h2>Новое обращение</h2>
    <b>Имя:</b> $name<br>
    <b>Телефон:</b> $phone<br><br>
    <b>Сообщение:</b><br>$message
    ";

}  else if ((isset($_POST['email']))) {
//    В $_POST пришёл email на подписку

    $email = $_POST['email'];

    if ($email=='') {
        echo "<meta http-equiv=\"refresh\" content='0; url=$back'>";
        exit();
    }

    $formActive = 1;
    $title = "Подписка";
    $body = "
    <h2>Подписка оформлена!</h2>
    <br>Ваш e-mail был добавлен в базу рассылок. Если это были не вы, 
    пожалуйста, <a href=$back"."unsubscribe.html>кликните сюда.</a>
    ";

} else {
    die("Все входные данные пусты. Скрипт завершается.");
}

// Настройки PHPMailer
$mail = new PHPMailer\PHPMailer\PHPMailer();
try {
    $mail->isSMTP();
    $mail->CharSet = "UTF-8";
    $mail->SMTPAuth = true;
    $mail->SMTPDebug = 2;
    $mail->Debugoutput = function ($str, $level) {
        $GLOBALS['status'][] = $str;
    };

    // Настройки вашей почты, с которой пойдёт отправка писем
    $mail->Host = 'ssl://smtp.yandex.ru'; // SMTP сервера вашей почты
    $mail->Username = 'werfoster@yandex.ru'; // Логин на почте
    $mail->Password = 'пароль'; // Пароль на почте
    $mail->SMTPSecure = 'ssl';
    $mail->Port = 465;
    $mail->setFrom('werfoster@yandex.ru', 'Пётр Васильевич'); // Адрес откуда отправляем письмо

    // Получатель письма
    $mail->addAddress($email);
    // $mail->addAddress('youremail@gmail.com'); // Ещё один, если нужен

// Отправка сообщения
    $mail->isHTML(true);
    $mail->Subject = $title;
    $mail->Body = $body;

// Проверяем отравленность сообщения
    if ($mail->send()) {
        if ($formActive == 1 ) {
            header('Location: ../onsubscribe.html');
        } else {
            header('Location: ../thankyou.html');
        }
    } else {
        $result = "error";
        $status = "Сообщение не было отправлено.";
		echo "Сообщение не было отправлено. Причина ошибки: {$mail->ErrorInfo} <br>";
    }

} catch (Exception $e) {
    $result = "error";
    $status = "Сообщение не было отправлено. Причина ошибки: {$mail->ErrorInfo}<br>";
    echo $mail->ErrorInfo . "<br>";
}