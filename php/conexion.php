<?php
use PSpell\Config;

    $host="mysql:dbname=".nameBD.";host=".host;
    try {
        $mysqli=new PDO ($host,user,psw,array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES utf8"));
    } catch (PDOException $e) {
        echo "<script>alert('Error...')</script>";
    }
?>