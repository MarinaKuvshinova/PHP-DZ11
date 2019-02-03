<?php
function connect(
    $host='127.0.0.1:3306',
    $user = 'root',
    $password ='',
    $dbname = 'postsbd'
){
    $connectionString = "mysql:host=$host;dbname=$dbname;charset=utf8";
    $options = [
        PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION, //отлавливание ошибок
        PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC, //для обращения через имя поля тбл
        PDO::MYSQL_ATTR_INIT_COMMAND=>'SET NAMES UTF8', //для кодировки
    ];
    try{
        $pdo=new PDO($connectionString, $user, $password, $options);
        return $pdo;

    }catch (PDOException $ex){
        echo  $ex->getMessage();
        return false;
    }
}

//$pdo = connect();
//$list = $pdo->query('select * from countries');
//while($row = $list->fetch()){
//    echo $row['id'].' '.$row['countryName'].'<br>';
//}