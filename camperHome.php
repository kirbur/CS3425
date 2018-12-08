<!DOCTYPE HTML>
<html>
<head>
<link rel="stylesheet" type="text/css" href="style.css"/>
<title>Home</title>
</head>
<body>
<div id="wrap">
  <div id="main">
   <div id="middle">
   <table id="mainTable"  height=600px >
    <tr>
      <th style="width: 500px; height: 60px;"><h3>Schedule</h3></td>
      <th style="width: 500px;"><h3>Bill</h3></td>
    </tr>
    <tr>
      <td>
      <div class="scroll" id="camperStuff">
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
              echo "<table border='1' bgcolor='white' align='center' class='schedule' id='camperSched'> ";
              echo "<TR>";
              echo "<TH> Date </TH> ";
              echo "<TH> Start Time </TH>";
              echo "<TH> End Time </TH>";
              echo "<TH> Coach </TH>";
              echo "</TR>";
             
              foreach( $dbh->query("select date, start, end, coach_email from slot where camper_email = '".$_SESSION["username"]."';") as $row){
       	        echo "<TR>";
       	        echo "<TD>".$row[0]."</TD>";	
       	        echo "<TD>".$row[1]."</TD>";
       	        echo "<TD>".$row[2]."</TD>";
       	        echo "<TD>".$row[3]."</TD>";
       	        echo "</TR>";
              }
                 echo "</table>";
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
      <div class="scroll" id="camperStuff">
         <?php
           if (isset($_SESSION["loggedin"]) ) {
           } else {
             header("LOCATION:https://classdb.it.mtu.edu/~krburns/finalproject/home.html");
           }
           try {
              $config = parse_ini_file("db.ini");
              $dbh = new PDO($config['dsn'], $config['username'], $config['password']);

              $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
              $dbh->beginTransaction();   
              echo "<table border='1' bgcolor='white' align='center' class='schedule' id='camperSched'> ";
              echo "<TR>";
              echo "<TH> Coach </TH>";
              echo "<TH> Date </TH> ";
              echo "<TH> Start Time </TH>";
              echo "<TH> End Time </TH>";
              echo "<TH> Price </TH>";
              echo "</TR>";
              foreach( $dbh->query("select coach_email, date, start, end, price from slot join coach on ( slot.coach_email = coach.email) where camper_email = '".$_SESSION["username"]."';") as $row){
       	        echo "<TR>";
       	        echo "<TD>".$row[0]."</TD>";	
       	        echo "<TD>".$row[1]."</TD>";
       	        echo "<TD>".$row[2]."</TD>";
       	        echo "<TD>".$row[3]."</TD>";
                 echo "<TD>$".$row[4]."</TD>";
       	        echo "</TR>";
              }
              $campfee = 0;
              foreach( $dbh->query("select reg_fee from camp where num='".$_SESSION["camp"]."';") as $row){
                 $campfee= $row[0]; 
       	        echo "<TR>";
       	        echo "<TD></TD>";	
       	        echo "<TD></TD>";
       	        echo "<TD></TD>";
       	        echo "<TD> Camp Fee:</TD>";
                 echo "<TD>$".$row[0]."</TD>";
       	        echo "</TR>";
              }
              
              foreach( $dbh->query("select sum(price) from slot join coach on ( slot.coach_email = coach.email) where camper_email = '".$_SESSION["username"]."';") as $row){
       	        $total = $row[0]+ $campfee;
                 echo "<TR>";
       	        echo "<TD></TD>";	
       	        echo "<TD></TD>";
       	        echo "<TD></TD>";
       	        echo "<TD> Total:</TD>";
                 echo "<TD>$".$total."</TD>";
       	        echo "</TR>";
              }
                 echo "</table>";
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
   
   </div><!--middle-->
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