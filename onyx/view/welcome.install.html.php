
    <div class="row">
        <div class="col-md-12">
            <h1>Welcome to the Onyx Installer</h1>
        </div>
        <div class="health-check col-md-12">
            <h2 onclick="opop.open({url: 'http://www.brafton.com'});">System Health Check</h2>
            <p>We are checking your system for Onyx Requirements:</p>
            <form class="health-check" action="" method="post">
            <label id="db">
                <span class="status"></span>
                <span class="check-type">Database Connections</span>
                <span>Mysql<span class="mysql-<?php echo $mysql; ?>"></span></span>
            </label>
            <label id="lib">
                <span class="status"></span>
                <span class="check-type">Required Libraries</span>
                <span><span class="library-<?php echo 'curl-'.$curl.' mail-'.$mail; ?>"></span></span>
            </label>
            <label id="write">
                <span class="status"></span>
                <span class="check-type">Disk Writable</span> 
                <span><span class="writable-<?php echo $writeable; ?>"></span></span>
            </label>
            <label>
                <span class="check-type"></span>
                <span></span>
            </label>
            </form>
            <div class="OnyxContinueInstall">
                <form action="?installer=DatabaseSetup&auth=<?php echo $auth; ?>" method="post">
                    <input type="hidden" name="OnyxAuth" value="<?php echo $auth; ?>">
                    <input type="submit" value="Next" <?php echo $continueStatus; ?>>
                </form>
            </div>
        </div>
    </div>
