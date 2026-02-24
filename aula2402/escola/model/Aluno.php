<?php

namespace escola\model;

class Aluno {
    // Atributos
    private int $ra;
    private string $nome;
    private string $turma;
    private string $instituicao;

    // Construtor para inicializar os dados
    public function __construct(int $ra, string $nome, string $turma, string $instituicao) {
        $this->ra = $ra;
        $this->nome = $nome;
        $this->turma = $turma;
        $this->instituicao = $instituicao;
    }

    // Método matricular
    public function matricular() {
        // Aqui preparamos os dados para o processa.php
        // Em um sistema real, aqui poderíamos validar os dados antes do envio
        return [
            'ra' => $this->ra,
            'nome' => $this->nome,
            'turma' => $this->turma,
            'instituicao' => $this->instituicao,
            'status' => 'Matrícula preparada com sucesso!'
        ];
    }

    // Getters (Caso precise exibir individualmente depois)
    public function getRa(): int { return $this->ra; }
    public function getNome(): string { return $this->nome; }
}