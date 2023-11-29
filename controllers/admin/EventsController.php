<?php

namespace app\controllers\admin;

use app\Entities\Events\Entities\Events;
use app\Entities\Events\Services\EventService;
use app\Entities\Events\Forms\CreateForm;
use app\Entities\Events\Forms\EventSearch;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class EventsController extends Controller
{
    public $layout = 'admin';
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
        ]);
    }

    public function actionView($id)
    {
        try{
            return $this->render('view', [
                'model' => $this->service->repository->one($id),
            ]);
        }catch (NotFoundHttpException $e) {
            \Yii::error($e->getMessage());
            return $this->redirect('index');
        }
    }

    public function actionCreate()
    {
        $form = new CreateForm();
        try {
            if ($this->request->isPost) {
                if ($form->load($this->request->post()) && $form->validate()) {
                    $event = $this->service->create($form);
                    return $this->redirect(['view', 'id' => $event->id]);
                }
            }
        } catch (BadRequestHttpException $e) {
            \Yii::error($e->getMessage());
            $form->addError('Что то пошло не так обратитесь к администратору');
        }
        return $this->render('create', [
            'model' => $form,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->service->repository->one($id);
        $form = new CreateForm($model);
        try{
            if ($this->request->isPost && $form->load($this->request->post()) && $form->validate()) {
                $this->service->update($model,$form);
            }
        } catch (BadRequestHttpException $e) {
            \Yii::error($e->getMessage());
            $form->addError('Что то пошло не так обратитесь к администратору');
        } catch (NotFoundHttpException $e) {
            \Yii::error($e->getMessage());
            $form->addError('Событие не найдено');
            return $this->redirect('index');
        }
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id)
    {
        try{
            $this->service->repository->remove($id);
        }catch (NotFoundHttpException $e) {
            \Yii::error($e->getMessage());
        }
        return $this->redirect(['index']);
    }

}
