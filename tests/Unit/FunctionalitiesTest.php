<?php

use App\Services\FunctionalitiesService;
use App\Services\ValidateService;

test('Função para validação da geração dos números sorteados', function () {
    $return = FunctionalitiesService::drawnNumberGenerator();

    $returnValidate = ValidateService::numberIntAndNoRepeat(json_decode($return));
    expect($returnValidate)->toBe(true);
});

test('Função para comparar Loteria com Sorteio', function () {
    $return = FunctionalitiesService::compareLotteryWithSortition(
        [1,2,3,4,5,6],
        [],
    );
    expect($return)->toBe(null);

    $return = FunctionalitiesService::compareLotteryWithSortition(
        [1,2,3,4,5,6],
        [6,5,4,3,2,1],
    );
    expect($return)->toBe(true);

    $return = FunctionalitiesService::compareLotteryWithSortition(
        [1,2,3,4,5,6],
        [1,2,3,4,5,7],
    );
    expect($return)->toBe(false);    
});
