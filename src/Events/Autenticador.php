<?php

namespace App\Events;

use App\Controller\TokenAuthenticatedController;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAccountStatusException;

class Autenticador implements EventSubscriberInterface
{
    private $token;

    public function onKernelController(ControllerEvent $event)
    {
        $controller = $event->getController();

        if (is_array($controller)) {
            $controller = $controller[0];
        }
        
        if ($controller instanceof TokenAuthenticatedController) {
            $token = str_replace(
                'Bearer ',
                '',
                $this->token
            );

            if (empty($token)) {
                throw new CustomUserMessageAccountStatusException(
                    'Invalid token'
                );
            }

            try {
                $credentials = JWT::decode($token, new Key('minha_chave_secreta', 'HS256'));
            } catch (\Exception $e) {
                $credentials = false;
            }

            if (!is_object($credentials) || (!property_exists($credentials, 'cpf') && !property_exists($credentials, 'cnpj'))) {
                throw new AccessDeniedHttpException('This action needs a valid token!');
            }
        }
    }

    public function autorizacao(RequestEvent $event)
    {
        $request = $event->getRequest();
        $this->token = $request->headers->get('Authorization');
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::CONTROLLER => 'onKernelController',
            RequestEvent::class => 'autorizacao',
        ];
    }
}