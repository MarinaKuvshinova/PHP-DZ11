<?php
include_once 'function.php';
$pdo = connect();

$ct1="create table categories(
id int not NULL auto_increment PRIMARY KEY,
categoryName varchar(64)
) DEFAULT charset='utf8'";

$ct2 = "create table posts(
id int not NULL auto_increment PRIMARY KEY,
postTitle varchar(64),
postText varchar(64),
imagePath varchar(255),
datePost DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
categoryId int,
FOREIGN KEY (categoryId) REFERENCES categories(id) on DELETE CASCADE
) DEFAULT charset='utf8'";


$ct3 = "create table comments(
id int not NULL auto_increment PRIMARY KEY,
commentText varchar(64),
commentAuthor varchar(255),
postId int,
FOREIGN KEY (postId) REFERENCES posts(id) on DELETE CASCADE
) DEFAULT charset='utf8'";

$pdo->exec($ct1);
$pdo->query("INSERT INTO categories SET categoryName='JS'");
$pdo->query("INSERT INTO categories SET categoryName='Text'");
$pdo->exec($ct2);
$pdo->exec($ct3);



//mysql_query($ct1);
//$err = mysql_errno();
//if ($err)
//{
//    echo 'Error code 1:'.$err.'<br>';
//    return false;
//}
//mysql_query($ct2);
//$err = mysql_errno();
//if ($err)
//{
//    echo 'Error code 2:'.$err.'<br>';
//    return false;
//}
