<?php
namespace App\Controller\template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
class templateController extends AbstractController{
    public function showtemplate($template,$data=NULL)
    {
        return $this->render($template,$data);
    }
    public function showJsonResponse($data) {
        return $this->json($data);
    }
}
?>
