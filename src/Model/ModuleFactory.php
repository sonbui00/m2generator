<?php


namespace Dylan\Generator\Model;


use Dylan\Generator\Api\ModuleInterface;
use Magento\Framework\Component\ComponentRegistrarInterface;
use Magento\Framework\ObjectManagerInterface;

class ModuleFactory
{
    private $componentRegistrar;

    /**
     * Object Manager
     *
     * @var \Magento\Framework\ObjectManagerInterface
     */
    protected $objectManager;

    public function __construct(
        ObjectManagerInterface $objectManager,
        ComponentRegistrarInterface $componentRegistrar
    )
    {
        $this->componentRegistrar = $componentRegistrar;
        $this->objectManager = $objectManager;
    }

    /**
     * @param $name
     * @return ModuleInterface
     */
    public function get($name)
    {
        if (!$name) {
            throw new \InvalidArgumentException('Incorrect module name');
        }

        return $this->objectManager->create(Module::class, ['name' => $name]);
    }
}