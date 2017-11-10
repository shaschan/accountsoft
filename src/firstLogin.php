<?php
    $showLogin = false;
    if(!array_key_exists("email",$_SESSION)){
        $showLogin = true;
    }
?>
<div class="inner_landing_bg">
    <?php if($showLogin){?>
        <div class="alert alert-success" style="display: block; text-align: center;">
            <strong>Successfully </strong> verified your account
        </div>
        <div class="container">
            <div class="row">
                <div class="col-sm-6 col-md-4 col-md-offset-4">
                    <div class="firstLoginLoader" style="display: none;"></div>
                    <h1 class="text-center login-title">Sign in to continue further</h1>
                    <form id="firstLogin">
                        <div class="account-wall">
                            <input id="firstLoginEmailOrMob" type="text" class="form-control" placeholder="Email/Mobile" required autofocus>
                            <input id="firstLoginPass" type="password" class="form-control" placeholder="Password" required>
                        </div>
                        <div id="firstLoginMessage" class="alert alert-warning" style="display: none; text-align: center;">
                            Something went wrong.. Please try again after some time.
                        </div>
                        <div style="float: left;">
                            <a id="firstLoginForPass" class="btn btn-link" href="#">Forgot Password?</a>
                        </div>
                        <div style="float:right">
                            <button type="submit" class="btn btn-default" style="background-color: #0d98bc; color: white;">Submit</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal" style="color: #0d98bc; border-color: #0d98bc;">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <?php }else{
        header("location: ../index");
        exit();
    }
    ?>
</div>