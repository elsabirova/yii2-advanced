<?php namespace frontend\tests;

use frontend\models\ContactForm;

class HomeWorkTest extends \Codeception\Test\Unit
{
    /**
     * @var \frontend\tests\UnitTester
     */
    protected $tester;
    
    protected function _before()
    {
    }

    protected function _after()
    {
    }

    // tests
    public function testExample()
    {
        $a = true;
        $this->assertTrue($a, 'Did not get expected value');

        $b = 3;
        $this->assertEquals(3, $b, 'Did not get expected value');

        $this->assertLessThan(4, $b, 'Did not get expected value');

        $name = 'Test';
        $email = 'mail@example.com';
        $subject = 'new letter';
        $body = 'message';
        $model = new ContactForm([
             'name' => $name,
             'email' => $email,
             'subject' => $subject,
             'body' => $body,
        ]);
        $this->assertAttributeEquals($name, 'name', $model, 'Did not get expected name');
        $this->assertAttributeEquals($email, 'email', $model, 'Did not get expected email');

        expect('Did not get expected subject', $model->subject)->equals($subject);

        $array = ['first', 'second'];
        $this->assertArrayHasKey(1, $array, 'Array does not have key');
    }
}