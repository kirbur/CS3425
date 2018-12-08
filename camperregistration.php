<!DOCTYPE HTML>
<html>
<head>
<link rel="stylesheet" type="text/css" href="style.css"/>
<title>Choose Class Slots</title>
</head>
<body>
<div id="wrap">
  <div id="main">
  
  <div id="info">
  <table id="mainTable"  height=600px >
  <tr>
    <th style="width: 500px; height: 60px;"><h3>Free Slots</h3></td>
    <th style="width: 500px;"><h3>Chosen Slots</h3></td>
  </tr>
  <tr>
    <td>
    <div class="scroll" id='schedtables'>
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
            echo "<table border='1' bgcolor='white' align='center' class='schedule' >";
           echo "<TR>";
           echo "<TH> Date </TH> ";
           echo "<TH> Start Time </TH>";
           echo "<TH> End Time </TH>";
           echo "<TH> Coach </TH>";
           echo "</TR>";
            foreach( $dbh->query("select date, start, end, coach_email from slot where coach_email is not null and camper_email is null and camp_number =".$_SESSION['camp'].";") as $row){
              echo '<form method="post" action="camperSelect.php">';
     	        echo "<TR>";
                
     	        echo "<TD>".$row[0]."</TD>";	
     	        echo '<input type="hidden" name="date" value="'.$row[0].'">';
                
     	        echo "<TD>".$row[1]."</TD>";
     	        echo '<input type="hidden" name="start" value="'.$row[1].'">';
                
              echo "<TD>".$row[2]."</TD>";
     	        echo '<input type="hidden" name="end" value="'.$row[2].'">';
              
              echo "<TD>".$row[3]."</TD>";
     	        echo '<input type="hidden" name="coach" value="'.$row[3].'">';
     	
     	        echo '<TD><input type="submit" name="select" value="select"> </TD>';
     	        echo '</form>';
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
    <div class="scroll" id='schedtables'>
      <?php
       
         try {
            $config = parse_ini_file("db.ini");
            $dbh = new PDO($config['dsn'], $config['username'], $config['password']);

            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $dbh->beginTransaction();  
            echo "<table border='1' bgcolor='white' align='center' class='schedule' > ";
           echo "<TR>";
           echo "<TH> Date </TH> ";
           echo "<TH> Start Time </TH>";
           echo "<TH> End Time </TH>";
           echo "<TH> Coach </TH>";           
           echo "</TR>";
           
            foreach( $dbh->query("select date, start, end, coach_email from slot where camper_email = '".$_SESSION["username"]."' and camp_number =".$_SESSION['camp'].";") as $row){
              echo '<form method="post" action="camperdeselect.php">';
     	        echo "<TR>";
                
     	        echo "<TD>".$row[0]."</TD>";	
     	        echo '<input type="hidden" name="date" value="'.$row[0].'">';
                
     	        echo "<TD>".$row[1]."</TD>";
     	        echo '<input type="hidden" name="start" value="'.$row[1].'">';
                
              echo "<TD>".$row[2]."</TD>";
     	        echo '<input type="hidden" name="end" value="'.$row[2].'">';
              
              echo "<TD>".$row[3]."</TD>";
     	        echo '<input type="hidden" name="coach" value="'.$row[3].'">';
                     	
     	        echo '<TD><input type="submit" name="deselect" value="deselect"> </TD>';
     	        echo '</form>';
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
   </div><!--info-->
  
  
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