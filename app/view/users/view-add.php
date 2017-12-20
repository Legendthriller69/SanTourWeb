<div class="container">
    <div class="san-title">
        <h5><?php __("Add a new user"); ?></h5>
        <a class="waves-effect waves-light btn btn-large san-btn san-btn-title"
           href="<?php echo ABSURL; ?>/users"><?php __("Return to the list of users"); ?></a>
    </div>
    <div class="row">
        <form class="col s12" method="post">
            <div class="row">
                <div class="input-field col s12">
                    <select name="role" id="san-select-role">
                        <?php
                        foreach ($roles as $role) {
                            if (isset($_POST['role']) && $role->getId() == $_POST['role']) {
                                echo '<option selected value="' . $role->getId() . '">' . $role->getName() . '</option>';
                            } else
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
                           value="<?php echo isset($_POST['username']) ? $_POST['username'] : '' ?>" required>
                    <label for="username"><?php __('Username') ?></label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s6">
                    <input id="password" name="password" type="password" class="validate" required>
                    <label for="password"><?php __('Password') ?></label>
                </div>
                <div class="input-field col s6">
                    <input id="passwordConf" name="passwordConf" type="password" class="validate" required>
                    <label for="password"><?php __('Password confirmation') ?></label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s12">
                    <input id="email" type="email" name="email" class="validate"
                           value="<?php echo isset($_POST['email']) ? $_POST['email'] : '' ?>" required>
                    <label for="email"><?php __('Email') ?></label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s12">
                    <button class="waves-effect waves-light btn btn-large san-btn" name="submit"
                            type="submit"><?php __('Add') ?></button>
                </div>
            </div>
        </form>
    </div>
</div>