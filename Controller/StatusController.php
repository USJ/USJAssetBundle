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

class StatusController extends Controller
{
    public function indexAction()
    {
        $statuses = $this->container->get('mdb_asset.manager.status')->findAllStatuses();
        
        return $this->render("MDBAssetBundle:Status:index.html.twig", array("statuses" => $statuses));
    }

    public function newAction()
    {
        $status = $this->container->get('mdb_asset.manager.status')->createStatus();
        $form = $this->container->get('mdb_asset.form_factory.status')->createForm();
        $form->setData($status);

        if($request->getMethod() == 'POST' ){
            $form->bind($request);
            if($form->isValid() ) {
                $this->container->get('mdb_asset.manager.status')->saveStatus($status);
                $this->get('session')->getFlashBag()->add('notice', 'Status created!');
                return $this->redirect($this->generateUrl('mdb_asset_status_index'));
            }
        }
        return $this->render("MDBAssetBundle:Status:new.html.twig", array('form' => $form->createView()));
    }
    

    public function editAction(Request $request, $id)
    {
        $status = $this->container->get('mdb_asset.manager.status')->findStatusById($id);
        $form = $this->container->get('mdb_asset.form_factory.status')->createForm();
        $form->setData($status);

        if($request->getMethod() == 'POST' ){
            $form->bind($request);
            if($form->isValid() ) {
                $this->container->get('mdb_asset.manager.status')->saveStatus($status);

                $this->get('session')->getFlashBag()->add('success', 'Status update!');
                return $this->redirect($this->generateUrl('mdb_asset_status_index'));
            }
        }
        return $this->render("MDBAssetBundle:Status:edit.html.twig", array('form' => $form->createView()));
    }

    public function deleteAction(Request $request, $id)
    {
        $statusManager = $this->container->get('mdb_asset.manager.status');

        $status = $statusManager->findStatusById($id);
        $statusManager->deleteStatus($status);
        $request->getSession()->getFlashBag()->set('notice', 'Status deleted');

        return $this->redirect($this->generateUrl('mdb_asset_status_index'));
    }
}

