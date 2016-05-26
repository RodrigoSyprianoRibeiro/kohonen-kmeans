<?php

class Kohonen
{
    public $geracaoAtual;

    public $quantidadeGeracoes; // Quantidade de vezes que vai efetuar o treinamento.
    public $raio; // Tamanho do raio
    public $taxaAprendizado; // 0 < $taxaAprendizado <= 1
    public $descrescimoTaxaAprendizado; // 0 < $taxaAprendizado <= 1

    public $tamanhoVetorX; // Tamanho do vetor de entrada. (Vetor da letra)
    public $vetorX; // Vetor de entrada. (Caracteres de uma Letra)

    public $matrizW; // Matriz com os pesos.

    public $quantidadeClusters; // Quantidade de classes a serem classificadas.
    public $somaPonderada; // Soma pondera do vetor de entrada ($vetorX) com vetor de saída ($somaPonderada).

    function __construct($dados) {
        $this->geracaoAtual = 1;

        $this->quantidadeGeracoes = (int) $dados['quantidade_geracoes'];
        $this->raio = (int) $dados['raio'];
        $this->taxaAprendizado = (float) ($dados['taxa_aprendizagem'] / 100);
        $this->descrescimoTaxaAprendizado = (float) ($dados['descrescimo_taxa_aprendizagem'] / 100);

        $this->tamanhoVetorX = 63;
        $this->vetorX = array();

        $this->matrizW = array();

        $this->quantidadeClusters = (int) $dados['quantidade_clusters'];
        $this->somaPonderada = array();
    }

    public function iniciarTreinamento($letrasTreinamento) {

        $this->iniciarMatrizW();

        while ($this->quantidadeGeracoes > 0) {

            foreach ($letrasTreinamento AS $letra) {

                $this->vetorX = $letra->getVetorCodigo();

                $this->somaPonderada = $this->somaPonderada();

                asort($this->somaPonderada); // Ordena o somaPonderada do menor para o maior.

                $this->atualizarMatrizW();
            }

            $this->atualizarTaxaAprendizado();

            $this->geracaoAtual++;
            $this->quantidadeGeracoes--;
        }
    }

    public function iniciarClassificaoExemplos($letrasTreinamento) {

        $resultadoClassificao = array();

        foreach ($letrasTreinamento AS $letra) {

            $this->vetorX = $letra->getVetorCodigo();

            $this->somaPonderada = $this->somaPonderada();

            asort($this->somaPonderada); // Ordena o somaPonderada do menor para o maior.

            $resultadoClassificao[key($this->somaPonderada)][] = $letra;
        }
        ksort($resultadoClassificao);
        return $resultadoClassificao;
    }

    public function iniciarClassificaoLetra($letra) {

        $this->vetorX = $letra->getVetorCodigo();

        $this->somaPonderada = $this->somaPonderada();

        asort($this->somaPonderada); // Ordena o somaPonderada do menor para o maior.

        return array(key($this->somaPonderada) => $letra);
    }

    public function iniciarMatrizW() {
        for ($i = 0; $i < $this->tamanhoVetorX; $i++) {
            for ($j = 0; $j < $this->quantidadeClusters; $j++) {
                $this->matrizW[$i][$j] = $this->gerarPesosAleatorios();
            }
        }
    }

    public function somaPonderada() {
        $vetorSaida = array();
        for ($j = 0; $j < $this->quantidadeClusters; $j++) {
            $vetorSaida[$j] = 0;
            for ($i = 0; $i < $this->tamanhoVetorX ; $i++) {
                $vetorSaida[$j] += round(pow($this->matrizW[$i][$j] - $this->vetorX[$i], 2), 4);
            }
        }
        return $vetorSaida;
    }

    public function atualizarMatrizW() {
        $listaJ[] = key($this->somaPonderada);
        if ($this->raio > 0) {
            for ($i = $this->raio; $i > 0; $i--) {
                $listaJ[] = (key($this->somaPonderada) - $i) >= 0 ? key($this->somaPonderada) - $i : count($this->somaPonderada) - $i;
                $listaJ[] = (key($this->somaPonderada) + $i) < count($this->somaPonderada) ? key($this->somaPonderada) + $i : $i - 1;
            }
        }
        for ($i = 0; $i < $this->tamanhoVetorX; $i++) {
            foreach ($listaJ as $j) {
                $this->matrizW[$i][$j] = $this->matrizW[$i][$j] + ($this->taxaAprendizado * ($this->vetorX[$i] - $this->matrizW[$i][$j]));
            }
        }
    }

    public function atualizarTaxaAprendizado() {
        $this->taxaAprendizado = ($this->taxaAprendizado > $this->descrescimoTaxaAprendizado) ? round($this->taxaAprendizado - $this->descrescimoTaxaAprendizado, 2) : $this->taxaAprendizado;
    }

    public function gerarPesosAleatorios() {
        $numero = (rand(1, 10) / 10);
        $numeroComSinal = rand(0, 1) ? $numero : $numero * (-1);
        return $numeroComSinal;
    }
}