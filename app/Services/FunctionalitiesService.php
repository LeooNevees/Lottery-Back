<?php

namespace App\Services;

use Illuminate\Support\Facades\Hash;

class FunctionalitiesService
{
    /**
     * Geração do número sorteado
     */
    public static function drawnNumberGenerator(): string
    {
        $result = [];
        while (count($result) < 6) {
            $result[] = rand(1, 60);
            $result = array_unique($result);
        }
        
        sort($result);
        return json_encode($result);
    }

        /**
     * Função para geração do Hash
     */
    public static function generateTicketCode(array $params): string
    {
        return Hash::make($params['name'] . now() . $params['numbers']);
    }

    /**
     * Serviço para comparar numeros entre apostador e sorteio
     */
    public static function compareLotteryWithSortition(array $numbersLottery, array $numbersSortition): bool | null
    {
        if (!count($numbersSortition)) {
            return null;
        }

        sort($numbersLottery);
        sort($numbersSortition);

        if ($numbersLottery == $numbersSortition) {
            return true;
        }

        return false;
    }
}
