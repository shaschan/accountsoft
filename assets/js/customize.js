function log(t){
    console.log(t);
}

function resendVerificationMail(type){
    var email;
    if(type === 2){ //signup
        email = $('#signupemail').val();
        $(".signupLoader").css("display","block");
        $("#signupForm :input").prop("disabled", true);
    }else if(type === 1){ //login
        email = $('#loginemail').val();
        $(".loginLoader").css("display","block");
        $("#loginForm :input").prop("disabled", true);
    }else if(type === 3){ //firstlogin
        email = $('#firstLoginEmailOrMob').val();
        $("#firstLogin :input").prop("disabled", true);
        $("#firstLoginForPass").attr("disabled", true);
        $(".firstLoginLoader").css("display","block");
        $("#firstLoginMessage").css("display","none");
    }
    
    var form_data = 'token=verify&email='+email;
    $.ajax({
            url: "includes/login.php",
            type: "POST",
            processData: false,
            dataType: 'json',
            data: form_data,
            success: function(data) {
                log(data);
                if(data === 1){
                    if(type === 2){ //signup
                        $('#signupMessage').css("display","block");
                        $(".signupLoader").css("display","none");
                        $("#genErrSignupMessage").css("display","none");
                        $("#warSignupMessage").css("display","none");
                        $('#errSignupMessage').css("display","none");
                        $("#signupForm :input").prop("disabled", false);
                    }else if(type === 1){ //login
                        $(".loginLoader").css("display","none");
                        $("#errLoginMessage").css("display","none");
                        $("#forgotPassMessage").css("display","block"); 
                        $("#genErrLoginMessage").css("display","none");
                        $("#warLoginMessage").css("display","none");
                        $("#loginForm :input").prop("disabled", false);
                    }else if(type === 3){ //firstlogin
                        $(".firstLoginLoader").css("display","none");
                        $("#firstLoginMessage").css("display","block");
                        $("#firstLoginMessage").removeClass();
                        $("#firstLoginMessage").addClass('alert alert-success');
                        $("#firstLoginMessage").html("<strong>Success!</strong> An email has been sent with further instruction. Please check your mail.");
                        $("#firstLogin :input").prop("disabled", false);
                        $("#firstLoginForPass").attr("disabled", false);
                    }
                }else{
                    if(type === 2){ //signup
                        $('#signupMessage').css("display","none");
                        $(".signupLoader").css("display","none");
                        $("#genErrSignupMessage").css("display","block");
                        $("#warSignupMessage").css("display","none");
                        $('#errSignupMessage').css("display","none");
                        $("#signupForm :input").prop("disabled", false);
                    }else if(type === 1){ //login
                        $(".loginLoader").css("display","none");
                        $("#errLoginMessage").css("display","none");
                        $("#forgotPassMessage").css("display","none"); 
                        $("#genErrLoginMessage").css("display","block");
                        $("#warLoginMessage").css("display","none");
                        $("#loginForm :input").prop("disabled", false);
                    }else if(type === 3){ //firstlogin
                        $(".firstLoginLoader").css("display","none");
                        $("#firstLoginMessage").removeClass();
                        $("#firstLoginMessage").css("display","block");
                        $("#firstLoginMessage").addClass('alert alert-danger');
                        $("#firstLoginMessage").html("Something went wrong.. Please try again after some time.");
                        $("#firstLogin :input").prop("disabled", false);
                        $("#firstLoginForPass").attr("disabled", false);
                    }
                }
            }
    });
    
}

$(document).ready(function(){
    $('#firstLogin').on('submit', function(e){
        e.preventDefault();
        var form_data = 'token=login&email='+$('#firstLoginEmailOrMob').val()+'&pass='+$('#firstLoginPass').val();
        
        $("#firstLogin :input").prop("disabled", true);
        $("#firstLoginForPass").attr("disabled", true);
        $(".firstLoginLoader").css("display","block");
        $("#firstLoginMessage").css("display","none");
        
	$.ajax({
                url: "includes/login.php",
                type: "POST",
                processData: false,
                dataType: 'json',
                data: form_data,
            success: function(data) {
                log(data);
                if(data === 0){
                    window.location.href = "index";
                }else{
                    $(".firstLoginLoader").css("display","none");
                    $("#firstLogin :input").prop("disabled", false);
                    $("#firstLoginForPass").attr("disabled", false);
                    if(data === 1){
                        $("#firstLoginMessage").css("display","block");
                        $("#firstLoginMessage").removeClass();
                        $("#firstLoginMessage").addClass('alert alert-warning');
                        $("#firstLoginMessage").html("<strong>Account not registered.</strong> Please check your mails for the activation Or <a href='#' onclick='resendVerificationMail(3)'>Resend mail</a>.");
                    }else if(data === 2){
                        $("#firstLoginMessage").css("display","block");
                        $("#firstLoginMessage").removeClass();
                        $("#firstLoginMessage").addClass('alert alert-warning');
                        $("#firstLoginMessage").html('<strong>Account Deactivated.</strong> Please contact <a href="mailto:shashishchandra@gmail.com">admin</a>.');
                    }else if(data === 3){//incorrect password/email
                        $("#firstLoginMessage").css("display","block");
                        $("#firstLoginMessage").removeClass();
                        $("#firstLoginMessage").addClass('alert alert-danger');
                        $("#firstLoginMessage").html('Incorrect Password/Email-id or Mobile.');
                    }else{//general
                        $("#firstLoginMessage").css("display","block");
                        $("#firstLoginMessage").removeClass();
                        $("#firstLoginMessage").addClass('alert alert-danger');
                        $("#firstLoginMessage").html('Something went wrong.. Please try again after some time.');
                    }
                }
            },
            error: function (textStatus, errorThrown) {
                log(textStatus);
                log(errorThrown);
                $(".firstLoginLoader").css("display","none");
                $("#firstLoginMessage").css("display","block");
                $("#firstLogin :input").prop("disabled", false);
                $("#firstLoginForPass").attr("disabled", false);
                $("#firstLoginMessage").removeClass();
                $("#firstLoginMessage").addClass('alert alert-danger');
                $("#firstLoginMessage").html('Something went wrong.. Please try again after some time.');
            },
            beforeSend: function () {
            }
        });
    });
});

