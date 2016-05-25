<?php

require_once('Arquivo.php');
require_once('Letra.php');

class Util
{
    public static function getLetrasTreinamento($tipo) {
        $listaLetras = array();
        foreach (self::getArquivos() as $arquivo) {
            $letra = new Letra();
            $letra->setNome($arquivo->getNome());
            $letra->setVetorSimbolo($arquivo->getConteudo());
            $letra->converteSimboloParaCodigo($tipo);
            array_push($listaLetras, $letra);
        }
        return $listaLetras;
    }

    public static function gerarLetraAleatoria($tipo) {
        $arquivos = self::getArquivos();
        $arquivo = $arquivos[array_rand($arquivos, 1)];
        $letra = new Letra();
        $letra->setNome($arquivo->getNome());
        $letra->setVetorSimbolo($arquivo->getConteudo());
        $letra->converteSimboloParaCodigo($tipo);
        return $letra;
    }

    public static function getLetraClassificacao($vetorSimbolo, $tipo) {
        $letra = new Letra();
        $letra->setVetorSimbolo($vetorSimbolo);
        $letra->converteSimboloParaCodigo($tipo);
        return $letra;
    }

    public static function getArquivos() {

        $path = "../letras/";
        $diretorio = dir($path);

        $listaArquivos = array();

        while($arquivo = $diretorio->read()){
                $nome = "".$arquivo;
                if (strpos($nome, '.txt') !== false) {
                    $caminhoCompleto = $path.$arquivo;
                    $arquivo = new Arquivo();
                    $arquivo->setNome(str_replace('.txt', '', $nome));
                    $arquivo->setCaminho($caminhoCompleto);
                    $arquivo->setConteudo();
                    array_push($listaArquivos, $arquivo);
                }
        }
        $diretorio -> close();

        return $listaArquivos;
    }
}