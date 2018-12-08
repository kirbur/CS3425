Purposes for each file
---------------------- 
style.css - css stylesheet used for every page of the site

db.ini - saved the login info for the database

home.html - first page a person would go to, has the options for camper login or register and coach login

register.php - camper registration page, redirects back to the main home page so user can click the camper login button

camperlogin.php - camper login page, redirects to camper home page if camper is already registered

camperHome.php - first/main screen for the camper, dislpays class schedule and current bill

camperregistration.php - page for campers to choose/discard classes for their schedule

updateCamper.php - page for campers to change their password, phone number, mailing address, or emergency contact info

camperdeselect.php - used by form in camperregistration.php to deselect a chosen class

camperselect.php - used by form in camperregistration.php to select a wanted class

updateCamperInfo.php - used by form in updateCamper.php to change values in camper table

coachInfo.php - page on camper site to see the basic information about each coach so they ccan make an informed decision

coachlogin.php - coach login page, redirects to coach home page

coachHome.php - coach home page displays the coaches current schedule

coachSchedule.php - page that allows coaches to de/select time slots they would like to teach

coachslot.php - used by form in coachSchedule.php to select a wanted time slot

coachdeslect.php- used by form in coachSchedule.php to deselect a chosen time slot

updateCoach.php - page for coaches to change their password, phone number, mailing address, or bio

changeBio.php - used by updateCoach.php to update the given coaches bio in the database

changepassword.php - used by updateCoach.php to update the given coaches password, phone number, or mailing address in the database

logout.php - the logout button on all of the sites goes here, this ends the session and redirects to the main homepage
