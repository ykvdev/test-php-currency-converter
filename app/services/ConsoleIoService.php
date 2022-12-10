<?php

namespace app\services;

use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputInterface;

class ConsoleIoService
{
    private ConfigService $config;

    private string $commandAlias;

    private OutputInterface $output;

    public function __construct(ConfigService $config)
    {
        $this->config = $config;
    }

    public function setCommandAlias(string $commandAlias): self
    {
        $this->commandAlias = $commandAlias;

        return $this;
    }

    public function setInput(InputInterface $input): self
    {
        $this->input = $input;

        return $this;
    }

    public function setOutput(OutputInterface $output): self
    {
        $this->output = $output;

        return $this;
    }

    public function info(string $msg): void
    {
        $msg = date('Y-m-d H:i:s') . ' [INFO] ' . $msg;
        $this->output->writeln($msg);
        $this->toLog($msg);
    }

    public function error(string $msg): void {
        $msg = date('Y-m-d H:i:s') . ' [ERROR] ' . $msg;
        $this->output->writeln("<error>{$msg}</error>");
        $this->toLog($msg);
    }

    public function toLog(string $msg): void {
        $path = strtr($this->config->get('services.console_io.logs_path'), ['{cmd}' => $this->commandAlias]);
        file_put_contents($path, $msg . PHP_EOL, FILE_APPEND);
    }
}