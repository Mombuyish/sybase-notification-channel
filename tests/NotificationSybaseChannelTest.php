<?php

namespace Yish\SybaseNotificationChannel\Tests;

use GuzzleHttp\Client;
use Illuminate\Notifications\Notifiable;
use Illuminate\Notifications\Notification;
use Orchestra\Testbench\TestCase as TestbenchTestCase;
use Mockery as m;
use Yish\Notifications\Channels\SybaseChannel;
use Yish\Notifications\Messages\SybaseMessage;

class NotificationSybaseChannelTest extends TestbenchTestCase
{
    /**
     * @var Client
     */
    private $guzzleHttp;

    /**
     * @var SybaseChannel
     */
    private $sybaseChannel;

    protected function setUp(): void
    {
        parent::setUp();

        config()->set('services.sybase.account', 'yish');
        config()->set('services.sybase.password', 1234);
        config()->set('services.sybase.endpoint', 'abc.com');

        $this->guzzleHttp = m::mock(Client::class);
        $this->sybaseChannel = new SybaseChannel($this->guzzleHttp, config()->get('services.sybase'));
    }

    protected function tearDown(): void
    {
        m::close();
        parent::tearDown();
    }

    /**
     * @doesNotPerformAssertions
     */
    public function testCorrectFlowSentToSybase()
    {
        $notification = new NotificationSybaseChannelTestNotification;
        $notifiable = new NotificationSybaseChannelTestNotifiable;

        $this->guzzleHttp->shouldReceive('post')->once();

        $this->sybaseChannel->send($notifiable, $notification);
    }

    public function testFilterMobileIncludeZero()
    {
        $result = $this->sybaseChannel->isTaiwanMobile('0912345678');

        $this->assertTrue($result);
    }

    public function testFilterMobileDoNotIncludeZero()
    {
        $result = $this->sybaseChannel->isTaiwanMobile('91234567');

        $this->assertFalse($result);
    }
}

class NotificationSybaseChannelTestNotifiable
{
    use Notifiable;

    public function routeNotificationForSybase()
    {
        return '0912345678';
    }
}

class NotificationSybaseChannelTestNotification extends Notification
{
    public function toSybase($notifiable)
    {
        return (new SybaseMessage)
            ->subject('Come on')
            ->content('Yes, you are come in.');
    }
}
