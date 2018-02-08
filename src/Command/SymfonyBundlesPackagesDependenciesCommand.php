<?php
/**
 * This file is part of the Symfony-Bundles.com project
 * https://github.com/symfony-bundles-com/symfony-bundles
 *
 * (c) 2017 WoW-Apps
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * Class SymfonyBundlesPackagesDependenciesCommand
 * @author Alexey Samara <lion.samara@gmail.com>
 * @package symfony-bundles-com/symfony-bundles
 */
class SymfonyBundlesPackagesDependenciesCommand extends Command
{
    protected static $defaultName = 'symfony-bundles:packages:dependencies';

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setDescription('Download composer.json of all packages and get Symfony versions by dependencies');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);



        $io->success('You have a new command! Now make it your own! Pass --help to see your options.');
    }
}