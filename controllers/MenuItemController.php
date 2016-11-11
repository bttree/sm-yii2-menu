<?php

namespace bttree\smymenu\controllers;

use bttree\smymenu\models\MenuItemRole;
use Yii;
use bttree\smymenu\models\MenuItem;
use bttree\smymenu\models\MenuItemSearch;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Response;

/**
 * MenuItemController implements the CRUD actions for MenuItem model.
 */
class MenuItemController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow'   => true,
                        'roles'   => ['smymenu.all'],
                    ],
                ],
            ],
            'verbs'  => [
                'class'   => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all MenuItem models.
     * @return mixed
     */
    public function actionIndex()
    {
        $param = Yii::$app->request->post();
        if (isset($_POST['hasEditable']) && $_POST['hasEditable']==1) {

            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            $id = $param['editableKey'];
            $attr = $param['editableAttribute'];
            $model=$this->findModel($id);

            $model->setAttributes(array_shift($param['MenuItem']));
            if ($model->save()) {

                $value = $model->$attr;

                return ['output'=>$value, 'message'=>''];

            } else {
                return ['output'=>'', 'message'=>$model->getErrors()];
            }
        }

        $searchModel = new MenuItemSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single MenuItem model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view',
                             [
                                 'model' => $this->findModel($id),
                             ]);
    }

    /**
     * Creates a new MenuItem model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new MenuItem();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            $this->updateRoles($model->id);

            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create',
                                 [
                                     'model' => $model,
                                 ]);
        }
    }

    /**
     * Updates an existing MenuItem model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $request = Yii::$app->request;
        if($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            $this->updateRoles($model->id);

            if ($request->isAjax) {
                return [
                    'result' => true
                ];
            } else {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            if ($request->isAjax) {
                return [
                    'result' => false,
                    'errors' => $model->getErrors(),
                ];
            } else {
                return $this->render('update',
                                     [
                                         'model' => $model,
                                     ]);
            }
        }
    }

    /**
     * Deletes an existing MenuItem model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the MenuItem model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return MenuItem the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MenuItem::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * @param integer $model_id
     *
     * @return void
     */
    protected function updateRoles($model_id)
    {
        $roles = Yii::$app->request->post('Roles', []);
        $ids   = [];

        foreach ($roles as $role) {
            $menu_item_role = MenuItemRole::findOne(['role_yii' => $role, 'menu_item_id' => $model_id]);
            if(!isset($menu_item_role)) {
                $menu_item_role = new MenuItemRole();
                $menu_item_role->role_yii = $role;
                $menu_item_role->menu_item_id = $model_id;
                if($menu_item_role->save()) {
                    $ids[] = $menu_item_role->id;
                }
            } else {
                $ids[] = $menu_item_role->id;
            }
        }
        
        MenuItemRole::deleteAll(['AND', 'menu_item_id = :model_id', ['NOT IN', 'id', $ids]], [':model_id' => $model_id]);
    }
}
