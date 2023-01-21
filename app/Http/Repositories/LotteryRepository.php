<?php

namespace App\Http\Repositories;

use App\Models\Lottery;

class LotteryRepository
{
    /**
     * Serviço responsável pela criação de novos jogos
     * 
     * @param array
     * @return mixed
     */
    public static function insert(array $params): mixed
    {
        return Lottery::create([
            'name' => $params['name'],
            'numbers' => $params['numbers'],
            'sortition_id' => $params['sortition'],
            'ticketCode' => $params['ticketCode'],
            'situation_id' => 1
        ]);
    }
}
