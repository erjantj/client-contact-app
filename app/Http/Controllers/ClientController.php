<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Rules\FileExtentionIn;
use App\Services\ClientService;
use App\Services\FileService;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * @SWG\Get(
     *     path="/client",
     *     tags={"Client"},
     *     summary="List of all clients",
     *     description="Return list of all clients available",
     *     consumes={"application/json"},
     *     @SWG\Response(
     *         response="default",
     *         description="List of all clients",
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
     * List of all clients
     *
     * @param  Request  $request request
     * @return string   json response
     */
    public function all(Request $request, ClientService $clientService)
    {
        $result = $clientService->all();
        return response()->json($result);
    }

    /**
     * @SWG\Post(
     *     path="/client",
     *     tags={"Client"},
     *     summary="Create client",
     *     description="Create client",
     *     consumes={"application/json"},
     *     @SWG\Parameter(
     *         name="body",
     *         in="body",
     *         required=true,
     *         @SWG\Schema(
     *             ref="#/definitions/Client"
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
     * Create client
     *
     * @param  Request  $request request
     * @return string   json response
     */
    public function create(Request $request, ClientService $clientService)
    {
        $this->validateCreate($request);
        $data = $request->only([
            'first_name',
            'last_name',
            'email',
        ]);

        if ($clientService->create($data)) {
            return response()->json();
        }

        abort(422, 'Problem saving client');
    }

    /**
     * @SWG\Delete(
     *     path="/client/{id}",
     *     tags={"Client"},
     *     summary="Delete client",
     *     description="Delete client",
     *     consumes={"application/json"},
     *     @SWG\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Client id",
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
    public function delete(Request $request, ClientService $clientService, $id)
    {
        if ($clientService->delete($id)) {
            return response()->json();
        }

        abort(422, 'Problem deleting client');
    }

    /**
     * @SWG\Get(
     *     path="/client/{id}",
     *     tags={"Client"},
     *     summary="Get client",
     *     description="Get client",
     *     consumes={"application/json"},
     *     @SWG\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Client id",
     *         type="integer",
     *     ),
     *     @SWG\Response(
     *         response="default",
     *         description="Get client",
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
     * Get client
     *
     * @param  Request  $request request
     * @return string   json response
     */
    public function get(Request $request, ClientService $clientService, $id)
    {
        $client = $clientService->get($id);
        return response()->json($client);
    }

    /**
     * @SWG\Post(
     *     path="/client/import",
     *     tags={"Client"},
     *     summary="Import clients",
     *     description="Import clients",
     *     consumes={"application/json"},
     *     @SWG\Parameter(
     *         name="file",
     *         in="formData",
     *         required=true,
     *         description="File",
     *         type="file",
     *     ),
     *     @SWG\Response(
     *         response="default",
     *         description="Clients imported",
     *     ),
     *     @SWG\Response(
     *         response=403,
     *         description="Forbidden",
     *     ),
     * )
     *
     * Import clients
     *
     * @param  Request  $request request
     * @return string   json response
     */
    public function import(Request $request, ClientService $clientService, FileService $fileService)
    {
        $this->validateImport($request);

        $file = $request->file('file');

        if ($fileData = $fileService->import($file)) {
            if ($clientService->saveFileData($fileData)) {
                return response()->json();
            }
        }

        abort(400, 'Problem updating client');
    }

    /**
     * @SWG\Post(
     *     path="/client/{id}",
     *     tags={"Client"},
     *     summary="Update client",
     *     description="Update client",
     *     consumes={"application/json"},
     *     @SWG\Parameter(
     *         name="id",
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
     *             ref="#/definitions/Client"
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
     * Update client
     *
     * @param  Request  $request request
     * @return string   json response
     */
    public function update(Request $request, ClientService $clientService, $id)
    {
        $this->validateUpdate($request, $id);
        $data = $request->only([
            'first_name',
            'last_name',
            'email',
        ]);

        if ($clientService->update($id, $data)) {
            return response()->json();
        }

        abort(422, 'Problem updating client');
    }

    /**
     * Validate create
     * @param  Rquest $request request object
     */
    private function validateCreate($request)
    {
        $this->validate($request, [
            'first_name' => 'required|max:255|string',
            'last_name' => 'required|max:255|string',
            'email' => 'required|max:255|email|unique:client,email',
        ]);
    }

    private function validateImport($request)
    {
        $this->validate($request, [
            'file' => ['required', 'file', new FileExtentionIn(['csv'])],
        ]);
    }

    /**
     * Validate update
     * @param  Rquest $request request object
     */
    private function validateUpdate($request, $id)
    {
        $this->validate($request, [
            'first_name' => 'sometimes|required|max:255|string',
            'last_name' => 'sometimes|required|max:255|string',
            'email' => 'sometimes|required|max:255|email|unique:client,email,' . $id,
        ]);
    }
}
