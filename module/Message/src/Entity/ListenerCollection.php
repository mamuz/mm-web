<?php

namespace Message\Entity;

class ListenerCollection extends \SplObjectStorage
{
    /** @var Listener[] */
    private $index = array();

    /**
     * {@inheritdoc}
     * @param Listener $object
     */
    public function attach($object, $data = null)
    {
        if ($object instanceof Listener
            && !$this->hasIndexFor($object)
        ) {
            $this->appendIndexFor($object);
            parent::attach($object, $data);
        }
    }

    /**
     * @param Listener[] $objects
     * @return void
     */
    public function attachAll(array $objects)
    {
        foreach ($objects as $object) {
            $this->attach($object);
        }
    }

    /**
     * @param Listener $listener
     * @return bool
     */
    private function hasIndexFor(Listener $listener)
    {
        return $this->has($listener->getId(), $this->index);
    }

    /**
     * @param string $index
     * @return bool
     */
    private function has($index)
    {
        return array_key_exists($index, $this->index);
    }

    /**
     * @param Listener $listener
     * @return void
     */
    private function appendIndexFor(Listener $listener)
    {
        $this->index[$listener->getId()] = $listener;
    }

    /**
     * @param $index
     * @return Listener|null
     */
    public function get($index)
    {
        if ($this->has($index)
            && $this->contains($this->index[$index])
        ) {
            return $this->index[$index];
        }

        return null;
    }
}
