<?php

namespace SanTourWeb\Library\Utils;

class Redirect
{
    /**
     * Redirection to an url
     * @param $link url to which we want to redirect
     */
    public static function toUrl($link)
    {
        header(sprintf('Location: %s', $link));
        exit;
    }

    /**
     * Redirection to the previous page
     */
    public static function toLastPage()
    {
        if (isset($_SERVER['HTTP_REFERER'])) $link = $_SERVER['HTTP_REFERER'];
        else {
            if (isset($_SESSION['user']))
                $link = ABSURL . DS . 'tracks';
            else
                $link = ABSURL;
        }

        header(sprintf('Location: %s', $link));
        exit;
    }

    /**
     * Redirection to a specific action
     * @param $controller
     * @param string $action
     * @param null $param Params in the url
     */
    public static function toAction($controller, $action = 'index', $param = null)
    {
        echo $controller;
        echo $action;
        if (isset($param)) {
            $queryString = '&';
            foreach ($param as $key => $value) {
                $queryString .= sprintf('%s=%s', $key, $value);
            }

            header(sprintf('Location: ' . ABSURL . DS . '%s' . DS . '%s?%s', $controller, $action, $queryString));
            exit;
        } else {
            header(sprintf('Location: ' . ABSURL . DS . '%s', $controller));
            exit;
        }
    }
}