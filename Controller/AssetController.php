<?php
/**
 * This controller provide an REST interface for assets model
 * 
 * @author  Marco Leong <marcogood411@gmail.com>
 */
namespace MDB\AssetBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class AssetController extends Controller
{
    public function indexAction(Request $request)
    {
        $assets = $this->get("mdb_asset.manager.asset")->findAllAssets();
        
        return $this->render("MDBAssetBundle:Asset:index.html.twig", array("assets" => $assets ));
    }

    public function newAction(Request $request)
    {
        $asset = $this->container->get('mdb_asset.manager.asset')->createAsset();
        $form = $this->container->get('mdb_asset.form_factory.asset')->createForm();
        $form->setData($asset);

        if($request->getMethod() == 'POST') {
            $form->bind($request);
            if($form->isValid()) {
                $asset = $form->getData();
                $this->container->get('mdb_asset.manager.asset')->saveAsset($asset);
                $this->get('session')->getFlashBag()->add('success', 'Asset created!');
                return $this->redirect($this->generateUrl('mdb_asset_asset_index'));
            }
        }
        return $this->render("MDBAssetBundle:Asset:new.html.twig", array("form" => $form->createView()));
    }

    public function showAction(Request $request, $id)
    {
        $asset = $this->container->get("mdb_asset.manager.asset")->findAssetById($id);
        
        if(!$asset) {
            throw $this->createNotFoundException(sprintf("Asset with ID %s was not found.", $id));
        }

        return $this->render("MDBAssetBundle:Asset:show.html.twig", array("asset" => $asset));
    }

    public function postPropertiesAction(Request $request, $id)
    {
        $asset = $this->container->get("mdb_asset.manager.asset")->findAssetBy(array("id" => $id));

        $name = $request->request->get('property_name');
        $value = $request->request->get('property_value');

        $asset->addProperty($name, $value);

        $this->container->get("mdb_asset.manager.asset")->saveAsset($asset);
        return $this->redirect($this->generateUrl('mdb_asset_asset_show', array('id'=>$id)));
    }


    public function deletePropertiesAction(Request $request, $id)
    {
        $asset = $this->container->get("mdb_asset.manager.asset")->findAssetBy(array("id" => $id));

        $name = $request->request->get('property_name');
        $value = $request->request->get('property_value');

        $asset->deleteProperty($name, $value);

        $this->container->get("mdb_asset.manager.asset")->saveAsset($asset);
        return $this->redirect($this->generateUrl('mdb_asset_asset_show', array('id'=>$id)));
    }


    public function editAction(Request $request, $id)
    {
        $asset = $this->container->get("mdb_asset.manager.asset")->findAssetBy(array("id"=>$id));
        $form = $this->container->get("mdb_asset.form_factory.asset")->createForm();
        $form->setData($asset);

        if($request->getMethod() == 'POST') {
            $form->bind($request);
            if($form->isValid()) {
                $this->container->get("mdb_asset.manager.asset")->saveAsset($asset);
            }
            $this->get('session')->getFlashBag()->add('notice', 'Asset updated!');
            return $this->redirect($this->generateUrl('mdb_asset_asset_index'));
        }
        return $this->render("MDBAssetBundle:Asset:edit.html.twig", array("form" => $form->createView()));
    }

    public function deleteAction($id)
    {
        $manager = $this->container->get("mdb_asset.manager.asset");
        $asset = $manager->findAssetById($id);
        $manager->deleteAsset($asset);
        
        return $this->redirect($this->generateUrl('mdb_asset_asset_index'));
    }

}
