<div class="container">
    <div class="san-title">
        <h5><?php __("List of categories"); ?></h5>
        <form class="col l6 s12 san-btn-title " method="post">
            <div class="input-field inline" id="san-add-category">
                <input id="name" maxlength="50" type="text" name="name" class="validate" required>
                <label for="name"><?php __('Name of the category') ?></label>
            </div>
            <button class="waves-effect waves-light btn btn-large san-btn inline" type="submit"
                    name="submit"><?php __('Add a new category') ?>
            </button>
        </form>
    </div>
    <table class="san-table striped" id="san-table-category">
        <thead>
        <tr>
            <th><?php __('Name') ?></th>
            <th><?php __('Actions') ?></th>
        </tr>
        </thead>
        <tbody>
        <?php
        $html = "";
        $i = 0;
        foreach ($categories as $category) {
            $actions = '
                <!-- Modal Trigger EDIT -->
                <a href="#modalEdit' . $category->getId() . '" class="waves-effect waves-light btn tooltipped modal-trigger san-btn" data-tooltip="' . __('Edit', true) . '">
                    <i class="large material-icons">edit</i>
                </a>
                
                <!-- Modal Structure EDIT -->
                <div id="modalEdit' . $category->getId() . '" class="modal">
                    <form method="post">
                        <div class="modal-content">
                            <h4>' . __("Edit the category", true) . ' : "' . $category->getName() . '"</h4>
                            <div class="input-field col s4">
                                <input type="hidden" name="editId" value="' . $category->getId() . '">
                                <input id="input-editZone" name="editName" type="text" class="validate" required>
                                <label for="input-EditZone">' . __("New category name", true) . '</label>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="modal-action waves-effect waves-green btn-flat" type="submit" name="submitEdit">' . __("Update", true) . '</button>
                            <a href="" class="modal-action modal-close waves-effect waves-green btn-flat">' . __("Cancel", true) . '</a>
                        </div>
                    </form>
                </div>
                
                <!-- Modal Trigger DELETE -->
                <a class="waves-effect waves-light btn tooltipped modal-trigger san-btn" data-tooltip="' . __('Delete', true) . '" href="#modalDelete' . $category->getId() . '">
                    <i class="large material-icons">delete</i>
                </a>
    
                <!-- Modal Structure DELETE -->
                <div id="modalDelete' . $category->getId() . '" class="modal">
                    <div class="modal-content">
                        <h4>' . __("Delete the category", true) . ' "' . $category->getName() . '"</h4>
                        <p>' . __("Do you really want to delete this category ?", true) . '</p>
                    </div>
                    <div class="modal-footer">
                        <a href="' . ABSURL . '/categories/delete?id=' . $category->getId() . '" class="modal-action modal-close waves-effect waves-green btn-flat">' . __("Confirm", true) . '</a>
                        <a href="" class="modal-action modal-close waves-effect waves-green btn-flat">' . __("Cancel", true) . '</a>
                    </div>
                </div>
            ';

            $html .= '
            <tr>
                <td>' . $category->getName() . '</td>
                <td>' . $actions . '</td>
            </tr>';

            $i++;
        }

        echo $html;
        ?>
        </tbody>

    </table>
</div>