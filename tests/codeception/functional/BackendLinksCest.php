<?php
/**
 * @group mandatory
 * @group long-running
 */
class BackendLinksCest
{
    public function _before(FunctionalTester $I)
    {
    }

    public function _after(FunctionalTester $I)
    {
    }

    // tests
    public function testBackendLinks(FunctionalTester $I)
    {
        $I->wantTo('Click backend links');

        $I->amGoingTo('start in the backend');
        $I->login('master', 'master1');
        $url = '/backend';
        $I->amOnPage($url);

        $links = $I->grabMultiple('section.content a[href^="/"]', 'href');

        foreach ($links as $i => $url) {

            switch ($url) {
                case '/debug':
                case '/gridview':
                case '/treemanager':
                    continue 2;
                    break;
            }

            $I->amGoingTo('check '.$url);
            $I->amOnPage($url);

            $I->cantSeeElement('.site-error');
            $I->cantSeeElement('.alert-warning .alert');
        }

    }
}
