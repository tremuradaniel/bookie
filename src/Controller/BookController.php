<?php

namespace App\Controller;

use App\Repository\BookRepository;
use App\Repository\AuthorRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BookController extends AbstractController
{

    private AuthorRepository $authorRepo;
    private BookRepository $bookRepo;

    public function __construct(
        AuthorRepository $authorRepo,
        BookRepository $bookRepo
    ) {
        $this->authorRepo = $authorRepo;
        $this->bookRepo = $bookRepo;
    }

    #[Route('/book', name: 'book')]
    public function index(): Response
    {
        return $this->render('book/index.html.twig', [
            'controller_name' => 'BookController',
        ]);
    }

    #[Route('/search-book', name: 'search-book')]
    public function searchBook(Request $request): Response
    {
        $searchTermType = $request->get("search-term-type");
        $searchTerm = $request->get("search-term");
        $books = [];
        if ($searchTermType == "author") {
            $books = $this->authorRepo->findBooksByAuthorName($searchTerm);
        } else {
            $books = $this->bookRepo->findBooksByTitle($searchTerm);
        }

        return $this->render('book/search-results.html.twig', [
            'books' => $books,
            'searchTerm' => $searchTerm
        ]);
    }
}
