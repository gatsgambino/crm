This project has been archived. Please see v2 at this [link](https://github.com/kkamara/laravel-crm/).

![oldcrm2.png](https://github.com/kkamara/useful/raw/main/oldcrm2.png)

# Client Relational Management

This project makes use of [JQuery](https://jquery.com/) and the [Foundation CSS framework](http://foundation.zurb.com/) for responsive design, [Less](http://lesscss.org/) for dynamic stylesheets and [Font Awesome](http://fontawesome.io/) for navbar icons.


# Database
Connect to your database with [./assets/includes/connect.php](https://github.com/kkamara/crm/blob/master/assets/includes/connect.php).

To setup tables with pre-filled data save the `hrcrm.sql` and run the following.

```bash
mysql -h localhost \
  -u root \ \
  hrcrm < $HOME/Downloads/hrcrm.sql
```

Save the `hrcrm.sql`.

```sql
-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jan 18, 2023 at 08:43 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.0.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hrcrm`
--

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE `clients` (
  `id` int(11) NOT NULL,
  `first_name` varchar(30) NOT NULL,
  `last_name` varchar(30) NOT NULL,
  `company` varchar(30) NOT NULL,
  `email` varchar(30) NOT NULL,
  `contact_number` varchar(30) NOT NULL,
  `address_number` varchar(30) NOT NULL,
  `street_name` varchar(30) NOT NULL,
  `postcode` varchar(30) NOT NULL,
  `city` varchar(30) NOT NULL,
  `country` varchar(30) NOT NULL,
  `user_who_created` varchar(30) NOT NULL,
  `date_modified` datetime DEFAULT NULL,
  `date_added` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`id`, `first_name`, `last_name`, `company`, `email`, `contact_number`, `address_number`, `street_name`, `postcode`, `city`, `country`, `user_who_created`, `date_modified`, `date_added`) VALUES
(1, 'Kelvin', 'Kamara', 'www.kelvinkamara.com', 'admin@localhost', '+44', '1', 'Street Name', 'PostCode', 'London', 'UK', 'admin', '2023-01-18 19:34:02', '2023-01-18 19:39:43');

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE `logs` (
  `id` int(11) NOT NULL,
  `title` varchar(30) NOT NULL,
  `description` varchar(255) NOT NULL,
  `body` varchar(255) NOT NULL,
  `notes` varchar(255) NOT NULL,
  `client_assigned_to` int(11) NOT NULL,
  `user_who_created` varchar(30) NOT NULL,
  `date_modified` datetime DEFAULT NULL,
  `date_added` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `logs`
--

INSERT INTO `logs` (`id`, `title`, `description`, `body`, `notes`, `client_assigned_to`, `user_who_created`, `date_modified`, `date_added`) VALUES
(1, 'First log', 'Description.', 'Body.', 'Notes.', 1, 'admin', NULL, '2023-01-18 19:35:37');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `first_name` varchar(30) NOT NULL,
  `last_name` varchar(30) NOT NULL,
  `email` varchar(30) NOT NULL,
  `password` varchar(255) NOT NULL,
  `privilege` varchar(30) NOT NULL,
  `login_token` varchar(255) NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `first_name`, `last_name`, `email`, `password`, `privilege`, `login_token`, `last_login`, `created`) VALUES
(1, 'admin', 'Kelvin', 'Kamara', 'kamaracomputers@gmail.com', '$2y$10$/h2IcIacC5ejAhTGnrcIPORmMlrCX1IE98FA.UJdNrqlSlAvZ3xdW', 'admin', '4iS9YOsH6lxLTArNykJVXUzM1BFbfIvn', '2023-01-18 19:28:58', '2023-01-18 18:42:48');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `logs`
--
ALTER TABLE `logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
```

## Contributing
Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.

Please make sure to update tests as appropriate.

## License
[BSD](https://opensource.org/licenses/BSD-3-Clause)
