<?php

namespace App\Controller;

use App\Entity\Book;
use App\Entity\Author;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BookController extends AbstractController
{
    #[Route('/book', name: 'book')]
    public function index(): Response
    {
        return $this->render('book/index.html.twig', [
            'controller_name' => 'BookController',
        ]);
    }

    #[Route('/search-book', name: 'search-book')]
    public function searchBook(Request $request, ManagerRegistry $doctrine): Response
    {
        $searchTermType = $request->get("search-term-type");
        $searchTerm = $request->get("search-term");
        $books = [];
        if ($searchTermType == "author") {
            $books = $doctrine->getRepository(Author::class)->findBooksByAuthorName($searchTerm);
        } else {
            $books = $doctrine->getRepository(Book::class)->findBooksByTitle($searchTerm);
        }
        
        return $this->render('book/search-results.html.twig', [
            'books' => $books,
            'searchTerm' => $searchTerm
        ]);
    }
}
