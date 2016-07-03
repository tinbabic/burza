<?php 

class IndexController extends BaseController
{
	public function index() 
	{
		// Samo preusmjeri na auths podstranicu.
		header( 'Location: ' . __SITE_URL . '/index.php?rt=auths' );
	}
}; 

?>
