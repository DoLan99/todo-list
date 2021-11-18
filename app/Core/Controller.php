<?php

namespace App\Core;

use App\Core\Application;

class Controller
{
    public function render($view, $params = [])
    {
        return Application::$app->template->render($view, $params);
    }

    public function abort($view)
    {
        return Application::$app->template->renderOnlyView($view);
    }

    public function redirect($url)
    {
        return Application::$app->response->redirect($url);
    }

    public function setFlash($key, $value)
    {
        return Application::$app->session->setFlash($key, $value);
    }
}