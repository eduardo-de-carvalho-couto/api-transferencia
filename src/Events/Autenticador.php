<?php

namespace App\Events;

use App\Controller\TokenAuthenticatedController;
use App\Dominio\Usuario\Loja\RepositorioDeLoja;
use App\Infra\RepositoriosComDoctrine\RepositorioDePessoaComDoctrine;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAccountStatusException;

class Autenticador implements EventSubscriberInterface
{
    private $token;

    private $requestId;

    private $repositorioDePessoa;

    private $repositorioDeLoja;

    public function __construct(RepositorioDePessoaComDoctrine $repositorioDePessoa, RepositorioDeLoja $repositorioDeLoja)
    {
        $this->repositorioDePessoa = $repositorioDePessoa;
        $this->repositorioDeLoja = $repositorioDeLoja;
    }

    public function autenticar(ControllerEvent $event)
    {
        $controller = $event->getController();

        $metodoAtualizar = false;
        $metodoRemover = false;

        if (is_array($controller) && in_array('atualizar', $controller)){
            $metodoAtualizar = true;
        }

        if (is_array($controller) && in_array('remove', $controller)){
            $metodoRemover = true;
        }

        if (is_array($controller) && !in_array('novo', $controller)) {
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

            $user = property_exists($credentials, 'cpf') 
                ? $this->getPessoa($credentials->cpf) 
                : $this->getLoja($credentials->cnpj);
            
            if(is_null($user)){
                throw new AccessDeniedException();
            }

            if ($metodoAtualizar == true && $user->getId() != $this->requestId){
                throw new CustomUserMessageAccountStatusException(
                    'Usuario n??o autorizado a atualizar este perfil.'
                );
            }

            if ($metodoRemover == true && $user->getId() != $this->requestId){
                throw new CustomUserMessageAccountStatusException(
                    'Usuario n??o autorizado a remover este perfil.'
                );
            }
        }
    }

    private function getPessoa(string $documento)
    {
        $user = $this->repositorioDePessoa->getRegistro()->findOneBy(['cpf' => $documento]);
        return $user;
    }

    private function getLoja(string $documento)
    {
        $user = $this->repositorioDeLoja->getRegistro()->findOneBy(['cnpj' => $documento]);
        return $user;
    }

    public function onKernelRequest(RequestEvent $event)
    {
        $request = $event->getRequest();
        $this->token = $request->headers->get('Authorization');
        $this->requestId = $request->get('id');
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::CONTROLLER => 'autenticar',
            RequestEvent::class => 'onKernelRequest',
        ];
    }
}