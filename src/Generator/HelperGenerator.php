<?php

namespace Dylan\Generator\Generator;

use Dylan\Generator\Api\ModuleInterface;

class HelperGenerator extends AbstractGenerator
{

    public function generate(ModuleInterface $module, $parameters)
    {
        $this->renderFile('Helper.php.twig', $module->getPath().'/Helper/'.$parameters['class_name'].'.php', $parameters);
    }
}