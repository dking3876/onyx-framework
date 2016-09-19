
        <div class="container-fluid">
            <div class="row">
                <h1>Login</h1>
                <div class="col-md-2"></div>
                <div class="col-md-4">
                    <form class="form-horizontal" action="" method="post">
                        <input type="hidden" name="onyx_login" value="<?php echo isset($attempts)? $attempts : 0; ?>">
                        <div class="form-group">
                            <label for="usr" class="control-label">Username</label>
                            <input type="text" name="usr" class="form-control" id="usr" placeholder="UserName/Email" value="<?php echo isset($userName)? $userName : ''; ?>">
                        </div>
                        <div class="form-group">
                            <label for="psw" class="control-label">Password</label>
                            <input type="password" name="psw" class="form-control" id="psw" >
                        </div>
                        <div class="form-group">
                            <input type="submit" class="form-control btn btn-primary" value="Login">
                        </div>
                        <div class="form-group">
                            <span><a href="?forgot">Forgot Login/Password</a></span>
                        </div>

                    </form>
                </div>
            </div>
        </div>
