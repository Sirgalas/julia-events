<?php

namespace app\controllers;

use app\Entities\Events\Entities\Events;
use app\Entities\Events\Forms\ManagerForm;
use app\Entities\Events\Services\EventService;
use app\Entities\Events\Forms\CreateForm;
use app\Entities\Events\Forms\EventSearch;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class EventsController extends Controller
{
    private EventService $service;

    public function __construct($id,  $module, EventService $service,$config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
    }

    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::class,
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    public function actionIndex()
    {
        $searchModel = new EventSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'data' => ArrayHelper::map($this->service->managerRepository->findAllByCriteria(),'id','name')
        ]);
    }


}
