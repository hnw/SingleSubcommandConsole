<?php
namespace Hnw\SingleSubcommandConsole\Command;

class Command extends \Symfony\Component\Console\Command\Command
{
    private $modifiedSynopsis = null;

    public function getProcessedHelp()
    {
        $placeholders = array(
            '%command.name%',
            '%command.full_name%'
        );
        $replacements = array(
            $_SERVER['PHP_SELF'],
            $_SERVER['PHP_SELF'],
        );

        return str_replace($placeholders, $replacements, $this->getHelp());
    }

    public function getSynopsis()
    {
        if (null === $this->modifiedSynopsis) {
            $this->modifiedSynopsis = trim(sprintf('%s %s', $_SERVER['PHP_SELF'], $this->getDefinition()->getSynopsis()));
        }

        return $this->modifiedSynopsis;
    }

}