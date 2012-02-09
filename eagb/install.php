<?php
require_once 'bootstrap.php';
$language = isset($_GET['language']) ? $_GET['language'] : 'ger';
switch ($language) {
    case 'eng':
        eaGB_Session::write('installLanguage', 'eng');
        break;
    case 'ger':
    default:
        eaGB_Session::write('installLanguage', 'ger');
        break;
}
try {
    eaGB_Translator::getInstance()->init('install', eaGB_Session::read('installLanguage'));
} catch (Exception $e) {
    die($e->getMessage());
}
if (!empty($_POST)) {
    $supportedLanguages = array('ger', 'eng');
    $settings = array(
        'sessionLifetime'   => "+10 minutes",
        'theme'             => "standard",
        'getParam'          => "eagb",
        'userSessionKey'    => "eagb_user",
        'hash'              => "sha1",
        'salt'              => uniqid(),
        'locale'            => in_array($_POST['language'], $supportedLanguages) ? $_POST['language'] : 'ger',
        'version'           => 2.1,
        'pageLimit'         => 10,
        'updateUrl'         => 'http://ea-style.de/version.php'
    );
    
    $config = new eaGB_Config($settings);
    
    define('DATABASE_TYPE', (isset($_POST['database-type']) AND $_POST['database-type'] == 'mysql') ? 'mysql' : 'sqlite');
    
    if (DATABASE_TYPE == 'mysql') {
        $config['dsn'] = eaGB_Database::buildMysqlDsn($_POST['mysql-host']);
        $config['user'] = $_POST['mysql-user'];
        $config['password'] = $_POST['mysql-password'];
        $schemaFile = _EA_ROOT . '/install/mysql.database.schema.sql';
        $dataFile = _EA_ROOT . '/install/mysql.database.data.sql';
    } else {
        $config['dsn'] = eaGB_Database::buildSqliteDsn();
        $config['user'] = '';
        $config['password'] = '';
        
        $schemaFile = _EA_ROOT . '/install/sqlite.database.schema.sql';
        $dataFile   = _EA_ROOT . '/install/sqlite.database.data.sql';
    }
    
    $dataQueries   = parseQueries($dataFile);
    $schemaQueries = parseQueries($schemaFile);
    
    try {
        // Set up database
        $dbh = new PDO($config['dsn'], $config['user'], $config['password'], array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
        
        if (DATABASE_TYPE == 'mysql') {
            $dbName = filter_input(INPUT_POST, 'mysql-db', FILTER_SANITIZE_STRING);
            $result = $dbh->query('SHOW DATABASES');
            foreach ($result as $db) {
                $databases[] = $db['Database'];
            }
            if (!in_array($dbName, $databases)) { 
                // Must have permissions!!!
                $dbh->query(sprintf('CREATE DATABASE IF NOT EXISTS `%s`;', $dbName));
            }
            $dbh->query(sprintf('USE `%s`', $dbName));
        }
        
        $dbh->beginTransaction();
        foreach ($schemaQueries as $schemaQuery) 
            $dbh->query($schemaQuery);
        
        foreach ($dataQueries as $dataQuery) 
            $dbh->query($dataQuery);
        $dbh->commit();
        
        // Set up config
        $configFile = _EA_ROOT . '/config/settings.php';
        if (file_exists($configFile)) {
            @unlink($configFile . '.bak');
            rename($configFile, $configFile . '.bak');
        }
        
        if (DATABASE_TYPE == 'mysql')
            $config['dsn'] = eaGB_Database::buildMysqlDsn($_POST['mysql-host'], $_POST['mysql-db']);
        
        $config->save($configFile);
        
        define('INSTALL_SUCCESS', true);
        
    } catch (PDOException $ex) {
        die('<h1>Database Error</h1><p>' . $ex->getMessage()) . '</p>';
    } catch (Exception $ex) {
        die('<h1>Error</h1><p>' . $ex->getMessage()) . '</p>';
    }
}

function parseQueries($sqlFile) {
    $sql = file_get_contents($sqlFile);
    return preg_split('/(?<=;)\s*(?=CREATE|UPDATE|INSERT|DELETE|DROP)/', $sql);
}

function getErrors() {
    $errors = array();
    if (!in_array('sqlite', PDO::getAvailableDrivers())) {
        $errors[] = array('type' => 'warning', 'message' => 'ERROR_SQLITE_NOT_INSTALLED');
    }
    if (!is_writable(_EA_ROOT . '/config')) {
        $errors[] = array('type' => 'error', 'message' => 'ERROR_CONFIG_DIR_NOT_WRITEABLE');
    }
    if (!is_writable(_EA_ROOT . '/data')) {
        $errors[] = array('type' => 'warning', 'message' => 'ERROR_DBDIR_NOT_WRITEABLE');
    } 
    return $errors;
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title><?php __('TITLE') ?></title>
        <style>
            body {
                background: #333;
                color: #fff;
                font: 14px/1.2 helvetica, arial, sans-serif;
            }
            
            div#intro {
                border-bottom: 1px solid #fff;
                padding: .5em 0;
            }
            
            div#intro * {
                padding: 0;
                margin: 5px 0;
            }
            
            div#intro p {
            }
            
            #container {
                width: 500px;
                margin: 5em auto;
                position: relative;
            }
            a, a:visited, a:active {
                color: #67a0ff;
            }
            form {
                margin: 10px 0;
            }
            label {
                display: inline-block;
                width: 100px;
            }
            .inputs {
                margin-left: 20px;
            }
            span {
                font-style: italic;
            }
            code {
                font-family: monospace;
            }
            
            #switch-language {
            }
            
            .important {
                font-size: 1.25em;
                background: #ec6642;
                padding: 2px 5px;
                border: 1px solid #f53825;
                font-style: normal;
                font-weight: bold;
                -webkit-border-radius: 5px;
                -khtml-border-radius: 5px;
                -moz-border-radius: 5px;
                border-radius: 5px;
            }
        </style>
    </head>
    <body>
        <div id="container">
            <?php if (defined('INSTALL_SUCCESS')): ?>
            <h1><?php __('INSTALL_SUCCESS'); ?></h1>
            <p><?php __('INSTALL_NOTICE'); ?></p>
            <p><?php __('INSTALL_NOTICE2'); ?></p>
            <?php else: ?>
            <div id="switch-language">
                <a href="?language=ger">Deutsch</a> | <a href="?language=eng">English</a>
            </div>
            <div id="intro">
                <h1><?php __('INSTALL_EAGB') ?></h1>
                <p><?php __('INTRO') ?></p>
            </div>
            <?php foreach (getErrors() as $error): ?>
            <p class="important <?php echo $error['type']; ?>-message">
                <?php __($error['message']) ?>
            </p>
            <?php endforeach; ?>
            <form action="install.php" method="POST">
                <p><?php __('LANGUAGE_DESCRIPTION') ?></p>
                <div class="inputs">
                    <label for="language"><?php __('LANGUAGE') ?></label>
                    <select id="language" name="language">
                        <option id="language-ger" value="ger">Deutsch</option>
                        <option id="language-eng" value="eng">English</option>
                    </select>
                </div>
                <p><?php __('DATABASE_DESCRIPTION') ?></p>
                <div class="inputs">
                    <div>
                        <input type="radio" name="database-type" id="database-type-sqlite" value="sqlite" checked="checked" />
                        <label for="database-type-sqlite">SQLite</label>
                    </div>
                    <div>
                        <input type="radio" name="database-type" id="database-type-mysql" value="mysql" />
                        <label for="database-type-mysql">MySQL</label>
                        <div id="mysql-credentials">
                            <div>
                                <label for="mysql-host"><?php __('MYSQL_HOST') ?></label>
                                <input type="text" name="mysql-host" id="mysql-host" />
                            </div>
                            <div>
                                <label for="mysql-port"><?php __('PORT') ?></label>
                                <input type="text" name="mysql-port" id="mysql-port"/> <span><?php __('LEAVE_EMPTY') ?></span>
                            </div>
                            <div>
                                <label for="mysql-db"><?php __('MYSQL_DB'); ?></label>
                                <input type="text" name="mysql-db" id="mysql-db"/> <span style="position:absolute;"><?php __('CREATE_IF_NOT_EXIST') ?></span>
                            </div>
                            <div>
                                <label for="mysql-user"><?php __('USERNAME') ?></label>
                                <input type="text" name="mysql-user" id="mysql-user"/>
                            </div>
                            <div>
                                <label for="mysql-password" ><?php __('PASSWORD') ?></label>
                                <input type="password" name="mysql-password" id="mysql-password" />
                            </div>
                        </div>
                    </div>
                </div>
                <div>
                    <input type="submit" value="<?php __('SUBMIT') ?>" />
                </div>
            </form>
            <?php endif;?>
        </div>
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
        <script type="text/javascript">
            $('document').ready(function() {
                checkCredentials();
                $('form').click(function() {
                    checkCredentials();
                });
                
            });
            function checkCredentials() {
                if ($('#database-type-mysql:checked').val() == 'mysql') {
                    $('#mysql-credentials').show();
                } else {
                    $('#mysql-credentials').hide();
                }
            }
        </script>
    </body>
</html>