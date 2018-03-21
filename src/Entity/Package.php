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
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Package
 *
 * @author Alexey Samara <lion.samara@gmail.com>
 * @package symfony-bundles-com/symfony-bundles
 * @ORM\Table(
 *     name="sb_packages",
 *     options={"collate"="utf8_unicode_ci", "charset"="utf8", "engine"="InnoDB"},
 *     indexes={@ORM\Index(name="sb_packages_package_id_uindex", columns={"package_id"})}
 * )
 * @ORM\Entity(repositoryClass="App\Repository\PackageRepository")
 */
class Package
{
    const TABLE_NAME = 'sb_packages';

    /**
     * Package identifier on Packagist.org
     *
     * @var string
     * @ORM\Column(name="package_id", type="string", nullable=false, length=255)
     * @ORM\Id
     */
    private $packageId = '';

    /**
     * Package repository url
     *
     * @var string
     * @ORM\Column(name="repository", type="string", nullable=true, length=255)
     */
    private $repository = '';

    /**
     * @var string
     * @ORM\Column(name="version", type="string", nullable=true, length=25)
     */
    private $version = '';

    /**
     * @var string
     * @ORM\Column(name="title", type="string", nullable=true, length=255)
     */
    private $title = '';

    /**
     * @var string
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description = '';

    /**
     * @var string
     * @ORM\Column(name="description_clean", type="text", nullable=true)
     */
    private $descriptionClean = '';

    /**
     * @var string
     * @ORM\Column(name="author", type="string", nullable=true, length=255)
     */
    private $author = '';

    /**
     * @var string
     * @ORM\Column(name="icon", type="string", nullable=true, length=255)
     */
    private $icon = '';

    /**
     * @var int
     * @ORM\Column(name="stat_installs", type="integer", nullable=true, options={"default":0}, length=11)
     */
    private $statInstalls = 0;

    /**
     * @var int
     * @ORM\Column(name="stat_dependents", type="integer", nullable=true, options={"default":0}, length=11)
     */
    private $statDependents = 0;

    /**
     * @var int
     * @ORM\Column(name="stat_suggesters", type="integer", nullable=true, options={"default":0}, length=11)
     */
    private $statSuggesters = 0;

    /**
     * @var int
     * @ORM\Column(name="stat_stars", type="integer", nullable=true, options={"default":0}, length=11)
     */
    private $statStars = 0;

    /**
     * @var int
     * @ORM\Column(name="stat_watchers", type="integer", nullable=true, options={"default":0}, length=11)
     */
    private $statWatchers = 0;

    /**
     * @var int
     * @ORM\Column(name="stat_forks", type="integer", nullable=true, options={"default":0}, length=11)
     */
    private $statForks = 0;

    /**
     * @var int
     * @ORM\Column(name="stat_issues", type="integer", nullable=true, options={"default":0}, length=11)
     */
    private $statIssues = 0;

    /**
     * @var bool
     * @ORM\Column(name="symfony_1", type="boolean")
     */
    private $symfony1;

    /**
     * @var bool
     * @ORM\Column(name="symfony_2", type="boolean")
     */
    private $symfony2;

    /**
     * @var bool
     * @ORM\Column(name="symfony_3", type="boolean")
     */
    private $symfony3;

    /**
     * @var bool
     * @ORM\Column(name="symfony_4", type="boolean")
     */
    private $symfony4;

    /**
     * @var \DateTime
     * @ORM\Column(name="added_at", type="datetime", nullable=true)
     */
    private $addedAt;

    /**
     * @var \DateTime
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     */
    private $updatedAt;

    public function __construct(string $packageId)
    {
        $this->setPackageId($packageId);
    }

    /**
     * @return string
     */
    public function getPackageId(): string
    {
        return $this->packageId;
    }

    /**
     * @param string $packageId
     * @return Package
     */
    public function setPackageId(string $packageId): Package
    {
        $this->packageId = $packageId;
        return $this;
    }

    /**
     * @return string
     */
    public function getRepository(): string
    {
        return $this->repository;
    }

    /**
     * @param string $repository
     * @return Package
     */
    public function setRepository(string $repository): Package
    {
        $this->repository = $repository;
        return $this;
    }

    /**
     * @return string
     */
    public function getVersion(): string
    {
        return $this->version;
    }

