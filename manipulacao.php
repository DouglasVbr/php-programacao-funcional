<?php

// 1. O script começa importando um array de dados (`$dados`).
//2. Conta o número de países presentes no array e exibe no console.
//3. Declara uma função para converter o nome dos países para letras maiúsculas.
//4. Aplica essa função a cada país do array usando `array_map`.
//5. Por fim, exibe o array modificado, onde todos os nomes dos países estão em letras maiúsculas.

$dados = require 'dados.php';

$contador = count($dados);
echo "Número de países: $contador\n";

function somaMedalhas(int $medalhaAcumuladas, int $medalhas): int

{
    return $medalhaAcumuladas + $medalhas;
}

$brasil = $dados[0];
$numeroDeMedalhas = array_reduce($brasil ['medalhas'],
    'somaMedalhas', 0);
echo $numeroDeMedalhas . "\n";


function convertePaísParaLetraMaiuscula(array $pais): array
{
    $pais['pais'] = mb_convert_case($pais['pais'], MB_CASE_UPPER);
    return $pais;

}

function VerificaSePaisTemEspacoNoNome(array $país): bool
{
    return strpos($país['pais'], ' ') !== false;

}

function compararMedalhas( array $medalhasPais1, array $medalhasPais2 , string $modalidade): callable

{
    return function (string $modalidade)  use ($medalhasPais1, $medalhasPais2): int{
        return $medalhasPais2[$modalidade] <=> $medalhasPais1[$modalidade];
    };

}



function medalhasAcumuladas(int $medalhaAcumuladas, array $pais): int
{
    return $medalhaAcumuladas + array_reduce($pais['medalhas'],
            'somaMedalhas', 0);
}

$dados = array_map('convertePaísParaLetraMaiuscula',
    $dados);
$dados = array_filter($dados,
    'VerificaSePaisTemEspacoNoNome');

$medalhas = array_reduce(
    array_map(function (array $medalhas) {
        return array_reduce($medalhas, 'somaMedalhas',
            0);
    }, array_column($dados, 'medalhas')),
    'somaMedalhas',
    0
);

usort($dados, function (array $país1, array $país2) {
    $medalhasPais1 = $país1 ['medalhas'];
    $medalhasPais2 = $país2 ['medalhas'];
    $comparador = compararMedalhas($medalhasPais1, $medalhasPais2);

    return  $comparador('ouro') !== 0 ? $comparador('ouro')
        : $comparador('prata') !== 0 ? $comparador('prata')
        : $comparador('bronze') !== 0 ? $comparador('bronze');
});


    var_dump($dados);

    echo $medalhas;
