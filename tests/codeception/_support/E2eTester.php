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
    * Define custom actions here
    */
    public function login($username, $password){
        $this->amOnPage('/user/security/login');
        $this->fillField('input[name="LoginForm[login]"]', $username);
        $this->fillField('input[name="LoginForm[password]"]', $password);
        $this->click('#LoginForm button');
        $this->waitForElementNotVisible('#LoginForm', 10);
    }

    public function dontSeeHorizontalScrollbars(){
        $this->assertFalse(
            $this->executeJS("return document.getElementsByTagName(\"html\")[0].scrollWidth > document.getElementsByTagName(\"html\")[0].clientWidth"),
            'Horizontal scrollbar'
        );
    }
}
