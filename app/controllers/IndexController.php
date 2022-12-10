<?php

namespace app\controllers;

class IndexController extends AbstractController
{
    public function indexAction(): void
    {
        $this->renderView('index/index', [
            'availableCurrencies' => $this->config->get('services.rates_api.available_symbols'),
            'js' => ['/assets/js/page-index.js'],
            'css' => ['/assets/css/page-index.css'],
        ]);
    }
}