<?php 
  //server name
  $sName = "localhost";        //имя сервера

  //user name
  $uName = "root";             //имя пользователя

  //password
  $pass = "";                  //пароль пользователя

  //database name
  $db_name = "online_book_store_db";      //имя БД

  //creating database connection using the PHP Data Objects (PDO)

  try {
    $conn = new PDO("mysql:host=$sName;dbname=$db_name", $uName, $pass);    //создаём соединение с БД
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);         //позволяем выбрасывать исключение при ошибке подключения

  } catch(PDOException $e) {                                                //если выбрасывается исключение
    echo "Connection failed : ". $e->getMessage();                          //выводим сообщение об ошибке
  }