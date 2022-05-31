<?php 
session_start();

if (isset($_POST['email']) && 
	isset($_POST['password'])) {
    
    # Database Connection File
	include "../db_conn.php";         //подключаем файл соединения с БД
    
    # Validation helper function
	include "func-validation.php";    //подключаем файл с функцией, позволяющей провести валидацию
	
	/** 
	   Get data from POST request 
	   and store them in var
	**/

	$email = $_POST['email'];          //записываем в переменную email данные, поллученные из инпута
	$password = $_POST['password'];    //записываем в переменную password данные, поллученные из инпута

	# simple form validation

	$text = "Email";           
	$location = "../login.php";
	$ms = "error";
    is_empty($email, $text, $location, $ms, "");  //проверяем, пуста ли переменная $email. Если путсая, то появляется надпись "Email is required" и производится перенаправление на страницу login
                                                  //переменная $ms позволяет отобразить блок с ошибкой в файле login.php
    $text = "Password";        
	$location = "../login.php";
	$ms = "error";
    is_empty($password, $text, $location, $ms, "");  //проверяем, пуста ли переменная $password. Если путсая, то появляется надпись "Password is required" и производится перенаправление на страницу login
                                                      //переменная $ms позволяет отобразить блок с ошибкой в файле login.php
    # search for the email
    $sql = "SELECT * FROM admin            
            WHERE email=?";                  //пишем sql-запрос. Вопросительный знак представляет параметр, который позже будет заменён
    $stmt = $conn->prepare($sql);            //пользуемся переменной $conn из файла db_conn.php и подготавливаем sql-запрос
    $stmt->execute([$email]);                //запускаем подготовленный запрос на выполнение

    # if the email is exist
    if ($stmt->rowCount() === 1) {          //rowCount возвращшает количество строк, затронутых последним SQL-запросом. Если количество равно 1
    	$user = $stmt->fetch();               //извлекаем строку из результирующего набора и записываем её в переменную $user            

    	$user_id = $user['id'];              //записываем в переменную $user_id значение id из базы данных
    	$user_email = $user['email'];        //записываем в переменную $user_email значение email из базы данных
    	$user_password = $user['password'];  //записываем в переменную $user_password значение password из базы данных
    	if ($email === $user_email) {                 //если переменная $email (значене email из инпута от пользователя) совпадает с email из базы данных             
    		if (password_verify($password, $user_password)) {     //а также если пароль соответствует хешу из базы данных
    			$_SESSION['user_id'] = $user_id;         //тогда устанавливаем в ассоциативный массив, содержащий текущие переменные сессии переменную user_id со значением id из базы данных
    			$_SESSION['user_email'] = $user_email;   //и переменную user_email со значением email из базы данных
    			header("Location: ../admin.php");        //производим перенаправление на админ-страницу
    		}else {
    			# Error message
    	        $em = "Incorrect User name or password";           //иначе создаём сообщение об ошибке
    	        header("Location: ../login.php?error=$em");        //и перенаправляем на страницу login с выводом сообщения об ошибке
    		}
    	}else {
    		# Error message
    	    $em = "Incorrect User name or password";               //иначе создаём сообщение об ошибке
    	    header("Location: ../login.php?error=$em");            //и перенаправляем на страницу login с выводом сообщения об ошибке
    	}
    }else{
    	# Error message
    	$em = "Incorrect User name or password";                  //иначе создаём сообщение об ошибке
    	header("Location: ../login.php?error=$em");               //и перенаправляем на страницу login с выводом сообщения об ошибке
    }
}else {
	# Redirect to "../login.php"
	header("Location: ../login.php");  //иначе перенаправляем на страницу логина
}