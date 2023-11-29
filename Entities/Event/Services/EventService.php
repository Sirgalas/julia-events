<?php

declare(strict_types=1);

namespace app\Entities\Event;

use app\Entities\Event\Entities\Events;
use app\Entities\Event\Forms\CreateForm;
use app\Entities\Event\Forms\UpdateForm;
use app\Entities\Event\Repositories\EventRepository;

class EventService
{
    private EventRepository $repository;

    public function __construct(EventRepository $repository)
    {

        $this->repository = $repository;
    }

    public function create(CreateForm $form): Events
    {
        $events = Events::create($form);
        return $this->repository->save($events);
    }

    public function update(Events $event, UpdateForm $form): void
    {
        $event->edit($form);
        $this->repository->save($event);
    }
}