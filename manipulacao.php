<?php

require 'vendor/autoload.php';

// 1. O script começa importando um array de dados (`$dados`).
//2. Conta o número de países presentes no array e exibe no console.
//3. Declara uma função para converter o nome dos países para letras maiúsculas.
//4. Aplica essa função a cada país do array usando `array_map`.
//5. Por fim, exibe o array modificado, onde todos os nomes dos países estão em letras maiúsculas.

$dados = require 'dados.php';

$contador = count($dados);
//echo "Número de países: $contador\n";

$somaMedalhas = fn(int $medalhaAcumuladas, int $medalhas) => $medalhaAcumuladas + $medalhas;


function convertePaísParaLetraMaiuscula(array $pais): array{

    $pais['pais'] = mb_convert_case($pais['pais'], MB_CASE_UPPER);
    return $pais;

}

$VerificaSePaisTemEspacoNoNome = fn(array $país): bool => strpos($país['pais'], ' ') !== false;


$compararMedalhas = fn(array $medalhasPais1, array $medalhasPais2) => fn(string $modalidade): int => $medalhasPais2[$modalidade] <=> $medalhasPais1[$modalidade];

$nomesDePaisesEmMaisuculo = fn($dados) => array_map('converterPaisParaLetraMaiuscula', $dados);
$filtraPaisesSemEspacoNoNome = fn($dados) => array_filter($dados, $VerificaSePaisTemEspacoNoNome);




$funcoes = \igorw\pipeline(
    $nomesDePaisesEmMaisuculo,
    $filtraPaisesSemEspacoNoNome
);

$dados = $funcoes($dados);

exit();

$medalhas = array_reduce(
    array_map(
        fn(array $medalhas) => array_reduce($medalhas, $somaMedalhas, 0),
        array_column($dados, 'medalhas')
    ),

    $somaMedalhas,
    0
);

usort($dados, function (array $país1, array $país2) use ($compararMedalhas) {
    $medalhasPais1 = $país1 ['medalhas'];
    $medalhasPais2 = $país2 ['medalhas'];
    $comparador = $compararMedalhas($medalhasPais1, $medalhasPais2);

    if ($comparador('ouro') !== 0) {
        return $comparador('ouro');
    } elseif ($comparador('prata') !== 0) {
        return $comparador('prata');
    } elseif ($comparador('bronze') !== 0) {
        return $comparador('bronze');
    } else {
        return 0;
    }
});


var_dump($dados);

echo $medalhas;



