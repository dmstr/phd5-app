<?php

use Codeception\Test\Unit;

/**
 * @group mandatory
 */
class ControllerTest extends Unit
{

    public function testApp()
    {
        $this->assertNotNull(Yii::$app);
    }

    public function testController()
    {
        $this->assertNotFalse(Yii::$app->createController('site/index'));
    }
}
