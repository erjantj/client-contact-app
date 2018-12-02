<?php

namespace App\Console\Commands;

use App\Models\Client;
use App\Services\TokenService;
use Illuminate\Console\Command;

class TokenGenerate extends Command
{
    protected $description = 'Generates token for client';

    protected $signature = 'token:generate {clientId}';

    protected $tokenService;

    public function __construct(TokenService $tokenService)
    {
        parent::__construct();
        $this->tokenService = $tokenService;
    }

    public function handle()
    {
        $clientId = $this->argument('clientId');

        $client = Client::findOrFail($clientId);
        $this->tokenService->generateTokenForClient($client);
    }
}
