<!DOCTYPE HTML>
<html>
<head>
<link rel="stylesheet" type="text/css" href="style.css"/>
<title>Change Info</title>
</head>
<body>
<div id="wrap">
  <div id="main">
  <h3>Change Info</h3>
  <div id='camper'>

      <?php     
      session_start();          
         try {
            $config = parse_ini_file("db.ini");
            $dbh = new PDO($config['dsn'], $config['username'], $config['password']);
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);               
            $dbh->beginTransaction();
            foreach( $dbh->query("select password, address, phone, emergency_contact from camper where email = '".$_SESSION["username"]."';") as $row){
              echo "<div id ='camperInfo'>";
              echo "<div style='height:50px;'></div>";
              
              echo "<form action='updateCamperInfo.php' method='post' id='usrform'>";
              
              echo "<label for='pass'>Current Password: ".$row[0]."</label><span>               </span>";
              echo "<input class='txtbox'  type='text' placeholder='Enter New Password' name='pass'>";
              echo "<button type='submit'  name='submit' value='pass' class='bot'>submit</button></br>";
              
              echo "<label for='addr'>Current Address: ".$row[1]."</label><span>                       </span>";
              echo "<input class='txtbox'  type='text' placeholder='Enter New Address' name='addr'>";
              echo "<button type='submit'  name='submit' value='addr' class='bot'>submit</button></br>";
              
              echo "<label for='phone'>Current Phone Number: ".$row[2]."</label><span>            </span>";
              echo "<input class='txtbox'  type='text' placeholder='Enter New Phone Number' name='phone'>";
              echo "<button type='submit'  name='submit' value='phone' class='bot'>submit</button></br>";
              
              echo "<label for='emrg'>Current Emergency Contact: ".$row[3]."</label><span>     </span>";
              echo "<input class='txtbox'  type='text' placeholder='Enter New Emergency Contact' name='emrg'>";
              echo "<button type='submit'  name='submit' value='emrg' class='bot'>submit</button></br>";
              
              echo "</form>";
              echo "</div>";

            }
            $dbh->commit();   
         } catch (PDOException $e) {
           $dbh->rollBack();
           print "Error!" . $e->getMessage()."<br/>";
           die();
         }
      ?>
    </div><!--camper-->
  
  
  
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
  		<li><a href="camperHome.php" target="_self">Home</a></li>
      <li><a href="coachInfo.php" target="_self">Coach Info</a></li>
      <li><a href="camperregistration.php" target="_self">Change Schedule</a></li>
      <li><a href="updateCamper.php" target="_self">Change Info</a></li>
      <li><a href="logout.php" target="_self">Logout</a></li>
  	</ul>
  </div><!--nav-->
</div><!--wrap-->
</body>
</html>