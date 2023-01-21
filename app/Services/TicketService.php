<?php

namespace App\Services;

use App\Http\Repositories\LotteryRepository;
use App\Models\Lottery;
use App\Models\Sortition;
use Exception;

class TicketService
{
    const idPendingStatus = 3;

    /**
     * Serviço responsável pela criação de novos jogos
     */
    public function create(array $request): array
    {
        try {
            // Valida os parâmetros
            $params = ValidateService::paramsCreateLottery($request);
            if ($params['error']) {
                throw new Exception($params['message']);
            }
            
            sort($params['numbers']);
            $params['numbers'] = json_encode($params['numbers']);
            $params['ticketCode'] = FunctionalitiesService::generateTicketCode($params);

            // Busca sorteio Válido
            $sortition = Sortition::where('situation_id', self::idPendingStatus)->get();
            if (!count($sortition)) {
                throw new Exception("No draw in progress");
            }
            $params['sortition'] = $sortition[0]->id;

            // Insere Loteria
            $ret = LotteryRepository::insert($params);
            if (!$ret) {
                throw new Exception("Error saving bet");
            }

            return [
                'error' => false,
                'ticketCode' => $params['ticketCode']
            ];
        } catch (\Throwable $th) {
            return [
                'error' => true,
                'message' => $th->getMessage()
            ];
        }
    }

    /**
     * Serviço responsável por validar e comparar ticket com jogo
     */
    public function show(string $ticketCode = null): array
    {
        try {
            if (empty(trim($ticketCode))) {
                throw new Exception("Need to provide ticket number");
            }

            // Busca Loteria por ticket
            $lottery = Lottery::where('ticketCode', $ticketCode)->first();
            if (!$lottery) {
                throw new Exception("No lottery found for this ticket");
            }
            $lotteryNumbers = json_decode($lottery->numbers);

            // Busca Sorteio
            $sortition = Sortition::where('id', $lottery->sortition_id)->first();
            if (!$sortition) {
                throw new Exception("Error when searching drawn. Please contact admin");
            }

            // Compara Loteria com Sorteio
            $sortitionNumbers = [];
            if (!empty($sortition->drawn_number)) {
                $sortitionNumbers = json_decode($sortition->drawn_number);
                sort($sortitionNumbers);
            }
            $resultSortition = FunctionalitiesService::compareLotteryWithSortition($lotteryNumbers, $sortitionNumbers);

            return [
                'error' => false,
                'name' => $lottery->name,
                'yourNumbers' => $lotteryNumbers,
                'machineNumbers' => count($sortitionNumbers) ? $sortitionNumbers : null,
                'winner' => $resultSortition ? $resultSortition : false,
                'message' => $this->getMessage($resultSortition),
            ];
        } catch (\Throwable $th) {
            return [
                'error' => true,
                'message' => $th->getMessage()
            ];
        }
    }

    /**
     * Retorna mensagem embasado no resultado
     */
    private function getMessage($result)
    {
        return match ($result) {
            true => 'You won!',
            false => 'You lost!',
            null => 'Not yet',
            default => 'Sorry, could not find'
        };
    }
}
