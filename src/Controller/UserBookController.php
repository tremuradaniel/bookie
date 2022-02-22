<?php

namespace App\Controller;

use App\Repository\ShelveRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

class UserBookController extends AbstractController
{

    private $userBooksRepository;

    public function __construct(ShelveRepository $userBooksRepository)
    {
        $this->userBooksRepository = $userBooksRepository;
    }


    #[Route('/book_list', name: 'user_book_list')]
    public function index(): Response
    {
        return $this->render('user_books/user_books.html.twig', [
            'list_user_books_url' => 'list_user_books',
        ]);
    }

    #[Route('/list_user_books/{shelve}', name: 'list_user_books')]
    public function list_user_book(string $shelve): JsonResponse
    {
        $user = $this->getUser()->getId();
        $userBooks = $this->userBooksRepository->getUserBooksFromShelve($user ,$shelve);
        return new JsonResponse($userBooks);
    }
}
