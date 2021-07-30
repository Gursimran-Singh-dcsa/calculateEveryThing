<?php
namespace App\Controller\ElasticSearch;
use App\Controller\template\templateController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Controller\ElasticSearch\getClient;
use Elasticsearch\ClientBuilder;
use Exception;
use Symfony\Component\HttpFoundation\RequestStack;

class ElasticSearch{
    /**
     * @var ClientBuilder
     */
    private $client;

    /**
     * @var TemplateController
     */
    private $templating;

    public function __construct(getClient $client, templateController $templating)
    {
        $this->client = $client->getclient();
        $this->templating = $templating;
    }

    public function create(Request $request)
    {
        $requestAttr = json_decode($request->getContent(), true);

        $params = [
            'index' => $requestAttr['indexname'],
            'body' => [
                'mappings' => [
                    'properties' => [
                        'brandName' => [
                            'type' => 'text'
                        ],
                        'modelName' => [
                            'type' => 'text'
                        ],
                        'specifications' => [
                            'type' => 'nested',
                            'properties' => [
                                'name' => [
                                    'type' => 'keyword'
                                ],
                                'value' => [
                                    'type' => 'text'
                                ]
                            ]
                        ],
                        'ratings' => [
                            'properties' => [
                                'designRating' => [
                                    'type' => 'float'
                                ],
                                'screenRating' => [
                                    'type' => 'float'
                                ],
                                'softwareRating' => [
                                    'type' => 'float'
                                ],
                                'performanceRating' => [
                                    'type' => 'float'
                                ],
                                'autonomyRating' => [
                                    'type' => 'float'
                                ],
                                'cameraRating' => [
                                    'type' => 'float'
                                ],
                                'design_rating' => [
                                    'type' => 'float'
                                ],
                            ]
                        ],
                        'launchDate' => [
                            'type' => 'date',
                        ],
                        'versions' => [
                            'type' => 'nested',
                            'properties' => [
                                'RAM' => [
                                    'type' => 'float'
                                ],
                                'ROM' => [
                                    'type' => 'float'
                                ],
                                'editorProvidedPrice' => [
                                    'type' => 'float'
                                ],
                                'store' => [
                                    'type' => 'nested',
                                    'properties' => [
                                        'name' => [
                                            'type' => 'text',
                                        ],
                                        'link' => [
                                            'type' => 'text',
                                        ],
                                        'uid' => [
                                            'type' => 'text',
                                        ],
                                        'price' => [
                                            'type' => 'text',
                                        ]
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ];
        try {
            $res = $this->client->indices()->create($params);
        } catch (Exception $e) {
            return $this->templating->showJsonResponse($e->getMessage());
        }
        return $this->templating->showJsonResponse($res);
    }

    public function getAll(getClient $client)
    {
        return $this->templating->showJsonResponse($this->client->cat()->indices());
    }

    public function deleteIndex(Request $request)
    {
        $requestAttr = json_decode($request->getContent(), true);
        $params = [
            "index" => $requestAttr['indexname']
        ];
        try {
            $res = $this->client->indices()->delete($params);
        } catch(Exception $e) {
            return $this->templating->showJsonResponse($e->getMessage());
        }
        return $this->templating->showJsonResponse($res);
    }

    public function getDocuments(Request $request)
    {
        // $requestAttr = json_decode($request->getContent(), true);
        $params = [
            "index" => $request->query->get('indexname'),
            "body" => [
                'query' => [
                    'query_string' => [
                        'query'=> '*pro*',
                        'fields'=> ['model', 'brand']
                    ]
                ]
            ]
        ];
        try {
            $res = $this->client->search($params);
        } catch(Exception $e) {
            return $this->templating->showJsonResponse($e->getMessage());
        }
        return $this->templating->showJsonResponse($res);
        // return $this->templating->showJsonResponse($request->query->get('indexname'));
    }
    public function createDocument(Request $request) {
        $requestAttr = json_decode($request->getContent(), true);
        $params = [
            "index" => $requestAttr['indexname'],
            "body" => [
                'brand' => 'mi',
                'model' => 'guri',
                'specifications' => [
                    ['name' => 'spec1', 'value' => 'value1'],
                    ['name' => 'spec2', 'value' => 'value2'],
                ],
                'ratings' => [
                    'designRating' => 8,
                    'screenRating' => 7,
                    'softwareRating' => 9,
                    'performanceRating' => 6,
                    'autonomyRating' => 5,
                    'cameraRating' => 6,
                    'designRating' => 6
                ],
                // 'launchDate' => date('U'),
                'versions' => [
                    [
                        'RAM' => 16,
                        'ROM' => 1,
                        'editorialProvidedPrice' => 20000,
                        'store' => [
                            'name' => 'amazon',
                            'link' => 'https://amazon.es',
                            'uid' => 'youId',
                            'price' => 22000
                        ],
                        'store' => [
                            'name' => 'ebay',
                            'link' => 'https://ebay.es',
                            'uid' => 'ebayyouId',
                            'price' => 19000
                        ]
                    ],
                    [
                        'RAM' => 4,
                        'ROM' => 1,
                        'editorialProvidedPrice' => 17000,
                    ]
                ]
            ]
        ];
        try {
            $res = $this->client->index($params);
        } catch(Exception $e) {
            return $this->templating->showJsonResponse($e->getMessage());
        }
        return $this->templating->showJsonResponse($res);
    }
}
?>
