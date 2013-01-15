<?php
/**
 * This controller give web view of all the asset
 * 
 * @author  Marco Leong <marcogood411@gmail.com>
 */
namespace MDB\AssetBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

use MDB\AssetBundle\Document\Asset;
use MDB\AssetBundle\Document\Status;
use MDB\AssetBundle\Document\AssetProperty;
use MDB\AssetBundle\Form\Type\StatusType;

class StatusController extends Controller
{
    /**
     * @Route("/", name="mdb_asset_status_index")
     * @Method({"GET"})
     */
    public function indexAction()
    {
        $status = $this->getManager()->getRepository('MDBAssetBundle:Status')->findAll();
        return $this->render("MDBAssetBundle:Status:index.html.twig",
            array(
                "statuses" => $status
            )
        );
    }

    /**
     * @Route("/new", name="mdb_asset_status_new")
     * @Method({"GET","POST"})
     */
    public function newAction()
    {
        $request = $this->getRequest();
        $status = $this->container->get('mdb_asset.manager.status')->createStatus();
        $form = $this->createForm(new StatusType(), $status);
        if($request->getMethod() == 'POST' ){
            $form->bind($request);
            if($form->isValid() ) {
                $dm = $this->getManager();
                $dm->persist($status);
                $dm->flush();
                
                $this->get('session')->getFlashBag()->add('notice', 'Status created!');
                return $this->redirect($this->generateUrl('mdb_asset_status_index'));
            }
        }
        return $this->render("MDBAssetBundle:Status:new.html.twig", array('form' => $form->createView()));
    }
    
    /**
     * @Route("/{id}/edit", name="mdb_asset_status_edit")
     * @Method({"GET","POST","PUT"})
     */
    public function editAction(Request $request, $id)
    {
        $request = $this->getRequest();
        $status = $this->container->get('mdb_asset.manager.status')->findStatusById($id);
        $form = $this->createForm(new StatusType(), $status);
        if($request->getMethod() == 'POST' ){
            $form->bind($request);
            if($form->isValid() ) {
                $dm = $this->getManager();
                $dm->flush($status); 

                $this->get('session')->getFlashBag()->add('notice', 'Status update!');
                return $this->redirect($this->generateUrl('mdb_asset_status_index'));
            }
        }
        return $this->render("MDBAssetBundle:Status:edit.html.twig", array('form' => $form->createView()));
    }

    /**
     * @Route("/{id}/delete", name="mdb_asset_status_delete")
     * @Method({"GET","DELETE"})
     */
    public function deleteAction(Request $request, $id)
    {
        $statusManager = $this->container->get('mdb_asset.manager.status');

        $status = $statusManager->findStatusById($id);
        $statusManager->deleteStatus($status);
        $request->getSession()->getFlashBag()->set('notice', 'Status deleted');

        return $this->redirect($this->generateUrl('mdb_asset_status_index'));
    }

    private function getManager()
    {
        return $this->container->get('doctrine_mongodb')->getManager();
    }
}

