<?php

class ControllerTest extends \PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
    }

    protected function tearDown()
    {
    }

    /**
     * @group mandatory
     */
    public function testApp()
    {
        Yii::$app;
    }
}
