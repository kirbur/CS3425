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
       $statement = $dbh->prepare("update slot set coach_email=:email where date=:day and start=:start_time and camp_number =".$_SESSION['camp']." and coach_email is null;");
       $result = $statement->execute(array(':email'=> $_SESSION['username'], ':day' => $_POST['date'], ':start_time' => $_POST['start']));
       $dbh->commit();  
      
      
      header("LOCATION:https://classdb.it.mtu.edu/~krburns/finalproject/coachSchedule.php");
   } catch (PDOException $e ) {
       $dbh->rollBack();
       print "Error!".$e->getMessage()."<br/>";
       die();
   }
   
?>