<?php

namespace App\Entity;

use App\Repository\ProdutoRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProdutoRepository::class)]
class Produto
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $nome = null;

    #[ORM\Column(length: 50)]
    private ?string $descricao = null;

    #[ORM\ManyToOne(targetEntity: Categoria::class, inversedBy: 'produtos')]
    #[ORM\JoinColumn(name: 'categoria_id', referencedColumnName: 'id', nullable: false)]
    private ?Categoria $categoria = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $data_cadastro = null;

    #[ORM\Column]
    private ?float $quantidade_inicial = null;

    #[ORM\Column]
    private ?float $quantidade_disponivel = null;

    #[ORM\Column]
    private ?float $valor = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNome(): ?string
    {
        return $this->nome;
    }

    public function setNome(string $nome): static
    {
        $this->nome = $nome;
        return $this;
    }

    public function getDescricao(): ?string
    {
        return $this->descricao;
    }

    public function setDescricao(string $descricao): static
    {
        $this->descricao = $descricao;
        return $this;
    }

    public function getCategoria(): ?Categoria
    {
        return $this->categoria; // Acessa a categoria
    }

    public function setCategoria(?Categoria $categoria): static // Renomeado para setCategoria
    {
        $this->categoria = $categoria;
        return $this;
    }

    public function getDataCadastro(): ?\DateTimeInterface
    {
        return $this->data_cadastro;
    }

    public function setDataCadastro(\DateTimeInterface $data_cadastro): static
    {
        $this->data_cadastro = $data_cadastro;
        return $this;
    }

    public function getQuantidadeInicial(): ?float
    {
        return $this->quantidade_inicial;
    }

    public function setQuantidadeInicial(float $quantidade_inicial): static
    {
        $this->quantidade_inicial = $quantidade_inicial;
        return $this;
    }

    public function getQuantidadeDisponivel(): ?float
    {
        return $this->quantidade_disponivel;
    }

    public function setQuantidadeDisponivel(float $quantidade_disponivel): static
    {
        $this->quantidade_disponivel = $quantidade_disponivel;
        return $this;
    }

    public function getValor(): ?float
    {
        return $this->valor;
    }

    public function setValor(float $valor): static
    {
        $this->valor = $valor;
        return $this;
    }
}
