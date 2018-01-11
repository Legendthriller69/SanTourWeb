<?php

namespace SanTourWeb\Library\Utils;

class Toast {
    private static $time = 4000;

    /**
     * Method used to add a new message
     * @param $message Content of the message
     * @param $color Color of the toast
     */
    public static function message($message, $color)
    {
        $_SESSION['messages'][] = array(
            'message' => $message,
            'color' => $color
        );
    }

    /**
     * Method used to display the messages stored in the session
     * @return string Html code containing the toasts
     */
    public static function displayMessages()
    {
        if (!isset($_SESSION['messages']) || sizeof($_SESSION['messages']) == 0)
            return "";

        $out = '<script> ';
        foreach ($_SESSION['messages'] as $message) {
            $out .= ' Materialize.toast("' . $message['message'] . '", "' . self::$time . '", "' . $message['color'] . '"); ';
        }

        $out .= '</script> ';
        $_SESSION['messages'] = array();

        return $out;
    }
}