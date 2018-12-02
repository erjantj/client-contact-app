<?php

namespace App\Services;

use App\Models\Client;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ClientService
{
    const PAGE_SIZE = 20;

    /**
     * Clients list
     * @return Collection
     */
    public function all()
    {
        return Client::with('contacts')->get();
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
        DB::beginTransaction();
        try {
            $client = Client::findOrFail($id);
            if ($client->delete()) {
                if ($client->contacts) {
                    $client->contacts()->delete();
                }
                DB::commit();
                return true;
            }
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }

        DB::rollBack();
        return false;
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

    public function getRules()
    {
        return [
            'first_name' => 'required|max:255|string',
            'last_name' => 'sometimes|required|max:255|string',
            'email' => 'required|max:255|email|unique:client,email',
        ];
    }

    /**
     * Save file data
     * @param  array $fileData file data
     * @return boolean status
     */
    public function saveFileData($fileData)
    {
        $exisitingClients = [];
        $clientsForInsert = [];

        foreach ($fileData as $data) {
            $clientData = [
                'first_name' => isset($data[0]) ? $data[0] : '',
                'email' => isset($data[1]) ? $data[1] : '',
            ];

            if ($this->validateClient($clientData)) {
                $exisitingClients[$clientData['email']] = $clientData;
            }
        }

        foreach ($exisitingClients as $email => $data) {
            $clientsForInsert[] = $data;
        }

        if ($clientsForInsert) {
            DB::beginTransaction();
            try {
                $clientsForInsert = array_chunk($clientsForInsert, 10);

                foreach ($clientsForInsert as $chunk) {
                    Client::insert($chunk);
                }

                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                throw $e;
            }
        }

        return true;
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

    private function validateClient($data)
    {
        $validator = Validator::make($data, $this->getRules());
        return !$validator->fails();
    }
}
