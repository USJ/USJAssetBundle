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

use MDB\AssetBundle\Document\AssetProperty;
use MDB\AssetBundle\Document\AssetManager;
use MDB\AssetBundle\Form\Type\AssetType;

class AssetController extends Controller
{
    /**
     * Basic listing of the asset
     * 
     * @Route("/assets", name="mdb_asset_asset_index")
     * @Method({"GET"})
     */
    public function indexAction(Request $request)
    {
        $query = $request->query->all();
        if($request->query->get('advance')) {
            $criteria = $query;
            unset($criteria['advance']);
            $assets = $this->container->get('mdb_asset.manager.asset')->findAssetsBy($criteria);
            return $this->render("MDBAssetBundle:Asset:index.html.twig", array("assets" => $assets ));
        }


        $repo = $this->container->get('mdb_asset.manager.asset')->getRepository();
        $router = $this->container->get('router');
        $options = array(
            'decorate' => true,
            'representationField' => 'code',
            'rootOpen' => '',
            'rootClose' => '',
            'childOpen' => '<tr>',
            'childClose' => '</tr>',
            'nodeDecorator' => function($node) use (&$router) {
                    $showRoute = $router->generate('mdb_asset_asset_show', array('id'=>$node['_id']));
                    $row = '<td><a class="level_'.$node['level'].'" href="'.$showRoute.'">'.$node['referenceId'].'</a>'.'</td>';
                    $row .= '<td>'.$node['name'].'</td>';
                    $row .= isset($node['description'])?'<td>'.$node['description'].'</td>':'<td></td>';
                    $row .= isset($node['category'])?'<td>'.$node['category'].'</td>':'<td></td>';

                    return $row;
                }
            );
         $tree = $repo->childrenHierarchy(
             null, /* starting from root nodes */
             false, /* load all children, not only direct */
             $options
         );


        // TODO search for asset
        return $this->render("MDBAssetBundle:Asset:index.html.twig", array("tree" => $tree ));
    }

    /**
     * Create of an asset here.
     * 
     * @Route("/assets/new", name="mdb_asset_asset_new")
     * @Method({"GET","POST"})
     */
    public function newAction(Request $request)
    {
        $asset = $this->container->get('mdb_asset.manager.asset')->createAsset();
        $form = $this->container->get('mdb_asset.form_factory.asset')->createForm();
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

    /**
     * Basic listing of the asset
     * 
     * @Route("/assets/{id}", name="mdb_asset_asset_show")
     * @Method({"GET"})
     */
    public function showAction(Request $request, $id)
    {
        $asset = $this->container->get("mdb_asset.manager.asset")->findAssetBy(array("id" => $id));
        if(!$asset) {
            throw $this->createNotFoundException(sprintf("Asset with ID %s was not found.", $id));
        }
        return $this->render("MDBAssetBundle:Asset:show.html.twig", array("asset" => $asset));
    }

    /**
     * Basic listing of the asset
     * 
     * @Route("/assets/{id}", name="mdb_asset_asset_update")
     * @Method({"PUT"})
     */
    public function updateAction(Request $request, $id)
    {
        $asset = $this->container->get("mdb_asset.manager.asset")->findAssetBy(array("id" => $id));
        
        $orig = $asset->getProperties();
        if($request->isXmlHttpRequest()) {
            $data = json_decode($request->getContent());
        }
        //TODO add update to name also
        $asset->setProperties($data['properties']);
        $this->container->get("doctrine_mongodb")->getManager()->flush($asset);

        if($request->isXmlHttpRequest()){
            return new Response(json_encode($asset),200);
        }
    }

    /**
     * Basic listing of the asset
     * 
     * @Route("/assets/{id}/properties", name="mdb_asset_asset_properties")
     * @Method({"POST"})
     */
    public function postPropertiesAction(Request $request, $id)
    {
        $asset = $this->container->get("mdb_asset.manager.asset")->findAssetBy(array("id" => $id));

        $name = $request->request->get('property_name');
        $value = $request->request->get('property_value');

        $asset->addProperty(array('name' => $name, 'value'=>$value));
        $this->container->get("doctrine_mongodb")->getManager()->flush($asset);
        return $this->redirect($this->generateUrl('mdb_asset_asset_show', array('id'=>$id)));
    }

    /**
     * Delete of asset properties
     * 
     * @Route("/assets/{id}/properties", name="mdb_asset_asset_properties_delete")
     * @Method({"DELETE"})
     */
    public function deletePropertiesAction(Request $request, $id)
    {
        $asset = $this->container->get("mdb_asset.manager.asset")->findAssetBy(array("id" => $id));

        $name = $request->request->get('property_name');
        $value = $request->request->get('property_value');

        $asset->deleteProperty($name, $value);
        $this->container->get("doctrine_mongodb")->getManager()->flush($asset);
        return $this->redirect($this->generateUrl('mdb_asset_asset_show', array('id'=>$id)));
    }

    /**
     * Edit/Update of the an asset
     * 
     * @Route("/assets/{id}/edit", name="mdb_asset_asset_edit")
     */
    public function editAction(Request $request, $id)
    {
        $asset = $this->container->get("mdb_asset.manager.asset")->findAssetBy(array("id"=>$id));
        $form_options['dm'] = $this->getManager();

        $form = $this->createForm(new AssetType(), $asset, $form_options);
        if($request->getMethod() == 'POST') {
            $form->bind($request);
            if($form->isValid()) {
                $dm = $this->getManager();
                $dm->persist($asset);
                $dm->flush();
            }
            $this->get('session')->getFlashBag()->add('notice', 'Asset updated!');
            return $this->redirect($this->generateUrl('mdb_asset_asset_index'));
        }
        return $this->render("MDBAssetBundle:Asset:edit.html.twig", array("form" => $form->createView()));
    }

    private function getAsset($id)
    {
        return $this->getManager()->getRepository('MDBAssetBundle:Asset')->findById($id);
    }
    private function getManager()
    {
        return $this->get('doctrine_mongodb')->getManager();
    }

}
