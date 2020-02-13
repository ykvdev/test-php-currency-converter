<?php declare(strict_types=1);

namespace app\cli\commands;

use app\services\ServicesContainer;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class UpdateCurrencyRates extends Command
{
    /** @var ServicesContainer */
    private $services;

    public function __construct(ServicesContainer $services)
    {
        parent::__construct();
        $this->services = $services;
    }

    protected function configure(): void
    {
        $this->setName('update-currency-rates')
            ->setDescription('Get new currency rates');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    protected function initialize(InputInterface $input, OutputInterface $output): void
    {
        $this->services->consoleIo
            ->setCommandAlias($this->getName())
            ->setInput($input)
            ->setOutput($output);
    }

    protected function execute(InputInterface $input, OutputInterface $output): void
    {
        try {
            //...
        } catch (\Throwable $e) {
            $this->services->consoleIo->error(
                PHP_EOL . '(' . get_class($e) . ') ' . $e->getMessage()
                . PHP_EOL . $e->getTraceAsString()
            );
        }
    }

    //...
}