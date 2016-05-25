<?php

class Arquivo
{
    public $nome;
    public $caminho;
    public $conteudo;

    function getNome() {
        return $this->nome;
    }

    function setNome($nome) {
        $this->nome = $nome;
    }

    function getCaminho() {
        return $this->caminho;
    }

    function setCaminho($caminho) {
        $this->caminho = $caminho;
    }

    function getConteudo() {
        return $this->conteudo;
    }

    function setConteudo() {
        $arquivo = file($this->caminho);

        foreach ($arquivo AS $linha) {
            foreach (str_split($linha) AS $indice => $caracter) {
                if ($indice < 7) {
                    $this->conteudo[] = $caracter;
                }
            }
        }
    }
}