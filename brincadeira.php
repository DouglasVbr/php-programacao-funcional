<?php
// closures é uma função que recebe o escopo externo já a class closures representa qualquer função anonima
$variavel = 'teste';
function outra(callable $funcao): void
{
    echo 'executando outra função: ';
    echo $funcao();
}
$nomeDaFuncao = function () use ($variavel) {
    echo $variavel;
    return 'uma outra função';
};
outra($nomeDaFuncao);

var_dump($nomeDaFuncao);
