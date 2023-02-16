<?php

namespace Typedin\LaravelCalendly\Commands;

use Throwable;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Typedin\LaravelCalendly\Actions\GeneratedFileManager;
use Typedin\LaravelCalendly\Supports\EndpointMapper;

#[AsCommand(
    name: 'app:generate',
    description: 'Generate all files from yaml files',
    hidden: false,
)]
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

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        try {
            (new GeneratedFileManager(new EndpointMapper(file_get_contents($input->getOption('source'))), $input->getOption('destination')))->writeAllFiles();
        } catch(Throwable $e) {
            ( new SymfonyStyle($input, $output) )->error($e->getMessage());

            return Command::FAILURE;
        }

        ( new SymfonyStyle($input, $output) )->success('All files have been written.');

        return Command::SUCCESS;
    }

    protected function configure(): void
    {
        $this
            ->addOption('source', 's', InputArgument::OPTIONAL, 'Yaml source from file or url', __DIR__.'/../../doc/openapi.yaml')
            ->addOption('destination', null, InputArgument::OPTIONAL, 'Destination for the generated files', __DIR__.'/../../src/');
    }
}
