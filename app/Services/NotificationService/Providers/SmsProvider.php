<?php

namespace App\Services\NotificationService\Providers;

use App\Services\NotificationService\Contracts\NotificationProviderInterface;

class SmsProvider implements NotificationProviderInterface
{

    /**
     * @var array $receivers
     */
    private array $receivers = [];

    /**
     * @var string
     */
    private string $message;

    /**
     * @var string
     */
    private string $template;

    /**
     * @var array
     */
    private array $params = [];

    /**
     * @param array $receivers
     * @return NotificationProviderInterface
     */
    public function receivers(array $receivers): NotificationProviderInterface
    {
        $this->receivers = $receivers;

        return $this;
    }

    /**
     * @param string $message
     * @return NotificationProviderInterface
     */
    public function messageByText(string $message): NotificationProviderInterface
    {
        $this->message = $message;

        return $this;
    }

    /**
     * @param string $template
     * @param array $params
     * @return NotificationProviderInterface
     */
    public function messageByTemplate(string $template, array $params = []): NotificationProviderInterface
    {
        $this->template = $template;
        $this->params = $params;

        return $this;
    }

    /**
     * @return bool
     */
    public function send(): bool
    {
        if (empty($this->receivers)) {
            $this->receivers = [env('SYSTEM_ADMIN_MOBILE')];
        }
    }

}
