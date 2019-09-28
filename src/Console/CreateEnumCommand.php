<?php declare(strict_types=1);

namespace Cspray\Yape\Console;

use Cspray\Yape\Console\Configuration\CreateEnumCommandConfig;
use Cspray\Yape\Console\InputDefinition\CreateEnumCommandDefinition;
use Cspray\Yape\EnumCodeGenerator;
use Cspray\Yape\EnumDefinition;
use Cspray\Yape\EnumDefinitionFactory;
use Cspray\Yape\Exception\EnumValidationException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 *
 * @package Cspray\Yape\Console
 * @license See LICENSE in source root
 */
final class CreateEnumCommand extends Command {

    protected static $defaultName = 'create-enum';

    private $codeGenerator;
    private $enumDefinitionFactory;
    private $config;

    public function __construct(
        EnumCodeGenerator $codeGenerator,
        EnumDefinitionFactory $enumDefinitionFactory,
        CreateEnumCommandConfig $config
    ) {
        parent::__construct();
        $this->codeGenerator = $codeGenerator;
        $this->enumDefinitionFactory = $enumDefinitionFactory;
        $this->config = $config;
    }

    protected function configure() {
        $this->setDescription('A PHP7+ code generator for creating type-safe, object-backed enums.')
            ->setHelp($this->getHelpText())
            ->setDefinition(new CreateEnumCommandDefinition());
    }

    private function getHelpText() : string {
        return <<<CONSOLE
The enumClass should be a fully qualified class name which MUST have at least 1 namespace part. Simply providing only a 
class name will result in an invalid Enum definition and an error.

There MUST be at least 1 entry in enumValues that will correspond to a static method on the generated class to retrieve 
that enum value. 
CONSOLE;

    }

    protected function execute(InputInterface $input, OutputInterface $output) : int {
        $cli = new SymfonyStyle($input, $output);

        try {
            if ($input->getOption('dry-run') && !is_null($input->getOption('output-dir'))) {
                $cli->error('You must not use the output-dir and dry-run options together.');
                return StatusCodes::INPUT_OPTIONS_CONFLICT_ERROR;
            }

            $enumDef = $this->enumDefinitionFactory->fromConsole($input);
            if ($input->getOption('dry-run')) {
                return $this->handleDryRun($cli, $enumDef);
            } else {
                return $this->handleRealRun($cli, $enumDef, $input);
            }
        } catch (EnumValidationException $enumValidationException) {
            return $this->handleValidationException($cli, $enumValidationException);
        }
    }

    private function handleDryRun(SymfonyStyle $cli, EnumDefinition $enumDefinition) : int {
        $cli->writeln('Your generated enum code:');
        $cli->newLine();
        $cli->writeln($this->codeGenerator->generate($enumDefinition));
        return StatusCodes::OK;
    }

    private function handleRealRun(SymfonyStyle $cli, EnumDefinition $enumDefinition, InputInterface $input) : int {
        $filePath = $this->getOutputPath($enumDefinition, $input);
        if (file_exists($filePath)) {
            $cli->writeln('There was an error creating your enum:');
            $cli->newLine();
            $cli->error(sprintf('- The enum specified, "%s", already exists at %s', $enumDefinition->getNamespace() . '\\' . $enumDefinition->getEnumName(), $filePath));
            return StatusCodes::ENUM_EXISTS_ERROR;
        }
        file_put_contents($filePath, $this->codeGenerator->generate($enumDefinition));
        $cli->writeln('Your enum was stored at ' . $filePath);
        return StatusCodes::OK;
    }

    private function handleValidationException(SymfonyStyle $cli, EnumValidationException $enumValidationException) : int {
        $cli->writeln('There was an error validating the enum provided. Please fix the following errors and try again:');
        $cli->newLine();

        $errorMessages = $enumValidationException->getValidationResults()->getErrorMessages();
        $cli->error(array_map(function($errMsg) { return "- {$errMsg}"; }, $errorMessages));
        return StatusCodes::ENUM_INVALID_ERROR;
    }

    private function getOutputPath(EnumDefinition $enumDefinition, InputInterface $input) : string {
        $outputDir = $input->getOption('output-dir') ?? $this->config->getDefaultOutputDir();
        return sprintf(
            '%s/%s/%s.php',
            $this->config->getRootDir(),
            $outputDir,
            $enumDefinition->getEnumName()
        );
    }

}