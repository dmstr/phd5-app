<?php


/**
 * Inherited Methods
 * @method void wantToTest($text)
 * @method void wantTo($text)
 * @method void execute($callable)
 * @method void expectTo($prediction)
 * @method void expect($prediction)
 * @method void amGoingTo($argumentation)
 * @method void am($role)
 * @method void lookForwardTo($achieveValue)
 * @method void comment($description)
 * @method \Codeception\Lib\Friend haveFriend($name, $actorClass = NULL)
 *
 * @SuppressWarnings(PHPMD)
*/
class E2eTester extends \Codeception\Actor
{
    use _generated\E2eTesterActions;

    /**
     * Login with username and password
     * @param $username
     * @param $password
     */
    public function login($username, $password, $waitForReload = true){
        $this->amOnPage('/user/security/login');
        $this->waitForElementVisible('#LoginForm');
        $this->fillField('input[name="LoginForm[login]"]', $username);
        $this->fillField('input[name="LoginForm[password]"]', $password);
        $this->click('#LoginForm button');
        if ($waitForReload) {
            $this->waitForElementNotVisible('#LoginForm', 30);
            // workaround for failing login, probably caused by "smart-wait", see also https://github.com/Codeception/Codeception/pull/4389/files
            $this->wait(0.1);
        }
    }

    public function dontSeeHorizontalScrollbars(){
        $this->assertFalse(
            $this->executeJS("return document.getElementsByTagName(\"html\")[0].scrollWidth > document.getElementsByTagName(\"html\")[0].clientWidth"),
            'Horizontal scrollbar'
        );
    }

    public function pauseExecution()
    {
        return $this->pause();
    }
}
