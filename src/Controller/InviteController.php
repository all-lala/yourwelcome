<?php

namespace App\Controller;

use FOS\RestBundle\Controller\AbstractFOSRestController;
use App\Service\InviteService;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\Annotations\View;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Invite;
use App\Exception\ValidatorException;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class InviteController extends AbstractFOSRestController
{
    const TABLE_NOT_FOUND = 'Entity not found';
    
    /**
     * retournes tous les invites
     * 
     * @View(statusCode=200, serializerEnableMaxDepthChecks=true)
     * @Rest\Get(path = "/invite")
     */
    public function getInvites(InviteService $inviteService) {
        $mariageId = $this->getUser()->getMariage()->getId();
        return $inviteService->getInvites($mariageId);
    }
    
    
    /**
     * Retourne un invite
     * 
     * @View(statusCode=200, serializerEnableMaxDepthChecks=true)
     * @Rest\Get(path = "/invite/{inviteId}", name="invite_show")
     */
    public function getInvite(InviteService $inviteService, int $inviteId) {
        $mariageId = $this->getUser()->getMariage()->getId();
        return $inviteService->getInvite($inviteId, $mariageId);
    }
    
    /**
     * Ajoute un invite
     * 
     * @View(statusCode=201)
     * @Rest\Post(path = "/invite")
     * @ParamConverter("invite", converter="fos_rest.request_body")
     */
    public function addInvite(InviteService $inviteService, Invite $invite) {
        try {
            $mariage = $this->getUser()->getMariage();
            $inviteService->addInvite($invite, $mariage);

            return $this->view($invite,
                Response::HTTP_CREATED,
                ['Location' => $this->generateUrl('invite_show', ['inviteId' => $invite->getId(), UrlGeneratorInterface::ABSOLUTE_URL])]);
        } catch (ValidatorException $errors) {
            return $this->view($errors->getErrors(), Response::HTTP_BAD_REQUEST);
        }
    }
    
    /**
     * Ajoute un invite
     *
     * @View(statusCode=200)
     * @Rest\Put(path = "/invite/{inviteId}")
     * @Rest\Patch(path = "/invite/{inviteId}")
     * @ParamConverter("invite", converter="fos_rest.request_body")
     */
    public function updateInvite(InviteService $inviteService, Invite $invite, int $inviteId) {
        if($invite->getId() === $inviteId) {
            try {
                $mariageId = $this->getUser()->getMariage()->getId();
                return $inviteService->updateInvite($invite, $mariageId);
            } catch (ValidatorException $errors) {
                return $this->view($errors->getErrors(), Response::HTTP_BAD_REQUEST);
            }
        }
        throw new BadRequestHttpException();
    }
    
    /**
     * Supprime un invite
     *
     * @View(statusCode=200)
     * @Rest\Delete(path = "/invite/{inviteId}")
     */
    public function deleteInvite(InviteService $inviteService, int $inviteId) {
        $mariageId = $this->getUser()->getMariage()->getId();
        return $inviteService->deleteInvite($inviteId, $mariageId);
    }
}
