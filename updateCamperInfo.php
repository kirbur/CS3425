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
    if(isset($_POST['submit'])){
      switch($_POST['submit']){
        case 'pass':
           $statement = $dbh->prepare("update camper set password=:pass where email=:Email;");
           $result = $statement->execute(array(':pass'=> $_POST['pass'], ':Email' => $_SESSION['username']));
           break;
        
        case 'addr';
           $statement = $dbh->prepare("update camper set address=:dress where email=:Email;");
           $result = $statement->execute(array(':dress'=> $_POST['addr'], ':Email' => $_SESSION['username']));
           break;
           
        case'phone';
           $statement = $dbh->prepare("update camper set phone=:p where email=:Email;");
           $result = $statement->execute(array(':p'=> $_POST['phone'], ':Email' => $_SESSION['username']));
           break;
           
        case'emrg';
           $statement = $dbh->prepare("update camper set emergency_contact=:ec where email=:Email;");
           $result = $statement->execute(array(':ec'=> $_POST['emrg'], ':Email' => $_SESSION['username']));
           break;
      }
    }
    $dbh->commit();
   header("LOCATION:https://classdb.it.mtu.edu/~krburns/finalproject/updateCamper.php");
   } catch (PDOException $e ) {
       $dbh->rollBack();
       print "Error!".$e->getMessage()."<br/>";
       die();
   }
?>