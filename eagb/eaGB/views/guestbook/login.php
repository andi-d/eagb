<?php
/**
 * Kurze Beschreibung der Datei
 *
 * Lange Beschreibung der Datei (wenn vorhanden)...
 *
 * LICENSE: Einige Lizenz Informationen
 *
 * @category   
 * @package    
 * @copyright   Copyright (c) 2010 Andreas Derksen andreasderksen.de
 * @license     http://www.andreasderksen.de/license   BSD License
 * @version     $Id:$
 * @link        http://www.andreasderksen.de/package/PackageName
 * @since       Datei vorhanden seit Release 0.0.0
 * @author      Andreas Derksen
 */
?>
<div id="login-page">
    <?php echo isset($loginError)? $loginError : null; ?>
    <form action="?eagb=login" method="post">
        <fieldset>
            <legend><?php __('LOGIN') ?></legend>
            <div>
                <label for="login-name"><?php __('NAME') ?></label>
                <input type="text" name="login-name" id="login-name" />
            </div>
            <div>
                <label for="login-password"><?php __('PASSWORD') ?></label>
                <input type="password" name="login-password" id="login-password" />
            </div>
        </fieldset>
        <div>
            <input type="submit" value="<?php echo __('SUBMIT') ?>" />
        </div>
    </form>
</div>