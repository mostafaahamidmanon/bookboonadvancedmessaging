<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Tests\Item\Controller;

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
     * Tests if index() in controller is returning 200 response
     * 
     * @covers App\Item\Controller\IndexController::index
     */
    public function testIfListItemsResponseCodeIs200() 
    {
        parent::$client->request('GET', '/');

        $this->assertEquals(
                Response::HTTP_OK,
                parent::$client->getResponse()->getStatusCode()
        );
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

        $this->assertEquals(
                    Response::HTTP_OK, 
                    parent::$client->getResponse()->getStatusCode()
                );
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
