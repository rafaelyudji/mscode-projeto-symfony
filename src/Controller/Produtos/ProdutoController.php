<?php

namespace App\Controller\Produtos;

use App\Entity\Categoria;
use App\Entity\Produto;
use App\Repository\ProdutoRepository;
use App\Repository\CategoriaRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProdutoController extends AbstractController
{
    private ProdutoRepository $produtoRepository;
    private CategoriaRepository $categoriaRepository; 
    private EntityManagerInterface $entityManager;

    public function __construct(ProdutoRepository $produtoRepository, CategoriaRepository $categoriaRepository, EntityManagerInterface $entityManager)
    {
        $this->produtoRepository = $produtoRepository;
        $this->categoriaRepository = $categoriaRepository; 
        $this->entityManager = $entityManager;
    }

    #[Route('/produtos', name: 'listar_produtos')]
    public function listar(): Response
    {
        $produtos = $this->produtoRepository->findAll();
        return $this->render('produtos/listar.html.twig', [
            'produtos' => $produtos,
        ]);
    }
    
    #[Route('/produtos/cadastrar', name: 'cadastrar_produto')]
    public function cadastrar(Request $request): Response
    {
        $categorias = $this->categoriaRepository->findAll();
        return $this->render('produtos/cadastrar.html.twig', [
            'categorias' => $categorias, 
        ]);
    }

    #[Route('/produtos/cadastrar/salvar', name: 'cadastrar_produto_salvar', methods: ['POST'])]
    public function salvar(Request $request): Response
    {
        $produto = new Produto();
        $produto->setNome($request->request->get('nome'));
        $produto->setDescricao($request->request->get('descricao'));

        // Busca a categoria pelo ID
        $categoriaId = $request->request->get('categoriaId');
        $categoria = $this->entityManager->getRepository(Categoria::class)->find($categoriaId);
        if (!$categoria) {
            throw $this->createNotFoundException('Categoria não encontrada.');
        }
        $produto->setCategoria($categoria);

        // Conversão de quantidade inicial
        $quantidadeInicial = $request->request->get('quantidadeInicial');
        $produto->setQuantidadeInicial($quantidadeInicial !== null ? (float)$quantidadeInicial : 0.0);
        $produto->setQuantidadeDisponivel($quantidadeInicial !== null ? (float)$quantidadeInicial : 0.0); // Pode ser ajustado conforme a lógica de negócio
        $produto->setValor($request->request->get('valor'));
        $produto->setDataCadastro(new \DateTime());

        // Usar o novo método save
        $this->produtoRepository->save($produto);
        
        return $this->redirectToRoute('listar_produtos');
    }

    #[Route('/produtos/editar/{id}', name: 'produto_editar')]
    public function editar(int $id): Response
    {
        $produto = $this->produtoRepository->find($id);
        if (!$produto) {
            throw $this->createNotFoundException('Produto não encontrado.');
        }
    
        // Busca todas as categorias
        $categorias = $this->categoriaRepository->findAll();
    
        return $this->render('produtos/editar.html.twig', [
            'produto' => $produto,
            'categorias' => $categorias,
            'titulo' => 'Editar produto'
        ]);
    }

    #[Route('/produtos/editar/{id}/salvar', name: 'produto_editar_salvar', methods: ['POST'])]
    public function salvarEdicao(Request $request, int $id): Response
    {
        $produto = $this->produtoRepository->find($id);
        if (!$produto) {
            throw $this->createNotFoundException('Produto não encontrado.');
        }

        $produto->setNome($request->request->get('nome'));
        $produto->setDescricao($request->request->get('descricao'));

        // Busca a categoria pelo ID
        $categoriaId = $request->request->get('categoriaId');
        $categoria = $this->entityManager->getRepository(Categoria::class)->find($categoriaId);
        if (!$categoria) {
            throw $this->createNotFoundException('Categoria não encontrada.');
        }
        $produto->setCategoria($categoria);

        // Conversão de quantidade inicial e disponível
        $quantidadeInicial = $request->request->get('quantidadeInicial');
        $produto->setQuantidadeInicial($quantidadeInicial !== null ? (float)$quantidadeInicial : 0.0);
        
        $quantidadeDisponivel = $request->request->get('quantidadeDisponivel');
        $produto->setQuantidadeDisponivel($quantidadeDisponivel !== null ? (float)$quantidadeDisponivel : 0.0);

        $produto->setValor($request->request->get('valor'));

        // Usar o novo método save
        $this->produtoRepository->save($produto);
        
        return $this->redirectToRoute('listar_produtos');
    }

    #[Route('/produtos/excluir/{id}', name: 'produto_excluir')]
    public function excluir(int $id): Response
    {
        $produto = $this->produtoRepository->find($id);
        if (!$produto) {
            throw $this->createNotFoundException('Produto não encontrado.');
        }

        $entityManager = $this->produtoRepository->getEntityManager();
        $entityManager->remove($produto);
        $entityManager->flush();

        return $this->redirectToRoute('listar_produtos');
    }
}
