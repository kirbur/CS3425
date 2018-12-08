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
           
       switch($_POST['submit']){
         case 'pass':
            $statement = $dbh->prepare("update coach set password=:pass where email=:Email;");
            $result = $statement->execute(array(':pass'=> $_POST['pass'], ':Email' => $_SESSION['username']));
            break;
         
         case 'fee';
            $statement = $dbh->prepare("update coach set price=:pr where email=:Email;");
            $result = $statement->execute(array(':pr'=> $_POST['fee'], ':Email' => $_SESSION['username']));
            break;
            
         case'phone';
            $statement = $dbh->prepare("update coach set phone=:p where email=:Email;");
            $result = $statement->execute(array(':p'=> $_POST['phone'], ':Email' => $_SESSION['username']));
            break;
            
         case'addr';
            $statement = $dbh->prepare("update coach set address=:dress where email=:Email;");
            $result = $statement->execute(array(':dress'=> $_POST['address'], ':Email' => $_SESSION['username']));
            break;
       }
       $dbh->commit();
      header("LOCATION:https://classdb.it.mtu.edu/~krburns/finalproject/updateCoach.php");
   } catch (PDOException $e ) {
       $dbh->rollBack();
       print "Error!".$e->getMessage()."<br/>";
       die();
   }
   
?>