<?php declare(strict_types=1);

namespace Cspray\Yape\Console\Configuration;

/**
 *
 * @package Cspray\Yape\Console\Configuration
 * @license See LICENSE in source root
 */
final class CreateEnumCommandConfig {

    private $rootDir;
    private $outputDir;

    public function __construct(string $rootDir, string $outputDir) {
        $this->rootDir = $rootDir;
        $this->outputDir = $outputDir;
    }

    public function getRootDir() : string {
        return $this->rootDir;
    }

    public function getDefaultOutputDir() : string {
        return $this->outputDir;
    }

}