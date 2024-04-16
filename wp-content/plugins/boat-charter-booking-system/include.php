<?php

/******************************************************************************/
/******************************************************************************/

require_once('define.php');

/******************************************************************************/

require_once(PLUGIN_BCBS_CLASS_PATH.'BCBS.File.class.php');
require_once(PLUGIN_BCBS_CLASS_PATH.'BCBS.Include.class.php');
require_once(PLUGIN_BCBS_CLASS_PATH.'BCBS.Widget.class.php');

BCBSInclude::includeClass(PLUGIN_BCBS_LIBRARY_PATH.'/stripe/init.php',array('Stripe\Stripe'));
BCBSInclude::includeFileFromDir(PLUGIN_BCBS_CLASS_PATH);

/******************************************************************************/
/******************************************************************************/