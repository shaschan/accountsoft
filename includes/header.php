<?php

?>
<div class="jumbotron" style="text-align: center;">
    <div style="display: inline-block; float: left;">
        <h1 style="font-size: 32px;">Financial Management System</h1>
    </div>
    <div style="display: inline-block; text-align: center; float: right; padding-top: 22px;">
        <?php if(!array_key_exists("email",$_SESSION)){?>
        <div style="display: inline-block;">
            <a href="<?php echo $conf->includesFolderURL?>about" class="btn btn-link" style="color:white;">About</a>
        </div>
        <?php } ?>
        <div style="display: inline-block;">
            <a href="#" class="btn btn-link" style="color:white;">Help</a>
        </div>
        <?php if(!array_key_exists("email",$_SESSION)){?>
        <div style="display: inline-block;">
            <a href="#" data-toggle="modal" data-target="#login" class="btn btn-link" style="color:white;">Login</a>
        </div>
        <div style="display: inline-block;">
            <a href="#" data-toggle="modal" data-target="#signup" class="btn btn-link" style="color:white;">SignUp</a>
        </div>
        <?php } else {?>
        <div style="display: inline-block; vertical-align: middle; padding-right: 64px;">
            <div class="dropdown">
                <a href="#" data-toggle="dropdown" class="dropdown-toggle" style="color: white; text-transform: capitalize;"><?php echo $_SESSION['fname']?><b class="caret"></b></a>
                <ul class="dropdown-menu">
                    <li><a href="#">Change Password</a></li>
                    <li><a href="<?php echo $conf->includesFolderURL?>logout">Log Out</a></li>
                </ul>
            </div>
        </div>
        <?php } ?>
    </div>
    
    <!-- login Modal -->
    <div id="login" class="modal fade" role="dialog">
      <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            
            <div class="modal-header" style="background-color: #0d98bc">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">Login</h4>
            </div>
        <div class="loginLoader" style="display: none;"></div>
        <form id="loginForm">
            <div id="loginModalBody" class="modal-body">
                <div class="form-group" style="color: black; text-align: left;">
                    <label for="email">Email Address/Mobile:</label>
                    <input type="text" class="form-control" style="border-color: #0d98bc;" id="loginemail" required>
                </div>
                <div class="form-group" style="color: black; text-align: left;">
                    <label for="pwd">Password:</label>
                    <input type="password" class="form-control" style="border-color: #0d98bc;" id="loginpassword" required>
                </div>
            </div>
            <div id="loginModalFooter" class="modal-footer">
                <div id="errLoginMessage" class="alert alert-danger" style="display: none; text-align: center;">
                    <strong>Wrong Credential!</strong> Please check your username/password.
                </div>
                <div id="forgotPassMessage" class="alert alert-success" style="display: none; text-align: center;">
                    <strong>Success!</strong> An email has been sent with further instruction. Please check your mail.
                </div>
                <div id="genErrLoginMessage" class="alert alert-danger" style="display: none; text-align: center;">
                    Something went wrong.. Please try again after some time.
                </div>
                <div id="warLoginMessage" class="alert alert-warning" style="display: none; text-align: center;">
                    
                </div>
                <div style="float: left;">
                    <a class="btn btn-link" href="#">Forgot Password?</a>
                </div>
                <div style="float:right">
                    <button type="submit" class="btn btn-default" style="background-color: #0d98bc; color: white;">Submit</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal" style="color: #0d98bc; border-color: #0d98bc;">Close</button>
                </div>
            </div>
        </form>
        </div>
      </div>
    </div>
    
    <!-- Signup Modal -->
    <div id="signup" class="modal fade" role="dialog">
      <div class="modal-dialog" >
        <!-- Modal content-->
        <div class="modal-content">
            
            <div class="modal-header" style="background-color: #0d98bc" >
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">SignUp</h4>
            </div>
        <div class="signupLoader" style="display: none;"></div>
        <form id="signupForm">
            <div id="signupModalBody" class="modal-body">
                <div class="form-group" style="color: black; text-align: left;">
                    <label for="email">Email Address:</label>
                    <input type="email" class="form-control" id="signupemail" style=" border-color: #0d98bc;" required>
                </div>
                <div class="form-group" style="color: black; text-align: left;">
                    <label for="firstName">First Name:</label>
                    <input type="text" class="form-control" id="signupfname" style=" border-color: #0d98bc;" required>
                </div>
                <div class="form-group" style="color: black; text-align: left;">
                    <label for="lastName">Last Name:</label>
                    <input type="text" class="form-control" id="signuplname" style=" border-color: #0d98bc;" required>
                </div>
                <div class="form-group" style="color: black; text-align: left;">
                    <label for="lastName">Mobile Number:</label>
                    <input type="number" class="form-control" id="signupmob" style=" border-color: #0d98bc;" required>
                </div>
                <div class="form-group" style="color: black; text-align: left;">
                    <label for="pwd1">Create Password:</label>
                    <input type="password" class="form-control" id="signuppassword1" style=" border-color: #0d98bc;" required>
                </div>
                <div class="form-group" style="color: black; text-align: left;">
                    <label for="pwd2">Confirm Password:</label>
                    <input type="password" class="form-control" id="signuppassword2" style=" border-color: #0d98bc;" required>
                </div>
            </div>
            <div id="signupModalFooter" class="modal-footer">
                <div id="errSignupMessage" class="alert alert-danger" style="display: none; text-align: center;">
                    <strong>Error!</strong> Passwords don't match.
                </div>
                <div id="genErrSignupMessage" class="alert alert-danger" style="display: none; text-align: center;">
                    Something went wrong.. Please try again after some time.
                </div>
                <div id="warSignupMessage" class="alert alert-warning" style="display: none; text-align: center;">
                    
                </div>
                <div id="signupMessage" class="alert alert-success" style="display: none; text-align: center;">
                    <strong>Success!</strong> Please check your email for account verification.
                </div>
                <button type="submit" class="btn btn-default" style="background-color: #0d98bc; color: white;">Submit</button>
                <button type="button" class="btn btn-default" data-dismiss="modal" style="color: #0d98bc; border-color: #0d98bc;">Close</button>
            </div>
        </form>
        </div>
      </div>
    </div>
</div>