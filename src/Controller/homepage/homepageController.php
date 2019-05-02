<?php
namespace App\Controller\homepage;
use App\Controller\template\templateController;
use Symfony\Component\HttpFoundation\Response;

class homepageController{
    private $templating;
    public function __construct(templateController $templating)
    {
      $this->templating = $templating;
    }
    public function homepage(){
        return $this->templating->showTemplate('homepage.html.twig',["testdata" => "success"]);
    }
}
?>
