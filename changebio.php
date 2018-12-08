<?php

   session_start();
   if(!$_SESSION["loggedin"]) {
      header("LOCATION:https://classdb.it.mtu.edu/~krburns/finalproject/coachlogin.html");
       return;
   }

   try{
       $config = parse_ini_file("db.ini");
       $dbh = new PDO($config['dsn'], $config['username'], $config['password']);

       $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
       $dbh->beginTransaction();
       $statement = $dbh->prepare("update coach set bio=:Bio where email=:Email;");
       $result = $statement->execute(array(':Bio'=> $_POST['newbio'], ':Email' => $_SESSION['username']));
       $dbh->commit();
      header("LOCATION:https://classdb.it.mtu.edu/~krburns/finalproject/updateCoach.php");
   } catch (PDOException $e ) {
       $dbh->rollBack();
       print "Error!".$e->getMessage()."<br/>";
       die();
   }
   
?>