<?php

namespace Typedin\LaravelCalendly\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GenerateFiles extends Command
{
    /**
     * The name of the command (the part after "bin/demo").
     *
     * @var string
     */
    protected static $defaultName = 'generate';

    /**
     * The command description shown when running "php bin/demo list".
     *
     * @var string
     */
    protected static $defaultDescription = 'generate all files';

    /**
     * Execute the command
     *
     * @return int 0 if everything went fine, or an exit code.
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        echo 'yep';

        return Command::SUCCESS;
    }

        protected function configure(): void
        {
            $this
                ->addArgument('url', InputArgument::OPTIONAL, 'Who do you want to greet?')
                ->addArgument('last_name', InputArgument::OPTIONAL, 'Your last name?');
        }
}
