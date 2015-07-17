<?php

namespace Knapsack;

use Traversable;

class ForEachCollection extends Collection
{
    private $usesKeys;
    private $callback;

    /**
     * @param array|Traversable $input
     * @param callable $callback
     */
    public function __construct($input, callable $callback)
    {
        parent::__construct($input);
        $this->callback = $callback;
        $this->usesKeys = $this->getNumberOfArguments($callback) == 2;
    }

    public function current()
    {
        $this->executeCallback($this->key(), parent::current());

        return parent::current();
    }

    /**
     * @param mixed $key
     * @param mixed $item
     * @return mixed
     */
    private function executeCallback($key, $item)
    {
        $callback = $this->callback;
        if ($this->usesKeys) {
            return $callback($key, $item);
        } else {
            return $callback($item);
        }
    }
}
