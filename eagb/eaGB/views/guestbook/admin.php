<script type="text/javascript">
    (function($){
        $('document').ready(function(){
            $('.admin-form').hide();
            $('legend').toggle(function(){
                $(this).parents('fieldset').children('.admin-form').show('fast');
            },
            function(){
                $(this).parents('fieldset').children('.admin-form').hide('fast');
            });
        });
    })(jQuery);
</script>
<div id="admin-panel">
    <h2>Adminpanel <small>ea-Style Guestbook v <?php echo $version ?></small></h2>
    <div id="update-notifier">
        <?php if ($newVersionAvailable === true): ?>
        <p class="notification"><?php __('UPDATE_AVAILABLE'); ?></p>
        <?php endif; ?>
    </div>
    <p><?php __('ClICK_TITLE') ?></p>
    <div class="admin-action-box" id="admin-change-language">
        <form action="?eagb=changelanguage" method="post">
            <fieldset>
                <legend><?php __('CHANGE_LANGUAGE'); ?></legend>
                <p class="admin-action-info"><?php __('CHANGE_PASS_INFO');?></p>
                <div class="admin-form">
                    <div>
                        <label for="language"><?php __('LANGUAGE'); ?></label>
                        <select id="language" name="language">
                            <option value="ger" <?php if ($currentLanguage == 'ger') echo 'selected="selected"'?>>Deutsch</option>
                            <option value="eng" <?php if ($currentLanguage == 'eng') echo 'selected="selected"'?>>English</option>
                        </select>
                    </div>
                    <div>
                        <input type="submit" value="<?php __('SAVE') ?>" />
                    </div>
                </div>
            </fieldset>
        </form>
    </div>
    <div class="admin-action-box" id="admin-change-pass">
        <form action="?eagb=changepass" method="post">
            <fieldset>
                <legend><?php __('CHANGE_PASSWORD') ?></legend>
                <p class="admin-action-info"><?php __('CHANGE_ADMIN_PASSWORD') ?></p>
                <div class="admin-form">
                    <div>
                        <label for="current-pass"><?php __('CURRENT_PASSWORD') ?></label>
                        <input type="password" id="current-pass" name="current-pass" />
                    </div>
                    <div>
                        <label for="new-pass"><?php __('NEW_PASSWORD') ?></label>
                        <input type="password" id="new-pass" name="new-pass" />
                    </div>
                    <div>
                        <label for="new-pass-confirm"><?php __('CONFIRM_NEW_PASSWORD') ?></label>
                        <input type="password" id="new-pass-confirm" name="new-pass-confirm" />
                    </div>
                    <div>
                        <input type="submit" value="<?php __('SAVE_PASSWORD') ?>" />
                    </div>
                </div>
            </fieldset>
        </form>
    </div>
    <div class="admin-action-box" id="admin-badlist">
        <form action="?eagb=addbadword" method="post">
            <fieldset>
                <legend><?php __('BAD_WORDS') ?></legend>
                <p class="admin-action-info"><?php __('BADWORDS_DESCRIPTION') ?></p>
                <div class="admin-form">
                    <table>
                        <thead>
                            <tr>
                                <th colspan="2"><?php __('WORD') ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(empty($badWords)): ?>
                            <tr>
                                <td colspan="2"><em><?php __('NO_BADWORDS_DEFINED') ?></em></td>
                            </tr>
                            <?php else: ?>
                                <?php $i=0; ?>
                                <?php foreach($badWords as $badWord): ?>
                                    <tr<?php echo $i%2?' class="altrow"':'' ?>>
                                        <td><?php echo $badWord['word'] ?></td>
                                        <td class="table-action"><a href="?eagb=badworddelete/<?php echo $badWord['id'] ?>"><?php __('DELETE') ?></a></td>
                                    </tr>
                                <?php $i++;?>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                    <div class="input-badword">
                        <label for="word"><?php __('ADD_BADWORD') ?></label>
                        <input type="text" name="word" id="word" />
                    </div>
                    <div class="submit-badword">
                        <input type="submit" value="<?php __('SAVE') ?>" />
                    </div>
                </div>
            </fieldset>
        </form>
    </div>
    <div class="admin-action-box" id="admin-smileys">
        <form method="post" action="?eagb=addsmiley">
            <fieldset>
                <legend><?php __('SMILEYS') ?></legend>
                <p class="admin-action-info"><?php __('SMILEYS_DESCRIPTION') ?></p>
                <div class="admin-form">
                    <table>
                        <thead>
                            <tr>
                                <th><?php __('SMILEY') ?></th>
                                <th colspan="3"><?php __('IMAGE') ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($smileys)): ?>
                            <tr>
                                <td colspan="3">
                                <?php __('NO_SMILEYS_DEFINED') ?>
                                </td>
                            </tr>
                            <?php else: ?>
                            <?php $i=0; ?>
                            <?php foreach ($smileys as $smiley): ?>
                            <tr<?php echo $i%2?' class="altrow"':''?>>
                                <td><?php echo $smiley['smiley'] ?></td>
                                <td><?php echo $smiley['url'] ?></td>
                                <td><img alt="" src="<?php echo eaBaseUrl() . $smiley['url'] ?>" /></td>
                                <td class="table-action"><a href="?eagb=deletesmiley/<?php echo $smiley['id'] ?>"><?php __('DELETE') ?></a></td>
                            </tr>
                            <?php $i++; ?>
                            <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                    <div class="input-smiley">
                        <label for="smiley"><?php __('SMILEY') ?></label>
                        <input name="smiley" id="smiley" type="text" />
                    </div>
                    <div class="input-url">
                        <label for="url"><?php __('URL') ?></label>
                        <input type="text" name="url" id="url" />
                    </div>
                    <div class="submit-smiley">
                        <input type="submit" value="<?php __('SAVE') ?>"/>
                    </div>
                </div>
            </fieldset>
        </form>
    </div>
    <div class="admin-action-box" id="admin-required-fields">
        <form action="?eagb=changerequired" method="post">
            <fieldset>
                <legend><?php __('SET_REQUIRED_FIELDS') ?></legend>
                <p class="admin-action-info"><?php __('REQUIRED_FIELDSDESCRIPTION') ?></p>
                    <div class="admin-form">

                        <?php foreach($fields as $name => $setting): ?>

                        <div>
                            <input value="1" type="checkbox" name="<?php echo str_replace('_', '-', $name)?>" id="<?php echo str_replace('_', '-', $name)?>" <?php echo $setting ? 'checked="checked"' : '' ?> />
                            <label for="<?php echo str_replace('_', '-', $name)?>"><?php echo ucfirst(str_replace('required_', '', $name)) ?></label>
                        </div>
                        
                        <?php endforeach; ?>

                        <div>
                            <input type="submit" value="<?php __('SUBMIT') ?>" />
                        </div>
                    </div>
            </fieldset>
        </form>
    </div>
</div>
