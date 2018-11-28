<?php

namespace App\Services;

use App\Models\Client;

class ClientService
{
    const PAGE_SIZE = 20;

    /**
     * Clients list
     * @return Paginator
     */
    public function all()
    {
        return Client::paginate(self::PAGE_SIZE);
    }

    /**
     * Create client
     * @param  array $data client data
     * @return boolean
     */
    public function create($data)
    {
        $client = new Client;
        $client->fill($data);

        return $client->save();
    }

    /**
     * Delete client
     * @param  integer $id client id
     * @return boolean
     */
    public function delete($id)
    {
        $client = Client::findOrFail($id);
        return $client->delete();
    }

    /**
     * Get client
     * @param  integer $id client id
     * @return boolean
     */
    public function get($id)
    {
        $client = Client::with('contacts')->findOrFail($id);
        return $client;
    }

    /**
     * Update client
     * @param  integer $id client id
     * @param  array $data client data
     * @return boolean
     */
    public function update($id, $data)
    {
        $client = Client::findOrFail($id);
        $client->fill($data);

        return $client->save();
    }
}
