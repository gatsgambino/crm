# Client Relational Management
<p>This project makes use of <a href="https://jquery.com/">JQuery</a> and the <a href="http://foundation.zurb.com/">Foundation CSS framework</a> for responsive design, <a href="http://lesscss.org/">Less</a> for dynamic stylesheets and <a href="http://fontawesome.io/">Font Awesome</a> for navbar icons.</p>

<hr>

# Database
Connect to your database in root/assets/includes/connect.php.

To setup tables with pre-filled data see the following link:
https://pastebin.com/uEV342VT

To setup tables only run the below SQL query in your database:

```sql
CREATE TABLE `users` (

      `id` int(11) UNSIGNED PRIMARY KEY NOT NULL,

      `username` varchar(255) NOT NULL,

      `email` varchar(1024) NOT NULL,

      `last_name` varchar(255) NOT NULL,

      `first_name` varchar(255) NOT NULL,

      `password` varchar(60) NOT NULL,

      `login_token` varchar(32) DEFAULT NULL,

      `reset_token` varchar(32) DEFAULT NULL,

      `email_confirmed` bit(1) DEFAULT NULL,

      `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,

      `last_login` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,

      `privilege` enum('admin','consultant') NOT NULL
  
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `clients` (

      `id` int(11) UNSIGNED PRIMARY KEY NOT NULL,

      `user_who_created` varchar(255) NOT NULL,

      `user_who_modified` varchar(255) DEFAULT NULL,

      `last_name` varchar(255) NOT NULL,

      `first_name` varchar(255) NOT NULL,

      `company` varchar(255) NOT NULL,

      `email` varchar(255) NOT NULL,

      `contact_number` varchar(255) NOT NULL,

      `address_number` varchar(255) NOT NULL,

      `street_name` varchar(255) NOT NULL,

      `postcode` varchar(255) NOT NULL,

      `city` varchar(255) NOT NULL,

      `country` varchar(255) NOT NULL,

      `date_added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,

      `date_modified` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
  
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `logs` (

      `id` int(11) UNSIGNED PRIMARY KEY NOT NULL,

      `client_assigned_to` int(11) NOT NULL,

      `user_who_created` varchar(255) NOT NULL,
      
      `user_who_modified` varchar(255) NOT NULL,

      `title` varchar(255) NOT NULL,

      `description` varchar(255) DEFAULT NULL,

      `body` text NOT NULL,

      `notes` varchar(255) DEFAULT NULL,

      `date_added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,

      `date_modified` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
  
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
```
<hr>
