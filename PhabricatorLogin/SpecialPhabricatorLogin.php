<?php
/**
 * Created by PhpStorm.
 * User: yangboz
 * Date: 13/03/2018
 * Time: 3:11 PM
 */
class SpecialPhabricatorLogin extends SpecialPage{
    function __construct()
    {
        parent::__construct('PhabricatorLoginExtension');
    }

    function execute($parameter){
        if(!$this->userCanExecute()){
            $this->showRestrictionError();
            return;
        }
       // Do your staff

    }
}