<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Groups;
use AppBundle\Entity\User;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;



class GroupController extends FosRestController
{

    /**
     * @Rest\Get("/groups/{id}", name="get_one_groups")
     * @Rest\View()
     *
     *
     */

    public function groupAction( Request $request)
    {
        $groupe = $this->getDoctrine()->getRepository(Groups::class)->find($request->get('id'));

        if (empty($groupe)) {
            return new JsonResponse(['message' => "groupe n'existe pas"], Response::HTTP_NOT_FOUND);
        }


        return $groupe;
    }

    /**
     * @Rest\Get("/groups", name="list_groups")
     * @Rest\View()
     *
     */

    public function listgroupAction(Request $request)
    {
        $groups = $this->getDoctrine()->getRepository(Groups::class)->findAll();
        return $groups;
    }

    /**
     * @Rest\Post("/groups")
     * @Rest\View(StatusCode = Response::HTTP_CREATED)
     * @ParamConverter("groupe", converter="fos_rest.request_body")
     *
     */
    public function createAction(Groups $groupe, Request $request)
    {
        $errors = $this->get('validator')->validate($groupe);
        if (count($errors)){
            return $this->view($errors, Response::HTTP_BAD_REQUEST);
        }

        $em = $this->getDoctrine()->getManager();
        $em->persist($groupe);
        $em->flush();

        return $groupe;
    }

    /**
     * @Rest\Put("/groups/{id}", name="update_groups")
     * @Rest\View()
     *
     *
     */

    public function updateGroupAction( Request $request)
    {
        return $this->updategroup($request, true);
    }

    /**
     * @Rest\Patch("/groups/{id}", name="patch_groups")
     * @Rest\View()
     *
     *
     */
    public function patchGroupAction( Request $request)
    {
        return $this->updategroup($request, false);
    }

    public function updategroup(Request $request, $clearMissing)
    {

        $groupe = $this->getDoctrine()->getRepository(Groups::class)->find($request->get('id'));

        /* @var $groupe Groups*/

        if (empty($groupe))
        {
            return new JsonResponse(['message'=>"groupe not found"],Response::HTTP_NOT_FOUND);
        }
        //$data = json_decode($request->getContent(), true);

        //dump($data);

        $form = $this->createForm(GroupsType::class, $groupe);
        $form->submit($request->request->all(), $clearMissing);

        $em = $this->getDoctrine()->getManager();
        $em->merge($groupe);
        $em->flush();

        return $groupe;
    }

    /**
     * @Rest\Delete("/groups/{id}", name="delete_groupe")
     * @Rest\View()
     *
     *
     */

    public function deleteGroupAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $groupe = $this->getDoctrine()->getRepository(Groups::class)->find($request->get('id'));

        /* @var $groupe Groups*/

        if($groupe)
        {
            $em->remove($groupe);
            $em->flush();
        }
    }


}
