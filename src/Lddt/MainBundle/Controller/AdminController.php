<?php

namespace Lddt\MainBundle\Controller;
use Lddt\MainBundle\Entity\Draw;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdminController extends Controller
{

    /**
     * @Template()
     */
public function indexAction(){
    $draws = $this->get('doctrine')
        ->getRepository('LddtMainBundle:Draw')
        ->findAllDrawsToPushOnline();
    $datas = ['draws'=>$draws];
    return $datas;

}
public function pushOnlineAction(Draw $draw) {
    $draw->setIsOnline(true);
    $em = $this->get('doctrine')->getManager();
    $em -> persist($draw);
    $em -> flush();
    //envoi du mail de confiration de mise en ligne
    $message = \Swift_Message::newInstance()
        ->setSubject("Votre dessin {$draw->getTitle()}")
        ->setFrom('gj_marlene@hotmail.com')
        ->setTo($draw->getAuthor()->getEmail())
        ->setBody($this->renderView('@LddtMain/Emails/confirmation_online.html.twig',['$draw'=>$draw]),'text/html');
        $this->get('mailer')->send($message);


    $this->addFlash('success', 'le dessin '.$draw->getTitle().' est en ligne');
    $this->redirect($this->generateUrl('lddt_main_homepage'));
    return $this->redirect($this->generateUrl('lddt_main_homepage'));
}

}