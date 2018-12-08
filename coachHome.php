<!DOCTYPE HTML>
<html>
<head>
<link rel="stylesheet" type="text/css" href="style.css"/>
<title>Home</title>
</head>
<body>
<div id="wrap">
  <div id="main">
  <h3>Class Schedule</h3>
  
    <div class="scroll" id='yup'>
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
            echo "<table border='1' bgcolor='white' align='center' class='schedule' id='finalSched'> ";
            echo "<TR>";
            echo "<TH> Date </TH> ";
            echo "<TH> Start Time </TH>";
            echo "<TH> End Time </TH>";
            echo "<TH> Camper </TH>";
            echo "<TH> Charge to Camper</TH>";
            echo "</TR>";
           
            foreach( $dbh->query("select date, start, end, camper_email, price from slot join coach on( slot.coach_email = coach.email) where coach_email = '".$_SESSION["username"]."';") as $row){
     	        echo "<TR>";
     	        echo "<TD>".$row[0]."</TD>";	
     	        echo "<TD>".$row[1]."</TD>";
     	        echo "<TD>".$row[2]."</TD>";
     	        echo "<TD>".$row[3]."</TD>";
              echo "<TD>".$row[4]."</TD>";
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


    </div><!--scroll-->
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