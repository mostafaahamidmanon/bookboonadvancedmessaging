<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Tests\Item\Controller {

    use App\Tests\Infrastructure\AbstractTestCase;
    use Symfony\Component\HttpFoundation\Response;

    /**
     * Description of IndexControllerTest
     * 
     * @covers App\Item\Controller\IndexController
     *
     * @author mosta <info@manonworld.de>
     */
    class IndexControllerTest extends AbstractTestCase {
        
        /**
         *
         * @var array $headers
         */
        private $headers = [
                'Content-Type' => 'application/json'
            ];
        
        /**
         *
         * @var string $baseUrl
         */
        private string $baseUrl = 'https://localhost:8000/';

        /**
         * Tests if index() in controller is returning 200 response
         * 
         * @covers App\Item\Controller\IndexController::index
         */
        public function testIfListItemsResponseCodeIs200() 
        {
            parent::$client->request('GET', '/');

            $this->assertEquals(Response::HTTP_OK, parent::$client->getResponse()->getStatusCode());
        }

        /**
         * Tests if find() in controller is returning 200 response
         * 
         * @covers App\Item\Controller\IndexController::find
         */
        public function testIfFindItemResponseCodeIs200() 
        {
            parent::$client->request('GET', '/');

            $res = parent::$client->getResponse()->getContent();

            $resObj = json_decode($res);
            
            $url = '/' . reset($resObj->details)->correlation_id;

            parent::$client->request('GET', $url);

            $this->assertEquals(Response::HTTP_OK, parent::$client->getResponse()->getStatusCode());
        }

        /**
         * Tests if create() in controller is returning 201 response
         * 
         * @covers App\Item\Controller\IndexController::create
         */
        public function testIfCreateItemResponseCodeIs201()
        {
            $msg = $this->getFakeMessage();
            
            $request = new \http\Client\Request('POST', $this->baseUrl, $this->headers);
            
            $request->setBody($msg);
            
            parent::$peclClient->enqueue($request)->send();
            
            $response = parent::$peclClient->getResponse();
            
            $this->assertEquals(Response::HTTP_CREATED, $response->getResponseCode());
        }
        
        /**
         * Tests if update() in controller is returning 202 response
         * 
         * @covers App\Item\Controller\IndexController::update
         */
        public function testIfUpdateItemResponseCodeIs202()
        {
            $msg = $this->getFakeMessage();
            
            $url = $this->getUrlOfOneItem();

            $request = new \http\Client\Request('PUT', $url, $this->headers);
            
            $request->setBody($msg);
            
            parent::$peclClient->enqueue($request)->send();
            
            $response = parent::$peclClient->getResponse();
            
            $this->assertEquals(Response::HTTP_ACCEPTED, $response->getResponseCode());
        }
        
        /**
         * Tests if delete() in controller is returning 204 response
         * 
         * @covers App\Item\Controller\IndexController::delete
         */
        public function testIfDeleteItemReponseCodeIs204()
        {
            $url = $this->getUrlOfOneItem();
            
            parent::$client->request('DELETE', $url);
            
            $code = $res = parent::$client->getResponse()->getStatusCode();
            
            $this->assertEquals(Response::HTTP_NO_CONTENT, $code);
        }
        
        /**
         * Sends a list items request and gets a URL of one item
         */
        private function getUrlOfOneItem()
        {
            parent::$client->request('GET', '/');

            $res = parent::$client->getResponse()->getContent();

            $resObj = json_decode($res);

            $url = $this->baseUrl . reset($resObj->details)->correlation_id;
            
            return $url;
        }
        
        /**
         * 
         * Prepares a fake message
         * 
         * @return \http\Message\Body
         */
        private function getFakeMessage(): \http\Message\Body
        {
            return $this->message->append(json_encode([
                'itemName' => $this->faker->firstName,
                'itemDetails' => $this->faker->sentence(3)
            ]));
        }

    }
}
