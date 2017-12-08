<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Movie;
use AppBundle\Form\MovieType;

/**
 * Movie controller.
 *
 * @Route("/movie")
 */
class MovieController extends Controller
{
    /**
     * Lists all Movie entities.
     *
     * @Route("/", name="movie_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $movies = $em->getRepository('AppBundle:Movie')->findAll();

        return $this->render('movie/index.html.twig', array(
            'movies' => $movies,
        ));
    }

    /**
     * Creates a new Movie entity.
     *
     * @Route("/new", name="movie_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $movie = new Movie();
        $form = $this->createForm('AppBundle\Form\MovieType', $movie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($movie);
            $em->flush();

            return $this->redirectToRoute('movie_show', array('id' => $movie->getId()));
        }

        return $this->render('movie/new.html.twig', array(
            'movie' => $movie,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Movie entity.
     *
     * @Route("/{id}", name="movie_show")
     * @Method("GET")
     */
    public function showAction(Movie $movie)
    {
        $deleteForm = $this->createDeleteForm($movie);

        return $this->render('movie/show.html.twig', array(
            'movie' => $movie,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Movie entity.
     *
     * @Route("/{id}/edit", name="movie_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Movie $movie)
    {
        $deleteForm = $this->createDeleteForm($movie);
        $editForm = $this->createForm('AppBundle\Form\MovieType', $movie);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($movie);
            $em->flush();

            return $this->redirectToRoute('movie_edit', array('id' => $movie->getId()));
        }

        return $this->render('movie/edit.html.twig', array(
            'movie' => $movie,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Movie entity.
     *
     * @Route("/{id}", name="movie_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Movie $movie)
    {
        $form = $this->createDeleteForm($movie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($movie);
            $em->flush();
        }

        return $this->redirectToRoute('movie_index');
    }

    /**
     * Delete a movie entity by ajax
     * @Route("/{id}/delete", name="movie_ajax_delete")
     * @Method("POST")
     */
    public function deleteAjaxAction(Request $request, $id)
    {
        //This is optional. Do not do this check if you want to call the same action using a regular request.
        if (!$request->isXmlHttpRequest()) {
            return new JsonResponse(array(
                'status' => 'danger',
                'message' => 'You can access this only using Ajax!'), 400);
        }

        $em = $this->getDoctrine()->getManager();
        $movie = $em->getRepository('AppBundle:Movie')->find($id);

        if($movie){
            $em->remove($movie);
            $em->flush();
            return new JsonResponse(array(
                'status' => 'success',
                'message' => 'Movie "'.$movie->getName().'" deleted',
            ), 200);
        }else{
            return new JsonResponse(array(
                'status' => 'danger',
                'message' => 'Movie not found'), 400);
        }

    }

    /**
     * Creates a form to delete a Movie entity.
     *
     * @param Movie $movie The Movie entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Movie $movie)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('movie_delete', array('id' => $movie->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
