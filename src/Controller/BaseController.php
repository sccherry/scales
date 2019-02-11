<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class BaseController extends AbstractController
{
    public function render(string $view, array $parameters = [], Response $response = null): Response
    {
        $request = $this->get('request_stack')->getCurrentRequest();
        $format = $request->get('_format');
        $accept = $request->headers->get('accept');

        if ($format === 'json' || strpos($accept, 'application/json') !== false)
        {
            return $this->json($parameters);
        }

        return parent::render($view, $parameters, $response);
    }
}
