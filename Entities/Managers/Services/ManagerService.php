<?php

declare(strict_types=1);

namespace app\Entities\Managers\Services;

use app\Entities\Managers\Entities\Managers;
use app\Entities\Managers\Forms\CreateForm;
use app\Entities\Managers\Repositories\ManagerRepository;

class ManagerService
{
    private ManagerRepository $repository;

    public function __construct(ManagerRepository $repository) {

        $this->repository = $repository;
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
}