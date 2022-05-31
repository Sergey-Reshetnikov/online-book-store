<?php

function is_empty ($var, $text, $location, $ms, $data) {   //функция, проверяющая на пустоту
  if (empty($var)) {    //если переменная $var пустая
    //error message
    $em = "The $text is required";   //Создаём собщение, что соответствующий параметр обязателен
    header("Location: $location?$ms=$em&$data");       //создаём заголовок,. который перенаправляет на соответвтующую страницу
    exit;                                              //выходим из скрипта
  }
  return 0;       //или же просто позвращаем 0
}