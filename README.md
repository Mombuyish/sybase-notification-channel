# Very short description of the package

[![Latest Version on Packagist](https://img.shields.io/packagist/v/yish/sybase-notification-channel.svg?style=flat-square)](https://packagist.org/packages/yish/sybase-notification-channel)
[![Build Status](https://img.shields.io/travis/Mombuyish/sybase-notification-channel/master.svg?style=flat-square)](https://travis-ci.org/Mombuyish/sybase-notification-channel)
[![Total Downloads](https://img.shields.io/packagist/dt/yish/sybase-notification-channel.svg?style=flat-square)](https://packagist.org/packages/yish/sybase-notification-channel)

Sybase 365 notification channel with Laravel.

## Installation

You can install the package via composer:

```bash
composer require yish/sybase-notification-channel
```

## Usage
### Creating notification:

``` bash
$ php artisan make:notification SendMessage
```

### Notify the service and send request
#### Basic

``` php
Notification::route('sybase', $phone)->notify(new \App\Notifications\SendMessage);
```

Or you can construct the properties:
``` php
Notification::route('sybase', $phone)
->notify(new \App\Notifications\SendMessage(
    "Hi, here is yours",
    "this is content."
));
```

Next, navigate to `App\Notifications\SendMessage.php`, set driver:
``` php
use Yish\Notifications\Messages\SybaseMessage;
class SendMessage extends Notification
{
    use Queueable;

    public $subject;

    public $content;

    public function __construct($subject, $content)
    {
        $this->subject = $subject;
        $this->content = $content;
    }

    public function via($notifiable)
    {
        return ['sybase'];
    }
    
    public function toSybase($notifiable)
    {
        return (new SybaseMessage)
                ->subject($this->subject)
                ->content($this->content);
    }
    ....
```

Finally, you must be set service account and password, add a few configuration options to your `config/services.php`
``` php
'sybase' => [
    'account' => env('SYBASE_ACCOUNT'),
    'password' => env('SYBASE_PASSWORD'),
    'endpoint' => env('SYBASE_ENDPOINT'),
],
```

### Advanced
In some cases, you want to customize the recipient or automatically sending: 
``` php
<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Guest extends Authenticatable
{
    use Notifiable; 
    
    public function routeNotificationForSybase($notification)
    {
        return $this->mobile;
    }
}
```

Finally, you can use:
``` php
$guest->notify(new SendMessage('Hello', 'world'));
```

### Security

If you discover any security related issues, please email mombuartworks@gmail.com instead of using the issue tracker.

## Credits

- [Yish](https://github.com/Mombuyish)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
