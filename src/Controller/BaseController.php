<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class BaseController extends AbstractController
{
    protected function renderResponse(string $view, array $parameters = [], Response $response = null): Response
    {
        $request = $this->get('request_stack')->getCurrentRequest();
        $format = $request->get('_format');
        $accept = $request->headers->get('accept');

        if ($format === 'json' || strpos($accept, 'application/json') !== false)
        {
            return $this->json($parameters);
        }
        elseif ($format === 'csv')
        {
            return $this->csv($parameters, $request->get('path'));
        }

        return $this->render($view, $parameters, $response);
    }

    protected function csv($data, $filename = 'export.csv') 
    {
        $serializer = $this->get('serializer');

        $data = $serializer->serialize($data, 'csv');

        $response = new Response();
        $response->setContent($data);
        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', 'attachment; filename="' . $filename . '"');

        return $response;
    }
}
