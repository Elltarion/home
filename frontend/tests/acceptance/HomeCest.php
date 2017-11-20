<?php
namespace frontend\tests\acceptance;

use frontend\tests\AcceptanceTester;
use yii\helpers\Url;

class HomeCest
{
    public function checkHome(AcceptanceTester $I)
    {
        $I->amOnPage(Url::toRoute('/home/index'));
        $I->see('My Home');

        $I->seeLink('О');
        $I->click('О');
        $I->wait(2); // wait for page to be opened

        $I->see('Главная страница');
    }
}
