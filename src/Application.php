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
        // Get rid of subcommand argument from definition
        $originalInputDefinition = parent::getDefaultInputDefinition();
        return new InputDefinition($originalInputDefinition->getOptions());
    }
}
