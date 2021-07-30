<?php
namespace App\Controller\ElasticSearch;
use Elasticsearch\ClientBuilder;

class getClient{
    public function getclient(){
        $hosts = [
            'https://Gursi:DowgAunWub!2@search-testproductsapi-wtdey6t2xvwryeo5fpwgx6lnjq.eu-west-1.es.amazonaws.com:443' // Different credentials on different host
        ];
        
        $client = ClientBuilder::create()
                            ->setHosts($hosts)
                            ->build();
        return $client;
    }
}
?>
