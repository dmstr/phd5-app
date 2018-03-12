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
class FunctionalTester extends \Codeception\Actor
{
    use _generated\FunctionalTesterActions;

   /**
    * Define custom actions here
    */
    public function login($username, $password){
        $this->amOnPage('/user/security/login');
        $this->fillField('input[name="login-form[login]"]', $username);
        $this->fillField('input[name="login-form[password]"]', $password);
        $this->click('#login-form button');
    }
}
