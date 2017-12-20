<div class="container">
    <div class="san-title">
        <h5><?php __('Edit the user');
            echo ': "' . $user->getUsername() . '"'; ?></h5>
        <a class="waves-effect waves-light btn  btn-large san-btn san-btn-title"
           href="<?php echo ABSURL; ?>/users"><?php __("Return to the list of users"); ?></a>
    </div>
    <div class="row">
        <form class="col s12" method="post">
            <input type="hidden" name="id" value="<?php echo $user->getId() ?>">
            <input id="changePass" name="changePass" type="hidden" value="false">
            <div class="row">
                <div class="input-field col s12">
                    <select name="role">
                        <?php
                        foreach ($roles as $role) {
                            if ($role->getId() == $user->getIdRole())
                                echo '<option selected value="' . $role->getId() . '">' . $role->getName() . '</option>';
                            else
                                echo '<option value="' . $role->getId() . '">' . $role->getName() . '</option>';
                        }
                        ?>
                    </select>
                    <label><?php __('Role') ?></label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s12">
                    <input id="username" name="username" type="text" class="validate"
                           value="<?php echo $user->getUsername(); ?>" required>
                    <label for="username"><?php __('Username') ?></label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s12">
                    <input id="email" type="email" name="email" class="validate" value="<?php echo $user->getMail() ?>"
                           required>
                    <label for="email"><?php __('Email') ?></label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s12">
                    <button class="waves-effect waves-light btn btn-large san-btn" id="btnChangePass"
                            type="button"><?php __('Change the password') ?></button>
                </div>
            </div>
            <div class="row" id="rowPass">
                <div class="input-field col s6">
                    <input id="password" name="password" type="password" class="validate">
                    <label for="password"><?php __('Password') ?></label>
                </div>
                <div class="input-field col s6">
                    <input id="passwordConf" name="passwordConf" type="password" class="validate">
                    <label for="password"><?php __('Password confirmation') ?></label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s12">
                    <button class="waves-effect waves-light btn btn-large san-btn" name="submit"
                            type="submit"><?php __('Update') ?></button>
                </div>
            </div>
        </form>
    </div>
</div>