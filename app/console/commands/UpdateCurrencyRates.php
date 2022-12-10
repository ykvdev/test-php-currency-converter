<?php

namespace app\console\commands;

use app\services\ConfigService;
use app\services\RatesApi\AbstractRatesApi;
use app\services\RatesApi\ExchangeRatesApi;
use app\services\ConsoleIoService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class UpdateCurrencyRates extends Command
{
    private ConfigService $config;

    private ConsoleIoService $io;

    private AbstractRatesApi $ratesApi;

    public function __construct(ConsoleIoService $io, ConfigService $config, ExchangeRatesApi $ratesApi)
    {
        parent::__construct();

        $this->io = $io;
        $this->config = $config;
        $this->ratesApi = $ratesApi;
    }

    protected function configure(): void
    {
        $this->setName('update-currency-rates')
            ->setDescription('Get new currency rates');
    }

    protected function initialize(InputInterface $input, OutputInterface $output): void
    {
        $this->io->setCommandAlias($this->getName())->setInput($input)->setOutput($output);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        try {
            $this->io->info('Start');

            $rates = $this->getRates();
            $this->io->info('Received rates: ' . var_export($rates, true));

            $this->saveRates($rates);
            $this->io->info('Rates saved');

            $this->io->info('End');
        } catch (\Throwable $e) {
            $this->io->error(
                PHP_EOL . '(' . get_class($e) . ') ' . $e->getMessage()
                . PHP_EOL . $e->getTraceAsString()
            );
        }

        return 0;
    }

    private function getRates(): array
    {
        $availableSymbols = $this->config->get('services.rates_api.available_symbols');
        $rates = [];
        foreach ($availableSymbols as $symbol) {
            $rates[$symbol] = $this->ratesApi->getLatestRates($symbol);
        }

        return $rates;
    }

    private function saveRates(array $rates): void
    {
        if (file_put_contents(
                $this->config->get('services.rates_api.file_db'),
                json_encode($rates, JSON_THROW_ON_ERROR)) === false
        ) {
            throw new \RuntimeException('Save rates failed');
        }
    }
}