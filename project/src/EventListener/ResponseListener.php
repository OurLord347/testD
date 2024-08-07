<?php
namespace App\EventListener;

use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpKernel\Event\RequestEvent;

class ResponseListener
{
    private $startTime;
    private $startMemory;

    public function onKernelRequest(RequestEvent $event)
    {
        $this->startTime = microtime(true);
        $this->startMemory = memory_get_usage();
    }

    public function onKernelResponse(ResponseEvent $event)
    {
        $duration = (microtime(true) - $this->startTime) * 1000; // в миллисекундах
        $memoryUsage = (memory_get_usage() - $this->startMemory) / 1024; // в килобайтах

        $response = $event->getResponse();
        $response->headers->set('X-Debug-Time', (int) $duration);
        $response->headers->set('X-Debug-Memory', (int) $memoryUsage);
    }
}