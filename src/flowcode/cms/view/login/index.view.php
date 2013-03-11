<br/><br/>
<div class="row-fluid">
    <div class="span10 well offset1 well-large">
        <div class="span7">
            <h1 class="offset2">Login</h1>
            <form name="form" method="post" action="/adminLogin/validate" class="form-horizontal">
                <div class="control-group">
                    <label class="control-label" for="username">Username</label>
                    <div class="controls">
                        <input id="username" name="username" type="text" />
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="password">Password</label>
                    <div class="controls">
                        <input id="password" name="password" type="password" />
                    </div>
                </div>
                <div><? echo $viewData["message"] ?></div>

                <div class="control-group">
                    <div class="controls">
                        <button type="submit" class="btn">Entrar</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="span4 offset1">
            <br/>
            <img src="<?php echo flowcode\smooth\mvc\Config::get("images", "logo") ?>" class="img-album"/>
        </div>
    </div>
</div>
