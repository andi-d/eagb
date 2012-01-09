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
<script type="text/javascript">
    jQuery(document).ready(function(){
        jQuery('#smiley-list img').click(function(){
            var text = jQuery(this).attr('alt');
            jQuery('#guestbook-add-body').val(jQuery('#guestbook-add-body').val() + text);
        });
    });
</script>
<div id="add-page">
    <?php echo eaGB_Session::flash('validationError'); ?>
    <div>
        <h2><?php __('ADD_ENTRY') ?></h2>
    </div>
    <form action="?eagb=add" method="post">
        <fieldset>
            <legend><?php __('LEAVE_ENTRY') ?></legend>
            <div id="guestbook-add-name-box">
                <label for="guestbook-add-name"><?php __('NAME'); echo $required['required_name'] ? '*' : '' ?></label>
                <?php if (isset($errors['name'])): ?>
                <p class="validation-error"><?php __($errors['name']['message']);?></p>
                <?php endif;?>
                <input type="text" id="guestbook-add-name" name="guestbook-add-name" value="<?php echo isset($data['name']) ? $data['name'] : '' ?>" />
            </div>
            <div id="guestbook-add-email-box">
                <label for="guestbook-add-email"><?php __('EMAIL'); echo $required['required_email'] ? '*' : '' ?></label>
                <?php if (isset($errors['email'])): ?>
                <p class="validation-error"><?php __($errors['email']['message']);?></p>
                <?php endif;?>
                <input type="text" id="guestbook-add-email" name="guestbook-add-email" value="<?php echo isset($data['email']) ? $data['email'] : '' ?>" />
            </div>
            <div>
                <input type="checkbox" value="1" name="guestbook-add-hide-email" id="guestbook-add-hide-email" />
                <label for="guestbook-add-hide-email"><?php __('HIDE') ?></label>
            </div>
            <div id="guestbook-add-homepage-box">
                <label for="guestbook-add-homepage"><?php __('HOMEPAGE'); echo $required['required_homepage'] ? '*' : '' ?></label>
                <?php if (isset($errors['homepage'])): ?>
                <p class="validation-error"><?php __($errors['homepage']['message']);?></p>
                <?php endif;?>
                <input type="text" id="guestbook-add-homepage" name="guestbook-add-homepage" value="<?php echo $data['homepage'] ?>" />
            </div>

            <div id="guestbook-add-body-box">
                <label for="guestbook-add-body"><?php __('MESSAGE'); echo $required['required_body'] ? '*' : '' ?></label>
                <?php if (isset($errors['body'])): ?>
                <p class="validation-error"><?php __($errors['body']['message']);?></p>
                <?php endif;?>
                <textarea cols="20" rows="5" id="guestbook-add-body" name="guestbook-add-body"><?php echo $data['body'] ?></textarea>
                <?php if (!empty($smileys)): ?>
                <div id="smileys" class="clearfix">
                    <ul id="smiley-list" class="clearfix">
                        <?php foreach($smileys as $smiley): ?>
                        <li><img src="<?php echo eaBaseUrl() . $smiley['url'] ?>" alt="<?php echo $smiley['smiley'] ?>" title="<?php echo $smiley['smiley'] ?>"/></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <?php endif; ?>
            </div>
            <?php if ($useCaptcha): ?>
            <div>
                <label for="guestbook-add-captcha"><?php __('CAPTCHA_DESCRIPTION') ?></label>
                <?php if (isset($errors['captcha'])): ?>
                    <p class="validation-error"><?php __($errors['captcha']['message']);?></p>
                <?php endif;?>
                <input type="text" id="guestbook-add-captcha" name="guestbook-add-captcha" />
                <img src="<?php echo eaBaseUrl() ?>/eagb/captcha/captcha.php" alt="" />
            </div>
            <?php endif; ?>
        </fieldset>
        <input type="submit" value="<?php __('SUBMIT') ?>" />
    </form>
</div>