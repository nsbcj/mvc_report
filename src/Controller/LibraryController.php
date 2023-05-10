<?php

namespace App\Controller;

use App\Entity\Library;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\LibraryRepository;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class LibraryController extends AbstractController
{
    /**
     * @Route("/library", name="app_library", methods="GET")
     */
    public function index(): Response
    {
        return $this->render('library/index.html.twig', [
            'controller_name' => 'LibraryController',
        ]);
    }

    /**
     * @Route("/library/create", name="library_create", methods="GET")
     */
     public function createBook(): Response
     {
         return $this->render('library/create.html.twig');
     }

     /**
      * @Route("/library/update/{bookId}", name="library_update", methods="GET")
      */
      public function updateBook(
          LibraryRepository $libraryRepository,
          int $bookId
      ): Response {
          $book = $libraryRepository->find($bookId);

          if (!$book) {
              return $this->redirectToRoute('library_show');
          }

          $data = [
              "book" => $book
          ];

          return $this->render('library/update.html.twig', $data);
      }

      /**
       * @Route("/library/delete/{bookId}", name="library_delete", methods="GET")
       */
       public function deleteBook(
           LibraryRepository $libraryRepository,
           int $bookId
       ): Response {
           $book = $libraryRepository->find($bookId);

           if (!$book) {
               return $this->redirectToRoute('library_show');
           }

           $data = [
               "book" => $book
           ];

           return $this->render('library/delete.html.twig', $data);
       }

     /**
      * @Route("/library/show", name="library_show", methods="GET")
      */
      public function showBooks(
          LibraryRepository $libraryRepository
      ): Response {
          $books = $libraryRepository->findAll();

          $data = [
              "books" => $books
          ];

          return $this->render('library/show.html.twig', $data);
      }

      /**
       * @Route("/library/show/{bookId}", name="library_one_book", methods="GET")
       */
       public function showOneBook(
           LibraryRepository $libraryRepository,
           int $bookId
       ): Response {
           $book = $libraryRepository->find($bookId);

           if (!$book) {
               return $this->redirectToRoute('library_show');
           }

           $data = [
               "book" => $book
           ];

           return $this->render('library/showone.html.twig', $data);
       }

    /**
     * @Route("/library/create", name="library_create_post", methods="POST")
     */
    public function createBookPost(
        ManagerRegistry $doctrine,
        Request $request
    ): Response {
        $title = $request->request->get("title") ?? null;
        $isbn = $request->request->get("isbn") ?? null;
        $author = $request->request->get("author") ?? null;
        $img = $request->request->get("img") ?? null;

        $entityManager = $doctrine->getManager();

        $library = new Library();
        $library->setTitle($title);
        $library->setIsbn($isbn);
        $library->setAuthor($author);
        $library->setImg($img);

        // tell Doctrine you want to (eventually) save the Product
        // (no queries yet)
        $entityManager->persist($library);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        $this->addFlash(
            "notice",
            "Boken '{$title}' har lagts till"
        );

        return $this->redirectToRoute("library_show");
    }

    /**
     * @Route("/library/update", name="library_update_post", methods="POST")
     */
    public function updateBookPost(
        LibraryRepository $libraryRepository,
        Request $request
    ): Response {
        $id = $request->request->get("id") ?? null;

        $title = $request->request->get("title") ?? null;

        $isbn = $request->request->get("isbn") ?? null;

        $author = $request->request->get("author") ?? null;

        $img = $request->request->get("img") ?? null;

        $book = $libraryRepository->find($id);

        if (!$book) {
            return $this->redirectToRoute('library_show');
        }

        $book->setTitle($title);
        $book->setIsbn($isbn);
        $book->setAuthor($author);
        $book->setImg($img);

        // tell Doctrine you want to (eventually) save the Product
        $libraryRepository->save($book, true);

        $this->addFlash(
            "notice",
            "Boken '{$title}' med id '{$id}' har updaterats"
        );

        return $this->redirectToRoute("library_show");
    }

    /**
     * @Route("/library/delete", name="library_delete_post", methods="POST")
     */
    public function deleteBookPost(
        LibraryRepository $libraryRepository,
        Request $request
    ): Response {
        $id = $request->request->get("id") ?? null;

        $book = $libraryRepository->find($id);

        $title = $book->getTitle();

        if (!$book) {
            return $this->redirectToRoute('library_show');
        }

        // tell Doctrine you want to (eventually) save the Product
        $libraryRepository->remove($book, true);

        $this->addFlash(
            "warning",
            "Boken '{$title}' med id '{$id}' har tagits bort"
        );

        return $this->redirectToRoute("library_show");
    }
}
