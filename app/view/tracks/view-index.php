<div class="container">
    <div class="san-title">
        <h5><?php __("List of tracks"); ?></h5>
    </div>
    <table class="san-table striped">
        <thead>
        <tr>
            <th><?php __('Name') ?></th>
            <th><?php __('Type') ?></th>
            <th><?php __('Tracker') ?></th>
            <th><?php __('Distance') ?></th>
            <th><?php __('Duration') ?></th>
            <th><?php __('Actions') ?></th>
        </tr>
        </thead>
        <tbody>
        <?php
        $html = "";
        $i = 0;
        foreach ($tracks as $track) {
            $actions = '
                <a class="waves-effect waves-light btn tooltipped modal-trigger san-btn" data-tooltip="' . __('Details', true) . '" href="' . ABSURL . DS . 'tracks' . DS . 'details?id=' . $track->getId() . '">
                    <i class="large material-icons">info_outline</i>
                </a>
                
                <!-- Modal Trigger DELETE -->
                <a class="waves-effect waves-light btn tooltipped modal-trigger san-btn" data-tooltip="' . __('Delete', true) . '" href="#modalDelete' . $track->getId() . '">
                    <i class="large material-icons">delete</i>
                </a>
    
                <!-- Modal Structure DELETE -->
                <div id="modalDelete' . $track->getId() . '" class="modal">
                    <div class="modal-content">
                        <h4>' . __("Delete the track", true) . ' "' . $track->getName() . '"</h4>
                        <p>' . __("Do you really want to delete this track ?", true) . '</p>
                    </div>
                    <div class="modal-footer">
                        <a href="' . ABSURL . '/tracks/delete?id=' . $track->getId() . '" class="modal-action modal-close waves-effect waves-green btn-flat">' . __("Confirm", true) . '</a>
                        <a href="" class="modal-action modal-close waves-effect waves-green btn-flat">' . __("Cancel", true) . '</a>
                    </div>
                </div>
            ';

            $html .= '
            <tr>
                <td>' . $track->getName() . '</td>
                <td>' . $types[$i]->getName() . '</td>
                <td>' . $users[$i]->getUsername() . '</td>
                <td>' . round_distance($track->getDistance()) . '</td>
                <td>' . setTime($track->getDuration()) . '</td>
                <td>' . $actions . '</td>
            </tr>';

            $i++;
        }

        echo $html;
        ?>
        </tbody>

    </table>
</div>
<?php
function round_distance($distance)
{
    if ($distance >= 1000)
        return round($distance / 1000, 2) . ' km';
    else
        return round($distance, 2) . ' m';
}

function setTime($time)
{
    $hours = intval($time / 3600);
    $minutes = intval(($time % 3600) / 60);
    $seconds = intval(($time % 3600) % 60);

    if ($hours < 10)
        $hours = '0' . $hours;

    if ($minutes < 10)
        $minutes = '0' . $minutes;

    if ($seconds < 10)
        $seconds = '0' . $seconds;

    return $hours . ':' . $minutes . ':' . $seconds;
}