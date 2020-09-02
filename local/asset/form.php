<?php
$to = "vakolesnev@yandex.ru";
// емайл получателя

$subject = "Заявка с сайта";
// тема письма

$message = "Новая заявка с сайта<br>Имя:".$_REQUEST['name']."<br>Номер телефона:".$_REQUEST['phone'];
// текст сообщения

$mailheaders = "Content-type:text/html;charset=windows-1251rn";
// почтовый заголовок, указывает формат письма - текстовый и кодировку

$mailheaders .= "From: SiteRobot <info@sdauto.ru>rn";
// почтовый заголовок, указывает емайл отправителя


$mailheaders .= "Reply-To: info@sdauto.ru";
// почтовый заголовок, указывает емайл для ответа
// лучше если емайл для ответа совпадает с емайлом отправителя, иначе некоторые почтовые сервисы могут классифицировать письмо как спам


mail($to, $subject, $message, $mailheaders);
// отправляем письмо
