<?php include("header.php") ?>
<div id="content" class="margin-top255">
    <div class="pix-logo"><a href="index.php" id="home-link"><img src="images/logo.png" width="260" height="204" /></a></div>
    <div class="side-icons">
        <?php $u->checkSecurityToken(); ?>

        <form id="pass_recoveryForm" method="post" action="#">

            <div class="form-row">
                <div class="pass-labels">Contraseña</div>
                <input type="password" id="recovery_password" value="" name="recovery_password" />
            </div>
            <div class="form-row">
                <div class="pass-labels">Repetir contraseña</div>
                <input type="password" id="confirm_recovery_password" value="" name="recovery_password" />
            </div>


            <p>
                <input type="hidden" id="sec_token" value="<?php echo $_GET['security_token'] ?>" />
                <input type="button" class="reset-pass-button" value="Reset Password"/>
            </p>
            <h3 class="pass-change">Password successfully changed</h3>

            <div class="clear">&nbsp;</div>
        </form>
        <script type="text/javascript">
            $(function() {
                $(".reset-pass-button").click(function(event) {
                    validator.errors.length = 0;
                    validator.requiredField("recovery_password");
                    if ($("#confirm_recovery_password").val() != $("#recovery_password").val()) {
                        validator.errors.push({ID: "confirm_recovery_password", errorMessage: "Please enter same password again"});
                    }

                    validator.displayErrors(callback);
                })

            });

            function callback() {
                $(".reset-pass-button").prop('disabled',true);
                $.ajax({
                    url: "lib/tools.php",
                    type: "post",
                    dataType: "text",
                    data: {
                        new_pass: $("#recovery_password").val(),
                        sec_token : $("#sec_token").val(),
                        pass_change: 1
                    },
                    success: function(data) {
                        // alert(data);
                        if (data == "1") {
                            $(".pass-change").css('display', 'block');
                            setTimeout(function(){
                                window.location = "index.php";
                            },2000);
                        }
                        $(".reset-pass-button").removeProp('disabled');
                    }

                });
            }
        </script>
    </div>
</div>
<?php include("footer.php") ?>