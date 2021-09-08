<?php

class ContactController extends Controller {
    
    function preAction(){
        
        if($_SESSION['has_submitted_the_form'] ?? 0 == 1){   
            
            $dbh = DbConnection::getInstance();
            $dbc = $dbh->getConnection();

            $pageObj = new Page($dbc);
            $pageObj->findBy('ex', 3);
            $variables['pageObj'] = $pageObj;

            $template = new Template('default');
            $template->view('static-page', $variables);
        
            return false;
        }
        return true;
    }
    
    function defaultAction(){
        
        $variables['title'] = '';
        $variables['content'] = '';
        
        $dbh = DbConnection::getInstance();
        $dbc = $dbh->getConnection();
        
        $pageObj = new Page($dbc);
        $pageObj->findBy('id', $this->entityId);
        $variables['pageObj'] = $pageObj;
        
        $template = new Template('default');
        $template->view('./contact/contact_me', $variables);
    }
    function submitContactFormAction() {
       
        $_SESSION['has_submitted_the_form'] = 1;
                
        $variables['title'] = '';
        $variables['content'] = '';
                
        $dbh = DbConnection::getInstance();
        $dbc = $dbh->getConnection();
        
        $pageObj = new Page($dbc);
        $pageObj->findBy('id', 5);  // might be ('contact', 5);
        $variables['pageObj'] = $pageObj;

        // var_dump($pageObj);
          
        $template = new Template('default');
        $template->view('static-page', $variables);

    }
    
}