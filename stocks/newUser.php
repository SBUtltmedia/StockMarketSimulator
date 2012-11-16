<?php
echo "New User! <br />";
echo $_SERVER["REMOTE_USER"] . "<br />";
echo "Click the button below to register yourself to the simulation. <br />";
?>

<input type="button" value="Click to Continue" onclick="window.location = 'addUser.php'" />
