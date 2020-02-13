<?php declare(strict_types=1);

namespace app\controllers;

class IndexController extends AbstractController
{
    protected function indexAction() : void
    {
        $this->renderView('index/index', [
            'js' => ['/assets/js/page-index.js'],
        ]);
    }
}