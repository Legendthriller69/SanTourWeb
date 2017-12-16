<div class="container">
    <div class="form">
        <form class="login-form col s12 san-form" method="POST">
            <div class="row">
                <div class="input-field col s12">
                    <input id="login" name="pseudo" type="text" class="validate">
                    <label class=active for="login"><?php __('Username') ?></label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s12">
                    <input id="password" name="password" type="password" class="validate">
                    <label class="active" for="password"><?php __('Password') ?></label>
                </div>
            </div>
                <button type="submit" name="submit" class="waves-effect waves-light btn btn-large resa-btn">
                    <!--<i class="material-icons right">send</i>-->
                    <?php __('Enter') ?>
                </button>
            </div>
        </form>
    </div>
</div>