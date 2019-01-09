<?php
namespace App\Controller;

use App\Controller\BaseController;

class DefaultController extends BaseController
{
    public function index()
    {
        $data = [
            'routes' => [
                'scales',
            ],
        ];

        return $this->render('index.html.twig', $data);
    }
}
