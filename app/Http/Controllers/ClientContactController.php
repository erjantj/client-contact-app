<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Services\ClientContactService;
use App\Services\ClientService;
use Illuminate\Http\Request;

class ClientContactController extends Controller
{
    /**
     * @SWG\Get(
     *     path="/client-contact",
     *     tags={"Client contact"},
     *     summary="List of all client contacts",
     *     description="Return list of all client contacts available",
     *     consumes={"application/json"},
     *     @SWG\Response(
     *         response="default",
     *         description="List of all client contacts",
     *     ),
     *     @SWG\Response(
     *         response=403,
     *         description="Forbidden",
     *     ),
     *     security={{
     *         "apiKey": {}
     *     }}
     * )
     *
     * List of all client contacts
     *
     * @param  Request  $request request
     * @return string   json response
     */
    public function all(Request $request, ClientContactService $clientContactService)
    {
        $result = $clientContactService->all();
        return response()->json($result);
    }

    /**
     * @SWG\Post(
     *     path="/client/{clientId}/contact",
     *     tags={"Client contact"},
     *     summary="Create client contact",
     *     description="Create client contact",
     *     consumes={"application/json"},
     *     @SWG\Parameter(
     *         name="clientId",
     *         in="path",
     *         required=true,
     *         description="Client id",
     *         type="integer",
     *     ),
     *     @SWG\Parameter(
     *         name="body",
     *         in="body",
     *         required=true,
     *         @SWG\Schema(
     *             ref="#/definitions/ClientContact"
     *         )
     *     ),
     *     @SWG\Response(
     *         response="default",
     *         description="Client created",
     *     ),
     *     @SWG\Response(
     *         response=422,
     *         ref="$/responses/UnprocessableEntity"
     *     ),
     *     @SWG\Response(
     *         response=403,
     *         description="Forbidden",
     *     ),
     * )
     *
     * Create client contact
     *
     * @param  Request  $request request
     * @return string   json response
     */
    public function createUserContact(Request $request, ClientContactService $clientContactService, $clientId)
    {
        $client = Client::findOrFail($clientId);

        $this->validateCreate($request);
        $data = $request->only([
            'address',
            'postcode',
        ]);

        if ($clientContactService->create($client, $data)) {
            return response()->json();
        }

        abort(422, 'Problem saving client contact');
    }

    /**
     * @SWG\Delete(
     *     path="/client/{clientId}/contact/{id}",
     *     tags={"Client"},
     *     summary="Delete client",
     *     description="Delete client",
     *     consumes={"application/json"},
     *     @SWG\Parameter(
     *         name="clientId",
     *         in="path",
     *         required=true,
     *         description="Client id",
     *         type="integer",
     *     ),
     *     @SWG\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Client contact id",
     *         type="integer",
     *     ),
     *     @SWG\Response(
     *         response="default",
     *         description="Client deleted",
     *     ),
     *     @SWG\Response(
     *         response=403,
     *         description="Forbidden",
     *     ),
     * )
     *
     * Delete client
     *
     * @param  Request  $request request
     * @return string   json response
     */
    public function delete(Request $request, ClientContactService $clientContactService, $clientId, $id)
    {
        if ($clientContactService->delete($clientId, $id)) {
            return response()->json();
        }

        abort(422, 'Problem deleting client contact');
    }

    /**
     * @SWG\Get(
     *     path="/client/{clientId}/contact/{id}",
     *     tags={"Client contact"},
     *     summary="Get client contact",
     *     description="Get client contact",
     *     consumes={"application/json"},
     *     @SWG\Parameter(
     *         name="Client id",
     *         in="path",
     *         required=true,
     *         description="Client id",
     *         type="integer",
     *     ),
     *     @SWG\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Contact id",
     *         type="integer",
     *     ),
     *     @SWG\Response(
     *         response="default",
     *         description="Get client contact",
     *     ),
     *     @SWG\Response(
     *         response=403,
     *         description="Forbidden",
     *     ),
     *     security={{
     *         "apiKey": {}
     *     }}
     * )
     *
     * Get client contact
     *
     * @param  Request  $request request
     * @return string   json response
     */
    public function get(Request $request, ClientContactService $clientContactService, $clientId, $id)
    {
        $clientContact = $clientContactService->get($clientId, $id);
        return response()->json($clientContact);
    }

    /**
     * @SWG\Post(
     *     path="/client/{clientId}/contact/{id}",
     *     tags={"Client contact"},
     *     summary="Update client contact",
     *     description="Update client contact",
     *     consumes={"application/json"},
     *     @SWG\Parameter(
     *         name="clientId",
     *         in="path",
     *         required=true,
     *         description="Client id",
     *         type="integer",
     *     ),
     *     @SWG\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Client contact id",
     *         type="integer",
     *     ),
     *     @SWG\Parameter(
     *         name="body",
     *         in="body",
     *         required=true,
     *         @SWG\Schema(
     *             ref="#/definitions/ClientContact"
     *         )
     *     ),
     *     @SWG\Response(
     *         response="default",
     *         description="Client updated",
     *     ),
     *     @SWG\Response(
     *         response=422,
     *         ref="$/responses/UnprocessableEntity"
     *     ),
     *     @SWG\Response(
     *         response=403,
     *         description="Forbidden",
     *     ),
     * )
     *
     * Update client contact
     *
     * @param  Request  $request request
     * @return string   json response
     */
    public function update(Request $request, ClientContactService $clientContactService, $clientId, $id)
    {
        $this->validateUpdate($request, $id);
        $data = $request->only([
            'address',
            'postcode',
        ]);

        if ($clientContactService->update($clientId, $id, $data)) {
            return response()->json();
        }

        abort(422, 'Problem updating client contact');
    }

    /**
     * @SWG\Get(
     *     path="/client/{clientId}/contact",
     *     tags={"Client contact"},
     *     summary="List of given client contacts",
     *     description="Return list of given client contacts available",
     *     consumes={"application/json"},
     *     @SWG\Parameter(
     *         name="clientId",
     *         in="path",
     *         required=true,
     *         description="Client id",
     *         type="integer",
     *     ),
     *     @SWG\Response(
     *         response="default",
     *         description="List of given client contacts",
     *     ),
     *     @SWG\Response(
     *         response=403,
     *         description="Forbidden",
     *     ),
     *     security={{
     *         "apiKey": {}
     *     }}
     * )
     *
     * List of given client contacts
     *
     * @param  Request  $request request
     * @return string   json response
     */
    public function userContacts(Request $request, ClientService $clientService, $clientId)
    {
        $client = $clientService->get($clientId);
        return response()->json($client->contacts);
    }

    /**
     * Validate create
     * @param  Rquest $request request object
     */
    private function validateCreate($request)
    {
        $this->validate($request, [
            'address' => 'required|max:255|string',
            'postcode' => 'required|max:255|string',
        ]);
    }

    /**
     * Validate update
     * @param  Rquest $request request object
     */
    private function validateUpdate($request, $id)
    {
        $this->validate($request, [
            'address' => 'sometimes|required|max:255|string',
            'postcode' => 'sometimes|required|max:255|string',
        ]);
    }
}
