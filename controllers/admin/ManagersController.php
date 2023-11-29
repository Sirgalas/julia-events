<?php

namespace app\controllers\admin;

use app\Entities\Managers\Entities\Managers;
use app\Entities\Managers\Forms\CreateForm;
use app\Entities\Managers\Forms\EventsForm;
use app\Entities\Managers\Forms\ManagerSearch;
use app\Entities\Managers\Services\ManagerService;
use Symfony\Component\DomCrawler\Form;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ManagersController implements the CRUD actions for Managers model.
 */
class ManagersController extends Controller
{
    public $layout = 'admin';

    private ManagerService $service;

    public function __construct($id,  $module, ManagerService $service,$config = [])
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
        $searchModel = new ManagerSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'data' => ArrayHelper::map($this->service->eventRepository->findAllByCriteria(),'id','name')
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
        try{
            if ($this->request->isPost) {
                if ($form->load($this->request->post()) && $form->validate()) {
                    $manager = $this->service->create($form);
                    return $this->redirect(['view', 'id' => $manager->id]);
                }
            }
        }catch (BadRequestHttpException $e) {
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
            return $this->render('update', [
                'model' => $model,
            ]);
        } catch (NotFoundHttpException  $e) {
            \Yii::error($e->getMessage());
            $form->addError($e->getMessage());
            return $this->redirect('index');
        }

        return $this->render('update', [
            'model' => $form,
        ]);
    }

    public function actionEvents(int $id) {

        $manager = $this->service->repository->one($id);
        $form = new EventsForm();
        $dataProvider = new ActiveDataProvider([
            'query' => $manager->getEvents(),
        ]);

        try{
            if($this->request->isPost && $form->load($this->request->post()) && $form->validate()) {
                $this->service->addEvent($manager,$form);
            }
        }catch (NotFoundHttpException $e) {
            \Yii::error($e->getMessage());
            $form->addError('Событие не найдено');
            return $this->redirect('index');
        } catch (BadRequestHttpException $e) {
            \Yii::error($e->getMessage());
            $form->addError($e->getMessage());
        }

        return $this->render('events',[
            'dataProvider' => $dataProvider,
            'model' => $form,
            'data' => ArrayHelper::map($this->service->eventRepository->findAllByUnique($manager),'id','name')
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
