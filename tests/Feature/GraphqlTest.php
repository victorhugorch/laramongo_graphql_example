<?php

namespace Tests\Feature;

use App\Models\Pdv;
use Tests\TestCase;

class GraphqlTest extends TestCase
{
    const PDV_TRADINGNAME = "Zé me contrata Bar e lanches";

    public function graphql(string $query)
    {
        return $this->post('/graphql', [
            'query' => $query
        ]);
    }

    public function test_create_pdv()
    {
        factory(Pdv::class)->create([
            'tradingName' => self::PDV_TRADINGNAME,
        ]);

        $queryFromFile = $this->getQuery('query_create_pdv');
        $response = $this->graphql($queryFromFile);

        $this->assertEquals(
            self::PDV_TRADINGNAME,
            $response->json("data.UpdateOrCreatePdv.tradingName")
        );
    }

    public function test_document_unique_when_creating_pdv()
    {
        $uniqueDocumentQuery = $this->getQuery('query_create_pdv_unique_document');
        $sameDocumentQuery = $this->getQuery('query_create_pdv_same_document');

        $this->graphql($uniqueDocumentQuery);
        $responseSameDocument = $this->graphql($sameDocumentQuery);

        $this->assertNull(
            $responseSameDocument->json("data.UpdateOrCreatePdv")
        );
    }

    private function getQuery(string $filename) : string
    {
        return file_get_contents(storage_path() . "/test/$filename.txt");
    }
}
