<?php

namespace App\Http\Repositories;

use App\Models\Sortition;

class SortitionRepository
{
    /**
     * Serviço responsável pela criação de novos jogos
     * 
     * @param array
     * @return mixed
     */
    public static function insert(array $params): mixed
    {
        return Sortition::create([
            'drawn_number' => $params['drawn_number'] ?? null,
            'situation_id' => $params['situation_id'],
        ]);
    }
}
