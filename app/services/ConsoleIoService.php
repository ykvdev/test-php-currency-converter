<?php declare(strict_types=1);

namespace app\services;

use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputInterface;

class ConsoleIoService extends AbstractService
{
    /** @var string */
    private $commandAlias;

    /** @var InputInterface */
    private $input;

    /** @var OutputInterface */
    private $output;

    public function init(): void
    {
    }

    public function setCommandAlias(string $alias): self
    {
        $this->commandAlias = $alias;

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

    public function getInput(): InputInterface
    {
        return $this->input;
    }

    public function getOutput(): OutputInterface
    {
        return $this->output;
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
        $path = strtr($this->services->config->get('services.console_io.logs_path'), ['{cmd}' => $this->commandAlias]);
        file_put_contents($path, $msg . PHP_EOL, FILE_APPEND);
    }
}