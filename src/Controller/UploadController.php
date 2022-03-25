<?php

namespace App\Controller;

use App\Entity\Upload;
use App\Form\UploadType;
use App\Repository\UploadRepository;
use App\Service\PalindromeService;
use App\Service\HighlightService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

/**
 * @Route("/")
 */
class UploadController extends AbstractController
{

    /**
     * @Route("/", name="upload_index", methods={"GET"})
     */
    public function index(UploadRepository $uploadRepository): Response
    {
        return $this->render('upload/index.html.twig', [
            'uploads' => $uploadRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="upload_new", methods={"GET","POST"})
     */
    public function new(Request $request, SluggerInterface $slugger, PalindromeService $palindromeService, HighlightService $highlightService): Response
    {
        $upload = new Upload();
        $form = $this->createForm(UploadType::class, $upload);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $textfile = $form->get('uploadFile')->getData();

            if ($textfile) {
                $originalFilename = pathinfo($textfile->getClientOriginalName(), PATHINFO_FILENAME);
              
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$textfile->guessExtension();

                // Move the file to the directory where textfiles are stored
                try {
                    $textfile->move(
                        $this->getParameter('upload_textfiles'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                    throw new FileException(sprintf('Could not get the content of the file "%s".', $this->getPathname()));
                }

                
                $upload->setUploadFile($newFilename);
                $filename = $this->getParameter('kernel.project_dir') . '/public/uploads/upload_textfiles/' . $newFilename;

                $palindromeArr=$palindromeService->doRequest($filename);
                $palindrome=$palindromeArr[0];
                $count=$palindromeArr[1];

                $highlight=$highlightService->highlight($filename, $palindrome);

                $upload->setHighlight($highlight);
                $upload->setPalindrome($palindrome);
                $upload->setPalindromeCount($count);
            }



            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($upload);
            $entityManager->flush();

            return $this->redirectToRoute('upload_index');
        }

        return $this->render('upload/new.html.twig', [
            'upload' => $upload,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="upload_show", methods={"GET"})
     */
    public function show(Upload $upload): Response
    {
        return $this->render('upload/show.html.twig', [
            'upload' => $upload,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="upload_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Upload $upload, SluggerInterface $slugger, PalindromeService $palindromeService, HighlightService $highlightService): Response
    {
        $form = $this->createForm(UploadType::class, $upload);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $textfile = $form->get('uploadFile')->getData();

            if ($textfile) {
                $originalFilename = pathinfo($textfile->getClientOriginalName(), PATHINFO_FILENAME);

                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$textfile->guessExtension();

                // Move the file to the directory where textfiles are stored
                try {
                    $textfile->move(
                        $this->getParameter('upload_textfiles'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                    throw new FileException(sprintf('Could not get the content of the file "%s".', $this->getPathname()));
                }
               
                $upload->setUploadFile($newFilename);
                $filename = $this->getParameter('kernel.project_dir') . '/public/uploads/upload_textfiles/' . $newFilename;

                $palindromeArr=$palindromeService->doRequest($filename);
                $palindrome=$palindromeArr[0];
                $count=$palindromeArr[1];

             
                $highlight=$highlightService->highlight($filename, $palindrome);
              
                $upload->setHighlight($highlight);
                $upload->setPalindrome($palindrome);
               

                $upload->setPalindromeCount($count);
            }
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('upload_index');
        }

        return $this->render('upload/edit.html.twig', [
            'upload' => $upload,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="upload_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Upload $upload): Response
    {
        if ($this->isCsrfTokenValid('delete'.$upload->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($upload);
            $entityManager->flush();
        }

        return $this->redirectToRoute('upload_index');
    }
}