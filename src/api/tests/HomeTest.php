<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class HomeTest extends TestCase
{
    /**
     * testHome
     *
     * @return void
     */
    public function testHome()
    {
        $this->get('/');
        $conteudoRetorno = $this->response->getContent();
        $conteudoJSON = json_decode($conteudoRetorno);

        $this->assertEquals(
            true, !empty($conteudoJSON)
        );
    }
}
