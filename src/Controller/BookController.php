<?php

namespace App\Controller;

use Exception;
use App\Entity\Book;
use App\Entity\Author;
use App\Form\BookType;
use App\Repository\BookRepository;
use App\Repository\AuthorRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

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

    #[Route('/book/{bookId}', name: 'book')]
    public function book($bookId): Response
    {
        $book = $this->bookRepo->find($bookId);

        return $this->render('book/book.html.twig', [
            'book' => $book,
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

    #[Route('/book-form', name: 'book-form')]
    public function bookForm(Request $request, EntityManagerInterface $entityManager): Response
    {
        $book = new Book();
        $author = new Author();

        $book->addAuthor($author);

        $form = $this->createForm(BookType::class, $book);

        $form->handleRequest($request);

        try {
            if ($form->isSubmitted() && $form->isValid()) {
                $book = $form->getData();

                $entityManager->persist($author);
                $entityManager->persist($book);
                $entityManager->flush($author);

                return $this->redirectToRoute('book', ["bookId" => $book->getId()]);
            }
        } catch (UniqueConstraintViolationException $e) {
            $this->addFlash(
                'error',
                'Book/author already present!'
            );
            return $this->redirectToRoute("book-form");
        } catch (Exception $e) {
            var_dump("Something went wrong:" , $e);
        }

        return $this->renderForm('book/form.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/search-book-author', name: 'search-book-author')]
    public function searchBookAuthor(Request $request): JsonResponse
    {
        $params = $request->request->all();

        try {
            $searchTerm = $params["searchKey"];
            $response = new JsonResponse(['data' => $this->bookRepo->getBookAuthor($searchTerm)]);
        } catch (Exception $e) {
            var_dump($e);
        }

        return $response;
    }
}
