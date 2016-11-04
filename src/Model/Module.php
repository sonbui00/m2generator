<?php


namespace Dylan\Generator\Model;


use Dylan\Generator\Api\ModuleInterface;
use Magento\Framework\Component\ComponentRegistrarInterface;

class Module implements ModuleInterface
{
    private $name;

    private $componentRegistrar;

    public function __construct(
        ComponentRegistrarInterface $componentRegistrar,
        $name
    )
    {
        $this->componentRegistrar = $componentRegistrar;
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->componentRegistrar->getPath(
            \Magento\Framework\Component\ComponentRegistrar::MODULE,
            $this->getName()
        );
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
}