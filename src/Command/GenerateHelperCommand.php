<?php


namespace Dylan\Generator\Command;


use Dylan\Generator\Generator\Factory;
use Dylan\Generator\Generator\HelperGenerator;
use Dylan\Generator\Model\ModuleFactory;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Filesystem;

class GenerateHelperCommand extends Command
{

    private $moduleFactory;

    private $generatorFactory;

    public function __construct(
        ModuleFactory $moduleFactory,
        Factory $generatorFactory
    )
    {
        $this->moduleFactory = $moduleFactory;
        $this->generatorFactory = $generatorFactory;
        parent::__construct();
    }

    public function configure()
    {
        $options = [
            new InputArgument(
                'module',
                InputArgument::REQUIRED,
                'Module name'
            ),
            new InputArgument(
                'class',
                InputArgument::REQUIRED,
                'Helper class name'
            )
        ];
        $this->setName('generator:helper')
            ->setDescription('Generate Magento Helper Class')
            ->setDefinition($options);
        parent::configure();
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $returnValue = \Magento\Framework\Console\Cli::RETURN_SUCCESS;
        $moduleName = $input->getArgument('module');
        $className = $input->getArgument('class');

        $module = $this->moduleFactory->get($moduleName);
        $fileSystem = new Filesystem();
        $fileSystem->mkdir($module->getPath().'/Helper');

        $parameters = array(
            'module_namespace' => $module->getNamespace(),
            'class_name' => $className
        );
        
        $generator = $this->generatorFactory->get('helper');
        $generator->generate($module, $parameters);
        
        return $returnValue;
    }
}