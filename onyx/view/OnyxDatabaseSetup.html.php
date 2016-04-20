<h1>This is the Installer View for asking for Database Creds to get started</h1>
<form action="?installer=AppSetup&auth=<?php echo $_GET['auth']; ?>" method="post" onSubmit="return CheckDatabaseConnection(); ">
    <input type="hidden" name="OnyxAuth" value="<?php echo $OnyxAuth; ?>">
    <label>
        <span>Connection</span>
        <select name="CONNECTION">
            <option value="MySQL">MySQL</option>
            <option value="PDO">PDO *Not Supported</option>
        </select>
    </label>
    <label>
        <span>Host</span>
        <input type="text" name="HOST">
    </label>
    <label>
        <span>Database</span>
        <input type="text" name="DATABASE">
    </label>
    <label>
        <span>Username</span>
        <input type="text" name="USER">
    </label>
    <label>
        <span>Paswword</span>
        <input type="text" name="PASSWORD">
    </label>
    <label>
        <span>Enviorment</span>
        <select name="ENVIROMENT">
            <option value="LIVE">LIVE</option>
            <option value="STAGING">STAGING</option>
            <option value="DEVELOPMENT">DEVELOPMENT</option>
        </select>
    </label>
    <input type="submit" value="submit">
</form>