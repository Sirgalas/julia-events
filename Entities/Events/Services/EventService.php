<?php

declare(strict_types=1);

namespace app\Entities\Events\Services;

use app\Entities\Events\Entities\Events;
use app\Entities\Events\Forms\CreateForm;
use app\Entities\Events\Repositories\EventRepository;

class EventService
{
    public EventRepository $repository;

    public function __construct(EventRepository $repository)
    {

        $this->repository = $repository;
    }

    public function create(CreateForm $form): Events
    {
        $events = Events::create($form);
        return $this->repository->save($events);
    }

    public function update(Events $event, CreateForm $form): void
    {
        $event->edit($form);
        $this->repository->save($event);
    }
}