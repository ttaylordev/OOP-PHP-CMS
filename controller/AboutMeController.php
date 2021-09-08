<?php
class AboutMeController extends Controller{

    function defaultAction(){

        $dbh = DbConnection->getInstance();
        $dbc = $dbh->getConnection();
        
        $pageObj = new Page($dbc);
        $pageObj->findById(2);
        $varArr['pageObj'] = $pageObj;

        $template = new Template('default');
        $template->view('static-page', $varArr);
    }
}