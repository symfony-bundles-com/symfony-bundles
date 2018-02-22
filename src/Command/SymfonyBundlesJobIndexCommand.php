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

use App\Services\PackagistApi;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

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

    /** @var PackagistApi */
    private $packagistApi;

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setDescription('Search packages and update information');
    }

//    /**
//     * SymfonyBundlesJobIndexCommand constructor.
//     * @param null|string $name
//     * @param PackagistApi $packagistApi
//     */
//    public function __construct(?string $name = null, PackagistApi $packagistApi)
//    {
//        parent::__construct($name);
//        $this->packagistApi = $packagistApi;
//    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return void
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        $this->packagistApi->indexPackagesJob();

        $io->success('Done');
    }
}
