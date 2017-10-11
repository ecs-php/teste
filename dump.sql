
--
-- Database: `test_db`
--
CREATE DATABASE IF NOT EXISTS `test_db` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `test_db`;

-- --------------------------------------------------------

--
-- Estrutura da tabela `planet`
--

CREATE TABLE `planet` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `galaxy` varchar(255) NOT NULL,
  `size` int(20) NOT NULL,
  `distance` int(20) NOT NULL,
  `date_created` datetime NOT NULL,
  `date_updated` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for table `planet`
--
ALTER TABLE `planet`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for table `planet`
--
ALTER TABLE `planet`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;