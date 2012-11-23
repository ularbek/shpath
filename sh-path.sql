-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 16, 2012 at 12:31 PM
-- Server version: 5.5.8
-- PHP Version: 5.3.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `sh-path`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE IF NOT EXISTS `admins` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(65) NOT NULL,
  `password` varchar(65) NOT NULL,
  `name` varchar(65) NOT NULL,
  `surname` varchar(65) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `login`, `password`, `name`, `surname`) VALUES
(1, 'admin', '12345', 'ularbek', 'turdukeev');

-- --------------------------------------------------------

--
-- Table structure for table `coordinates`
--

CREATE TABLE IF NOT EXISTS `coordinates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `route_type` varchar(30) NOT NULL,
  `route_number` int(4) NOT NULL,
  `lat` float(10,6) NOT NULL,
  `lng` float(10,6) NOT NULL,
  `order_number` int(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=753 ;

--
-- Dumping data for table `coordinates`
--

INSERT INTO `coordinates` (`id`, `route_type`, `route_number`, `lat`, `lng`, `order_number`) VALUES
(638, 'bus', 7, 42.872295, 74.689003, 1),
(639, 'bus', 7, 42.871605, 74.690636, 2),
(640, 'bus', 7, 42.854935, 74.692009, 4),
(641, 'bus', 7, 42.866699, 74.690636, 3),
(642, 'bus', 7, 42.855122, 74.687805, 5),
(643, 'bus', 7, 42.855438, 74.680939, 6),
(644, 'bus', 7, 42.855625, 74.675529, 7),
(645, 'bus', 7, 42.856003, 74.667809, 8),
(646, 'bus', 7, 42.854935, 74.664719, 9),
(647, 'bus', 7, 42.855373, 74.661110, 10),
(648, 'bus', 7, 42.855373, 74.656563, 11),
(649, 'bus', 7, 42.855247, 74.652786, 12),
(650, 'bus', 7, 42.855186, 74.649864, 13),
(651, 'bus', 7, 42.856003, 74.645920, 14),
(652, 'bus', 7, 42.856003, 74.638794, 15),
(653, 'bus', 7, 42.856003, 74.637421, 16),
(654, 'bus', 7, 42.857574, 74.636475, 17),
(655, 'bus', 7, 42.861729, 74.636475, 18),
(656, 'bus', 7, 42.866760, 74.636475, 19),
(657, 'bus', 7, 42.871983, 74.637161, 20),
(658, 'bus', 7, 42.875004, 74.636734, 21),
(659, 'bus', 7, 42.874874, 74.630035, 22),
(660, 'bus', 7, 42.874813, 74.625748, 23),
(661, 'bus', 7, 42.875191, 74.619995, 24),
(662, 'bus', 7, 42.875317, 74.617332, 25),
(663, 'bus', 7, 42.875648, 74.612274, 26),
(664, 'bus', 7, 42.875740, 74.609421, 27),
(665, 'bus', 7, 42.875916, 74.605774, 28),
(666, 'bus', 7, 42.876011, 74.602379, 29),
(667, 'bus', 7, 42.876183, 74.597809, 30),
(668, 'bus', 7, 42.876354, 74.591675, 31),
(669, 'bus', 7, 42.876778, 74.583626, 33),
(670, 'minibus', 102, 42.854935, 74.692009, 1),
(671, 'minibus', 102, 42.855122, 74.687286, 2),
(672, 'minibus', 102, 42.855312, 74.680336, 3),
(673, 'minibus', 102, 42.855751, 74.674843, 4),
(674, 'minibus', 102, 42.854809, 74.664803, 6),
(675, 'minibus', 102, 42.855247, 74.662056, 7),
(676, 'minibus', 102, 42.856068, 74.665749, 5),
(677, 'minibus', 102, 42.855373, 74.658966, 8),
(678, 'minibus', 102, 42.855373, 74.655106, 9),
(679, 'minibus', 102, 42.855373, 74.649521, 10),
(680, 'minibus', 102, 42.855690, 74.643173, 11),
(681, 'minibus', 102, 42.855877, 74.636734, 12),
(682, 'minibus', 102, 42.856068, 74.633904, 13),
(683, 'minibus', 102, 42.856255, 74.626007, 14),
(684, 'minibus', 102, 42.856506, 74.619141, 15),
(685, 'minibus', 102, 42.856506, 74.612190, 16),
(686, 'minibus', 102, 42.856884, 74.609779, 17),
(687, 'minibus', 102, 42.857136, 74.600685, 18),
(688, 'minibus', 102, 42.857201, 74.596565, 19),
(689, 'minibus', 102, 42.857327, 74.587212, 20),
(690, 'minibus', 102, 42.862736, 74.587128, 21),
(691, 'minibus', 102, 42.867390, 74.587555, 22),
(692, 'minibus', 102, 42.872768, 74.587898, 23),
(693, 'minibus', 102, 42.872959, 74.584465, 24),
(694, 'minibus', 102, 42.873085, 74.580940, 25),
(695, 'minibus', 102, 42.873241, 74.577469, 26),
(696, 'minibus', 102, 42.873493, 74.574760, 27),
(697, 'minibus', 102, 42.873524, 74.571587, 28),
(698, 'minibus', 102, 42.872078, 74.571419, 29),
(699, 'minibus', 102, 42.871040, 74.571205, 30),
(700, 'minibus', 102, 42.870914, 74.574890, 31),
(701, 'minibus', 102, 42.870789, 74.577171, 32),
(702, 'minibus', 102, 42.870537, 74.580986, 33),
(703, 'minibus', 102, 42.870316, 74.584381, 34),
(704, 'minibus', 102, 42.870094, 74.587128, 35),
(705, 'minibus', 252, 42.814022, 74.629700, 1),
(706, 'minibus', 252, 42.817169, 74.624718, 2),
(707, 'minibus', 252, 42.820633, 74.619484, 3),
(708, 'minibus', 252, 42.825794, 74.612961, 5),
(709, 'minibus', 252, 42.823090, 74.615707, 4),
(710, 'minibus', 252, 42.827934, 74.609268, 6),
(711, 'minibus', 252, 42.828125, 74.607384, 7),
(712, 'minibus', 252, 42.831333, 74.607468, 8),
(713, 'minibus', 252, 42.835804, 74.608070, 9),
(714, 'minibus', 252, 42.838573, 74.608322, 10),
(715, 'minibus', 252, 42.842728, 74.608841, 11),
(716, 'minibus', 252, 42.845997, 74.609184, 12),
(717, 'minibus', 252, 42.849773, 74.609528, 13),
(718, 'minibus', 252, 42.853107, 74.610298, 14),
(719, 'minibus', 252, 42.856758, 74.610298, 15),
(720, 'minibus', 252, 42.861729, 74.611160, 16),
(721, 'minibus', 252, 42.865818, 74.610985, 17),
(722, 'minibus', 252, 42.870914, 74.611671, 18),
(723, 'minibus', 252, 42.874813, 74.611588, 19),
(724, 'minibus', 252, 42.880409, 74.611839, 20),
(725, 'minibus', 252, 42.883682, 74.611931, 21),
(726, 'minibus', 252, 42.889343, 74.611671, 22),
(727, 'minibus', 252, 42.894688, 74.611504, 23),
(728, 'minibus', 252, 42.898460, 74.611839, 24),
(729, 'minibus', 252, 42.903049, 74.612442, 25),
(730, 'minibus', 252, 42.907578, 74.612701, 26),
(731, 'minibus', 252, 42.913486, 74.612442, 27),
(732, 'bus', 3, 42.827244, 74.610298, 1),
(733, 'bus', 3, 42.827621, 74.607208, 2),
(734, 'bus', 3, 42.833538, 74.607552, 3),
(735, 'bus', 3, 42.841217, 74.608925, 4),
(736, 'bus', 3, 42.847004, 74.608925, 5),
(737, 'bus', 3, 42.853676, 74.610298, 6),
(738, 'bus', 3, 42.860092, 74.610809, 7),
(739, 'bus', 3, 42.867012, 74.611160, 8),
(740, 'bus', 3, 42.873428, 74.611671, 9),
(741, 'bus', 3, 42.875568, 74.611839, 10),
(742, 'bus', 3, 42.875568, 74.607292, 11),
(743, 'bus', 3, 42.875694, 74.600769, 12),
(744, 'bus', 3, 42.876011, 74.596138, 13),
(745, 'bus', 3, 42.876133, 74.591331, 14),
(746, 'bus', 3, 42.876450, 74.588158, 15),
(747, 'bus', 3, 42.876701, 74.581459, 16),
(748, 'bus', 3, 42.877140, 74.577339, 17),
(749, 'bus', 3, 42.877205, 74.574677, 18),
(750, 'bus', 3, 42.877079, 74.570045, 19),
(751, 'bus', 3, 42.877457, 74.565750, 20),
(752, 'bus', 3, 42.877644, 74.562492, 21);

-- --------------------------------------------------------

--
-- Table structure for table `images`
--

CREATE TABLE IF NOT EXISTS `images` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=24 ;

--
-- Dumping data for table `images`
--

INSERT INTO `images` (`id`, `url`) VALUES
(13, 'images/locations/63.JPG'),
(14, 'images/locations/Bayrak.jpg'),
(15, 'images/locations/Black_Evo.jpg'),
(16, 'images/locations/Bayrak.jpg'),
(17, 'images/locations/Eiffel_Tower.jpg'),
(18, 'images/locations/map144.jpg'),
(19, 'images/locations/map144.jpg'),
(20, 'images/locations/0002.jpg'),
(21, 'images/locations/Hydrangeas.jpg'),
(22, 'images/locations/Hydrangeas.jpg'),
(23, 'images/locations/0007.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `intersection`
--

CREATE TABLE IF NOT EXISTS `intersection` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `marker_id` int(11) NOT NULL,
  `marker_id2` int(11) NOT NULL,
  `length` double NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=132 ;

--
-- Dumping data for table `intersection`
--

INSERT INTO `intersection` (`id`, `marker_id`, `marker_id2`, `length`) VALUES
(49, 17, 18, 0.016668263315817),
(50, 18, 19, 0.018414880298607),
(51, 18, 20, 0.039397542095322),
(52, 17, 21, 0.017072709585956),
(53, 21, 19, 0.01381364140936),
(55, 19, 22, 0.03983259169901),
(56, 20, 22, 0.018829600987147),
(57, 19, 23, 0.011507019571767),
(58, 23, 24, 0.043510572135304),
(59, 22, 24, 0.013297683379425),
(60, 20, 25, 0.0038060082229888),
(61, 25, 26, 0.0082200110280024),
(63, 26, 28, 0.0023208431686691),
(64, 20, 29, 0.012318672336216),
(65, 29, 28, 0.0047600677354794),
(66, 25, 30, 0.011666039088902),
(67, 30, 31, 0.013785022704081),
(68, 28, 31, 0.0094360993321615),
(69, 31, 32, 0.0065342940320396),
(70, 32, 33, 0.0083389485655494),
(71, 32, 34, 0.0035458511217657),
(72, 34, 35, 0.0060246966044061),
(73, 33, 36, 0.0059322519143875),
(74, 36, 35, 0.0084146984201219),
(75, 35, 37, 0.007025156841851),
(76, 31, 38, 0.01400454975468),
(77, 28, 39, 0.013570588412343),
(78, 39, 38, 0.0093539559216564),
(79, 39, 40, 0.0048012177797729),
(80, 29, 40, 0.013443145179297),
(81, 22, 41, 0.019575865440517),
(82, 40, 42, 0.018859863659749),
(83, 41, 42, 0.005670409945778),
(84, 24, 43, 0.019068588095075),
(85, 43, 41, 0.0095284874711677),
(86, 43, 44, 0.0047211067652023),
(87, 44, 42, 0.0091842395226037),
(88, 42, 45, 0.023191010283528),
(89, 40, 46, 0.023351372802507),
(90, 45, 46, 0.019249137592518),
(91, 38, 47, 0.022668039341543),
(92, 46, 47, 0.013967037204446),
(93, 44, 48, 0.02285312704469),
(94, 48, 45, 0.007313952585528),
(95, 37, 49, 0.0091695121647483),
(96, 49, 50, 0.003036218285793),
(97, 38, 50, 0.014679216372074),
(98, 50, 51, 0.021821432351735),
(99, 47, 51, 0.014301777776752),
(100, 51, 52, 0.022319174739235),
(101, 47, 53, 0.025407130857886),
(102, 53, 52, 0.014371050424245),
(103, 45, 54, 0.012541379025516),
(104, 48, 55, 0.012541376638536),
(105, 55, 54, 0.007313893236753),
(106, 54, 56, 0.010656630523843),
(107, 56, 57, 0.0052728668326739),
(108, 57, 58, 0.013869718014361),
(109, 53, 59, 0.0083140096167813),
(110, 58, 59, 0.0087981518649648),
(111, 57, 60, 0.0064628136503145),
(112, 60, 61, 0.005007852633659),
(113, 54, 62, 0.014022178048742),
(114, 62, 61, 0.0054636481636997),
(115, 55, 0, 0.016315590161707),
(116, 63, 64, 0.0044649678558317),
(117, 64, 62, 0.0084861762482838),
(118, 57, 65, 0.033922028005583),
(119, 59, 66, 0.011502000748158),
(120, 66, 67, 0.022243671854239),
(121, 62, 68, 0.0387957161858),
(122, 65, 69, 0.010226244324269),
(123, 68, 69, 0.010812881932742),
(124, 64, 70, 0.026976080453269),
(125, 51, 71, 0.020182077716585),
(126, 52, 72, 0.015627786515189),
(128, 72, 73, 0.011643287387167),
(129, 67, 67, 0),
(130, 74, 55, 0.0098207375615785),
(131, 67, 0, 0.0068269709709628);

-- --------------------------------------------------------

--
-- Table structure for table `locations`
--

CREATE TABLE IF NOT EXISTS `locations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `address` varchar(255) NOT NULL,
  `lat` double NOT NULL,
  `lng` double NOT NULL,
  `type` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `locations`
