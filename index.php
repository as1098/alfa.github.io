﻿<?
 //данные для предачи в клоаку
 $post['ip'] = $_SERVER["REMOTE_ADDR"];
 $post['domain'] = $_SERVER['HTTP_HOST'];
 $post['referer'] = @$_SERVER['HTTP_REFERER'];
 $post['user_agent'] = $_SERVER['HTTP_USER_AGENT'];
 $post['headers'] = json_encode(apache_request_headers());

//передаем данные в клоаку, запрос идет по http адресу клоаки соответственно ленлинг может быть расположен где угодно, хоть на другом хостинге
 $curl = curl_init('https://app-olk.site/api/check_ip');
 curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
 curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
 curl_setopt($curl, CURLOPT_TIMEOUT, 60);
 curl_setopt($curl, CURLOPT_POST, true);
 curl_setopt($curl, CURLOPT_POSTFIELDS, $post);

 //получаем ответ
 $json_reqest = curl_exec($curl);
 curl_close($curl);
 $api_reqest = json_decode($json_reqest);

//в зависимости от ответа клоаки выполняем то или иной скрипт (если нет ответа от клоаки ИЛИ есть белая ссылка в ответе клоаки  ИЛИ клоака определила что нужно показывать белый) - показываем белый, в остальных случаях показываем черный.
 if(!@$api_reqest || @$api_reqest->white_link || @$api_reqest->result == 0){
 	require_once('wtk.html');
 }else{
 	require_once('blk.html');
 }
