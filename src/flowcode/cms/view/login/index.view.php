<script type="text/javascript">
    $(document).ready(function() {
        $("#login-name").focus();
    });
</script>
<div class="login">
    <div class="login-screen">
        <div class="login-icon">
            <img src="/images/flowcode-fav.png" alt="Welcome to Mail App" />
            <h4>Welcome to <small><? echo flowcode\wing\mvc\Config::getByModule("front", "site", "name") ?></small></h4>
        </div>

        <div class="login-form">
            <form name="form" method="post" action="/adminLogin/validate">
                <div class="control-group">
                    <input type="text" class="login-field" value="" placeholder="Enter your name" id="login-name" name="username" />
                    <label class="login-field-icon fui-man-16" for="login-name"></label>
                </div>

                <div class="control-group">
                    <input type="password" class="login-field" value="" placeholder="Password" id="login-pass" name="password" />
                    <label class="login-field-icon fui-lock-16" for="login-pass"></label>
                </div>

                <? if (strlen($viewData["message"]) != 0): ?>
                    <div class="alert alert-error"><strong>Error!</strong> <? echo $viewData["message"] ?></span></div>
                <? endif; ?>

                <button class="btn btn-primary btn-large btn-block" type="submit">Login</button>
                <a class="login-link" href="#">Lost your password?</a>
            </form>
        </div>
    </div>
</div>
