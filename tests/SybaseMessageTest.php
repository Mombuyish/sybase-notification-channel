<?php

namespace Yish\SybaseNotificationChannel\Tests;

use Orchestra\Testbench\TestCase;
use Yish\Notifications\Messages\SybaseMessage;

class SybaseMessageTest extends TestCase
{
    /**
     * @test
     * @group sybase-notification-channel
     */
    public function it_should_be_set_subject()
    {
        $expected = $subject = "Hello, Yish";

        $message = new SybaseMessage();
        $message->subject($subject);

        $this->assertEquals($expected, $message->subject);
    }

    /**
     * @test
     * @group sybase-notification-channel
     */
    public function it_should_be_set_content()
    {
        $expected = $content = "Let it go, let it go
                    Can't hold it back anymore
                    Let it go, let it go
                    Turn away and slam the door
                    I don't care what they're going to say
                    Let the storm rage on
                    The cold never bothered me anyway";

        $message = new SybaseMessage();
        $message->content($content);

        $this->assertEquals($expected, $message->content);
    }

    /**
     * @test
     * @group sybase-notification-channel
     */
    public function it_should_be_get_all()
    {
        $expected = new \stdClass();
        $expected->subject = 'Hello';
        $expected->content = 'My name is Yish';

        $message = new SybaseMessage();
        $message->subject('Hello');
        $message->content('My name is Yish');

        $this->assertEquals($expected->subject, $message->subject);
        $this->assertEquals($expected->content, $message->content);
    }
}
