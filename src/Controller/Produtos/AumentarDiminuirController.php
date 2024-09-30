<?php

namespace App\Controller\Produtos;

use App\Repository\ProdutoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AumentarDiminuirController extends AbstractController
{
    private ProdutoRepository $produtoRepository;

    public function __construct(ProdutoRepository $produtoRepository)
    {
        $this->produtoRepository = $produtoRepository;
    }

    #[Route('/produto/aumentar/{id}', name: 'produto_aumentar')]
    public function aumentar(int $id): Response
    {
        $produto = $this->produtoRepository->find($id);
        
        if (!$produto) {
            throw $this->createNotFoundException('Produto não encontrado.');
        }

        // Aumentar a quantidade disponível
        $produto->setQuantidadeDisponivel($produto->getQuantidadeDisponivel() + 1);
        $this->produtoRepository->save($produto); // Mudei de salvar para save

        return $this->redirectToRoute('listar_produtos'); // Altere para a rota correta
    }

    #[Route('/produto/diminuir/{id}', name: 'produto_diminuir')]
    public function diminuir(int $id): Response
    {
        $produto = $this->produtoRepository->find($id);
        
        if (!$produto) {
            throw $this->createNotFoundException('Produto não encontrado.');
        }

        // Diminuir a quantidade disponível se for maior que zero
        if ($produto->getQuantidadeDisponivel() > 0) {
            $produto->setQuantidadeDisponivel($produto->getQuantidadeDisponivel() - 1);
            $this->produtoRepository->save($produto); // Mudei de salvar para save
        }

        return $this->redirectToRoute('listar_produtos'); // Altere para a rota correta
    }
}
