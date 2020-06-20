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

            $impl = implode('-', (array) reset($resObj)->correlation_id->fields);

            $url = '/' . $this->strReplaceN('-', '', $impl, 4);

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
            $msg = $this->message->append(json_encode([
                'itemName' => $this->faker->firstName,
                'itemDetails' => $this->faker->sentence(3)
            ]));
            
            $url = 'https://localhost:8000/';
            
            $request = new \http\Client\Request('POST', $url, $this->headers);
            
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
            $msg = $this->message->append(json_encode([
                'itemName' => $this->faker->firstName,
                'itemDetails' => $this->faker->sentence(3)
            ]));
            
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

            $impl = implode('-', (array) reset($resObj)->correlation_id->fields);

            $url = 'https://localhost:8000/' . $this->strReplaceN('-', '', $impl, 4);
            
            return $url;
        }

        /**
         * 
         * Replaces N occurrence of a string
         * 
         * @param string $search
         * @param string $replace
         * @param string $subject
         * @param int $occurrence
         * @return string
         */
        private function strReplaceN(string $search, string $replace, string $subject, int $occurrence): string
        {
            $search = preg_quote($search);

            return preg_replace("/^((?:(?:.*?$search){" . --$occurrence . "}.*?))$search/i", "$1$replace", $subject);
        }

    }
}
