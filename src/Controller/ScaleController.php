<?php
namespace App\Controller;

use App\Controller\BaseController;
use App\Entity\Scale;

class ScaleController extends BaseController
{
    public function list()
    {
        $scales = [];

        foreach (range(0, 4095) as $id)
        {
            $scales[$id] = new Scale($id);
        }

        $data['scales'] = $scales;

        return $this->renderResponse('scale/list.html.twig', $data);
    }


    public function show(int $id)
    {
        $scale = new Scale($id);

        $data = [
            'scale' => $scale,
        ];

        return $this->renderResponse('scale/show.html.twig', $data);
    }
}
