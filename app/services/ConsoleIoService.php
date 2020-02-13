<?php declare(strict_types=1);

namespace app\services;

use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputInterface;

class ConsoleIoService
{
    /** @var ConfigService */
    private $configService;

    /** @var string */
    private $commandAlias;

    /** @var InputInterface */
    private $input;

    /** @var OutputInterface */
    private $output;

    public function __construct(ConfigService $configService, string $alias, InputInterface $input, OutputInterface $output)
    {
        $this->configService = $configService;

        $this->commandAlias = $alias;
        $this->input = $input;
        $this->output = $output;
    }

    public function info(string $msg) : void
    {
        $msg = date('Y-m-d H:i:s') . ' [INFO] ' . $msg;
        $this->output->writeln($msg);
        $this->toLog($msg);
    }

    /**
     * @param string $msg
     */
    public function error(string $msg) : void {
        $msg = date('Y-m-d H:i:s') . ' [ERROR] ' . $msg;
        $this->output->writeln("<error>{$msg}</error>");
        $this->toLog($msg);
    }

    /**
     * @param string $msg
     */
    public function toLog(string $msg) : void {
        $path = strtr($this->configService->get('services.console_io.logs_path'), ['{cmd}' => $this->commandAlias]);
        file_put_contents($path, $msg . PHP_EOL, FILE_APPEND);
    }
}