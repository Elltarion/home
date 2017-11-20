<?php

namespace app\modules\economy\controllers;

use Yii;
use app\modules\economy\models\Products;
use app\modules\economy\models\ProductsSearch;
use app\modules\economy\models\EconomyProductCountRanges;
use app\modules\economy\models\EconomyCountRangeTypes;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ProductsController implements the CRUD actions for Products model.
 */
class ProductsController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Products models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProductsSearch();
        $params = Yii::$app->request->queryParams;
        $params['pageSize'] = 15;
        $dataProvider = $searchModel->search($params);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Products model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Products model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Products();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->product_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Products model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            if(isset(Yii::$app->request->post()['count_ranges'])) {
                foreach(Yii::$app->request->post()['count_ranges'] as $range) {
                    $range['pcr_product'] = $id;
                    $rangeDBObject = EconomyProductCountRanges::find()->andWhere(['=', 'pcr_product', $id])->andWhere(['=', 'pcr_type', $range['pcr_type']])->one();

                    if($rangeDBObject) {
                        $rangeDBObject->pcr_value = $range['pcr_value'];
                        $rangeDBObject->save(false);
                    } else {
                        $modelRange = new EconomyProductCountRanges();
                        $modelRange->load(['EconomyProductCountRanges' => $range]);
                        $modelRange->save();
                    }
                }
            }
            return $this->redirect(['view', 'id' => $model->product_id]);
        } else {
            $countRanges = EconomyProductCountRanges::find()->joinWith('type')->andWhere(['=', 'pcr_product', $id])->orderBy('clt_weight', SORT_ASC)->all();
            $countRangeTypes = EconomyCountRangeTypes::find()->orderBy('clt_weight', SORT_ASC)->all();
            if(!$countRanges) {
                $modelRange = new EconomyProductCountRanges();
                $modelRange->load(['EconomyProductCountRanges' => ['pcr_product' => $id, 'pcr_value' => 0, 'pcr_type' => 1]]);
                $modelRange->save();
                $countRanges = EconomyProductCountRanges::find()->joinWith('type')->andWhere(['=', 'pcr_product', $id])->orderBy('clt_weight', SORT_ASC)->all();
            }

            return $this->render('update', [
                'model' => $model,
                'params' => [
                    'countRanges' => $countRanges,
                    'countRangeTypes' => $countRangeTypes
                ]
            ]);
        }
    }

    /**
     * Deletes an existing Products model.
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
     * Finds the Products model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Products the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Products::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
