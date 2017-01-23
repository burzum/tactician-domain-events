<?php

namespace BornFree\TacticianDomainEvent\EventDispatcher;


class EventDispatcher implements EventDispatcherInterface
{
    /**
     * @var callable[][]
     */
    private $listeners = [];

    /**
     * @inheritdoc
     */
    public function dispatch($event)
    {
        $name = $event instanceof NamedEvent ? $event->getName() : get_class($event);

        foreach ($this->getListeners($name) as $listener) {
            $listener($event);
        }
    }

    /**
     * @param string $eventName
     * @param callable $listener
     */
    public function addListener($eventName, callable $listener)
    {
        $this->listeners[$eventName][] = $listener;
    }

    /**
     * @param string $eventName
     * @return callable[]
     */
    public function getListeners($eventName)
    {
        if (! $this->hasListeners($eventName)) {
            return [];
        }

        return $this->listeners[$eventName];
    }

    /**
     * @param string $eventName
     * @return bool
     */
    public function hasListeners($eventName)
    {
        return isset($this->listeners[$eventName]);
    }
}