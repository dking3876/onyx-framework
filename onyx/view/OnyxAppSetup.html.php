<h1>This is the Installer View for asking for Application Settings</h1>
<form action="?installer=appSetup&auth=<?php echo $_GET['auth']; ?>" method="post">
    <input type="hidden" name="OnyxAuth" value="<?php echo $OnyxAuth; ?>">
    <input type="submit" value="submit">
</form>