<?php
 
          
    try {
      if(isset($_POST["email"])){
         $config = parse_ini_file("db.ini");
         $dbh = new PDO($config['dsn'], $config['username'], $config['password']);

         $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
         $dbh->beginTransaction();   
         $statement = $dbh->prepare("insert into camper( name, email, password, address, phone, emergency_contact, camp_number) values ( :name, :email, :password, :address, :phone, :emergency_contact, :camp_num);");
         $result = $statement->execute(array(':name'=> $_POST['name'], ':email'=> $_POST['email'], ':password'=> $_POST['password'], ':address'=> $_POST['addr'], ':phone'=> $_POST['phone'], ':emergency_contact'=> $_POST['emr'], ':camp_num' => $_POST['opt']));
         $dbh->commit();     
        
         header("LOCATION:https://classdb.it.mtu.edu/~krburns/finalproject/home.html");
       }
    } catch (PDOException $e) {
      $dbh->rollBack();
      print "Error!" . $e->getMessage()."<br/>";
      die();
    }
?>



<html>
<head>
  <link rel="stylesheet" type="text/css" href="style.css"/>
	<title>Register</title>
</head>
<body>
<div id="wrap">
    <div id="main">

<form action="register.php" method="post">
  <div class="container" id="regi">
    <h1>Sign Up</h1>
    <p>Please fill in this form to create an account.</p>
    

    <label for="email"><b>Email</b></label>
    <input class="txtbox" type="text" placeholder="Enter Email" name="email" required>
      </br>
    <label for="psw"><b>Password</b></label>
    <input class="txtbox"  type="password" placeholder="Enter Password" name="password" required>
      </br>
    <label for="name"><b>Name</b></label>
    <input class="txtbox" type="text" placeholder="Enter Name" name="name" required>
      </br>
    <label for="addr"><b>Address</b></label>
    <input class="txtbox"  type="text" placeholder="Enter Address" name="addr" required>
      </br>
    <label for="phone"><b>Phone Number</b></label>
    <input class="txtbox" type="text" placeholder="Enter Phone Number" name="phone" required>
      </br>
    <label for="emr"><b>Emergencee Contact </b></label>
    <input class="txtbox"  type="text" placeholder="Enter Emergence Contact" name="emr" required>
      </br>
  
  <label for="opt"><b>Choose Camp</b></label>
   <?php
      try {
         $config = parse_ini_file("db.ini");
         $dbh = new PDO($config['dsn'], $config['username'], $config['password']);
         $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
         $dbh->beginTransaction();
         echo "<select name='opt'>";
         foreach( $dbh->query("select name, num from camp;") as $row){
               
             echo "<option value='" . $row[1] . "'>" . $row[0] . "</option>";
         } 
         $dbh->commit();
         echo "</select>";
       } catch (PDOException $e) {
         $dbh->rollBack();
         print "Error!" . $e->getMessage()."<br/>";
         die();
       }
   ?>
   
   </br></br>
  
  
    <p>By creating an account you agree to our <a onclick="alert('TERMS & CONDITIONS')" style="color:dodgerblue">Terms & Privacy</a>.</p>

    <div class="clearfix">
      <button type="button" onclick="window.location.href='home.html'" class="btn">Cancel</button>
      <button type="submit" class="btn">Sign Up</button>
    </div>
  </div>
</form>



</div>
</div>
</body>
</html>