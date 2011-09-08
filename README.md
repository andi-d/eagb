# Documentation

## Requirements

- At least PHP 5 (tested on PHP 5.2.17)
- Either SQLite exension installed or MySQL Database available

## Getting started

### Installation

1. Copy all content of the package into your webroot
2. Navigate to yourdomain.tld/eagb/install.php
3. You now have to choose between SQLite and MySQL
    - [SQLite](http://sqlite.org/): Make sure your "data" folder inside the eagb folder is writeable (777)) and click &lt;Install&gt;.
    - [MySQL](http://mysql.com/): Enter your Server Information and User credentials. Then click &lt;Install&gt;.
4. Finish! You should now see the "Success" page. To check your installation, navigate to yourdomain.tld/demo.php to see the demo page.

### Integration
_(For basic integration, you can check the demo.php inside your webroot.)_

Basically, you need 3 Things after you installed the guestbook:

1. put `include 'eagb/eagb.php'` at the top of your index.php
2. put `<?php echo eaLoadTheme('standard'); ?>` inside your layout's `&lt;head&gt;` to load the basic styling for the guestbook.
3. A place for the guestbook itself. To ouput it in the desired place, just write `<?php echo $eaGB; ?>` where you want your guestbook.

# Enjoy!