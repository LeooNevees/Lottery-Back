<?php

use App\Services\ValidateService;

test('Função para valição dos parâmetros enviados da loteria', function () {
    $returnString = ValidateService::rectifyParams(' teste ');
    expect($returnString)->toBe("TESTE");

    $returnArray = ValidateService::rectifyParams([' leonardo ']);
    expect($returnArray)->toMatchArray(['LEONARDO']);
});


test('Função para validação dos números da loteria', function () {
    $return = ValidateService::numberIntAndNoRepeat([1, 2, 3, 4, 5, 6]);
    expect($return)->toBe(true);

    $return = ValidateService::numberIntAndNoRepeat([1, 2, 3, 4, 5, 5]);
    expect($return)->toBe(false);

    $return = ValidateService::numberIntAndNoRepeat([1, 2, 3, 4, 5, 61]);
    expect($return)->toBe(false);

    $return = ValidateService::numberIntAndNoRepeat([1, 2, 3, 4, 5, 61, 7]);
    expect($return)->toBe(false);
});

test('Função para validação dos parâmetros e números fornecidos (unificação)', function () {
    $return = ValidateService::paramsCreateLottery([
        'name' => 'teste',
        'numbers' => [1, 2, 3, 4, 5, 6]
    ]);

    expect($return)->toMatchArray([
        'error' => false,
        'name' => 'TESTE',
        'numbers' => [1, 2, 3, 4, 5, 6]
    ]);
});
