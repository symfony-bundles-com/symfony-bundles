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

use App\Entity\Package;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use WowApps\PackagistBundle\Service\ApiProvider;
use WowApps\PackagistBundle\Service\Packagist;

/**
 * Class SymfonyBundlesJobIndexCommand
 *
 * @author Alexey Samara <lion.samara@gmail.com>
 * @package symfony-bundles-com/symfony-bundles
 */
class SymfonyBundlesJobIndexCommand extends Command
{
    /** @var string */
    protected static $defaultName = 'symfony-bundles:packages:index';

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setDescription('Search packages and update information');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        $packagist =  new Packagist(
            new ApiProvider()
        );

        $packages = $packagist->getPackageList(null, 'symfony-bundle');

        $io->listing($packages);

        $io->success('Done');
    }
}
