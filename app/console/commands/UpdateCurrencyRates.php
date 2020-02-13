<?php declare(strict_types=1);

namespace app\cli\commands;

use app\services\ConsoleIoService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class UpdateCurrencyRates extends Command
{
    /** @var ConsoleIoService */
    private $consoleIoService;

    public function __construct(ConsoleIoService $consoleIoService)
    {
        parent::__construct();

        $this->consoleIoService = $consoleIoService;
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
        $this->consoleIoService
            ->setCommandAlias($this->getName())
            ->setInput($input)
            ->setOutput($output);
    }

    protected function execute(InputInterface $input, OutputInterface $output): void
    {
        try {
            //...
        } catch (\Throwable $e) {
            $this->consoleIoService->error(
                PHP_EOL . '(' . get_class($e) . ') ' . $e->getMessage()
                . PHP_EOL . $e->getTraceAsString()
            );
        }
    }

    //...
}