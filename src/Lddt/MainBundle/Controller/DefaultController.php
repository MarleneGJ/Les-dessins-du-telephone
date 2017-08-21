<?php

namespace Lddt\MainBundle\Controller;

use Lddt\MainBundle\Entity\Category;
use Lddt\MainBundle\Entity\Color;
use Lddt\MainBundle\Entity\Comment;
use Lddt\MainBundle\Entity\Draw;
use Lddt\MainBundle\Entity\Tag;
use Lddt\MainBundle\Form\CommentType;
use Lddt\MainBundle\Form\DrawType;
use Lddt\MainBundle\Form\FormHandler;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller
{
    public function indexAction()
    {
        //Recuperer tous les dessins
        $draws= $this->get('doctrine')
                ->getRepository('LddtMainBundle:Draw')
                ->findAllDraws();
        //passage des données a la vue
        // les clés du tableau asscociatif deviennet le nom des variables dans las vues twig
        $datas = ['draws'=>$draws];
        return $this->render('LddtMainBundle:Default:index.html.twig',$datas);
    }

   /* public function showAction(Request $request){
    $id =$request->get('id');
   $draw =
       $this->get('doctrine')
        ->getRepository('LddtMainBundle:Draw')
        ->findOneBy(array('id'=>$id));
   $datas =['draw'=>$draw];
   return $this->render('LddtMainBundle:Default:show.html.twig',$datas);

    }*/

    /**
     * @Template()
     *
     */
    public function showAction(Draw $draw, Request $request)
    {
        $user= $this->getUser();
        $is_proprio = false;
        if($user == $draw->getAuthor()){
            $is_proprio = true;
        }
        $datas = ['draw'=>$draw, 'is_proprio'=>$is_proprio];
        if($user){
            $form = $this->createForm(CommentType::class, new Comment($draw, $user));
            $datas = ['draw' => $draw, 'form_comment'=>$form->createView(),'is_proprio'=>$is_proprio];
            $em = $this->get('doctrine')->getManager();
            $formHandler = new FormHandler($form, $request, $em);
            if ($formHandler->process()) {
                return $this->redirect($this->generateUrl('lddt_main_show',['id'=>$draw->getId()]));
            }
        }
        return $datas;
    }

//    public function createAction (){
//        //instanciation de l'entité category et hydratation
//        $category = new Category();
//        $category->setName("Accessoire");
//        //1 ter crea color
//        $color=new Color();
//        $color->setName ('rouge');
//        $color->setCode ('FF0000');
//
//       $color2=new Color();
//        $color2->setName ('bleu');
//        $color2->setCode ('000FFF');
//
//        $color3=new Color();
//        $color3->setName ('noir');
//        $color3->setCode ('000000');
//
//        //1 bis instanciation de l'entité draw et hydratation
//        $draw=new Draw();
//        $draw->setTitle('chaussure');
//        $draw->setDrawPath('chaussure.jpg');
//        $draw->setIsOnline(true);
//        $draw->setAuthorName('marie');
//        $draw->setAvatarPath('marie-ico.jpg');
//        $draw->setCreatedAt(new \DateTime());
//        $draw->setUpdatedAt(new \DateTime());
//        //on lie la category et le dessin
//        $draw->setCategory($category);
//        //on lie les couleurs aux dessins
//        $draw->addColor($color);
//        $draw->addColor($color2);
//        $draw->addColor($color3);
//        //2 appel de l'entity manager de doctrine
//        $em = $this->get('doctrine')->getManager();
//        //on persiste l'instance (prepa requete)
//        $em->persist($category);
//        $em->persist($color);
//        $em->persist($color2);
//        $em->persist($color3);
//        $em->persist($draw);
//        //on execute la requete
//        $em->flush();
//
//        return $this->redirect($this->generateUrl('lddt_main_homepage'));
//    }
    public function createAction(Request $request){
        //appel de l'instance DrawType (pour afficher le formulaire)
        //recuperer l'utilisateur connecté
        $author = $this->getUser();
//        var_dump($author);
//        die();
        $datas = [];
        if($author){
        $form=$this->createForm(DrawType::class,new Draw($author));
        $datas=['form'=>$form->createView()];
            $em = $this->get('doctrine')->getManager();
        $formHandler = new FormHandler($form,$request, $em);
        if ($formHandler->process()){
            $this->addFlash('success','Le dessin a bien été créé, il est en attente de modération');
            return $this->redirect($this->generateUrl('lddt_main_homepage'));
            }
        }
        return $this->render('LddtMainBundle:Default:create.html.twig',$datas);
    }

    /**
     * @Template()
     * @param Draw $draw
     * @param Request $request
     */
    public function editAction(Draw $draw, Request $request){
        if(! $this->checkAuthorization($draw->getAuthor())){
            return $this->redirect($this->generateUrl('lddt_main_homepage'));
        }


        //appel de l'instance DrawType (pour afficher le formulaire)
        $form=$this->createForm(DrawType::class,$draw);
        $datas=['form'=>$form->createView(),'draw'=>$draw];
        $em = $this->get('doctrine')->getManager();
        $formHandler = new FormHandler($form,$request, $em);
        if ($formHandler->process()){
            $this->addFlash('success','Le dessin a bien été modifié');
           return $this->redirect($this->generateUrl('lddt_main_homepage'));
        }

        return $datas;
    }
   public function deleteAction(Draw $draw){
       if(! $this->checkAuthorization($draw->getAuthor())){
           return $this->redirect($this->generateUrl('lddt_main_homepage'));
       }
        $em = $this->get('doctrine')->getManager();
        $em->remove($draw);
        $em->flush();
       $this->addFlash('success','Le dessin a bien été supprimé');
       return $this->redirect($this->generateUrl('lddt_main_homepage'));

    }

    /**
     * @Template("LddtMainBundle:Default:index.html.twig")
     * @param Category $category
     * @return array
     */
    public function listDrawsByCatAction (Category $category){
       //Req DQL pour filtrer les dessins d'une catégorie
        $draws = $this->get('doctrine')
            ->getRepository("LddtMainBundle:Draw")
            ->findAllDrawsByCat($category);
        $datas = ['draws'=>$draws,'category'=>$category];
        return $datas;

    }
    /**
     * @Template("LddtMainBundle:Default:index.html.twig")
     * @param Color $color
     * @return array
     */
    public function listDrawsByColorAction(Color $color){
        $draws = $this->get('doctrine')
            ->getRepository("LddtMainBundle:Draw")
            ->findAllDrawsByColor(array($color->getName()));

        $datas = ['draws'=>$draws,'color'=>$color];
        return $datas;
    }

    /**
     * @Template("LddtMainBundle:Default:index.html.twig")
     * @param Tag $tag
     * @return array
     */
    public function listDrawsByTagAction(Tag $tag){
        $draws = $this->get('doctrine')
            ->getRepository("LddtMainBundle:Draw")
            ->findAllDrawsByTag(array($tag->getName()));

        $datas = ['draws'=>$draws,'tag'=>$tag];
        return $datas;
    }

    private function checkAuthorization($instance){
        // return true si le user est admin
        if($this->get('security.authorization_checker')
            ->isGranted('ROLE_ADMIN')){
            return true;
        }
        //return true si le user est proprio
        elseif ($this->getUser()==$instance){
            return true;
        }
        //return false si le user est non autorisé
        else{
            return false;
        }



    }
}





