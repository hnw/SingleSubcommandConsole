<?php
namespace Hnw\SingleSubcommandConsole;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Command\HelpCommand;

class Application extends \Symfony\Component\Console\Application
{
    private $forcedCommand = null;

    public function add(Command $command)
    {
        $command = parent::add($command);
        if ($command) {
            $this->forcedCommand = $command;
        }
        return $command;
    }

    protected function getCommandName(InputInterface $input)
    {
        return $this->forcedCommand->getName();
    }

    protected function getDefaultCommands()
    {
        return array(new HelpCommand());
    }

    protected function getDefaultInputDefinition()
    {
        return new InputDefinition(array(
            new InputOption('--help',           '-h', InputOption::VALUE_NONE, 'Display this help message.'),
            new InputOption('--quiet',          '-q', InputOption::VALUE_NONE, 'Do not output any message.'),
            new InputOption('--verbose',        '-v|vv|vvv', InputOption::VALUE_NONE, 'Increase the verbosity of messages: 1 for normal output, 2 for more verbose output and 3 for debug'),
            new InputOption('--version',        '-V', InputOption::VALUE_NONE, 'Display this application version.'),
            new InputOption('--ansi',           '',   InputOption::VALUE_NONE, 'Force ANSI output.'),
            new InputOption('--no-ansi',        '',   InputOption::VALUE_NONE, 'Disable ANSI output.'),
            new InputOption('--no-interaction', '-n', InputOption::VALUE_NONE, 'Do not ask any interactive question.'),
        ));
    }
}
