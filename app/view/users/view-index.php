<div class="container">
    <div class="san-title">
        <h5><?php __("List of users"); ?></h5>
        <a class="waves-effect waves-light btn btn-large san-btn san-btn-title"
           href="<?php echo ABSURL; ?>/users/add"><?php __("Add an user"); ?></a>
    </div>
    <table class="san-table striped">
        <thead>
        <tr>
            <th><?php __('Name') ?></th>
            <th><?php __('Role') ?></th>
            <th><?php __('Mail address') ?></th>
            <th><?php __('Actions') ?></th>
        </tr>
        </thead>
        <tbody>
        <?php
        $html = "";
        $i = 0;
        foreach ($users as $user) {
            $actions = '
                <a href="' . ABSURL . '/users/edit?id=' . $user->getId() . '" class="waves-effect waves-light btn tooltipped san-btn" data-tooltip="' . __('Edit', true) . '">
                    <i class="large material-icons">edit</i>
                </a>
                
                <!-- Modal Trigger DELETE -->
                <a class="waves-effect waves-light btn tooltipped modal-trigger san-btn" data-tooltip="' . __('Delete', true) . '" href="#modalDelete' . $user->getId() . '">
                    <i class="large material-icons">delete</i>
                </a>
    
                <!-- Modal Structure DELETE -->
                <div id="modalDelete' . $user->getId() . '" class="modal">
                    <div class="modal-content">
                        <h4>' . __("Delete the user", true) . ' "' . $user->getUsername() . '"</h4>
                        <p>' . __("Do you really want to delete this user ?", true) . '</p>
                    </div>
                    <div class="modal-footer">
                        <a href="' . ABSURL . '/users/delete?id=' . $user->getId() . '" class="modal-action modal-close waves-effect waves-green btn-flat">' . __("Confirm", true) . '</a>
                        <a href="" class="modal-action modal-close waves-effect waves-green btn-flat">' . __("Cancel", true) . '</a>
                    </div>
                </div>
            ';

            $html .= '
            <tr>
                <td>' . $user->getUsername() . '</td>
                <td>' . $roles[$i]->getName() . '</td>
                <td>' . $user->getMail() . '</td>
                <td>' . $actions . '</td>
            </tr>';

            $i++;
        }

        echo $html;
        ?>
        </tbody>

    </table>
</div>