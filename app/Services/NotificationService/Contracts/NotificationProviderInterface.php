<?php

namespace App\Services\NotificationService\Contracts;

interface NotificationProviderInterface
{

    /**
     * @param array $receivers
     * @return void
     */
    public function receivers(array $receivers): self;

    /**
     * @param string $message
     * @return void
     */
    public function messageByText(string $message): self;

    /**
     * @param string $template
     * @param array $params
     * @return void
     */
    public function messageByTemplate(string $template, array $params = []): self;


    /**
     * @return bool
     */
    public function send(): bool;

}
