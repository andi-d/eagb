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
<div id="guestbook">
    <div>
        <h2><?php __('WELCOME')?></h2>
        <p><?php __('SITE_DESCRIPTION') ?></p>
    </div>
    <?php if(!empty($entries)): ?>
    <ul>
        <?php foreach ($entries as $entry) : ?>
            <li class="guestbook-entry">
                <?php if (eaGB_Session::read('userId')): ?>
                    <div class="admin-actions">
                        <a class="delete-action" href="?eagb=delete/<?php echo $entry['id'] ?>" title="<?php __('DELETE_ENTRY') ?>"><?php __('DELETE_ENTRY') ?></a>
                    </div>
                <?php endif ?>
                <div class="guestbook-header clearfix">
                    <div class="guestbook-name">
                        <?php echo empty($entry['name']) ? __('UNKNOWN', true) : $entry['name'] ?>
                    </div>
                    <div class="guestbook-date">
                        <?php echo ($entry['hide_email'] || empty($entry['email'])) ? '' : '<span class="guestbook-email"><a href="mailto:' . $entry['email'] . '">' . $entry['email'] . '</a></span>'  ?>
                        <?php echo $entry['homepage'] == 'http://' ? '' :  '<a href="' . $entry['homepage'] .'" rel="nofollow">' . $entry['homepage'] . '</a>' ?>
                    </div>
                </div>
                <div class="guestbook-subheader">
                        <?php echo date('d.m.Y H:i', strtotime($entry['created'])) ?>
                </div>
                <div class="guestbook-body">
                    <p>
                        <?php echo nl2br($entry['body']) ?>
                    </p>
                </div>
            </li>
        <?php endforeach ?>
    </ul>
    <p style="text-align: center;">
        <span>
            <?php if ($page - 1 != 0): ?>
            <a href="?eagb=index/<?php echo $page - 1 ?>">&larr;</a>
            <?php else: ?>
            &larr;
            <?php endif; ?>
        </span>
        <?php for($i = 0; $i < $pages; $i++): ?>
        <span><a href="?eagb=index/<?php echo $i+1 ?>"><?php echo $i+1; ?></a></span>
        <?php endfor; ?>
        <span>
            <?php if ($page < $pages): ?>
            <a href="?eagb=index/<?php echo $page + 1 ?>">&rarr;</a>
            <?php else: ?>
            &rarr;
            <?php endif; ?>
        </span>
    </p>
    <?php else: ?>
        <p><?php __('NO_ENTRIES_FOUND') ?></p>
    <?php endif; ?>
</div>