<?php
include 'eagb/eagb.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>ea-Style Guestbook Demo</title>

        <?php echo eaLoadTheme('standard') ?>
        <link rel="stylesheet" type="text/css" href="/css/style.css" />
    </head>
    <body>
        <div id="container">
            <div id="header">
                <div id="branding">
                    <h1><a href="/">ea-Style Guestbook Demo</a></h1>
                    <p>Demonstration Page</p>
                </div>
            </div>
            <div id="navigation">
                <ul>
                    <li><a href="/demo.php"><?php __('OVERVIEW'); ?></a></li>
                    <li><a href="?eagb=add"><?php __('ADD'); ?></a></li>
                    <?php if (isset($_SESSION['userId'])): ?>
                    <li>
                        <a href="?eagb=admin">Adminpanel</a> <a href="?eagb=logout"><?php __('LOGOUT') ?></a>
                        <?php else: ?>
                    </li>
                    <li>
                        <a href="?eagb=login"><?php __('LOGIN') ?></a>
                    </li>
                    <?php endif; ?>
                </ul>
            </div>
            <div id="body">
                <div id="content">
                    <?php echo $eaGB ?>
                </div>
            </div>
            <div id="footer">
                <p><?php echo date('Y') ?> &copy; Andreas Derksen - <a href="http://ea-style.de/">Webdesign Agentur</a></p>
            </div>
        </div>
    </body>
</html>
