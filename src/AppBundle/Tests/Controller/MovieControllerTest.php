<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class MovieControllerTest extends WebTestCase
{

    public function testCompleteScenario()
    {
        // Create a new client to browse the application
        $client = static::createClient();

        //veo la ruta principal y si carga bien
        $crawler = $client->request('GET', '/');
        //la pagina principal redirecciona al listado
        $this->assertTrue($client->getResponse()->isRedirection());
        //sigo la corriente
        $crawler = $client->followRedirect();
        //que la respuesta este ok
        $this->assertTrue($client->getResponse()->isSuccessful());
        $this->assertEquals(200, $client->getResponse()->getStatusCode(), "Unexpected HTTP status code for GET /");


        // Create a new entry in the database
        $crawler = $client->click($crawler->selectLink('Create a new entry')->link());

        $em = $this->getContainer()->get;

        // Fill in the form and submit it
        $form = $crawler->selectButton('Create')->form(array(
            'movie[name]' => 'Foo',
            'movie[year]' => 2015
            // ... other fields to fill
        ));

        $client->submit($form);

        //que la respuesta este ok
//        $result = $client->getResponse()->isSuccessful();

//        //si la respuesta es succefull es que no redirecciono pero tiene que devolver el error
//        if ($result){
//            //la pagina tiene status 200 pero muestra un error
//            $this->assertEquals(200, $client->getResponse()->getStatusCode(), "Unexpected HTTP status code validation");
//            $newCrawler = $crawler->filter('div')
//                                    ->reduce( function ($node, $i){
//                                        if (!$node->getAttribute('class')) {
//                                            return false;
//                                        }
//                                    })
//                                    ->first();
//            dump($newCrawler);
//            $this->assertGreaterThan(0, $crawler->filter('div')->count(), 'Missing element error');
//
//        }else{
            //el agregar redirecciona al show
            $this->assertTrue($client->getResponse()->isRedirection(), "No esta redireccionando");
            $this->assertEquals(302, $client->getResponse()->getStatusCode(), "Unexpected HTTP status code for redirection");
            //sigo la corriente
            $crawler = $client->followRedirect();
//        }



        $this->assertEquals(200, $client->getResponse()->getStatusCode(), "Unexpected HTTP status code for GET /");


        // Check data in the show view
        $this->assertGreaterThan(0, $crawler->filter('td:contains("Foo")')->count(), 'Missing element td:contains("Foo")');

        // Edit the entity
        $crawler = $client->click($crawler->selectLink('Edit')->link());

        $form = $crawler->selectButton('Update')->form(array(
            'movie[name]' => 'Bar',
            'movie[year]' => 2017
        ));

        $client->submit($form);
        $crawler = $client->followRedirect();

        // Check the element contains an attribute with value equals "Foo"
        $this->assertGreaterThan(0, $crawler->filter('[value="Bar"]')->count(), 'Missing element [value="Bar"]');
        $this->assertGreaterThan(0, $crawler->filter('[value="2017"]')->count(), 'Missing element [value="2017"]');

        // Delete the entity
        $client->submit($crawler->selectButton('Delete')->form());
        $crawler = $client->followRedirect();

        // Check the entity has been delete on the list
        $this->assertNotRegExp('/Foo/', $client->getResponse()->getContent());
    }


}
