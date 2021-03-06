<?php

class Kmeans
{
    public $geracaoAtual;

    public $tamanhoVetorX; // Tamanho do vetor de entrada. (Vetor da letra)

    public $centroides;
    public $centroidesAux;
    public $mediasIguais;

    public $letrasCentroideInicial;

    public $quantidadeClusters; // Quantidade de classes a serem classificadas.

    function __construct($dados) {
        $this->geracaoAtual = 0;

        $this->tamanhoVetorX = 63;

        $this->centroides = array();
        $this->centroidesAux = array();
        $this->mediasIguais = false;

        $this->letrasCentroideInicial = array();

        $this->quantidadeClusters = (int) $dados['quantidade_clusters'];
    }

    public function iniciarTreinamento($letrasTreinamento) {

        $this->iniciarCentroides($letrasTreinamento);

        while ($this->mediasIguais === false) {

            $this->geracaoAtual++;

            foreach ($letrasTreinamento AS $letra) {
                if (!in_array($letra->getNome(), $this->letrasCentroideInicial)) {
                    $centroideMaisProximo = $this->distaciaEuclidiana($letra->getVetorCodigo());
                    $this->centroides[$centroideMaisProximo]['letras'][] = $letra;
                }
            }

            $this->guardarMediasAntigas();
            $this->atualizarMediaCentroides();

            $this->mediasIguais = $this->ehMediasIguais();

            $this->letrasCentroideInicial = array();
        }
        unset($this->centroidesAux);
        unset($this->mediasIguais);
        unset($this->letrasCentroideInicial);
    }

    public function iniciarClassificaoExemplos($letrasTreinamento) {

        $resultadoClassificao = array();

        foreach ($letrasTreinamento AS $letra) {
            $centroideMaisProximo = $this->distaciaEuclidiana($letra->getVetorCodigo());
            $resultadoClassificao[$centroideMaisProximo][] = $letra;
        }
        ksort($resultadoClassificao);
        return $resultadoClassificao;
    }

    public function iniciarClassificaoLetra($letra) {
        $centroideMaisProximo = $this->distaciaEuclidiana($letra->getVetorCodigo());
        return array($centroideMaisProximo => $letra);
    }

    public function iniciarCentroides($letrasTreinamento) {
        shuffle($letrasTreinamento);
        for ($j = 0; $j < $this->quantidadeClusters; $j++) {
            $this->centroides[$j]['media'] = $letrasTreinamento[$j]->getVetorCodigo();
            $this->centroides[$j]['letras'][] = $letrasTreinamento[$j];
            $this->letrasCentroideInicial[] = $letrasTreinamento[$j]->getNome();
        }
    }

    public function distaciaEuclidiana($vetorX) {
        $distacia = array();
        for ($j = 0; $j < $this->quantidadeClusters; $j++) {
            $distacia[$j] = 0;
            for ($i = 0; $i < $this->tamanhoVetorX ; $i++) {
                $distacia[$j] += round(pow($vetorX[$i] - $this->centroides[$j]['media'][$i], 2), 4);
            }
            $distacia[$j] = sqrt($distacia[$j]);
        }
        asort($distacia);
        return key($distacia);
    }

    public function guardarMediasAntigas() {
        for ($j = 0; $j < $this->quantidadeClusters; $j++) {
            $this->centroidesAux[$j]['media'] = $this->centroides[$j]['media'];
        }
    }

    public function atualizarMediaCentroides() {
        $medias = array();
        for ($i = 0; $i < $this->tamanhoVetorX; $i++) {
            $medias[$i] = 0;
        }
        for ($j = 0; $j < $this->quantidadeClusters; $j++) {
            foreach ($this->centroides[$j]['letras'] AS $letra) {
                foreach ($letra->getVetorCodigo() AS $indice => $codigo) {
                    $medias[$indice] += $codigo;
                }
            }
            $quantidadeLetrasCluster = count($this->centroides[$j]['letras']);
            if ($quantidadeLetrasCluster > 0) {
                foreach ($medias AS $indice => $media) {
                    $this->centroides[$j]['media'][$indice] = $media / $quantidadeLetrasCluster;
                }
                $this->centroides[$j]['letras'] = array();
            }
        }
    }

    public function ehMediasIguais() {
        for ($j = 0; $j < $this->quantidadeClusters; $j++) {
            if ($this->centroidesAux[$j]['media'] !== $this->centroides[$j]['media']) {
                return false;
            }
        }
        return true;
    }
}