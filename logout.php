<?php


session_start();   //запускаем сессию

session_unset();      //удаляем все переменные из текущей сессии
session_destroy();    //уничтожаем все данные, связанные с текущей сессией

header("Location: login.php");   //производим перенаправление на login.php
exit;                //завершаем работу скрипта