<?php namespace frontend\tests\functional;
use frontend\tests\FunctionalTester;

class HomeWorkCest
{
    public function _before(FunctionalTester $I)
    {
    }
    /**
     * @dataProvider pageProvider
     */
    public function tryToTest(FunctionalTester $I, \Codeception\Example $data)
    {
        $I->amOnPage($data['url']);
        $I->see($data['menu.active'], 'li.active');
    }

    /**
     * @return array
     */
    protected function pageProvider()
    {
        return [
            ['url'=>"/site/index", 'menu.active'=>"Home"],
            ['url'=>"/site/about", 'menu.active'=>"About"],
            ['url'=>"/site/contact", 'menu.active'=>"Contact"],
            ['url'=>"/site/signup", 'menu.active'=>"Signup"],
            ['url'=>"/site/login", 'menu.active'=>"Login"],
        ];
    }
}
