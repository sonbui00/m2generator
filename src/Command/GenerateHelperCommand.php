<?php


namespace Dylan\Generator\Command;


use Dylan\Generator\Model\ModuleFactory;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\StringInput;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Filesystem;

class GenerateHelperCommand extends Command
{

    private $moduleFactory;

    public function __construct(ModuleFactory $moduleFactory)
    {
        $this->moduleFactory = $moduleFactory;
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
        $class = $input->getArgument('class');
        $output->writeln($moduleName);
        $output->writeln($class);

        $module = $this->moduleFactory->get($moduleName);
        $fileSystem = new Filesystem();
        $fileSystem->mkdir($module->getPath().'/Helper');

        $parameters = array(
            'module_namespace' => $moduleName,
            'class_name' => $class
        );

        $this->renderFile('Helper.php.twig', $module->getPath().'/Helper/'.$class.'.php', $parameters);
        
        return $returnValue;
    }

    protected function renderFile($template, $target, $parameters)
    {
        if (!is_dir(dirname($target))) {
            mkdir(dirname($target), 0777, true);
        }

        return file_put_contents($target, $this->render($template, $parameters));
    }

    protected function render($template, $parameters)
    {
        $twig = $this->getTwigEnvironment();

        return $twig->render($template, $parameters);
    }

    protected function getTwigEnvironment()
    {
        return new \Twig_Environment(new \Twig_Loader_Filesystem(__DIR__.'/../Skeleton/'), array(
            'debug' => true,
            'cache' => false,
            'strict_variables' => true,
            'autoescape' => false,
        ));
    }
}