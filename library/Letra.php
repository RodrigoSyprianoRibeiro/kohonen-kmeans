<?php

class Letra
{
    public $nome;
    public $vetorCodigo;
    public $vetorSimbolo;

    function converteSimboloParaCodigo($tipo) {
        $numero = ($tipo == 'bipolar') ? -1 : 0;
        foreach ($this->vetorSimbolo AS $simbolo) {
            $this->vetorCodigo[] = (int) ($simbolo == '#') ? 1 : $numero;
        }
    }

    function converteCodigoParaSimbolo() {
        foreach ($this->vetorCodigo AS $codigo) {
            $this->vetorSimbolo[] = ($codigo == 1) ? '#' : '.';
        }
    }

    function getNome() {
        return $this->nome;
    }

    function setNome($nome) {
        $this->nome = $nome;
    }

    function getVetorCodigo() {
        return $this->vetorCodigo;
    }

    function setVetorCodigo($vetorCodigo) {
        $this->vetorCodigo = $vetorCodigo;
    }

    function getVetorSimbolo() {
        return $this->vetorSimbolo;
    }

    function setVetorSimbolo($vetorSimbolo) {
        $this->vetorSimbolo = $vetorSimbolo;
    }
}