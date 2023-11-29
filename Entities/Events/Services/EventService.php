<?php

declare(strict_types=1);

namespace app\Entities\Events\Services;

use app\Entities\Events\Entities\Events;
use app\Entities\Events\Forms\CreateForm;
use app\Entities\Events\Forms\ManagerForm;
use app\Entities\Events\Repositories\EventRepository;
use app\Entities\Managers\Repositories\ManagerEventsRepository;
use app\Entities\Managers\Repositories\ManagerRepository;
use yii\web\BadRequestHttpException;

class EventService
{
    public EventRepository $repository;
    public ManagerRepository $managerRepository;
    private ManagerEventsRepository $managerEventsRepository;

    public function __construct(
        EventRepository $repository,
        ManagerRepository $managerRepository,
        ManagerEventsRepository $managerEventsRepository
    ) {
        $this->repository = $repository;
        $this->managerRepository = $managerRepository;
        $this->managerEventsRepository = $managerEventsRepository;
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

    public function addManager(Events $model, ManagerForm $form) {
        if($this->managerEventsRepository->uniqueFind($model->id,$form->manager_id)) {
            throw new BadRequestHttpException('Указаный организатор уже добавлен к соббытию');
        }
        $manager = $this->managerRepository->one($form->manager_id);
        $model->link('managers',$manager);
    }
}