--

INSERT INTO `locations` (`id`, `address`, `lat`, `lng`, `type`, `image`) VALUES
(2, 'Tunguch 1', 42.854115802222, 74.682396148682, 'address', ''),
(3, 'Vefa', 42.857214604953, 74.609826301575, 'supermarket', ''),
(4, 'Zum', 42.876102926898, 74.614568447113, 'supermarket', ''),
(5, 'Beta Stores 1', 42.876024303067, 74.592209552765, 'supermarket', ''),
(6, 'Ataturk-Alatoo', 42.856255093824, 74.68095848465, 'university', ''),
(7, 'KGMA', 42.842474240433, 74.607122634888, 'university', ''),
(8, 'Manas', 42.848877370933, 74.586737846374, 'university', ''),
(12, 'beta stores 2', 42.831365516073, 74.621499275207, 'supermarket', 'images/locations/Bayrak.jpg'),
(14, 'domino 1', 42.842702373191, 74.608495925903, 'coffee', 'images/locations/map144.jpg'),
(15, 'white house', 42.876669015524, 74.602101539612, 'congress', 'images/locations/0002.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `markers`
--

CREATE TABLE IF NOT EXISTS `markers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `address` varchar(100) NOT NULL,
  `lat` double NOT NULL,
  `lng` double NOT NULL,
  `type` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=76 ;

--
-- Dumping data for table `markers`
--

INSERT INTO `markers` (`id`, `name`, `address`, `lat`, `lng`, `type`) VALUES
(17, '', '', 42.85505961647568, 74.692009185791, ''),
(18, '', '', 42.85581465749337, 74.67535803222654, ''),
(19, '', '', 42.87418447682612, 74.67664549255369, ''),
(20, '', '', 42.85612925519279, 74.6359617462158, ''),
(21, '', '', 42.87204580644791, 74.69029257202146, ''),
(22, '', '', 42.874939283970726, 74.63682005310056, ''),
(23, '', '', 42.885505614619845, 74.67870542907713, ''),
(24, '', '', 42.88814691454415, 74.63527510070799, ''),
(25, '', '', 42.853046128629636, 74.63373014831541, ''),
(26, '', '', 42.851473045573, 74.62566206359861, ''),
(28, '', '', 42.851598893692014, 74.62334463500974, ''),
(29, '', '', 42.85634947262879, 74.62364504241941, ''),
(30, '', '', 42.84168756928808, 74.63639089965818, ''),
(31, '', '', 42.84219103997453, 74.6226150741577, ''),
(32, '', '', 42.83567707115037, 74.62210009002683, ''),
(33, '', '', 42.83520501774012, 74.63042566680906, ''),
(34, '', '', 42.83215231863292, 74.62171385192869, ''),
(35, '', '', 42.826266792736185, 74.62300131225584, ''),
(36, '', '', 42.82928830918733, 74.63085482025144, ''),
(37, '', '', 42.822111966459055, 74.61733648681638, ''),
(38, '', '', 42.84282037256301, 74.60862467193601, ''),
(39, '', '', 42.85210228360375, 74.60978338623045, ''),
(40, '', '', 42.856884283132366, 74.61021253967283, ''),
(41, '', '', 42.875442483604886, 74.61725065612791, ''),
(42, '', '', 42.8756940818833, 74.61158583068845, ''),
(43, '', '', 42.88493960706488, 74.61647817993162, ''),
(44, '', '', 42.884876717016, 74.61175749206541, ''),
(45, '', '', 42.876574667779614, 74.58841154479978, ''),
(46, '', '', 42.85738762996341, 74.5868665924072, ''),
(47, '', '', 42.84344969874087, 74.5859653701782, ''),
(48, '', '', 42.88387046751428, 74.58892652893064, ''),
(49, '', '', 42.82777756942363, 74.61012670898435, ''),
(50, '', '', 42.8282182056689, 74.60712263488767, ''),
(51, '', '', 42.82916241561733, 74.58532164001463, ''),
(52, '', '', 42.82954009555818, 74.56300566101072, ''),
(53, '', '', 42.843701427417045, 74.56055948638914, ''),
(54, '', '', 42.87707785407854, 74.5758802642822, ''),
(55, '', '', 42.88437359431676, 74.57639524841306, ''),
(56, '', '', 42.86651008014511, 74.57450697326658, ''),
(57, '', '', 42.86537771133089, 74.56935713195799, ''),
(58, '', '', 42.851661817655405, 74.56729719543455, ''),
(59, '', '', 42.851756203480186, 74.5584995498657, ''),
(60, '', '', 42.87179419329571, 74.5685846557617, ''),
(61, '', '', 42.872863542108476, 74.56369230651853, ''),
(62, '', '', 42.87802131732968, 74.56188986206053, ''),
(63, '', '', 42.88387046751428, 74.56008741760252, ''),
(64, '', '', 42.883744685172516, 74.55562422180174, ''),
(65, '', '', 42.86424532174504, 74.53545401000974, ''),
(66, '', '', 42.85188205102222, 74.54699823760984, ''),
(67, '', '', 42.83872959614843, 74.52905962371824, ''),
(68, '', '', 42.87437317947783, 74.52326605224607, ''),
(69, '', '', 42.86374203081723, 74.52524015808103, ''),
(70, '', '', 42.90053435960367, 74.5345098724365, ''),
(71, '', '', 42.80901614183855, 74.58412001037595, ''),
(72, '', '', 42.81392740106585, 74.56369230651853, ''),
(73, '', '', 42.80385260266478, 74.56952879333494, ''),
(74, '', '', 42.894057985510635, 74.57476446533201, ''),
(75, '', '', 42.83671557596008, 74.52253649139402, '');
