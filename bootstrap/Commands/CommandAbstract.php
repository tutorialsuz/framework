<?php

namespace Bootstrap\Commands;

abstract class CommandAbstract
{

    public $env;
    /**
     * @var mixed
     */
    private $commands;

    public function __construct()
    {
        $this->commands = commands();
    }

    abstract public function execute();

    public function validateCommand($environmentArgument)
    {
        return array_key_exists($environmentArgument[1], $this->commands);
    }

    protected function hasOption($environmentArgument)
    {
        $difference = array_diff($this->commands[$environmentArgument[1]],
            $this->getOptionValues($environmentArgument));

        return empty($difference);
    }

    protected function getOptionValues($environmentArgument)
    {
        return array_slice($environmentArgument, 2);
    }
}
