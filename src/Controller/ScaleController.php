<?php
namespace App\Controller;

use App\Controller\BaseController;
use App\Entity\Scale;

class ScaleController extends BaseController
{
    public function list()
    {
        $data = [
            'scales' => range(0, 4095),
        ];

        return $this->render('scale/list.html.twig', $data);
    }


    public function show(int $id)
    {
        $scale = new Scale($id);

        $data = [
            'scale' => $scale,
        ];

        return $this->render('scale/show.html.twig', $data);
    }
}
