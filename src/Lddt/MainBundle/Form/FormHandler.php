<?php

namespace Lddt\MainBundle\Form;


use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;

class FormHandler
{
    private $form;
    private $request;
    private $em;

    public function __construct(Form $form,Request $request,EntityManager $em)
    {
        $this->form = $form;
        $this->request = $request;
        $this->em = $em;
    }

    public function  process(){
        if($this->request->getMethod()=="POST"){
            $this->form->handleRequest($this->request);
            if($this->form->isValid()==true){
                //On persiste les données
                $this->onSuccess($this->form->getData());
                //On return true
                return true;
            }
            return false;
        }
        return false;
    }

    private function onSuccess ($instance){
        $this->em->persist($instance);
        $this->em->flush();
    }
}