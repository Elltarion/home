<?php

namespace frontend\tests\functional;

use frontend\tests\FunctionalTester;

class HomeCest
{
    public function checkOpen(FunctionalTester $I)
    {
        $I->amOnPage(\Yii::$app->homeUrl);
        $I->see('My Home');
        $I->seeLink('О');
        $I->click('О');
        $I->see('Главная страница');
    }
}