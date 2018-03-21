<?php

namespace App\Command;

use App\Services\Jobs\Packages;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class SymfonyBundlesJobPackagesCommand extends Command
{
    /** @var string */
    protected static $defaultName = 'symfony-bundles:job:packages';

    /** @var  */
    private $job;

    /**
     * SymfonyBundlesJobPackagesCommand constructor.
     * @param null|string $name
     * @param Packages $job
     */
    public function __construct(?string $name = null, Packages $job)
    {
        parent::__construct($name);
        $this->job = $job;
    }

    /**
     * @return void
     */
    protected function configure()
    {
        $this->setDescription('Get mostly full information from Packagist');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->job->execute();
    }
}
