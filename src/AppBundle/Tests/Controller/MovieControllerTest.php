<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class MovieControllerTest extends WebTestCase
{

    public function testCompleteScenario()
    {
        // Create a new client to browse the application
        $client = static::createClient();

        // Create a new entry in the database
        $crawler = $client->request('GET', '/movie/');
        $this->assertEquals(200, $client->getResponse()->getStatusCode(), "Unexpected HTTP status code for GET /movie/");
        $crawler = $client->click($crawler->selectLink('Create a new entry')->link());

        // Fill in the form and submit it
        $form = $crawler->selectButton('Create')->form(array(
            'movie[name]' => 'La Vida es bella',
            'movie[year]' => 2015
            // ... other fields to fill
        ));

        $client->submit($form);

        //dump($client->getResponse());
        // check the response
       // $this->assertTrue($client->getResponse()->isSuccessful());

        // then check the response content
        //$this->assertEquals(0, $crawler->filter('td:contains("La Vida es bella")')->count(), 'Missing element td:contains("La Vida es bella")');

       // $this->assertTrue($client->getResponse()->isRedirection());

        $crawler = $client->followRedirect();

        // Check data in the show view
        $this->assertGreaterThan(0, $crawler->filter('td:contains("La Vida es bella")')->count(), 'Missing element td:contains("Test")');

        // Edit the entity
        $crawler = $client->click($crawler->selectLink('Edit')->link());

        $form = $crawler->selectButton('Update')->form(array(
            'movie[name]' => 'Foo',
            'movie[year]' => 2017
        ));

        $client->submit($form);
        $crawler = $client->followRedirect();

        // Check the element contains an attribute with value equals "Foo"
        $this->assertGreaterThan(0, $crawler->filter('[value="Foo"]')->count(), 'Missing element [value="Foo"]');
        $this->assertGreaterThan(0, $crawler->filter('[value="2017"]')->count(), 'Missing element [value="2017"]');

        // Delete the entity
        $client->submit($crawler->selectButton('Delete')->form());
        $crawler = $client->followRedirect();

        // Check the entity has been delete on the list
        $this->assertNotRegExp('/Foo/', $client->getResponse()->getContent());
    }


}
