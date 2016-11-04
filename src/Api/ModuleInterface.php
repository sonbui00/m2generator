<?php


namespace Dylan\Generator\Api;


interface ModuleInterface
{
    /**
     * @return string
     */
    public function getPath();

    /**
     * @return string
     */
    public function getName();
}