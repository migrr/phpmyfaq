<?php
/**
 * Frontend to edit an instance.
 *
 * PHP Version 5.5
 *
 * This Source Code Form is subject to the terms of the Mozilla Public License,
 * v. 2.0. If a copy of the MPL was not distributed with this file, You can
 * obtain one at http://mozilla.org/MPL/2.0/.
 *
 * @category  phpMyFAQ
 *
 * @author    Thorsten Rinne <thorsten@phpmyfaq.de>
 * @copyright 2012-2017 phpMyFAQ Team
 * @license   http://www.mozilla.org/MPL/2.0/ Mozilla Public License Version 2.0
 *
 * @link      http://www.phpmyfaq.de
 * @since     2012-04-16
 */
if (!defined('IS_VALID_PHPMYFAQ')) {
    $protocol = 'http';
    if (isset($_SERVER['HTTPS']) && strtoupper($_SERVER['HTTPS']) === 'ON') {
        $protocol = 'https';
    }
    header('Location: '.$protocol.'://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['SCRIPT_NAME']));
    exit();
}

?>
    <header>
        <h2 class="page-header"><i aria-hidden="true" class="fa fa-wrench"></i> <?php echo $PMF_LANG['ad_menu_instances']; ?></h2>
    </header>
<?php
if ($user->perm->checkRight($user->getUserId(), 'editinstances')) {
    $instanceId = PMF_Filter::filterInput(INPUT_GET, 'instance_id', FILTER_VALIDATE_INT);

    $instance = new PMF_Instance($faqConfig);
    $instanceData = $instance->getInstanceById($instanceId);

    ?>
    <form class="form-horizontal" action="?action=updateinstance" method="post" accept-charset="utf-8">
        <input type="hidden" name="instance_id" value="<?php echo $instanceData->id ?>" />
        <div class="control-group">
            <label class="control-label"><?php echo $PMF_LANG['ad_instance_url'] ?>:</label>
            <div class="controls">
                <input type="url" name="url" id="url" required="required" value="<?php echo $instanceData->url ?>">
            </div>
        </div>
        <div class="control-group">
            <label class="control-label"><?php echo $PMF_LANG['ad_instance_path'] ?>:</label>
            <div class="controls">
                <input type="text" name="instance" id="instance" required="required"
                       value="<?php echo $instanceData->instance ?>">
            </div>
        </div>
        <div class="control-group">
            <label class="control-label"><?php echo $PMF_LANG['ad_instance_name'] ?>:</label>
            <div class="controls">
                <input type="text" name="comment" id="comment" required="required"
                       value="<?php echo $instanceData->comment ?>">
            </div>
        </div>
        <div class="control-group">
            <label class="control-label"><?php echo $PMF_LANG['ad_instance_config'] ?>:</label>
            <div class="controls">
            <?php
            foreach ($instance->getInstanceConfig($instanceData->id) as $key => $config) {
                echo '<span class="uneditable-input">'.$key.': '.$config.'</span><br/>';
            }
    ?>
            </div>
        </div>
        <div class="form-group">
            <button class="btn btn-primary" type="submit">
                <?php echo $PMF_LANG['ad_instance_button'] ?>
            </button>
            <a class="btn btn-info" href="?action=instances">
                <?php echo $PMF_LANG['ad_entry_back'] ?>
            </a>
        </div>
    </form>
<?php

} else {
    echo $PMF_LANG['err_NotAuth'];
}
