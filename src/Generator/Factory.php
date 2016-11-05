<?php


namespace Dylan\Generator\Generator;


use Magento\Framework\ObjectManagerInterface;

class Factory
{
    protected $map = [
        'helper' => HelperGenerator::class  
    ];

    /**
     * Object Manager
     *
     * @var \Magento\Framework\ObjectManagerInterface
     */
    protected $objectManager;

    public function __construct(
        ObjectManagerInterface $objectManager
    )
    {
        $this->objectManager = $objectManager;
    }

    /**
     * @param $name
     * @return AbstractGenerator
     */
    public function get($name)
    {
        if (!$name || !isset($this->map[$name])) {
            throw new \InvalidArgumentException('Incorrect class name');
        }

        return $this->objectManager->create($this->map[$name]);
    }
}