<?php

declare(strict_types=1);

namespace app\Entities\Managers\Services;

use app\Entities\Events\Entities\Events;
use app\Entities\Events\Repositories\EventRepository;
use app\Entities\Managers\Entities\Managers;
use app\Entities\Managers\Forms\CreateForm;
use app\Entities\Managers\Forms\EventsForm;
use app\Entities\Managers\Repositories\ManagerEventsRepository;
use app\Entities\Managers\Repositories\ManagerRepository;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;

class ManagerService
{
    public ManagerRepository $repository;
    public EventRepository $eventRepository;
    private ManagerEventsRepository $managerEventsRepository;

    public function __construct(
        ManagerRepository $repository,
        EventRepository $eventRepository,
        ManagerEventsRepository $managerEventsRepository
    ) {

        $this->repository = $repository;
        $this->eventRepository = $eventRepository;
        $this->managerEventsRepository = $managerEventsRepository;
    }


    public function create(CreateForm $form): Managers
    {
        $events = Managers::create($form);
        return $this->repository->save($events);
    }

    public function update(Managers $event, CreateForm $form): void
    {
        $event->edit($form);
        $this->repository->save($event);
    }

    public function addEvent(Managers $model, EventsForm $form) {
        if($this->managerEventsRepository->uniqueFind($form->event_id,$model->id)) {
            throw new BadRequestHttpException('Указаный организатор уже добавлен к соббытию');
        }
        $event = $this->eventRepository->one($form->event_id);
        $model->link('events',$event);
    }
}