<?php

namespace app\controllers\admin;

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
            'data' => ArrayHelper::map($this->service->managerRepository->findAllByCriteria(),'id','name')
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
                return $this->redirect(['view', 'id' => $model->id]);
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
            'model' => $form,
        ]);
    }

    public function actionManagers($id)
    {
        $event = $this->service->repository->one($id);
        $form = new ManagerForm();
        $dataProvider = new ActiveDataProvider([
            'query' => $event->getManagers(),
        ]);
        try{
            if($this->request->isPost && $form->load($this->request->post()) && $form->validate()) {
                $this->service->addManager($event, $form);
            }
        }catch (NotFoundHttpException $e) {
            \Yii::error($e->getMessage());
            $form->addError('Событие не найдено');
            return $this->redirect('index');
        } catch (BadRequestHttpException $e) {
            \Yii::error($e->getMessage());
            $form->addError($e->getMessage());
        }

        return $this->render('managers',[
            'dataProvider' => $dataProvider,
            'model' => $form,
            'data' => ArrayHelper::map($this->service->managerRepository->findAllByUnique($event),'id','name')
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
