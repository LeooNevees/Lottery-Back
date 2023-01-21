<?php

namespace App\Http\Controllers;

use App\Http\Requests\TicketRequest;
use App\Services\TicketService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TicketController extends Controller
{

    /**
     * Criar novo jogo
     */
    public function create(TicketRequest $request): JsonResponse
    {
        try {
            $returnCreate = (new TicketService)->create($request->all());
            if ($returnCreate['error']) {
                throw new Exception($returnCreate['message'], 422);
            }

            return response()->json($returnCreate, 201);
        } catch (\Throwable $th) {
            return response()->json(['error' => true, 'message' => $th->getMessage()], $th->getCode());
        }
    }

    /**
     * Mostrar resultado do jogo embasado no ticket fornecido
     */
    public function show(Request $request): JsonResponse
    {
        try {
            $returnData = (new TicketService)->show($request->input('ticketCode'));
            if ($returnData['error']) {
                throw new Exception($returnData['message'], 422);
            }

            return response()->json($returnData, 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => true, 'message' => $th->getMessage()], $th->getCode());
        }
    }
}
