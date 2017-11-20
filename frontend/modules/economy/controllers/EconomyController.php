<?php

namespace app\modules\economy\controllers;

use yii\web\Controller;

/**
 * Default controller for the `economy` module
 */
class EconomyController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
}
