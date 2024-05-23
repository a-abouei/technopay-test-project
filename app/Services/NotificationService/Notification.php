<?php

namespace App\Services\NotificationService;

use App\Services\NotificationService\Providers\EmailProvider;
use App\Services\NotificationService\Providers\SmsProvider;

class Notification
{

    /**
     * @return SmsProvider
     */
    public static function sms()
    {
        return resolve(SmsProvider::class);
    }

    public static function email()
    {
        return resolve(EmailProvider::class);
    }

}
