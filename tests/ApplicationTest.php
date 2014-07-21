<?php

namespace Hnw\SingleSubcommandConsole\Tests;

use Hnw\SingleSubcommandConsole\Application;
use Hnw\SingleSubcommandConsole\Command\Command;
use Symfony\Component\Console\Tester\ApplicationTester;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class TestCommand extends Command
{
    protected function configure()
    {
        $this->setName('test')
            ->setDefinition(array(
                    new InputOption('foobarbaz', null, InputOption::VALUE_REQUIRED, 'foo bar baz')
                ));
    }
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln("qux quux");
    }
}

class ApplicationTest extends \PHPUnit_Framework_TestCase
{
    public function testCommandHelp()
    {
        $app = new Application();
        $app->add(new TestCommand());
        $app->setAutoExit(false); // For testing

        $tester = new ApplicationTester($app);
        $tester->run(array('--help'), array('decorated' => false));
        $this->assertContains("foo bar baz", $tester->getDisplay(true));
        $this->assertContains("--help", $tester->getDisplay(true));
    }

    public function testCommandExecute()
    {
        $app = new Application();
        $app->add(new TestCommand());
        $app->setAutoExit(false); // For testing

        $tester = new ApplicationTester($app);
        $tester->run(array(), array('decorated' => false));
        $this->assertContains("qux quux", $tester->getDisplay(true));
    }
}