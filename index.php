<?php
require_once('models/MysqliStatement.php');

$sql = 'select * from department where id = ?';

$mysqli = new MysqliStatement();
$mysqli->setParams(['1']);
$res = $mysqli->execute($sql);
echo '<pre>';
print_r($res);



