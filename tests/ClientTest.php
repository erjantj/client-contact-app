<?php

use App\Models\Client;
use App\Models\Token;
use Laravel\Lumen\Testing\DatabaseTransactions;

class ClientTest extends TestCase
{
    use DatabaseTransactions;

    public function getHeaders($token)
    {
        $header = [
            'Authorization' => $token,
        ];
        return $header;
    }

    public function setUp()
    {
        parent::setUp();

        $this->apiVersion = 'v1';
        $this->endpoint = 'client';
    }

    /**
     * All
     *
     * @return void
     */
    public function testAll()
    {
        $client = factory(Client::class)->create();
        $token = factory(Token::class)->create([
            'client_id' => $client->id,
        ]);

        $clientsCount = 10;
        $clients = factory(Client::class, $clientsCount)->create();

        $result = $this->get("/api/{$this->apiVersion}/{$this->endpoint}/", $this->getHeaders($token->token));
        $content = json_decode($result->response->getContent(), true);

        if (isset($content['data'])) {
            $this->assertTrue(count($content['data']) >= $clientsCount);
        } else {
            $this->assertTrue(false);
        }
    }

    /**
     * Create success
     *
     * @return void
     */
    public function testCreateSuccess()
    {
        $client = factory(Client::class)->create();
        $token = factory(Token::class)->create([
            'client_id' => $client->id,
        ]);

        $client2 = factory(Client::class)->make();

        $result = $this->post("/api/{$this->apiVersion}/{$this->endpoint}/", $client2->toArray(), $this->getHeaders($token->token));

        $this->assertEquals(200, $result->response->status());
        $result->seeJson([]);
    }

    /**
     * Create Unauthenticated
     *
     * @return void
     */
    public function testCreateUnauthenticated()
    {
        $this->post("/api/{$this->apiVersion}/{$this->endpoint}/", [])
            ->seeJson([
                'message' => 'Unauthenticated.',
            ]);
    }

    /**
     * Create with empty params
     *
     * @return void
     */
    public function testCreateWithEmptyParams()
    {
        $client = factory(Client::class)->create();
        $token = factory(Token::class)->create([
            'client_id' => $client->id,
        ]);

        $this->post("/api/{$this->apiVersion}/{$this->endpoint}/", [],
            $this->getHeaders($token->token))
            ->seeJson([
                'first_name' => ['The first name field is required.'],
                'last_name' => ['The last name field is required.'],
                'email' => ['The email field is required.'],
            ]);
    }

    /**
     * Delete
     *
     * @return void
     */
    public function testDelete()
    {
        $client = factory(Client::class)->create();
        $token = factory(Token::class)->create([
            'client_id' => $client->id,
        ]);

        $client2 = factory(Client::class)->create();

        $this->delete("/api/{$this->apiVersion}/{$this->endpoint}/$client2->id", [], $this->getHeaders($token->token));

        $result = $this->get("/api/{$this->apiVersion}/{$this->endpoint}/$client2->id",
            $this->getHeaders($token->token));

        $this->assertEquals(404, $result->response->status());
    }

    /**
     * Get
     *
     * @return void
     */
    public function testGet()
    {
        $client = factory(Client::class)->create();
        $token = factory(Token::class)->create([
            'client_id' => $client->id,
        ]);

        $client2 = factory(Client::class)->create();

        $this->get("/api/{$this->apiVersion}/{$this->endpoint}/$client2->id", $this->getHeaders($token->token))
            ->seeJson([
                'first_name' => $client2->first_name,
                'last_name' => $client2->last_name,
                'email' => $client2->email,
            ]);
    }

    /**
     * Invalid email
     *
     * @return void
     */
    public function testInvalidEmail()
    {
        $client = factory(Client::class)->create();
        $token = factory(Token::class)->create([
            'client_id' => $client->id,
        ]);

        $client2 = factory(Client::class)->make();
        $client2->email = 'asd';

        $this->post("/api/{$this->apiVersion}/{$this->endpoint}/", $client2->toArray(),
            $this->getHeaders($token->token))
            ->seeJson([
                'email' => ['The email must be a valid email address.'],
            ]);
    }

    /**
     * Update
     *
     * @return void
     */
    public function testUpdate()
    {
        $client = factory(Client::class)->create();
        $token = factory(Token::class)->create([
            'client_id' => $client->id,
        ]);

        $client2 = factory(Client::class)->create();
        $clientUpdated = factory(Client::class)->make();

        $this->post("/api/{$this->apiVersion}/{$this->endpoint}/$client2->id", $clientUpdated->toArray(), $this->getHeaders($token->token))
            ->seeJson([]);

        $this->get("/api/{$this->apiVersion}/{$this->endpoint}/$client2->id",
            $this->getHeaders($token->token))
            ->seeJson([
                'first_name' => $clientUpdated->first_name,
                'last_name' => $clientUpdated->last_name,
                'email' => $clientUpdated->email,
            ]);
    }
}
