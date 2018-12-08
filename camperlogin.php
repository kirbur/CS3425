<?php
 session_start();
    if (isset($_SESSION["loggedin"]) ) {
      header("LOCATION:https://classdb.it.mtu.edu/~krburns/finalproject/camperHome.html");
       return;
    }
          
    try {
       $config = parse_ini_file("db.ini");
       $dbh = new PDO($config['dsn'], $config['username'], $config['password']);

       $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
       $dbh->beginTransaction();
       foreach( $dbh->query("select email, password, camp_number, camp.name from camper join camp where camper.camp_number = camp.num;") as $row){
         if(isset($_POST["username"])){
            if($_POST["username"] == $row[0] && $_POST["password"] == $row[1]  && $_POST["opt"] == $row[3] ){
               $_SESSION["loggedin"] = true;
               $_SESSION["username"] = $_POST["username"];
               $_SESSION["camp"] = $row[2];
               //echo '<script type="text/javascript">alert("success");</script>';
               header("LOCATION:https://classdb.it.mtu.edu/~krburns/finalproject/camperHome.php");
               exit();
               // return;             
            }  else { 
                  echo '<script type="text/javascript">alert("Wrong username or password.");</script>';
                  header("LOCATION:https://classdb.it.mtu.edu/~krburns/finalproject/camperlogin.php");
            }
         }
       }
       $dbh->commit();
    } catch (PDOException $e) {
      $dbh->rollBack();
      print "Error!" . $e->getMessage()."<br/>";
      die();
    }
?>
<html>
<head>
  <link rel="stylesheet" type="text/css" href="style.css"/>
	<title>Login</title>
</head>
<body>
<div id="wrap">
    <div id="main">
      <h1>Welcome Back</h1>
      <br/>
      
      
<form action="camperlogin.php" method="post">
  <div class="container">
    
    <label for="email"><b>Email</b></label>
    <input class="txtbox" type="text" placeholder="Enter Email" name="username" required>
</br></br>
    <label for="password"><b>Password</b></label>
    <input class="txtbox"  type="password" placeholder="Enter Password" name="password" required>
</br></br>
   
   <label for="opt"><b>Choose Camp</b></label>
   <?php
      try {
         $config = parse_ini_file("db.ini");
         $dbh = new PDO($config['dsn'], $config['username'], $config['password']);
         $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
         $dbh->beginTransaction();
         echo "<select name='opt'>";
         foreach( $dbh->query("select name from camp;") as $row){
             echo "<option value='" . $row[0] . "'>" . $row[0] . "</option>";
         } 
         echo "</select>";
         $dbh->commit();
       } catch (PDOException $e) {
         $dbh->rollBack();
         print "Error!" . $e->getMessage()."<br/>";
         die();
       }
   ?>
   
   </br></br>
   
    <div class="clearfix">
      <button type="submit"  name="submit" class="btn">Login</button>
    </div>
  </div>
</form>

</div>
</div>

</body>
</html>