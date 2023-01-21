<?php

namespace App\Services;

use Exception;

class ValidateService
{
    const idPendingStatus = 3;

    /**
     * Tratamento dos parâmetros vindos da Request.
     */
    public static function rectifyParams(array|string $params): array|string
    {
        if (is_string($params)) {
            return mb_strtoupper(trim($params));
        }

        return array_map('mb_strtoupper', array_map('trim', $params));
    }

    /**
     * Serviço responsável pela validação de todos os números dos jogos
     */
    public static function numberIntAndNoRepeat(array $params): bool
    {
        $params = array_unique($params);
        if (count($params) != 6) {
            return false;
        }

        foreach ($params as $value) {
            if ((int) $value != $value || $value > 60) {
                return false;
            }
        }

        return true;
    }

    /**
     * Serviço responsável pela validação dos dados para inserção
     */
    public static function paramsCreateLottery(array $params): array
    {
        try {
            if (!count($params)) {
                throw new Exception("Invalid parameters");
            }

            $params['name'] = static::rectifyParams($params['name']);

            $retValidateNumberInt = static::numberIntAndNoRepeat($params['numbers']);
            if (!$retValidateNumberInt) {
                throw new Exception("Invalid numbers (1 to 60)");
            }

            return [
                'error' => false,
                'name' => $params['name'],
                'numbers' => $params['numbers']
            ];
        } catch (\Throwable $th) {
            return [
                'error' => true,
                'message' => $th->getMessage()
            ];
        }
    }
}
