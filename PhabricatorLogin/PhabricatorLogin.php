<?php
/**
 * Created by PhpStorm.
 * User: yangboz
 * Date: 13/03/2018
 * Time: 3:09 PM
 */
if(!defined('MEDIAWIKI')){
    die("This is not a valid entry point.");
}

$wgExtensionCredits['other'] = array(
    'name' => 'PhabricatorLogin Extension',
    'author' => 'yangboz',
    'descriptionmsg'=>'PhabricatorLogin Extension for REMIX.NETWORK',
    'url'=>'http://remix.network',
);

$dir = dirname(__FILE__);

$wgExtensionMessagesFiles['PhabricatorLogin'] = "$dir/PhabricatorLogin.i18n.php";

$wgAutoloadClasses['SpecialPhabricatorLogin'] = "$dir/SpecialPhabricatorLogin.php";

$wgSpecialPages['PhabricatorLogin'] = 'SpecialPhabricatorLogin';

$wgHooks['UserLoginComplete'][] = 'wfPhabricatorLoginHook';

function wfPhabricatorLoginHook(&$user,&$inject_html){
    //This should be in a message TODO
    $inject_html .=Html::element('p',null,"You're all logged in.");
    return true;
}
