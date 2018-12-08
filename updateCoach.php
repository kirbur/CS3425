<!DOCTYPE HTML>
<html>
<head>
<link rel="stylesheet" type="text/css" href="style.css"/>
<title>Profile</title>
</head>
<body>
<div id="wrap">
  <div id="main">
  
 <table id="mainTable"  height=600px >
  <tr>
    <th style="width: 500px; height: 60px;"><h3>Change Bio</h3></td>
    <th style="width: 500px;"><h3>Change Info</h3></td>
  </tr>
  <tr>
    <td>
    <div class="scroll" id='bio'>

      <?php
        session_start();
         if (isset($_SESSION["loggedin"]) ) {
         } else {
           header("LOCATION:https://classdb.it.mtu.edu/~krburns/finalproject/home.html");
         }
               
         try {
            $config = parse_ini_file("db.ini");
            $dbh = new PDO($config['dsn'], $config['username'], $config['password']);
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);           
            $dbh->beginTransaction();    
            foreach( $dbh->query("select bio from coach where email = '".$_SESSION["username"]."';") as $row){
              echo "<div id ='text'>";
              echo "<b>Current Bio</b>";
              echo "<p>    ".$row[0]."</p>";
              echo "</div>";
              
              echo "<form action='changebio.php' method='post' id='usrform'>";
              
              echo "<textarea name='newbio'rows='15' cols='60' style='resize: none'>Type new bio here...</textarea></br>";
              echo "<button type='submit'  name='submit' >submit</button>";
              echo "</form>";
                          }
            $dbh->commit();
         } catch (PDOException $e) {
           $dbh->rollBack();
           print "Error!" . $e->getMessage()."<br/>";
           die();
         }
      ?>
    </div>
    </td> 
 
    <td>
    <div class="scroll" id='bio'>

      <?php               
         try {
            $config = parse_ini_file("db.ini");
            $dbh = new PDO($config['dsn'], $config['username'], $config['password']);
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);               
            $dbh->beginTransaction();
            foreach( $dbh->query("select password, price, phone, address from coach where email = '".$_SESSION["username"]."';") as $row){
              echo "<div id ='text'>";
              echo "<p>Current Password: ".$row[0]."</p>";
              echo "<p>Current Fee: $".$row[1]."</p>";
              echo "<p>Current Phone Number: ".$row[2]."</p>";
              echo "<p>Current Address:     ".$row[3]."</p>";
              echo "</div>";
              
              echo "<form action='changepassword.php' method='post' id='usrform'>";
              
              echo "<input class='txtbox'  type='text' placeholder='Enter New Password' name='pass'>";
              echo "<button type='submit'  name='submit' value='pass' class='bot'>submit</button></br>";
              
              echo "<input class='txtbox'  type='text' placeholder='Enter New Price' name='fee'>";
              echo "<button type='submit'  name='submit' value='fee' class='bot'>submit</button></br>";
              
              echo "<input class='txtbox'  type='text' placeholder='Enter New Phone Number' name='phone'>";
              echo "<button type='submit'  name='submit' value='phone' class='bot'>submit</button></br>";
              
              echo "<input class='txtbox'  type='text' placeholder='Enter New Address' name='address'>";
              echo "<button type='submit'  name='submit' value='addr' class='bot'>submit</button></br>";
              
              echo "</form>";
              

            }
            $dbh->commit();
         } catch (PDOException $e) {
            $dbh->rollBack();
           print "Error!" . $e->getMessage()."<br/>";
           die();
         }
      ?>
    </div>
    </td> 
  </tr>
  
  </table>

  </div><!--main-->
  <div id="nav">
  <ul>
      <li>
            <?php 
               $usr = $_SESSION["username"];
               
               try {
                  $config = parse_ini_file("db.ini");
                  $dbh = new PDO($config['dsn'], $config['username'], $config['password']);
                  $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                  $dbh->beginTransaction();
                  $camp = 'camp name';
                  if(isset($_SESSION['camp'])){
                     foreach( $dbh->query("select name from camp where num = ".$_SESSION['camp'].";") as $row){
                       $camp = $row[0];
                     }
                  }
                  $dbh->commit();
               } catch (PDOException $e) {
                 $dbh->rollBack(); 
                 print "Error!" . $e->getMessage()."<br/>";
                 die();
               }
                              
               echo "<p>".$camp."</p>"; 
               echo "<p>".$usr."</p>"; 
            ?>
      </li>
  		<li><a href="coachHome.php" target="_self">Home</a></li>
      <li><a href="coachSchedule.php" target="_self">Change Schedule</a></li>
      <li><a href="updateCoach.php" target="_self">Change Info</a></li>
      <li><a href="logout.php" target="_self">Logout</a></li>
  	</ul>
  </div><!--nav-->
  
  
</div><!--wrap-->
</body>
</html>