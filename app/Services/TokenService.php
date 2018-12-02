<?php

namespace App\Services;

use App\Models\Client;
use App\Models\Token;

class TokenService
{
    /**
     * Generates random token for given client
     * @param  Client $client client
     * @return string
     */
    public function generateToken(Client $client)
    {
        return sha1($client->id . time() . rand());
    }

    public function generateTokenForClient(Client $client)
    {
        Token::where('client_id', '=', $client->id)->delete();

        $token = $this->generateToken($client);
        $tokenRecord = new Token();
        $tokenRecord->token = $token;
        $tokenRecord->client_id = $client->id;

        return $tokenRecord->save();
    }
}