$(document).ready(function(){
    
    $('#loginForm').on('submit', function(e){
        e.preventDefault();
        var form_data = 'token=login&email='+$('#loginemail').val()+'&pass='+$('#loginpassword').val();
        
        $("#loginForm :input").prop("disabled", true);
        $(".loginLoader").css("display","block");
        $("#errLoginMessage").css("display","none");
        $("#forgotPassMessage").css("display","none"); 
        $("#genErrLoginMessage").css("display","none");
        $("#warLoginMessage").css("display","none");
        
	$.ajax({
                url: "includes/login.php",
                type: "POST",
                processData: false,
                dataType: 'json',
                data: form_data,
            success: function(data) {
                log(data);
                if(data === 0){
                    window.location.href = "index";
                }else{
                    $(".loginLoader").css("display","none");
                    $("#loginForm :input").prop("disabled", false);
                    if(data === 1){
                        $("#warLoginMessage").css("display","block");
                        $("#warLoginMessage").html("Already registered. Please check your mails for the activation Or <a href='#' onclick='resendVerificationMail(1)'>Resend mail</a>");
                    }else if(data === 2){
                        $("#warLoginMessage").css("display","block");
                        $("#warLoginMessage").html('Account Deactivated. Please contact <a href="mailto:shashishchandra@gmail.com">admin</a>.');
                    }else if(data === 3){
                        $("#errLoginMessage").css("display","block");
                    }else{
                        $("#genErrLoginMessage").css("display","block");
                    }
                }
            },
            error: function (textStatus, errorThrown) {
                log(textStatus);
                log(errorThrown);
                $(".loginLoader").css("display","none");
                $("#loginForm :input").prop("disabled", false);
                $("#errLoginMessage").css("display","block");
            },
            beforeSend: function () {
            }
        });
    });
    
    $('#signupForm').on('submit', function(e){
        e.preventDefault();
        if($('#signuppassword1').val() !== $('#signuppassword2').val()){
            $('#errSignupMessage').css("display","block");
            return;
        }else{
            $('#errSignupMessage').css("display","none");
        }
        
        var form_data ='token=signup&email='+$('#signupemail').val()+'&fname='+$('#signupfname').val()
                +'&lname='+$('#signuplname').val()+'&mob='+$('#signupmob').val()+'&pass='+$('#signuppassword1').val();
        $("#signupForm :input").prop("disabled", true);
        $(".signupLoader").css("display","block");
        $("#signupMessage").css("display","none");
        $("#genErrSignupMessage").css("display","none");
        $("#warSignupMessage").css("display","none");
	$.ajax({
                    url: "includes/login.php",
                    type: "POST",
                    processData: false,
                    dataType: 'json',
                    data: form_data,
                success: function(data) {
                    log(data);
                    $(".signupLoader").css("display","none");
                    $("#signupForm :input").prop("disabled", false);
                    if(data === 0){
                        $("#signupMessage").css("display","block");
                    }else if(data === 1){
                        $("#warSignupMessage").css("display","block");
                        $("#warSignupMessage").html("Already registered. Please check your mails for the activation Or <a href='#' onclick='resendVerificationMail(2)'>Resend mail</a>");
                    }else if(data === 2){
                        $("#warSignupMessage").css("display","block");
                        $("#warSignupMessage").html('Account Deactivated. Please contact <a href="mailto:shashishchandra@gmail.com">admin</a>.');
                    }else if(data === 3){
                        $("#warSignupMessage").css("display","block");
                        $("#warSignupMessage").html('Already registered. Try <a href="#" onclick="$('+"'#signup'"+').modal('+"'toggle'"+'); $('+"'#loginemail'"+').val('+"'"+$('#signupemail').val()+"'"+');" data-toggle="modal" data-target="#login">signing in</a>.');
                    }else{
                        $("#genErrSignupMessage").css("display","block");
                    }
                },
                error: function (textStatus, errorThrown) {
                    log(textStatus);
                    log(errorThrown);
                    $(".signupLoader").css("display","none");
                    $("#signupForm :input").prop("disabled", false);
                    $("#genErrSignupMessage").css("display","none");
                },
                beforeSend: function () {
                }
        });
    });
});