<?php declare(strict_types=1);

namespace app\controllers;

class CommonController extends AbstractController
{
    public function error404Action() : void
    {
        header($_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found', true, 404);
        $this->renderView('common/error404');
    }

    public function error405Action() : void
    {
        header($_SERVER['SERVER_PROTOCOL'] . ' 405 Method Not Allowed', true, 405);
        $this->renderView('common/error405');
    }

    public function error500Action() : void
    {
        header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
        $this->renderView('common/error500');
    }
}