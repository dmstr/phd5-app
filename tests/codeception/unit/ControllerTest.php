<?php

class ControllerTest extends \Codeception\Test\Unit
{
    /**
     * @group mandatory
     */
    public function testApp()
    {

        $this->assertNotNull(Yii::$app);
    }

    public function testController()
    {
        $this->assertNotFalse(Yii::$app->createController('site/index'));
    }
}