    /**
     * @param string $version
     * @return Package
     */
    public function setVersion(string $version): Package
    {
        $this->version = $version;
        return $this;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return Package
     */
    public function setTitle(string $title): Package
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return Package
     */
    public function setDescription(string $description): Package
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescriptionClean(): string
    {
        return $this->descriptionClean;
    }

    /**
     * @param string $descriptionClean
     * @return Package
     */
    public function setDescriptionClean(string $descriptionClean): Package
    {
        $this->descriptionClean = $descriptionClean;
        return $this;
    }

    /**
     * @return string
     */
    public function getAuthor(): string
    {
        return $this->author;
    }

    /**
     * @param string $author
     * @return Package
     */
    public function setAuthor(string $author): Package
    {
        $this->author = $author;
        return $this;
    }

    /**
     * @return string
     */
    public function getIcon(): string
    {
        return $this->icon;
    }

    /**
     * @param string $icon
     * @return Package
     */
    public function setIcon(string $icon): Package
    {
        $this->icon = $icon;
        return $this;
    }

    /**
     * @return int
     */
    public function getStatInstalls(): int
    {
        return $this->statInstalls;
    }

    /**
     * @param int $statInstalls
     * @return Package
     */
    public function setStatInstalls(int $statInstalls): Package
    {
        $this->statInstalls = $statInstalls;
        return $this;
    }

    /**
     * @return int
     */
    public function getStatDependents(): int
    {
        return $this->statDependents;
    }

    /**
     * @param int $statDependents
     * @return Package
     */
    public function setStatDependents(int $statDependents): Package
    {
        $this->statDependents = $statDependents;
        return $this;
    }

    /**
     * @return int
     */
    public function getStatSuggesters(): int
    {
        return $this->statSuggesters;
    }

    /**
     * @param int $statSuggesters
     * @return Package
     */
    public function setStatSuggesters(int $statSuggesters): Package
    {
        $this->statSuggesters = $statSuggesters;
        return $this;
    }

    /**
     * @return int
     */
    public function getStatStars(): int
    {
        return $this->statStars;
    }

    /**
     * @param int $statStars
     * @return Package
     */
    public function setStatStars(int $statStars): Package
    {
        $this->statStars = $statStars;
        return $this;
    }

    /**
     * @return int
     */
    public function getStatWatchers(): int
    {
        return $this->statWatchers;
    }

    /**
     * @param int $statWatchers
     * @return Package
     */
    public function setStatWatchers(int $statWatchers): Package
    {
        $this->statWatchers = $statWatchers;
        return $this;
    }

    /**
     * @return int
     */
    public function getStatForks(): int
    {
        return $this->statForks;
    }

    /**
     * @param int $statForks
     * @return Package
     */
    public function setStatForks(int $statForks): Package
    {
        $this->statForks = $statForks;
        return $this;
    }

    /**
     * @return int
     */
    public function getStatIssues(): int
    {
        return $this->statIssues;
    }

    /**
     * @param int $statIssues
     * @return Package
     */
    public function setStatIssues(int $statIssues): Package
    {
        $this->statIssues = $statIssues;
        return $this;
    }

    /**
     * @return bool
     */
    public function isSymfony1(): bool
    {
        return $this->symfony1;
    }

    /**
     * @param bool $symfony1
     * @return Package
     */
    public function setSymfony1(bool $symfony1): Package
    {
        $this->symfony1 = $symfony1;
        return $this;
    }

    /**
     * @return bool
     */
    public function isSymfony2(): bool
    {
        return $this->symfony2;
    }

    /**
     * @param bool $symfony2
     * @return Package
     */
    public function setSymfony2(bool $symfony2): Package
    {
        $this->symfony2 = $symfony2;
        return $this;
    }

    /**
     * @return bool
     */
    public function isSymfony3(): bool
    {
        return $this->symfony3;
    }

    /**
     * @param bool $symfony3
     * @return Package
     */
    public function setSymfony3(bool $symfony3): Package
    {
        $this->symfony3 = $symfony3;
        return $this;
    }

    /**
     * @return bool
     */
    public function isSymfony4(): bool
    {
        return $this->symfony4;
    }

    /**
     * @param bool $symfony4
     * @return Package
     */
    public function setSymfony4(bool $symfony4): Package
    {
        $this->symfony4 = $symfony4;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getAddedAt(): \DateTime
    {
        return $this->addedAt ?? new \DateTime();
    }

    /**
     * @param \DateTime $addedAt
     * @return Package
     */
    public function setAddedAt(\DateTime $addedAt): Package
    {
        $this->addedAt = $addedAt;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedAt(): \DateTime
    {
        return $this->updatedAt ?? new \DateTime();
    }

    /**
     * @param \DateTime $updatedAt
     * @return Package
     */
    public function setUpdatedAt(\DateTime $updatedAt): Package
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }
}
