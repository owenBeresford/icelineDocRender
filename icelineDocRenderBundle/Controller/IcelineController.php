<?php

namespace icelineLtd\icelineDocRenderBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use icelineLtd\icelineDocRenderBundle\PagesCollectionInterface;
use icelineLtd\icelineDocRenderBundle\PageServiceInterface;

/**
 * IcelineController 
 * 
 * @uses Controller
 * @package 
 * @version $id$
 * @author oab1 / Owen Beresford / owen@iceline.ltd.uk  
 * @license AGPL {@link http://www.gnu.org/licenses/agpl-3.0.html}
 */
class IcelineController extends Controller
{
	protected $page;
	protected $render;

	/**
	 * setPages
	 * 
	 * @param PageCollectionInterface $pci 
	 * @return <self>
	 */
	function setPages(PagesCollectionInterface $pci) {
		$this->page=$pci;
		return $this; 
	}

	/**
	 * setPageRenderer
	 * 
	 * @param PageServiceInterface $psi 
	 * @return <self>
	 */
	function setPageRenderer(PageServiceInterface $psi) {
		$this->render=$psi;
		return $this;
	}

	/**
	 * reject
	 * 
	 * @param int $code 
	 * @param string $msg 
	 * @return <JsonResponse>
	 */
	private function reject($code=400, $msg="Incorrect values supplied") {
		return new JsonResponse(['msg'=>$msg], $code);
	}


	/**
	 * renderAction
	 * 
	 * @access public
	 * @return <self>
	 */
	public function renderAction($page=null) {
		if(!$page) { 
			$req=Request::createFromGlobals();
			$page=$req->get('resource');		
		}

		if(!$this->page->exists($page)) {
			return $this->reject(404, "Unknown resource");
		}
		$page=$this->page->toFile($page);
		// all the page rendering objects are hidden behind this line \/ \/
		$page=$this->render->render($page);
		if(is_int($page)) {
			return $this->reject($page, "Dev: You have an error.");
		} else {
			return new Response($page, 200);
		}
	}

}
# vi: ts=4
# vim: ts=4 sw=4 fdm=marker syn=php

