<?php

namespace App\Services;

use App\Models\Client;
use App\Models\ClientContact;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class ClientContactService
{
    const PAGE_SIZE = 20;

    /**
     * Clients list
     * @return Paginator
     */
    public function all()
    {
        return ClientContact::paginate(self::PAGE_SIZE);
    }

    /**
     * Create client
     * @param  Client $client client
     * @param  array $data client contact data
     * @return boolean
     */
    public function create($client, $data)
    {
        if (count($client->contacts) >= Client::CONTACTS_LIMIT) {
            throw new BadRequestHttpException('Too many contacts for this user');
        }

        $clientContact = new ClientContact;
        $clientContact->fill($data);
        $clientContact->client_id = $client->id;

        return $clientContact->save();
    }

    /**
     * Delete client
     * @param  integer $clientId client id
     * @param  integer $id       client contact id
     * @return boolean
     */
    public function delete($clientId, $id)
    {
        $clientContact = $this->get($clientId, $id);
        return $clientContact->delete();
    }

    /**
     * Get client
     * @param  integer $clientId client id
     * @param  integer $id       client contact id
     * @return boolean
     */
    public function get($clientId, $id)
    {
        $clientContact = ClientContact::where('client_id', '=', $clientId)->findOrFail($id);
        return $clientContact;
    }

    /**
     * Update client
     * @param  integer $clientId client id
     * @param  integer $id       client contact id
     * @param  array $data       client contact data
     * @return boolean
     */
    public function update($clientId, $id, $data)
    {
        $clientContact = $this->get($clientId, $id);
        $clientContact->fill($data);

        return $clientContact->save();
    }
}
