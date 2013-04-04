<?php include("header.php") ?>
<?php //print_r( $_SESSION[$u->session_user_data] ); ?>
<?php //print_r($_SERVER)?>
<div id="content" class="margin-top255">
    <div id="tv-object">
        <a href="#" class="feedback">Feedback</a>
        <h3 class="success-register">
            <?php
            if (isset($_SESSION['fresh_register'])) {
                unset($_SESSION['fresh_register']);
                echo "Registro Completo.";
            }
            ?>
        </h3>
    </div>
    <aside id="right-sidebar">
        <div class="logo"><a href="index.php" id="home-link"></a></div>

        <div id="anim-wrap">
            <!--Init login button-->
            <div class="login-init">
                <a href="#" id="init-button"><img src="images/iniciar-session.jpg" width="200" height="55" /></a>
                <h3>HAZ <a href="register-type.php" id="register-type">CLICK AQUI</a> PARA REGISTRARTE</h3>
            </div>

            <!--Login container-->
            <div class="login-container">
                <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" id="login-form">
                    <div class="form-row" id="email-fl">
                        <div class="pass-labels lbpad-top">EMAIL</div>
                        <input type="text" name="username" id="username"  autocomplete="off"   />
                    </div>
                    <div class="form-row" id="pass-fl">
                        <div class="pass-labels lbpad-top">contraseña</div>
                        <input type="password" name="password" id="password"  autocomplete="off" />
                    </div>


                    <a id="rm-link" href="#" >Olivide mi contraseña</a>
                    <div id="login-wrap"><input type="submit"  id="login-button"  value="Login" /></div>
                    <div id="login-response" class="error">Contraseña o usuario invalido.</div>
                </form>
            </div>
            
            <!-- Forgoten password field -->
            <div class="pass-forgot-block">
                <div class="form-row">
                    <div class="pass-labels lbpad-top">Enter Your Email</div>
                    <input type="text" id="usr-email" value="" autocomplete="off" />
                </div>
                <input type="button" id="pass-forgot" value="Send Request" />
            </div>

        </div>
    </aside>
</div>
<script type="text/javascript">
    $(function() {
        $("#login-button").click(function(event) {
            event.preventDefault();
            jQuery.ajax({
                url: 'lib/tools.php',
                type: "post",
                datatype: 'text',
                data: {param1: $("#username").val(), param2: $("#password").val()},
                success: function(data) {
                    if (data == "1") {
                        $("#login-response").hide();
                        $(".success-register").html("Ya eres partes parte de pix.");
						window.location = 'page_1.php';
                    }
                    else {
                        $("#login-response").show();
                    }
                }
            });
        });
    });
</script>
<?php include("footer.php") ?>