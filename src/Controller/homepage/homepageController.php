<?php
namespace App\Controller\homepage;
use App\Controller\template\templateController;
use Symfony\Component\HttpFoundation\Response;
use Elasticsearch\ClientBuilder;

class homepageController{
    // private $templating;
    public function __construct(templateController $templating)
    {
      $this->templating = $templating;
    }
    public function homepage(){
        $hosts = [
            'https://search-gursi-testing-ggw5oktby6nt2gv6kkwy4hnshu.ap-south-1.es.amazonaws.com:443' // Different credentials on different host
        ];
        
        $client = ClientBuilder::create()
                            ->setHosts($hosts)
                            ->build();
        // print_r($client->indices());die;
        $params = [
            'index' => 'new_test_index',
            // 'id'    => '1',
            // 'body'  => ['brand' => 'iphone', 'model' => '']
        ];
        
        // $response = $client->In;
        // print_r($client->indices()->create($params));
        return $this->templating->showTemplate('homepage.html.twig',["testdata" => "success"]);
    }
}
?>
