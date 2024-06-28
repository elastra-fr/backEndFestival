<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserTest extends WebTestCase
{
 

/**
 * Tester la redirection vers le front-end en cas d'accès refusé
 *
 * @return void
 */
   public function testAccessDeniedRedirectsToHome()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/access-denied');

        $this->assertResponseRedirects('https://www.nationsound2024-festival.fr/home');
    }


}
