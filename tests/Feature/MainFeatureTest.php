<?php

namespace App\Tests\Feature;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;


class MainFeatureTest extends WebTestCase
{
    /**
     * @test
     */
    public function testIfMainRouteWorks()
    {
        $client = static::createClient();

        $client->request('GET', '/');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    /**
     * @test
     */
    public function testRandomRouteDoesntExist()
    {
        $client = static::createClient();

        $client->request('GET', '/this/is/random/route');

        $this->assertEquals(404, $client->getResponse()->getStatusCode());
    }

    /**
     * @test
     */
    public function testRedirectToLoginWhenAccessingEntryData()
    {
        $client = static::createClient();

        $client->request('GET', '/pbEntry');

        $this->assertResponseRedirects('/login');
    }

    /**
     * @test
     */
    public function testThatMainRouteHasH1()
    {
        $client = static::createClient();

        $client->request('GET', '/');

        $crawler = $client->getCrawler();

        $this->assertGreaterThan(0, $crawler->filter('h1')->count(),
            'There is at least one h1 heading');
    }

    /**
     * @test
     */
    public function testIfLoginRouteWorks()
    {
        $client = static::createClient();

        $client->request('GET', '/login');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    /**
     * @test
     */
    public function testIfShowEntryRouteWorks()
    {
        $client = static::createClient();

        $client->request('GET', '/pbEntry/2');

        $this->assertEquals(302, $client->getResponse()->getStatusCode());
    }

    /**
     * @test
     */
    public function testIfLogoutRouteWorks()
    {
        $client = static::createClient();

        $client->request('GET', '/pbEntry/546');

        $this->assertEquals(302, $client->getResponse()->getStatusCode());
    }
}