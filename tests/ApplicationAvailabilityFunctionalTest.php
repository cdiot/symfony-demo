<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class ApplicationAvailabilityFunctionalTest extends WebTestCase
{
    /**
     * @dataProvider publicUrlProvider
     */
    public function testPublicPageIsSuccessful($url)
    {
        $client = self::createClient();
        $client->catchExceptions(false);
        $client->request('GET', $url);

        $this->assertResponseIsSuccessful();
    }

    /**
     * @dataProvider privateUrlProvider
     */
    public function testPrivatePageIsSuccessful($url)
    {
        $client = static::createClient();
        $client->catchExceptions(false);
        $crawler = $client->request('GET', '/connexion');

        $buttonCrawlerNode = $crawler->selectButton('Connexion');
        $form = $buttonCrawlerNode->form();

        $form = $buttonCrawlerNode->form([
            'email' => 'foo@test.com',
            'password' => '123456'
        ]);

        $client->submit($form);

        $crawler = $client->request('GET', $url);
        $this->assertResponseIsSuccessful();
    }

    public function publicUrlProvider()
    {
        yield 'home' => ['/'];
        yield 'app_login' => ['/connexion'];
        yield 'app_register' => ['/inscription'];
    }

    public function privateUrlProvider()
    {
        yield 'account' => ['/compte'];
    }
}
