# ************************************************************
# Sequel Pro SQL dump
# Version 4096
#
# http://www.sequelpro.com/
# http://code.google.com/p/sequel-pro/
#
# Host: 127.0.01 (MySQL 5.6.17)
# Database: b247-com
# Generation Time: 2014-08-13 10:01:42 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table age_group
# ------------------------------------------------------------

DROP TABLE IF EXISTS `age_group`;

CREATE TABLE `age_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `range` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `age_group` WRITE;
/*!40000 ALTER TABLE `age_group` DISABLE KEYS */;

INSERT INTO `age_group` (`id`, `range`)
VALUES
	(1,'0-9'),
	(2,'10-19'),
	(3,'20-29'),
	(4,'30-39'),
	(5,'40-49'),
	(6,'50-59'),
	(7,'60-69'),
	(8,'69-70');

/*!40000 ALTER TABLE `age_group` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table article
# ------------------------------------------------------------

DROP TABLE IF EXISTS `article`;

CREATE TABLE `article` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `event_id` int(11) DEFAULT NULL,
  `author_id` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `sef_name` varchar(255) DEFAULT NULL,
  `sub_heading` varchar(150) DEFAULT NULL,
  `body` text,
  `body_continued` text,
  `postcode` varchar(15) DEFAULT NULL,
  `lat` varchar(20) DEFAULT NULL,
  `lon` varchar(20) DEFAULT NULL,
  `area` varchar(75) DEFAULT NULL,
  `impressions` int(11) DEFAULT NULL,
  `is_active` tinyint(4) DEFAULT '0',
  `is_featured` tinyint(4) DEFAULT '0',
  `is_picked` tinyint(4) DEFAULT '0',
  `is_deleted` tinyint(4) DEFAULT NULL,
  `is_comments` tinyint(4) DEFAULT NULL,
  `is_approved` tinyint(4) DEFAULT NULL,
  `published` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `article -> event_idx` (`event_id`),
  CONSTRAINT `article -> event` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `article` WRITE;
/*!40000 ALTER TABLE `article` DISABLE KEYS */;

INSERT INTO `article` (`id`, `event_id`, `author_id`, `title`, `sef_name`, `sub_heading`, `body`, `body_continued`, `postcode`, `lat`, `lon`, `area`, `impressions`, `is_active`, `is_featured`, `is_picked`, `is_deleted`, `is_comments`, `is_approved`, `published`, `created_at`, `updated_at`)
VALUES
	(187,NULL,2,'Bristol streets to be haunted by shadowy ghosts of the past','bristol-streets-to-be-haunted-by-shadowy-ghosts-of-the-past','Bristolians will see their shadows replayed back to them on the cityâ€™s streets this September, thanks to the winners of the Playable City award','<p style=\"font-family: \'palatino linotype\', palatino, serif; font-size: 14px; line-height: 21px;\">Bristolians will see their shadows replayed back to them on the city&rsquo;s streets this September, thanks to the winners of the Playable City award.</p>\r\n<p style=\"font-family: \'palatino linotype\', palatino, serif; font-size: 14px; line-height: 21px;\">As the sun goes down and Bristol&rsquo;s street lights come on, traces of those who have passed by will be played back as shadows, re-animating the streets.</p>\r\n<p style=\"font-family: \'palatino linotype\', palatino, serif; font-size: 14px; line-height: 21px;\">As people interact with these curious figures, their movements and actions will be recorded and echoed back to the next visitor.</p>\r\n<p style=\"font-family: \'palatino linotype\', palatino, serif; font-size: 14px; line-height: 21px;\">The aim of the project is to offer passers-by a trace of those who have walked the same path moments, days or weeks before, &ldquo;at times like ghostly time travellers, at others more like a more playful Peter Pan&rdquo;.</p>\r\n<p style=\"font-family: \'palatino linotype\', palatino, serif; font-size: 14px; line-height: 21px;\">&lsquo;Shadowing&rsquo; is the brainchild of design duo Jonathan Chomko and Matthew Rosier, based in New York and Treviso, Italy, respectively.</p>\r\n<p style=\"font-family: \'palatino linotype\', palatino, serif; font-size: 14px; line-height: 21px;\">They will now work with the Watershed in Bristol to develop the infrared technology needed to capture people&rsquo;s outlines and work out ways to project movement back as shadows after people have moved on.</p>\r\n<p style=\"font-family: \'palatino linotype\', palatino, serif; font-size: 14px; line-height: 21px;\">&ldquo;We saw this as an opportunity to create a piece that lived in the city, rather than add on more infrastructure,&rdquo; said Jonathan Chomko.</p>\r\n<p style=\"font-family: \'palatino linotype\', palatino, serif; font-size: 14px; line-height: 21px;\">&ldquo;Our starting point was the notion that what makes our cities vibrant are the people we share them with, and we hoped to find a way to augment this presence. Our goal is to create unexpected interactions between people who share an urban environment by placing pockets of memory throughout the city that remember those who have passed through, allowing citizens to interact through time.&rdquo;</p>\r\n<p style=\"font-family: \'palatino linotype\', palatino, serif; font-size: 14px; line-height: 21px;\">The Playable City Award is in its second year, and started in Bristol last year with the&nbsp;<a style=\"color: #cd1613; outline: none; text-decoration: none; font-weight: bold;\" href=\"http://www.bristol247.com/2013/01/22/hello-lamp-post-whatcha-knowin-77166/\">Hello, Lamppost!</a>&nbsp;creation.</p>\r\n<p style=\"font-family: \'palatino linotype\', palatino, serif; font-size: 14px; line-height: 21px;\">The creators receive a &pound;30,000 cash prize to develop their idea. The award is co-funded by an expert network of organisations interested in exploring the future of creativity, technology and citizenship in urban spaces.</p>\r\n<p style=\"font-family: \'palatino linotype\', palatino, serif; font-size: 14px; line-height: 21px;\">The partners are: Future Cities Catapult, University of Bristol, University of the West of England and Bristol City Council. The Award is produced by Watershed with support from Arts Council England.</p>','','BS4 3EN','51.417036045801986','-2.572318111669915',NULL,NULL,1,1,0,0,NULL,NULL,'2014-07-04 00:00:01','0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(188,NULL,2,'Review: The multi-purpose Peugeot 5008','review-the-multipurpose-peugeot-5008','The 5008 is more compact, making it more enjoyable to drive, but does mean that if there are seven passengers thereâ€™s not a huge amount of room for ','<p style=\"font-family: \'palatino linotype\', palatino, serif; font-size: 14px; line-height: 21px;\">Transporting seven people in comfort can present a problem unless of course you don&rsquo;t mind Transit vans. Peugeot has a solution though in its 5008 MPV (multi-purpose vehicle). Unlike the earlier Peugeot 807 people carrier the 5008 is more compact, making it more enjoyable to drive but this does mean that if there are seven passengers there&rsquo;s not a huge amount of room for luggage. Importantly for the driver it&rsquo;s not too difficult to reverse or manoeuvre.</p>\r\n<p style=\"font-family: \'palatino linotype\', palatino, serif; font-size: 14px; line-height: 21px;\">This style of vehicle is quite van like in terms of appearance but it is very much like a car to drive and driver appeal is one of the advantages of the Peugeot. The test model, a two-litre diesel Allure &ndash; top-of-the-range, is equipped with a six speed automatic gearbox but it can also be driven like a manual.</p>\r\n<p style=\"font-family: \'palatino linotype\', palatino, serif; font-size: 14px; line-height: 21px;\">At low speeds, typically up hill, this gearbox is a little indecisive not sure whether to go for third gear or second, which does make for the occasional uncomfortable jolt.</p>\r\n<p style=\"font-family: \'palatino linotype\', palatino, serif; font-size: 14px; line-height: 21px;\">It is quite frugal for a vehicle of its size, returning over 40mpg on average. I put it through its paces over a long weekend to Pembrokeshire where we experienced a variety of roads. On the motorway (the M4, over the Severn Bridge) it was very capable, happily cruising at 70mph, even though it is heavily laden with five passengers and luggage. Cruise control makes life so much easier on such travels and the electric child lock engaged by the click of a switch on the driver&rsquo;s door is easy to operate.</p>\r\n<p style=\"font-family: \'palatino linotype\', palatino, serif; font-size: 14px; line-height: 21px;\">The one-way streets, invariably up sharp inclines in this part of the world, certainly cause the tired motorist some confusion but thank goodness I&rsquo;m driving the 5008 because the auto box makes light work of the hills. I&rsquo;m not usually a fan of electronic handbrakes but the one fitted to this vehicle is quick and simple to engage and disengage.</p>\r\n<p style=\"font-family: \'palatino linotype\', palatino, serif; font-size: 14px; line-height: 21px;\">Inside, the Allure benefits from an enormous panoramic glass roof (with electric sliding cover), which makes the vehicle really light and airy. The front passengers get captain style seats with pull down armrests that can be adjusted to the desired height. The driver&rsquo;s seat is certainly comfortable, hardwearing and supportive although I do find that when my daughter&rsquo;s baby seat is in place behind I cannot push my seat back quite as far as I might desire.</p>\r\n<p style=\"font-family: \'palatino linotype\', palatino, serif; font-size: 14px; line-height: 21px;\">There are all the gadgets the modern day motorist could dream of including sat nav, a useful head-up display showing the speed and ensuring the driver doesn&rsquo;t take their eyes off the road. Air conditioning and a good quality sound system are all part of the package.</p>\r\n<p style=\"font-family: \'palatino linotype\', palatino, serif; font-size: 14px; line-height: 21px;\">I like the way that the centre of the dash, with all the controls for the air conditioning, slopes forward at an angle towards the windscreen, in quite a futuristic way. I also find the mirror above the rear view mirror useful for keeping an eye on our cheeky little daughters behind.</p>','','BS4 3EN','51.4405288280076','-2.5760088312744074',NULL,NULL,1,1,0,0,NULL,NULL,'2014-07-04 00:00:01','0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(189,NULL,2,'Festival of Ideas: An honest evening with Lynn \'Demon\' Barber','festival-of-ideas-an-honest-evening-with-lynn-demon-barber','She takes risks and is direct, clear and has a fierce intelligence, and is even now in these times of shock and schlock journalism an erudite force','<p style=\"font-family: \'palatino linotype\', palatino, serif; font-size: 14px; line-height: 21px;\">Lynn Barber is one of&nbsp;the best known interviewer-journalist of the past 40&nbsp;years. Her tendency to ask the unaskable directly of her interviewees and lack of the traditionally English tendency to social embarrassment&nbsp;-she famously asked Jimmy Savile if the rumours about his &ldquo;liking young girls&rdquo; in one interview&nbsp;-&nbsp;led to her acquiring the soubriquet &lsquo;Demon Barber&rsquo;.</p>\r\n<p style=\"font-family: \'palatino linotype\', palatino, serif; font-size: 14px; line-height: 21px;\">Once a fixture at the Independent on Sunday and the Observer and now writing for the Sunday Times, her career began post university at the men&rsquo;s magazine &lsquo;Penthouse&rsquo;. &nbsp;Her career arc was one of many subjects touched upon in this candid talk and Q&amp;A&nbsp;session.</p>\r\n<p style=\"font-family: \'palatino linotype\', palatino, serif; font-size: 14px; line-height: 21px;\">The talk which took interview form and was led by Jenny Lacey, began with a frank discussion of the relationship Barber had with a much older conman when she was a schoolgirl and which she documented in her first memoir &lsquo;An Education&rsquo;, which was &nbsp;adapted for the cinema in 2009 and starred Carey Mulligan.</p>\r\n<p style=\"font-family: \'palatino linotype\', palatino, serif; font-size: 14px; line-height: 21px;\">Barber did not shrink from any of the questions asked about this and her honesty about the conman&rsquo;s effect upon her was impressive and unusual. Her admission that she did realise in later years that not only had she been &lsquo;groomed&rsquo; by him so had her parents was slightly eyebrow-raising as was her casual and relaxed approach to her promiscuity at Oxford.</p>\r\n<p style=\"font-family: \'palatino linotype\', palatino, serif; font-size: 14px; line-height: 21px;\">Barber&rsquo;s candour about her relationships was unexpected and unusual, especially her blunt assessment of seeing her husband-to-be and deciding she was going to marry him, at first sight, and adapting her life path in order to do so.</p>\r\n<p style=\"font-family: \'palatino linotype\', palatino, serif; font-size: 14px; line-height: 21px;\">When discussing her career, Barber appeared a truly formidable and yet empathic woman. She detailed her work processes when she is commissioned to interview someone, initially beginning with research and much of it, creating a list of questions which she can fall back on, transcribing the interview herself which is where the angle she is taking is pondered and finally writing it up.</p>\r\n<p style=\"font-family: \'palatino linotype\', palatino, serif; font-size: 14px; line-height: 21px;\">She admitted she hates the interview experience and finds it immensely stressful and worries about whether it will prove fruitless and uninteresting, yet does not worry if the subject of the interview dislikes her. She did elaborate on this during the questions and answers session when someone asked if she allows interviews to develop organically. &nbsp;Here she stated that she does not allow her list of questions to dictate the shape of an interview or where it is going ultimately &ndash; that cannot be predicted or controlled it must be permitted to follow the most interesting path.</p>\r\n<p style=\"font-family: \'palatino linotype\', palatino, serif; font-size: 14px; line-height: 21px;\">The anecdotes Barber told about interviewing the likes of Shane McGowen (The Pogues) and Bob Guccione were interesting and amusing. Yet an element of pathos emerged when she was revealed that she felt she missed a number of hints about Nureyev and his imminent death due to AIDS when she interviewed him and that certain revelations about interviewees which came to light at much later dates could not be included as they did not have substantive evidence. However, in the case of Jimmy Saville she felt that by at least putting the idea out there she was able to raise her reader&rsquo;s awareness of the rumours.</p>\r\n<p style=\"font-family: \'palatino linotype\', palatino, serif; font-size: 14px; line-height: 21px;\">An hour in the company of Lynn Barber was a thoroughly pleasurable way to start an evening, she was eloquent, articulate and you believed completely honest and open. &nbsp;It was entirely clear why she is such a successful interviewer and such a pleasure to read. She takes risks and is direct, clear and has a fierce intelligence, and is even now in these times of shock and schlock journalism an erudite force to be enjoyed on a number of levels. Long may the Demon Barber continue to dissect celebrities and peel back their surprising layers to get to the person beneath.</p>','','BS4 3EN','51.44668097722482','-2.5409040796874933',NULL,NULL,1,1,0,0,NULL,NULL,'2014-07-04 00:00:01','0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(190,NULL,2,'Review: The fun and powerful Honda CR-V','review-the-fun-and-powerful-honda-crv','This all-wheel-drive vehicle can tackle most terrains while having enough oomph to travel from 0 to 60mph in a little over 10 seconds','<p style=\"font-family: \'palatino linotype\', palatino, serif; font-size: 14px; line-height: 21px;\">Fun and power. Two words that, for me, best describe the Honda CR-V. Fun because this all-wheel-drive vehicle can tackle most terrains while the 150bhp 2.2 litre diesel unit has enough oomph to travel from 0 to 60mph in a little over 10 seconds.</p>\r\n<p style=\"font-family: \'palatino linotype\', palatino, serif; font-size: 14px; line-height: 21px;\">I&rsquo;m testing the top-of-the-range &pound;33,000 plus 2.2-litre four-wheel-drive version. As I look down the side panels I&rsquo;m instantly struck by how this fourth generation model reminds me of the BMW X5. It looks grander, more striking and capable than its predecessors. I like the polished metal finish. Eldest daughter Harriett likes the way water jets clean the headlights at the push of a button.</p>\r\n<p style=\"font-family: \'palatino linotype\', palatino, serif; font-size: 14px; line-height: 21px;\">In fact this sports utility vehicle (SUV) is fitted with a number of luxury features including the power tailgate that makes light work of closing the boot, extremely easy to fold rear seats and a panoramic glass roof.</p>\r\n<p style=\"font-family: \'palatino linotype\', palatino, serif; font-size: 14px; line-height: 21px;\">My test takes in Dorset, Hampshire and Oxford. A selection of artists have opened their studios and so it is an ideal opportunity to go and visit them. Interestingly the route is pretty much a straight run from Oxford down to Dorset and we are able to take in an average of three studios a day, racking up just over 500 miles and returning at best 39.7mpg at a constant 56mph.</p>\r\n<p style=\"font-family: \'palatino linotype\', palatino, serif; font-size: 14px; line-height: 21px;\">As temperatures drop to minus figures in the winter months it is reassuring to be driving a vehicle that is fitted with permanent four-wheel drive, especially when visiting the remote parts of the country that our trip takes us to. In fact on a number of occasions we find ourselves parking in farmers&rsquo; fields to visit the studios and the CR-V makes extremely light work of such requests. Hill descent is a useful feature too enhancing its capabilities when tackling such scenarios.</p>\r\n<p style=\"font-family: \'palatino linotype\', palatino, serif; font-size: 14px; line-height: 21px;\">The black leather interior is comfortable and the power front seats are easy to operate, although the driver&rsquo;s seat does seem to remember a different position on locking the vehicle. This is no doubt down to me not setting my desired position on the memory function. Similarly my wife and I find the radio frustrating because it refuses to play our favourite station, bypassing it at every request.</p>\r\n<p style=\"font-family: \'palatino linotype\', palatino, serif; font-size: 14px; line-height: 21px;\">The automatic gearbox is smooth. The centre armrests front and back together with the blacked out rear windows add to the hint of luxury.</p>\r\n<p style=\"font-family: \'palatino linotype\', palatino, serif; font-size: 14px; line-height: 21px;\">Parkers, the car experts, say: &ldquo;The British-built Honda CR-V is now in its fourth generation. The five-seat SUV has been in production since 1995 and has proven incredibly popular for the Japanese manufacturer. Indeed, five million CR-Vs have gone to happy homes around the world. Its blend of practicality, reliability and efficiency has stood it in good stead, but competition from the likes of Mazda&rsquo;s CX-5, Nissan&rsquo;s X-Trail and even BMW&rsquo;s X3 means Honda really has to be on its toes to retain its share of the market.&rdquo;</p>','','bs23 2pj','51.35073621942768','-2.979205088499384',NULL,NULL,1,0,1,0,NULL,NULL,'2014-07-04 00:00:01','0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(191,NULL,2,'Review: The Amazing Spiderman 2','review-the-amazing-spiderman-2','The emotional epicentre of the Spiderman mythology has always been the love story, whether itâ€™s Mary-Jane or Gwen Stacey','<p style=\"font-family: \'palatino linotype\', palatino, serif; font-size: 14px; line-height: 21px;\">Exactly why Spiderman needed another interpretation is open to speculation &ndash; some believe it&rsquo;s to make up for the over-stuffed, messy Spiderman 3, others that the studio wanted to retain the rights before they reverted back to Marvel.</p>\r\n<p style=\"font-family: \'palatino linotype\', palatino, serif; font-size: 14px; line-height: 21px;\">Whatever the reason, our favourite acrobatic arachnid &ndash; now prefixed with the Amazing attribute &ndash; was given a slightly different spin on an old and familiar comic book origins story. It wasn&rsquo;t as good as Raimi&rsquo;s, but it wasn&rsquo;t a total disaster either.</p>\r\n<p style=\"font-family: \'palatino linotype\', palatino, serif; font-size: 14px; line-height: 21px;\">The Amazing Spiderman 2 gives us more of the same. More, in fact, of everything. More back-story about Peter Parker&rsquo;s parents, more villains, more romance, more special effects, more spectacular city-destroying action. There&rsquo;s a prevailing and niggling sense of de ja vu with it all, exacerbated by the fact that practically every week ushers in the cinematic unleashing of a new Marvel movie. A certain case of the law of diminishing returns.</p>\r\n<p style=\"font-family: \'palatino linotype\', palatino, serif; font-size: 14px; line-height: 21px;\">It doesn&rsquo;t help that director Webb seems so often split as to which story he really wants to tell. On one hand it&rsquo;s a romance, sprinkled with the angst and torment of teen love and Parker&rsquo;s inevitable realisation that his web-slinging alter-ego will inevitably pose a threat to those he loves the most.</p>\r\n<p style=\"font-family: \'palatino linotype\', palatino, serif; font-size: 14px; line-height: 21px;\">The emotional epicentre of the Spiderman mythology has always been the love story, whether it&rsquo;s Mary-Jane or Gwen Stacey. Admittedly, the dynamic between Andrew Garfield and Emma Stone works well, blending the kooky, lanky, charming awkwardness of Parker with the head-strong academic beauty of Stacey. They over-play it a little here, but there&rsquo;s an undeniable charm and chemistry with their interplay. There are also a few unexpectedly moving scenes between Peter and Aunt May (Sally Field) that deliver a surprisingly emotional wallop.</p>\r\n<p style=\"font-family: \'palatino linotype\', palatino, serif; font-size: 14px; line-height: 21px;\">But if Marvel on celluloid is defined by anything it&rsquo;s the ability to deliver action-packed set-pieces and villains that kick monumental ass &ndash; and Spidey 2 delivers in bucket loads.<br />Jamie Foxx&rsquo;s Max Dillon is set up as Oscorp&rsquo;s gap-toothed, bespectacled nerdy lackey who transforms into Electro after plunging into a gigantic vat of mutant electric eels. Electro himself growls, snarls and hurls bolts of electric charges from his fingertips in his destructive skirmishes with our webbed wonder, yet visually he seems a twisted, sparkling, translucent love child of Dr Manhattan from Watchmen and Mr Freeze.</p>\r\n<p style=\"font-family: \'palatino linotype\', palatino, serif; font-size: 14px; line-height: 21px;\">Dane DeHaan plays Harry Osborn as a convincing pal to Parker, rekindling an old friendship in earlier scenes of affecting psychological drama that ultimately degenerate into inane grinning and cackling when he finally &ndash; and all to briefly &ndash; falls victim to an hereditary mutation that make him the Green Goblin. Paul Giamatti even makes an appearance in the very first and last five minutes as a deranged Russian mobster and his eventual alter-ego Rhino. As with Raimi&rsquo;s Spiderman 3, it comes occasionally dangerously close to packing in too many bad guys. More bang for your buck certainly, but at the expense of fleshing any of them sufficiently out.</p>\r\n<p style=\"font-family: \'palatino linotype\', palatino, serif; font-size: 14px; line-height: 21px;\">And therein lays another problem: the length. You always like to feel you&rsquo;re getting value for money &ndash; and you certainly do during the many frenzied, CGI-led action sequences (and with a reported budget of $200m the money&rsquo;s definitely up on the screen) &ndash; but with a running time of 142 minutes it would have benefitted from a judicious editorial trimming. Scenes are padded out and extra characters are briefly introduced and just as quickly excised, and the whole thing could have been snipped to fashion a punchier, tighter film.</p>\r\n<p style=\"font-family: \'palatino linotype\', palatino, serif; font-size: 14px; line-height: 21px;\">The 3D is nevertheless absolutely spectacular, pushing the boundaries and gob-smacking effectiveness of the format to new and thrilling limits, sweeping us through the city&rsquo;s skyscrapers and inducing a giddying, exhilarating rush as Spidey web-slings his ways from one heroic action set-piece to another. It&rsquo;s also employed in more subtle and effective ways too, exploiting the medium&rsquo;s potential for unexpected visual depth for scenes inside the sanctum of Oscorp itself and a disused subway station.</p>\r\n<p style=\"font-family: \'palatino linotype\', palatino, serif; font-size: 14px; line-height: 21px;\">The Amazing Spiderman 2 then, is something of a mixed bag, its own disparate web of intrigue. It certainly delivers on the thrills and spills and a more hit than miss interplay with its romantic leads, but it does beg the question of whether it was all absolutely necessary.<br />As with the recent glut of Marvel flicks there&rsquo;s also the inevitable realisation it&rsquo;s something of a teaser for a whole slew of other adaptions and spin-offs currently in the pipeline, chief amongst them The Sinister Six.</p>\r\n<p style=\"font-family: \'palatino linotype\', palatino, serif; font-size: 14px; line-height: 21px;\">So there&rsquo;s a lot here that&rsquo;s really done before and some scenes could have in fact been cut and paste from previous Spidey adventures. That said, there are plenty of thrills and spills amidst the expositional sojourns, and it&rsquo;s occasionally a perky, funky, vibrant take on the character&rsquo;s mythology.</p>','','BS4 3EN','51.46636228553551','-2.5787554133056574',NULL,NULL,1,0,1,0,NULL,NULL,'2014-07-04 00:00:01','0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(192,NULL,2,'Film review: Captain America: The Winter Soldier','film-review-captain-america-the-winter-soldier','Itâ€™s a slick, bold action-adventure film','<p style=\"font-family: \'palatino linotype\', palatino, serif; font-size: 14px; line-height: 21px;\"><span style=\"line-height: 1.5em;\">Another week, another Marvel comics movie, this time pitting Captain America, aka super soldier Steve Rogers, against the shadowy machinations of S.H.I.E.L.D in a movie that&rsquo;s fast, frenetic and huge, rip-roaring fun.</span></p>\r\n<p style=\"font-family: \'palatino linotype\', palatino, serif; font-size: 14px; line-height: 21px;\">Captain America&rsquo;s second outing is the eighth movie in the Marvel universe released since 2008 (actually nine if you include The Incredible Hulk), with the cash-cow not set to stop there with a rumoured four more in the works. It&rsquo;s the franchise that just keeps giving. You might also be forgiven for thinking that the whole superhero conceit is starting to wear a bit thin, and the oh-so regular tranche comic book film forays are running out of steam and imagination.</p>\r\n<p style=\"font-family: \'palatino linotype\', palatino, serif; font-size: 14px; line-height: 21px;\">That couldn&rsquo;t be further from the truth here &ndash; and to a large extent the entire Marvel world, as its characters span a diverse range of genres &ndash; as Captain A is shifted to a new genre himself: the 70s spy espionage thriller.<br />And who better to usher into the comic enclave than 70s icon Robert Redford as suave S.H.I.E.L.D top man, Alexander Pierce, who adds a weight, occasionally chilly gravitas. Directors the Russo brothers even throw in a few neat 70s references, including a nod to the brainwashing scene from the Manchurian Candidate and a few shots of the Watergate building.</p>\r\n<p style=\"font-family: \'palatino linotype\', palatino, serif; font-size: 14px; line-height: 21px;\">It&rsquo;s a slick, bold action-adventure film that has Steve Rogers chiselled out as a character who would now sit more comfortably alongside the likes of Jack Ryan or Jason Bourne, manoeuvring his way through series of cross and double crosses and twisty, labyrinthine plots in which he doesn&rsquo;t know who to trust or who to believe, even himself. Things are darker, more noir-ish and insidious than before &ndash; at least for three quarters of the film anyway &ndash; a perilous search to weed out the enemy from within.</p>\r\n<p style=\"font-family: \'palatino linotype\', palatino, serif; font-size: 14px; line-height: 21px;\">Recently, the Marvel universe has exploited the idea that the characters interweave and relate to each other in their vast, inter-dependent universe, hopscotching in and out of each other films with casual, party-crashing abandon.</p>\r\n<p style=\"font-family: \'palatino linotype\', palatino, serif; font-size: 14px; line-height: 21px;\">Here, however, it feels like a completely independent movie that can stand on its own two feet without any particular knowledge (though admittedly a little bit would help) of anything that&rsquo;s gone before it.</p>\r\n<p style=\"font-family: \'palatino linotype\', palatino, serif; font-size: 14px; line-height: 21px;\">Kicking off with a thrilling rescue mission on board a hijacked ship, it soon becomes clear to ol&rsquo; Cap that something strange is afoot, with Samuel L Jackson&rsquo;s Nick Fury revealing the organisations plans to launch a series of heli-ships armed with an eye-popping array of weaponry under the guise of protecting the universe and predicting crimes &ndash; Minority Report pre-crime style &ndash; before they happen. But duplicitous machinations and shadowy dealings soon surface, throwing Rogers&rsquo; into a cat-and-mouse chase and as a fugitive on the run.</p>\r\n<p style=\"font-family: \'palatino linotype\', palatino, serif; font-size: 14px; line-height: 21px;\">What adds an extra dimension and further dramatic scope is that the whole movie doesn&rsquo;t solely hang on Captain America himself. Amidst the action &ndash; and there&rsquo;s plenty of it &ndash; there&rsquo;s also breathing space for the development of other key characters.</p>\r\n<p style=\"font-family: \'palatino linotype\', palatino, serif; font-size: 14px; line-height: 21px;\">Scarlett Johansson&rsquo;s Black Widow and Samuel L Jackson&rsquo;s Nick Fury get satisfyingly meatier roles, making it more of an ensemble superhero piece, yet with the Captain still the bonding agent that keeps the whole troupe together. Chris Evans throws in a nice turn as the Captain, charming, complicated, with depth, emotion, heart and soul.</p>\r\n<p style=\"font-family: \'palatino linotype\', palatino, serif; font-size: 14px; line-height: 21px;\">If there&rsquo;s a slight problem then it&rsquo;s with Anthony Mackie&rsquo;s fellow S.H.I.E.L.D soldier Sam Wilson who, quite late in the film, dons a hi-tech prototype exoskeleton that sprouts mechanical wings to become The Falcon. It&rsquo;s not the best of characters anyway, and its CGI execution is slightly clunky and awkward, feeling more like he&rsquo;s yet another character thrown into the Marvel milieu just for the sake of it.</p>\r\n<p style=\"font-family: \'palatino linotype\', palatino, serif; font-size: 14px; line-height: 21px;\">Surprisingly too, the metal-armed cyborg Winter Soldier of the title doesn&rsquo;t make that much of a menacing mark, not so much an imposing, bad-ass super-villain as more of an inconsequential interloper, popping up a few times to grimace and scowl, but ranking as one of the least formidable bad guys in the Marvel canon so far.</p>\r\n<p style=\"font-family: \'palatino linotype\', palatino, serif; font-size: 14px; line-height: 21px;\">But these are minor quibbles in a movie that&rsquo;s immense fun, crammed choc-o-bloc full of superbly choreographed, dizzyingly action-packed set-pieces (a full-on, bullet-riddled assault on Nick Fury&rsquo;s car being a thrilling highlight), and interesting, developed character arcs. There are also a few tantalising post-credit sequences giving us a glimpse of characters to come.<br />And yes, we even get the obligatory Stan Lee cameo.</p>','','BS4 3EN','51.46138927792885','-2.611027752172845',NULL,NULL,1,0,1,0,NULL,NULL,'2014-07-04 00:00:01','0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(193,NULL,2,'Film review: Non-Stop','film-review-nonstop','Itâ€™s a kind slick narrative combo of Agatha Christie and Cluedo whodunit at 40,000 feet','<p style=\"font-family: \'palatino linotype\', palatino, serif; font-size: 14px; line-height: 21px;\"><span style=\"line-height: 1.5em;\">At 61, Liam Neeson has become a somewhat late entrant in the pantheon of action movie heroes. In recent years we&rsquo;ve seen him fight killer wolves in The Grey, have his wife and identity stolen in Unknown, and his daughter kidnapped by Albanians in Taken.</span></p>\r\n<p style=\"font-family: \'palatino linotype\', palatino, serif; font-size: 14px; line-height: 21px;\">It&rsquo;s a role he&rsquo;s taken on with gusto and verve, battling the bad guys with face-slapping, bone-crunching glee, occasionally the ultimate anti-hero but never afraid to expose his more vulnerable, human side. He&rsquo;s become a global superhero, the everyman of the action world, and perhaps the most convincing average Joe battling extraordinary circumstances since Harrison Ford as Indiana Jones or Jack Ryan.</p>\r\n<p style=\"font-family: \'palatino linotype\', palatino, serif; font-size: 14px; line-height: 21px;\">The premise to Non-Stop is text book high concept: Bill Marks (Neeson) &ndash; a washed-up, alcoholic, U.S. Air Marshal boards a flight across the Atlantic and receives a series of threatening texts from an unidentified passenger saying someone will be killed every 20 minutes unless $150 million is deposited into an offshore account.</p>\r\n<p style=\"font-family: \'palatino linotype\', palatino, serif; font-size: 14px; line-height: 21px;\">And so the heat is on, as Neeson whittles his way through the motley crew of passengers to suss out who the real terrorist is. Everyone&rsquo;s a suspect here, catching suspicious glances from potential distrustful passengers, and ticking the boxes of characters that may or may not play an important role later (Muslim doctor, New York cop, nerdy teacher, uncooperative youth).</p>\r\n<p style=\"font-family: \'palatino linotype\', palatino, serif; font-size: 14px; line-height: 21px;\">It deftly points us wrong directions, misguides and narratively trips us up, racking up a claustrophobic atmosphere of suspicion and suspense as Nesson relentlessly exchanges texts to catch his man. It&rsquo;s a kind slick narrative combo of Agatha Christie and Cluedo whodunit at 40,000 feet.</p>\r\n<p style=\"font-family: \'palatino linotype\', palatino, serif; font-size: 14px; line-height: 21px;\">There are a few cracking action sequences, including one fantastic, brutal fight in a locked toilet where there&rsquo;s barely enough room to swing a punch but there&rsquo;s a flurry of jaw-snapping fisticuffs.</p>\r\n<p style=\"font-family: \'palatino linotype\', palatino, serif; font-size: 14px; line-height: 21px;\">Director Juame Collet-Seraa, who also directed Neeson in Unknown, choreographs the set pieces with a slick and stylish flourish, and he&rsquo;s aided by some effective, disorienting cinematography by Flavio Martinez Labiano, and an occasionally pulsating score by John Ottman which accentuates the taut, tense atmosphere. Julianne Moore also comes along for the ride to offer Neeson calming support amidst the unfolding fear and paranoia.</p>\r\n<p style=\"font-family: \'palatino linotype\', palatino, serif; font-size: 14px; line-height: 21px;\">But the movie&rsquo;s real trump card and saving grace is Neeson,a hulking, grimacing, growling monolith of a man who you&rsquo;re often unsure is going to rough you up or burst into tears. Here he&rsquo;s a broken man, still suffering from the loss of his young daughter, distraught, emotional, totally vulnerable and exposed, yet brimming with frustration, anger and anxiety as he tries to convince passengers of their plight as they start to turn against him.</p>\r\n<p style=\"font-family: \'palatino linotype\', palatino, serif; font-size: 14px; line-height: 21px;\">He&rsquo;s a commanding, imperious presence with a huge amount of gravitas, full of brooding and melancholy, stomping through the aisles and barking lines such as &ldquo;I&rsquo;m not here to blow up the plane, I&rsquo;m here to save it!&rdquo; with absurdly believable, almost Shakespearean passion. Even his final, personal plea for understanding as he gives a quick synopsis of his life story has an emotional weight and power (&ldquo;I&rsquo;m not a good father. I&rsquo;m not a good man. But I want to save this plane.&rdquo;) It&rsquo;s something only Neeson could pull off effectively with such anguished, pained humanity.</p>\r\n<p style=\"font-family: \'palatino linotype\', palatino, serif; font-size: 14px; line-height: 21px;\">Ultimately though, this is big, dumb and incredibly fun action fare, a B-movie genre piece writ large and total, occasionally exhilarating, popcorn fodder. Take it for the trashy, nonsensical, outrageous fun that it is, switch your brain into neutral, and you&rsquo;ll have a hell of a good time.</p>','','BS4 3EN','51.472938656804','-2.541333233129876',NULL,NULL,1,0,1,0,NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(194,NULL,2,'Review: Muppets Most Wanted','review-muppets-most-wanted','Taking riffs on a raft espionage thrillers and mistaken identity plots, it breezes through several gut-bustingly funny musical numbers','<p style=\"font-family: \'palatino linotype\', palatino, serif; font-size: 14px; line-height: 21px;\">Kicking off immediately after the events of the last film, the Muppets embark on a European tour after being double-crossed by their sneaky agent Dominic Badguy (Ricky Gervais). It isn&rsquo;t log before matters take a turn for the worse and Kermit is kidnapped, sent off to a Russian gulag, and replaced by the mole-faced criminal mastermind, Constantine.</p>\r\n<p style=\"font-family: \'palatino linotype\', palatino, serif; font-size: 14px; line-height: 21px;\">Cognizant from the get-go of the old adage that the sequel is never as good as the original, the prophetic opening razzle-dazzle number &ldquo;We&rsquo;re doing a sequel&rdquo; prepares full-on Muppet aficionados for potential disappointment. They needn&rsquo;t worry though as, while it might not have as much heart, soul and affectionate nostalgia as The Muppets, it&rsquo;s still a madcap, energetic, occasionally self-deprecating globe-trotting crime caper.</p>\r\n<p style=\"font-family: \'palatino linotype\', palatino, serif; font-size: 14px; line-height: 21px;\">They zip from their first gig in Germany (Die Muppets) to Madrid to Berlin to Dublin, entangling themselves in a cross and double-cross plot as Badguy and Constantine attempt to steal the crown jewels from the Tower of London (cue laser-beam dodging, Mission: Impossible parody). Hot on their heels are Interpol agent, Jean Pierre Napoleon (Ty Burrell, clearly having a whale of a time as the bumbling French agent) and Sam the Eagle.</p>\r\n<p style=\"font-family: \'palatino linotype\', palatino, serif; font-size: 14px; line-height: 21px;\">Taking riffs on a raft espionage thrillers and mistaken identity plots, it breezes through several gut-bustingly funny musical numbers, again penned by Bret McKenzie. &ldquo;I&rsquo;m Number One&rdquo; has Constantine literally leap-frogging around the room to an exasperated Gervais, &ldquo;I&rsquo;ll Get You What You Want&rdquo; is an hysterical, funky Lionel Ritchie-style groove, and the inspired &ldquo;Interrogation Song&rdquo; is a superbly crafted exposition number that spits its lines with a machine-gun style delivery of the screwball comedy era. Miss Piggy even gets her own Celine Dion ballad.</p>\r\n<p style=\"font-family: \'palatino linotype\', palatino, serif; font-size: 14px; line-height: 21px;\">Kermit&rsquo;s gulag scenes are amusing enough as he tries to hatch a Great Escape-style plan to dig his way to freedom, made even more enjoyable &ndash; and slightly surreal &ndash; by the fact the rag tag band of singing and dancing inmates include the likes of Ray Liotta and Danny Trejo. There&rsquo;s also handful of in-jokes and movie references to keep the parents mildly amused (Kermit being wheeled into the gulag with a Hannibal Lecter mask strapped to his face is a hoot).</p>\r\n<p style=\"font-family: \'palatino linotype\', palatino, serif; font-size: 14px; line-height: 21px;\">Ricky Gervais is, well, Ricky Gervais, not adding any particular character or depth but serving the story as &lsquo;number two&rsquo; accomplice with his usual gurning, playful schtick. For those familiar with his Office days, he even manages to sneak a grin-inducing David Brent dance move into one of the musical numbers.</p>\r\n<p style=\"font-family: \'palatino linotype\', palatino, serif; font-size: 14px; line-height: 21px;\">As breezy and mirthful as it all is, however, it does outstay its welcome and could have done with a snip here and there, and it&rsquo;s all rounded off with a predictably moralistic epilogue about the importance of friendship.<br />Nevertheless, it&rsquo;s an infectiously fun, feel-good, occasionally inspired addition to the Muppet movie canon that will entertain the kids and their parents in equal measure.</p>','','BS4 3EN','51.43983331552017','-2.5469980585693293',NULL,NULL,1,0,1,0,NULL,NULL,'2014-07-04 00:00:01','0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(195,NULL,2,'Festival celebrates live of Bristol actor Cary Grant','festival-celebrates-live-of-bristol-actor-cary-grant','With news of a new Cary Grant festival taking place in Bristol this Autumn, we look back on the actorâ€™s bright career','<p style=\"font-family: \'palatino linotype\', palatino, serif; font-size: 14px; line-height: 21px;\">Nobody brought sophistication, charm, suaveness and effortless cool to the movies more than one of Bristol&rsquo;s most famous sons, Cary Grant.</p>\r\n<p style=\"font-family: \'palatino linotype\', palatino, serif; font-size: 14px; line-height: 21px;\">Born Archibald Leach in this very city on 18 January 1904, Grant lived a relatively unhappy childhood in Horfield as his mum battled clinical depression until she was eventually admitted to a mental institution (Grant was told by his father she&rsquo;d gone on a &lsquo;long holiday&rsquo; and later, at the age of 31, found out the truth).</p>\r\n<p style=\"font-family: \'palatino linotype\', palatino, serif; font-size: 14px; line-height: 21px;\">After his father remarried, relatively little is known about Grant&rsquo;s formative years, though he was expelled from Fairfeld Grammar School, performed as a stilt walker with the Bob Pender Stage Troupe, and travelled with them to the United States in 1920.</p>\r\n<p style=\"font-family: \'palatino linotype\', palatino, serif; font-size: 14px; line-height: 21px;\">He quickly became part of the vaudeville world and performed in a plethora of plays, adding acrobat, juggler and mime to his repertoire. This led to a natural transition to several Broadway musicals.</p>\r\n<p style=\"font-family: \'palatino linotype\', palatino, serif; font-size: 14px; line-height: 21px;\">He changed his name to Cary Lockwood but quickly changed it because it was similar to another actor&rsquo;s name, after which he changed it to Cary Grant, the reasoning being the initials CG had already proved particularly auspicious for Clark Gable and Gary Cooper.<br />After a long and massively successful film career during which he starred with a star-studded range of actors and actresses and worked with some of Hollywood&rsquo;s top directors, Grant died on 29 November 1986.</p>\r\n<p style=\"font-family: \'palatino linotype\', palatino, serif; font-size: 14px; line-height: 21px;\">His legacy, however, lives on through the string of unforgettable celluloid masterpieces he starred in. Here are five of my favourites.</p>\r\n<p style=\"font-family: \'palatino linotype\', palatino, serif; font-size: 14px; line-height: 21px;\"><strong>His Girl Friday (1940)</strong></p>\r\n<p style=\"font-family: \'palatino linotype\', palatino, serif; font-size: 14px; line-height: 21px;\">Grant&rsquo;s early movie career comprised of several superlative screwball comedies, and this may well be his best. It&rsquo;s a blistering, relentless, hysterical remake of Ben Hecht&rsquo;s play, The Front Page, about the hysteria and manic madness of the newspaper world.</p>\r\n<p style=\"font-family: \'palatino linotype\', palatino, serif; font-size: 14px; line-height: 21px;\">The dialogue rattles along at a blistering, machine-gun fire pace and the performances by Grant, the spunky, feisty Rosalind Russell, and meek Ralph Bellamy. Grant&rsquo;s the editor, Russell his top reporter and ex-wife, Bellamy the new man in her life who doesn&rsquo;t stand a chance against Grant&rsquo;s incorrigible scheming and manipulation to Russell to cover a high-profile murder scoop and win her back.</p>\r\n<p style=\"font-family: \'palatino linotype\', palatino, serif; font-size: 14px; line-height: 21px;\"><span style=\"line-height: 1.5em;\">Twists, turns, tongue-tying one-liners, gems of physical comedy and top-notch supporting performances make this a bubbly, boisterous, brilliant comedy.</span></p>\r\n<p style=\"font-family: \'palatino linotype\', palatino, serif; font-size: 14px; line-height: 21px;\"><strong>Bringing Up Baby (1938)</strong></p>\r\n<p style=\"font-family: \'palatino linotype\', palatino, serif; font-size: 14px; line-height: 21px;\">Another quirky screwball comedy offering, here with Grant &ndash; usually charismatic and suave &ndash; as a flustered, absent-minded professor putting together dinosaur bones from an archaeological dig, whilst Katherine Hepburn is the kooky heiress whose pet dog steals the final, vital bone.<br />The movie whips along with gusto and verve in a labyrinthine, convoluted series of madcap escapades and implausibly nonsensical set-pieces. It was a box office failure when it was first released (then again, so was It&rsquo;s A Wonderful Life) but its standing today as one of the greatest screwball farces every made is indubitable. Oh, and the Baby of the title is a leopard.</p>\r\n<p style=\"font-family: \'palatino linotype\', palatino, serif; font-size: 14px; line-height: 21px;\"><strong>Charade (1963)</strong></p>\r\n<p style=\"font-family: \'palatino linotype\', palatino, serif; font-size: 14px; line-height: 21px;\">Another Hepburn &ndash; Audrey &ndash; pairs up with Grant, who here has echoes of characters from lighter Hitchcock roles. Hepburn, recently widowed, is followed by a gang of nasty gangsters in Paris, with Grant allegedly her shadowy protector &ndash; or is he? It&rsquo;s a harmless, fun, frothy caper that also throws in a great performance from Walter Matthau.</p>\r\n<p style=\"font-family: \'palatino linotype\', palatino, serif; font-size: 14px; line-height: 21px;\"><strong>Arsenic and Old Lace (1944)</strong></p>\r\n<p style=\"font-family: \'palatino linotype\', palatino, serif; font-size: 14px; line-height: 21px;\">Grant didn&rsquo;t much like is performance here, though the rest of us Grant fans are in agreement it&rsquo;s one of his frenetic best.</p>\r\n<p style=\"font-family: \'palatino linotype\', palatino, serif; font-size: 14px; line-height: 21px;\">It&rsquo;s a darker, macabre tale of Mortimer Brewster, recently-married author whose brother&rsquo;s convinced he&rsquo;s Teddy Roosevelt and whose aunts have a worrying predilection for poisoning old men. Brother Raymond Massey and alcoholic Peter Lorre try to dispose of a recently-deceased body, whilst the only thing Mortimre&rsquo;s wife wants to do is start their honeymoon.<br />Deliciously twisted fun from director Frank Capra.</p>\r\n<p style=\"font-family: \'palatino linotype\', palatino, serif; font-size: 14px; line-height: 21px;\"><strong>North By Northwest (1959)</strong></p>\r\n<p style=\"font-family: \'palatino linotype\', palatino, serif; font-size: 14px; line-height: 21px;\">Another spin on Hitchcock&rsquo;s favourite &lsquo;wrong man&rsquo; theme, Grant plays ad man Roger Thornhill who is mistaken for a top spy and then set up for murder. On the run as a fugitive, his quest is to find the real culprit to save his own life. Sexy but mysterious, icy blonde Eve Kendall (Eve Marie Saint) pairs up to help him, but may or may not be as straightforward as she seems.<br />Kinetic, colourful and comic, this is Hitchcock at his mischievous, playful, entertaining best, staging a few (now iconic) set pieces involving a crop duster and a perilous dash across the stone faces of Mount Rushmore.</p>\r\n<p style=\"font-family: \'palatino linotype\', palatino, serif; font-size: 14px; line-height: 21px;\">James Mason puts in a memorable turn as deadly enemy agent Vandamm, and despite numerous death-defying scrapes, Grant still looks immaculate. Fantastic score by Bernard Herrmann, too.</p>','','BS4 3EN','51.46213793738036','-2.5263128626464777',NULL,NULL,1,0,0,0,NULL,NULL,'2014-07-04 00:00:01','0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(196,NULL,2,'Supergirl gets the Bristol Bad Film Club treatment','supergirl-gets-the-bristol-bad-film-club-treatment','Bristol Bad Film Club has teamed up with What The Frock! for a special One25 charity fundraiser on April 24','<p style=\"font-family: \'palatino linotype\', palatino, serif; font-size: 14px; line-height: 21px;\"><span style=\"line-height: 1.5em;\">Bristol Bad Film Club is teaming up with What The Frock! Comedy&nbsp;to show Supergirl&hellip; the reason Wonder Woman is still waiting to have her own film.</span></p>\r\n<p style=\"font-family: \'palatino linotype\', palatino, serif; font-size: 14px; line-height: 21px;\">Two local institutions &ndash; The Bristol Bad Film Club and What The Frock! Comedy &ndash; are uniting to put on a film and comedy fundraising event on April 24 in support of our city&rsquo;s One25 Charity.</p>\r\n<p style=\"font-family: \'palatino linotype\', palatino, serif; font-size: 14px; line-height: 21px;\">In-between the disastrous Superman III and the god-awful Superman IV: The Quest For Peace, producers&nbsp;Alexander&nbsp;and&nbsp;Ilya Salkind&nbsp;were still looking to wring as much cash as possible from their superhero franchise.</p>\r\n<p style=\"font-family: \'palatino linotype\', palatino, serif; font-size: 14px; line-height: 21px;\">Their brilliant idea? A spin-off, starring Superman&rsquo;s cousin &ndash; Supergirl!<br />Starring the likes of Peter O&rsquo;Toole, Faye Dunaway and Peter Cook (all of whom were clearly strapped for cash), Supergirl attempted to replicate the success of the first Superman movie by surrounding the unknown lead with some famous faces. It didn&rsquo;t work.</p>\r\n<p style=\"font-family: \'palatino linotype\', palatino, serif; font-size: 14px; line-height: 21px;\">We know what you&rsquo;re thinking: &ldquo;But I love Supergirl! It was great when I was a kid!&rdquo; We grew up loving Supergirl as well, but you have to admit, it&rsquo;s one of the most bizarre, cheap-looking and nonsensical superhero films ever made. Need proof? Just look at the opening scene.</p>\r\n<p style=\"font-family: \'palatino linotype\', palatino, serif; font-size: 14px; line-height: 21px;\">It starts with Peter O&rsquo;Toole playing Argo City&rsquo;s resident artist and eccentric Zaltar, stealing the city&rsquo;s power source in order to create a tree. Kara (aka Supergirl) then makes a dragonfly using Zaltar&rsquo;s magic wand, which then ruptures Argo City&rsquo;s &lsquo;membrane&rsquo;, prompting Kara to try and retrieve in it an&nbsp;inter-dimensional pod. At least, that&rsquo;s what we think it is. Details aren&rsquo;t important in this film.</p>\r\n<p style=\"font-family: \'palatino linotype\', palatino, serif; font-size: 14px; line-height: 21px;\">Cue some classic dialogue:<br />&ldquo;What is a tree?&rdquo;<br />&ldquo;A lovely thing which grows on Earth.&rdquo;<br />&ldquo;Earth? You mean where my cousin went?&rdquo;<br />&ldquo;And to where one day soon perhaps I might venture as well.&rdquo;<br />&ldquo;I don&rsquo;t believe you. How?&rdquo;<br />&ldquo;In that. Through there.&rdquo;&nbsp;(We like to think this was improvised on O&rsquo;Toole&rsquo;s part because he couldn&rsquo;t be bothered to spout the rubbish dialogue)<br />&ldquo;The Binary Chute? But you could never survive the pressure. It would destroy you&hellip;&rdquo;</p>\r\n<p style=\"font-family: \'palatino linotype\', palatino, serif; font-size: 14px; line-height: 21px;\">Still, Peter O&rsquo;Toole at his most lame is still better than 90% of the world&rsquo;s actors. Which brings us to the rest of the cast.&nbsp;<span style=\"line-height: 1.5em;\">Despite throwing money at some of the biggest stars at the time (Dolly Parton was offered $7 million to star as the villain, Dudley Moore $4 million to be her lackey), no one wanted to take part. Rumour has it that Melanie Griffith, Brooke Shields and Demi Moore all turned down the role, until relative unknown Helen Slater was finally cast.</span></p>\r\n<p style=\"font-family: \'palatino linotype\', palatino, serif; font-size: 14px; line-height: 21px;\">While she is perfectly fine in the role, it is a shame that the overall film never saw her career take off. Plus it doesn&rsquo;t help that while she&rsquo;s taking it seriously, everyone else seems to be there for the money or just bemused by the whole thing.</p>\r\n<p style=\"font-family: \'palatino linotype\', palatino, serif; font-size: 14px; line-height: 21px;\">The film went on to under-perform in every possible way. It has the lowest box office returns of any Superman film (just $14 million) and even got Peter O&rsquo;Toole and Faye Dunaway nominated for two Razzie awards.</p>\r\n<p style=\"font-family: \'palatino linotype\', palatino, serif; font-size: 14px; line-height: 21px;\">It is one reason DC Comics are so reluctant to put money into a female-led superhero film (Catwoman can also take a lot of the blame), but for that reason alone, it stands unique among the plethora of spandex-clad superhero films out there.</p>\r\n<p style=\"font-family: \'palatino linotype\', palatino, serif; font-size: 14px; line-height: 21px;\">As well as the film, What The Frock! Comedy comedian&nbsp;Amy Howerska&nbsp;will be performing a stand-up set before the film. And with Amy being a card-carrying Supergirl geek, that is something not to be missed!</p>\r\n<p style=\"font-family: \'palatino linotype\', palatino, serif; font-size: 14px; line-height: 21px;\">The event is on April 24 at 8pm, at The Cuban on Bristol&rsquo;s Harbourside. Tickets are &pound;7 in advance and &pound;8 cash on the door, with all profits going to&nbsp;<a style=\"color: #cd1613; outline: none; text-decoration: none; font-weight: bold;\" href=\"http://www.one25.org.uk/\" target=\"_blank\">One25 Charity</a>.</p>','','BS4 3EN','51.43656961547595','-2.5392732966064386',NULL,NULL,1,0,0,0,NULL,NULL,'2014-07-04 00:00:01','0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(197,NULL,2,'Top 10 film releases - July 2014','top-10-film-releases-july-2014','Summer blockbuster season is here, with lots of exciting releases this month','<p style=\"font-family: \'palatino linotype\', palatino, serif; font-size: 14px; line-height: 21px;\"><strong>CINEMA RELEASES:</strong></p>\r\n<p style=\"font-family: \'palatino linotype\', palatino, serif; font-size: 14px; line-height: 21px;\"><strong>Transformers: Age of Extinction</strong></p>\r\n<p style=\"font-family: \'palatino linotype\', palatino, serif; font-size: 14px; line-height: 21px;\">Michael Bay directs again and blows more things up in the fourth instalment of the franchise, which this time sees a car mechanic and his daughter make a discovery that makes them a target for the Autobots, Decepticons and a paranoid government official.</p>\r\n<p style=\"font-family: \'palatino linotype\', palatino, serif; font-size: 14px; line-height: 21px;\"><strong>How to Train Your Dragon 2</strong></p>\r\n<p style=\"font-family: \'palatino linotype\', palatino, serif; font-size: 14px; line-height: 21px;\">Second instalment of the kids&rsquo; cartoon. When Hiccup and Toothless discover an ice cave that is home to hundreds of new wild dragons and the mysterious Dragon Rider, the two friends find themselves at the center of a battle to protect the peace.</p>\r\n<p style=\"font-family: \'palatino linotype\', palatino, serif; font-size: 14px; line-height: 21px;\"><strong>Dawn of the Planet of the Apes</strong></p>\r\n<p style=\"font-family: \'palatino linotype\', palatino, serif; font-size: 14px; line-height: 21px;\">Director Matt Reeves goes ape directing mo-cap master Andy Serkis in this highly anticipated sequel. A growing nation of genetically evolved apes, led by Caesar, is threatened by a band of human survivors of the devastating virus unleashed a decade earlier. However, peace is short-lived and a war is unleashed to determine Earth&rsquo;s dominant species.</p>\r\n<p style=\"font-family: \'palatino linotype\', palatino, serif; font-size: 14px; line-height: 21px;\"><strong>Guardians of the Galaxy</strong></p>\r\n<p style=\"font-family: \'palatino linotype\', palatino, serif; font-size: 14px; line-height: 21px;\">Another, more unique entry into the Marvel universe sees American pilot Peter Quill the object of an outer space manhunt after stealing an orb created by the villainous Ronan.</p>\r\n<p style=\"font-family: \'palatino linotype\', palatino, serif; font-size: 14px; line-height: 21px;\"><strong>The Purge: Anarchy</strong></p>\r\n<p style=\"font-family: \'palatino linotype\', palatino, serif; font-size: 14px; line-height: 21px;\">Terrifying sequel that continues the original&rsquo;s premise where one night a year, all crime &ndash; including murder &ndash; is legal for 12 hours. This one sees a man heading out into the carnage and chaos to avenge the death of his son, only to inadvertently end up rescuing a stranded couple.</p>\r\n<p style=\"font-family: \'palatino linotype\', palatino, serif; font-size: 14px; line-height: 21px;\"><strong>DVD/BLU-RAY:</strong></p>\r\n<p style=\"font-family: \'palatino linotype\', palatino, serif; font-size: 14px; line-height: 21px;\"><strong>The Lego Movie</strong></p>\r\n<p style=\"font-family: \'palatino linotype\', palatino, serif; font-size: 14px; line-height: 21px;\">Fun, frenetic riff on the Lego universe which see an ordinary Lego construction worker, thought to be the prophesied &lsquo;Special&rsquo;, recruited to join a quest to stop an evil tyrant from gluing the Lego universe into eternal stasis.</p>\r\n<p style=\"font-family: \'palatino linotype\', palatino, serif; font-size: 14px; line-height: 21px;\"><strong>The Grand Budapest Hotel</strong></p>\r\n<p style=\"font-family: \'palatino linotype\', palatino, serif; font-size: 14px; line-height: 21px;\">Director Wes Anderson&rsquo;s typically offbeat, idiosyncratic comedy farce recounts the adventures of Gustave H, a legendary concierge at a famous European hotel between the wars, and Zero Moustafa, the lobby boy who becomes his most trusted friend. Quirky, surreal and sublime.</p>\r\n<p style=\"font-family: \'palatino linotype\', palatino, serif; font-size: 14px; line-height: 21px;\"><strong>The Book Thief</strong></p>\r\n<p style=\"font-family: \'palatino linotype\', palatino, serif; font-size: 14px; line-height: 21px;\">Adapted from the novel by Markus Zusak, during World War II young Liesel finds solace by stealing books and sharing them with others, whilst in the basement of her home a Jewish refugee is being sheltered by her adoptive parents.</p>\r\n<p style=\"font-family: \'palatino linotype\', palatino, serif; font-size: 14px; line-height: 21px;\"><strong>Under The Skin</strong></p>\r\n<p style=\"font-family: \'palatino linotype\', palatino, serif; font-size: 14px; line-height: 21px;\">Based on Michael Faber&rsquo;s novel, director Jonathan Glazer weaves a trippy, surreal, subversive tale of a mysterious alien seductress (Scarlett Johansson) who roams around Scotland in search of men to lure into her otherworldly lair.</p>\r\n<p style=\"font-family: \'palatino linotype\', palatino, serif; font-size: 14px; line-height: 21px;\"><strong>Noah</strong></p>\r\n<p style=\"font-family: \'palatino linotype\', palatino, serif; font-size: 14px; line-height: 21px;\">Darren Aronofsky directs Russell Crowe as Noah in this sweeping, epic take on the tale of the man chosen by his world&rsquo;s creator to undertake a momentous mission before an apocalyptic flood cleanses the world.</p>','','BS4 3EN','51.448927642496','-2.5946340906738214',NULL,NULL,1,0,0,0,NULL,NULL,'2014-07-04 00:00:01','0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(198,NULL,2,'Review: Rosie Wilby at Watershed, Bristol','review-rosie-wilby-at-watershed-bristol','The show is structured perfectly and has a strong narrative arc and a wonderful twist at the end','<p style=\"font-family: \'palatino linotype\', palatino, serif; font-size: 14px; line-height: 21px;\">Rosie Wilby is one of the finest stand up comedians in the UK. She has been compared, in the past, to Eddie Izzard, high praise indeed, possibly due to her anecdotal and tangential style which can see the absurd and humorous in the everyday.</p>\r\n<p style=\"font-family: \'palatino linotype\', palatino, serif; font-size: 14px; line-height: 21px;\">Who would imagine the instructions for the cooking of a Pot Noodle are actually when removed from their normal context, ie person making it is so inebriated they wouldn&rsquo;t even bother reading the instructions, are very funny? Or they are when delivered by Rosie.</p>\r\n<p style=\"font-family: \'palatino linotype\', palatino, serif; font-size: 14px; line-height: 21px;\">However Nineties Woman isn&rsquo;t solely a stand up show it is very funny but has important points to make about society&rsquo;s approach to sexism and feminism and the issues feminism dealt with back in the mists of time, well the nineties. The show is structured perfectly and has a strong narrative arc and a wonderful twist at the end.</p>\r\n<p style=\"font-family: \'palatino linotype\', palatino, serif; font-size: 14px; line-height: 21px;\">Inspired by finding copies of the old York University feminist newspaper &lsquo;Matrix&rsquo; in her parent&rsquo;s house Rosie decides to track down her fellow contributors and see what &lsquo;Matrix&rsquo; meant to them and what they feel about feminism today and whether anything has changed.</p>\r\n<p style=\"font-family: \'palatino linotype\', palatino, serif; font-size: 14px; line-height: 21px;\">The majority of the revealing and honest interviews are filmed and the films are curious, perhaps the most comfortable person on camera was the acclaimed comedian Zoe Lyons who was warm, funny and honest about her motives for joining &lsquo;Matrix&rsquo; ie she fancied the charismatic leader &lsquo;Kate&rsquo;. A number of the editorial collective who were lesbians in the Nineties or rather were &lsquo;political&rsquo; lesbians subsequently discarded that identity in the intervening years, much to the bemusement of their peers. This in itself was enough to spark a lively post-show discussion, much later, about nature, nurture, and choice when it comes to sexual identity.</p>\r\n<p style=\"font-family: \'palatino linotype\', palatino, serif; font-size: 14px; line-height: 21px;\">Feminism and feminists are all too often seen as very, very serious and lacking in humour. This show proves that with the benefit of hindsight this really is not the case. Well certainly not nowadays. Being of an age when I remember the type of women who ran &lsquo;Matrix&rsquo; running &lsquo;Codpiece&rsquo; the radical theatre soc at my old University (still going today) and the LGB society (they didn&rsquo;t like the &lsquo;T&rsquo;s much back then) much of Nineties Woman rang very true indeed. The women took themselves and their feminism and politics VERY SERIOUSLY INDEED unsurprisingly, they were dealing with and protesting big issues.</p>\r\n<p style=\"font-family: \'palatino linotype\', palatino, serif; font-size: 14px; line-height: 21px;\">However, slightly guilty though I felt, the point where Rosie Wilby read a birthday card from her big crush, the ubiquitous, charismatic &lsquo;Kate&rsquo; which was essentially hippy dippy drivel repeating &lsquo;Deep peace&rsquo; at the start of each line was one of the most amusing things I have seen this year. Closely followed by Rosie&rsquo;s attempt to storm an elitist college ball and the subsequent shock she received whne she did.</p>\r\n<p style=\"font-family: \'palatino linotype\', palatino, serif; font-size: 14px; line-height: 21px;\">This show doesn&rsquo;t just examine feminism it examines the search for identity and the need to belong and to find kindred spirits. It will strike a chord with anyone who has felt outside the norm, who wants to be cooler than they think they are (note to all teenagers and young people, you&rsquo;re really not as cool as you think) and anyone who was once involved with student politics or had an inappropriate crush or unattainable crush. Well crafted, well researched and making the juncture where the personal met the political funny and yet poignant.</p>','<p>s</p>','BS4 3EN','51.46566716651704','-2.5877676355956964',NULL,NULL,1,0,0,0,NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(202,NULL,2,'Cibo Restaurant','cibo_restaurant','Cibo Restaurant has been established for nearly 3 decades. We warmly welcome you to a relaxed environment, whatever your occasion.','<h3 style=\"border: 0px; outline: 0px; font-size: 18px; vertical-align: baseline; margin: 0px 0px 0.5em; padding: 0px; font-family: \'Palatino,;\"><strong style=\"border: 0px; outline: 0px; vertical-align: baseline; margin: 0px; padding: 0px; background: transparent;\">Address:</strong>&nbsp;289 Gloucester Rd, Bristol, BS7 8NY<br /><strong style=\"border: 0px; outline: 0px; vertical-align: baseline; margin: 0px; padding: 0px; background: transparent;\">Telephone:</strong>&nbsp;0117 9429 475<br /><strong style=\"border: 0px; outline: 0px; vertical-align: baseline; margin: 0px; padding: 0px; background: transparent;\">Website:</strong>&nbsp;<a style=\"border: 0px; outline: 0px; vertical-align: baseline; margin: 0px; padding: 0px; color: #cd2127; text-decoration: none; background: transparent;\" href=\"http://www.ciboristorante.co.uk/\" target=\"_blank\">www.ciboristorante.co.uk</a><br /><strong style=\"border: 0px; outline: 0px; vertical-align: baseline; margin: 0px; padding: 0px; background: transparent;\">Twitter:</strong>&nbsp;<a style=\"border: 0px; outline: 0px; vertical-align: baseline; margin: 0px; padding: 0px; color: #cd2127; text-decoration: none; background: transparent;\" href=\"https://twitter.com/Cibo_Bristol\" target=\"_blank\">@Cibo_Bristol</a><br /><strong style=\"border: 0px; outline: 0px; vertical-align: baseline; margin: 0px; padding: 0px; background: transparent;\">Facebook:</strong>&nbsp;<a style=\"border: 0px; outline: 0px; vertical-align: baseline; margin: 0px; padding: 0px; color: #cd2127; text-decoration: none; background: transparent;\" href=\"https://www.facebook.com/pages/CIBO-Ristorante/123782687639956\" target=\"_blank\">Click here&hellip;</a></h3>\r\n<p style=\"border: 0px; outline: 0px; font-size: 14px; vertical-align: baseline; margin: 0px 0px 1.2em; padding: 0px; line-height: 21px; font-family: Palatino, \'Palatino Linotype\', serif; color: #333333; background-image: initial; background-attachment: initial; background-size: initial; background-origin: initial; background-clip: initial; background-position: initial; background-repeat: initial;\">&nbsp;</p>\r\n<p style=\"border: 0px; outline: 0px; font-size: 14px; vertical-align: baseline; margin: 0px 0px 1.2em; padding: 0px; line-height: 21px; font-family: Palatino, \'Palatino Linotype\', serif; color: #333333; background-image: initial; background-attachment: initial; background-size: initial; background-origin: initial; background-clip: initial; background-position: initial; background-repeat: initial;\">Cibo Restaurant has been established for nearly 3 decades. We warmly welcome you to a relaxed environment, whatever your occasion &ndash; coffee with a friend, lunch with the kids, a glass of wine with a colleague or an evening meal with someone special.</p>\r\n<p style=\"border: 0px; outline: 0px; font-size: 14px; vertical-align: baseline; margin: 0px 0px 1.2em; padding: 0px; line-height: 21px; font-family: Palatino, \'Palatino Linotype\', serif; color: #333333; background-image: initial; background-attachment: initial; background-size: initial; background-origin: initial; background-clip: initial; background-position: initial; background-repeat: initial;\">We use the finest and freshest ingredients. Our menu offers affordable authentic Italian classics; tempting antipasti, pizza and pasta choices, as well as mouth watering contemporary fish and meat dishes &ndash; and check out our blackboard for changing daily specials. We also have a take away service; you can order your meal and collect.</p>\r\n<p style=\"border: 0px; outline: 0px; font-size: 14px; vertical-align: baseline; margin: 0px 0px 1.2em; padding: 0px; line-height: 21px; font-family: Palatino, \'Palatino Linotype\', serif; color: #333333; background-image: initial; background-attachment: initial; background-size: initial; background-origin: initial; background-clip: initial; background-position: initial; background-repeat: initial;\">Home cooked food without the hassle. Bespoke catering available for small and informal events, larger celebrations or business entertaining &ndash; Speak to us or pop in and choose from our range of fresh and oven ready meals available to pick up and take away at any time &hellip;and why not add a bottle of wine from our extensive Italian range, all wines are 50% discounted from our in-house price list.</p>','','BS7 8NY','51.479171','-2.589170500000023',NULL,NULL,1,0,0,0,NULL,NULL,'2014-07-04 00:00:01','0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(207,NULL,2,'Bottelino\'s','bottelinos','Bedminster branch of the newly awarded \'2010 Independent Italian Restaurant Chain of the Year\'','<p><span style=\"color: #333333; font-family: Palatino, \'Palatino Linotype\', serif; font-size: 14px; line-height: 21px;\">Welcome to the Bedminster branch of the newly awarded &rsquo;2010 Independent Italian Restaurant Chain of the Year&rsquo;, where our excellence has been nationally recognised.</span></p>','','BS3 4AQ','51.4440711','-2.593840900000032',NULL,NULL,1,0,1,0,NULL,NULL,'2014-07-04 00:00:01','0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(208,NULL,2,'Mamma Mia','mamma_mia','Family-Italian restaurant, established in 1985. Function room available for private dining upstairs.','<p><a style=\"color: #cd2127; outline: none; text-decoration: none; font-family: \'palatino linotype\', palatino, serif; font-size: 14px; line-height: 19.600000381469727px;\" href=\"http://www.mammamiabristol.co.uk/\" target=\"_blank\">Mamma Mia</a><span style=\"color: #1c1c1c; font-family: \'palatino linotype\', palatino, serif; font-size: 14px; line-height: 19.600000381469727px;\">&nbsp;on Park Row is one of the stereotypical &lsquo;traditional family-run Italian&rsquo; restaurants that are abundant in Bristol. It&rsquo;s the type of place that always makes me think of the restaurant scene in &ldquo;Lady And The Tramp&rdquo; &ndash; red and white checked tablecloths and a tall candle on each table, the Italian flag and various other curios on the walls, Italian music playing gently in the background&hellip;right down, on one previous visit, to a heated argument in Italian in the kitchen, audible to the entire restaurant.</span></p>','','BS1 5LJ','51.4552938','-2.6006790000000137',NULL,NULL,1,0,0,0,NULL,NULL,'2014-07-04 00:00:01','0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(209,NULL,2,'Europa','europa','Aiming to bring our customers freshly prepared Italian cooking at its best','<p><span style=\"color: #333333; font-family: Palatino, \'Palatino Linotype\', serif; font-size: 14px; line-height: 21px;\">Europa Italian Restaurant aim to bring our customers freshly prepared Italian cooking at its best, our portions are large and our prices are reasonable; what more could you want! Taking the freshest produce available we create incredible freshly cooked pizzas and pasta dishes. Alongside our meat, fish and chicken the choice is wide but carefully chosen to present authentic Italian cuisine. There are also daily specials to choose from plus an extensive wine list.</span></p>','','BS1 1JX','51.4536968','-2.594699799999944',NULL,NULL,1,1,0,0,NULL,NULL,'2014-07-04 00:00:01','0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(210,NULL,2,'Coronation Curry House','coronation_curry_house','The Coronation Curry House is a brand new Indian restaurant opened on Coronation Road, Southville.','<h3 style=\"border: 0px; outline: 0px; font-size: 18px; vertical-align: baseline; margin: 0px 0px 0.5em; padding: 0px; font-family: \'Palatino,;\"><strong style=\"border: 0px; outline: 0px; vertical-align: baseline; margin: 0px; padding: 0px; background: transparent;\">Address:</strong>&nbsp;190 Coronation Road, Bristol, BS3 1RF<br /><strong style=\"border: 0px; outline: 0px; vertical-align: baseline; margin: 0px; padding: 0px; background: transparent;\">Telephone:</strong>&nbsp;0117 966 4569<br /><strong style=\"border: 0px; outline: 0px; vertical-align: baseline; margin: 0px; padding: 0px; background: transparent;\">Website: N/A</strong></h3>\r\n<p style=\"border: 0px; outline: 0px; font-size: 14px; vertical-align: baseline; margin: 0px 0px 1.2em; padding: 0px; line-height: 21px; font-family: Palatino, \'Palatino Linotype\', serif; color: #333333; background-image: initial; background-attachment: initial; background-size: initial; background-origin: initial; background-clip: initial; background-position: initial; background-repeat: initial;\">The Coronation Curry House warmly welcomes you to experience and enjoy the authentic culinary art of Indian cuisine.</p>\r\n<p style=\"border: 0px; outline: 0px; font-size: 14px; vertical-align: baseline; margin: 0px 0px 1.2em; padding: 0px; line-height: 21px; font-family: Palatino, \'Palatino Linotype\', serif; color: #333333; background-image: initial; background-attachment: initial; background-size: initial; background-origin: initial; background-clip: initial; background-position: initial; background-repeat: initial;\">The Coronation Curry House is a brand new Indian restaurant opened on Coronation Road, Southville&nbsp;(Opposite Vauxhall Bridge). The Coronation Curry House is a fully licensed restaurant and is a 5 minute walking distance from the vibrant North Street, Bedminster and also the Tobacco Factory Theatre. The Coronation Curry House also do takeaway.</p>\r\n<p style=\"border: 0px; outline: 0px; font-size: 14px; vertical-align: baseline; margin: 0px 0px 1.2em; padding: 0px; line-height: 21px; font-family: Palatino, \'Palatino Linotype\', serif; color: #333333; background-image: initial; background-attachment: initial; background-size: initial; background-origin: initial; background-clip: initial; background-position: initial; background-repeat: initial;\">Our aim is to provide you with a mouthwatering adventure like no other. At Coronation Curry House we are inspired to redefine Indian cooking excellence, set in atmospheric plush surroundings with a naturally relaxing ambience. We use only the freshest ingredients with authentic herbs and spices to flavour. Each dish is a masterpiece for you to enjoy and is complemented by our first class service.</p>\r\n<p style=\"border: 0px; outline: 0px; font-size: 14px; vertical-align: baseline; margin: 0px 0px 1.2em; padding: 0px; line-height: 21px; font-family: Palatino, \'Palatino Linotype\', serif; color: #333333; background-image: initial; background-attachment: initial; background-size: initial; background-origin: initial; background-clip: initial; background-position: initial; background-repeat: initial;\">Coronation Curry House is designed to be exclusive, friendly, informal, relaxing and fun &ndash; a place where you will always be welcomed.</p>','','BS3 1RF','51.4457853','-2.610223700000006',NULL,NULL,1,1,0,0,NULL,NULL,'2014-07-04 00:00:01','0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(211,NULL,2,'The Raj Indian Restaurant','the_raj_indian_restaurant','Family-run Indian restaurant, originally opened in 1981.','<h3 style=\"border: 0px; outline: 0px; font-size: 18px; vertical-align: baseline; margin: 0px 0px 0.5em; padding: 0px; font-family: \'Palatino,;\"><strong style=\"border: 0px; outline: 0px; vertical-align: baseline; margin: 0px; padding: 0px; background: transparent;\">Address:</strong>&nbsp;35 King Street, Bristol, BS1 4DZ<br /><strong style=\"border: 0px; outline: 0px; vertical-align: baseline; margin: 0px; padding: 0px; background: transparent;\">Telephone:</strong>&nbsp;0117 929 1132<br /><strong style=\"border: 0px; outline: 0px; vertical-align: baseline; margin: 0px; padding: 0px; background: transparent;\">Website:</strong>&nbsp;<a style=\"border: 0px; outline: 0px; vertical-align: baseline; margin: 0px; padding: 0px; color: #cd2127; text-decoration: none; background: transparent;\" href=\"http://www.raj-bristol.co.uk/\" target=\"_blank\">www.raj-bristol.co.uk</a></h3>\r\n<p style=\"border: 0px; outline: 0px; font-size: 14px; vertical-align: baseline; margin: 0px 0px 1.2em; padding: 0px; line-height: 21px; font-family: Palatino, \'Palatino Linotype\', serif; color: #333333; background-image: initial; background-attachment: initial; background-size: initial; background-origin: initial; background-clip: initial; background-position: initial; background-repeat: initial;\">Family-run Indian restaurant, originally opened in 1981.</p>','','BS1 4DZ','51.45194249999999','-2.59487850000005',NULL,NULL,1,0,0,0,NULL,NULL,'2014-07-04 00:00:01','0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(212,NULL,2,'4,500 Miles From Delhi','4500_miles_from_delhi','Bringing a little bit of Delhi to Bristol.','<h3 style=\"border: 0px; outline: 0px; font-size: 18px; vertical-align: baseline; margin: 0px 0px 0.5em; padding: 0px; font-family: \'Palatino,;\"><strong style=\"border: 0px; outline: 0px; vertical-align: baseline; margin: 0px; padding: 0px; background: transparent;\">Address:</strong>&nbsp;8 Colston Avenue, Bristol, BS1 4ST<br /><strong style=\"border: 0px; outline: 0px; vertical-align: baseline; margin: 0px; padding: 0px; background: transparent;\">Telephone:</strong>&nbsp;0117 929 2224<br /><strong style=\"border: 0px; outline: 0px; vertical-align: baseline; margin: 0px; padding: 0px; background: transparent;\">Website:</strong>&nbsp;<a style=\"border: 0px; outline: 0px; vertical-align: baseline; margin: 0px; padding: 0px; color: #cd2127; text-decoration: none; background: transparent;\" href=\"http://4500miles.co.uk/bristol\" target=\"_blank\">http://4500miles.co.uk/bristol</a></h3>\r\n<p style=\"border: 0px; outline: 0px; font-size: 14px; vertical-align: baseline; margin: 0px 0px 1.2em; padding: 0px; line-height: 21px; font-family: Palatino, \'Palatino Linotype\', serif; color: #333333; background-image: initial; background-attachment: initial; background-size: initial; background-origin: initial; background-clip: initial; background-position: initial; background-repeat: initial;\">Our chefs have been brought in from Delhi to ensure that the dishes that we serve are of the highest quality and prepared to authentic Indian recipes. Our chefs will be using fresh herbs, spices and ingredients that are free from artificial colouring and flavouring.</p>\r\n<p style=\"border: 0px; outline: 0px; font-size: 14px; vertical-align: baseline; margin: 0px 0px 1.2em; padding: 0px; line-height: 21px; font-family: Palatino, \'Palatino Linotype\', serif; color: #333333; background-image: initial; background-attachment: initial; background-size: initial; background-origin: initial; background-clip: initial; background-position: initial; background-repeat: initial;\">The generosity of our people is legendary. In Sanskrit literature we say &lsquo;Atithi Devo Bhava&rsquo; (the guest is truly your god) meaning that we are honoured to share our mealtimes with guests. Even our poorest look forward to receiving guests and sharing their meal.</p>\r\n<p style=\"border: 0px; outline: 0px; font-size: 14px; vertical-align: baseline; margin: 0px 0px 1.2em; padding: 0px; line-height: 21px; font-family: Palatino, \'Palatino Linotype\', serif; color: #333333; background-image: initial; background-attachment: initial; background-size: initial; background-origin: initial; background-clip: initial; background-position: initial; background-repeat: initial;\">With the restaurant we wanted to create a place that is relaxing and comfortable, but also wanted to inject some of the hustle and bustle of everyday life of Delhi. With the open plan &lsquo;theatre&rsquo; kitchen, in hope that we have brought a little bit of Delhi to Bristol.</p>','','BS1 4ST','51.4539205','-2.5966743999999835',NULL,NULL,1,0,0,0,NULL,NULL,'2014-07-04 00:00:01','0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(213,NULL,2,'Namaskar Lounge','namaskar_lounge','A unique Indian experience brought to the West, first stop - Bristol.','<h3 style=\"border: 0px; outline: 0px; font-size: 18px; vertical-align: baseline; margin: 0px 0px 0.5em; padding: 0px; font-family: \'Palatino,;\"><strong style=\"border: 0px; outline: 0px; vertical-align: baseline; margin: 0px; padding: 0px; background: transparent;\">Address:</strong>&nbsp;Welsh Back, Bristol, BS1 4RR<br /><strong style=\"border: 0px; outline: 0px; vertical-align: baseline; margin: 0px; padding: 0px; background: transparent;\">Telephone:</strong>&nbsp;0117 929 8276<br /><strong style=\"border: 0px; outline: 0px; vertical-align: baseline; margin: 0px; padding: 0px; background: transparent;\">Website:</strong>&nbsp;<a style=\"border: 0px; outline: 0px; vertical-align: baseline; margin: 0px; padding: 0px; color: #cd2127; text-decoration: none; background: transparent;\" href=\"http://www.namaskarlounge.com/\" target=\"_blank\">www.namaskarlounge.com</a><br /><strong style=\"border: 0px; outline: 0px; vertical-align: baseline; margin: 0px; padding: 0px; background: transparent;\">Twitter:</strong>&nbsp;<a style=\"border: 0px; outline: 0px; vertical-align: baseline; margin: 0px; padding: 0px; color: #cd2127; text-decoration: none; background: transparent;\" href=\"https://twitter.com/#!/namaskarlounge\" target=\"_blank\">@namaskarlounge</a></h3>\r\n<p style=\"border: 0px; outline: 0px; font-size: 14px; vertical-align: baseline; margin: 0px 0px 1.2em; padding: 0px; line-height: 21px; font-family: Palatino, \'Palatino Linotype\', serif; color: #333333; background-image: initial; background-attachment: initial; background-size: initial; background-origin: initial; background-clip: initial; background-position: initial; background-repeat: initial;\">Namaskar in its simplest form means welcome, we welcome you to join us in our future. A unique Indian experience brought to the West, first stop &ndash; Bristol.</p>\r\n<p style=\"border: 0px; outline: 0px; font-size: 14px; vertical-align: baseline; margin: 0px 0px 1.2em; padding: 0px; line-height: 21px; font-family: Palatino, \'Palatino Linotype\', serif; color: #333333; background-image: initial; background-attachment: initial; background-size: initial; background-origin: initial; background-clip: initial; background-position: initial; background-repeat: initial;\">&nbsp;</p>\r\n<p style=\"color: #1c1c1c; font-family: \'palatino linotype\', palatino, serif; font-size: 14px; line-height: 19.600000381469727px;\">Having been closed for several years, the old Bar Med site on Welsh Back has now been given a new lease of life. Indian restaurant and bar<a style=\"color: #cd2127; outline: none; text-decoration: none;\" href=\"http://www.namaskarlounge.com/\" target=\"_blank\">Namaskar Lounge</a>&nbsp;has been in the pipeline since early last year, and finally opened its doors before Christmas. With a plethora of Indian restaurants already in existence in Bristol, I&rsquo;m pleased to say that this place is a cut above the rest.</p>\r\n<p style=\"color: #1c1c1c; font-family: \'palatino linotype\', palatino, serif; font-size: 14px; line-height: 19.600000381469727px;\">Decor-wise, its smart interior, with more of a nightclub feel to the downstairs bar, flat screen TVs on the walls and futuristic lighting sets it apart from the &ldquo;standard&rdquo; furnishings that tend to feature in the majority of Indian restaurants. The owners certainly seem to be making it a destination venue&hellip;not just in its decor, but also in terms of its food and drink offerings.</p>\r\n<p style=\"color: #1c1c1c; font-family: \'palatino linotype\', palatino, serif; font-size: 14px; line-height: 19.600000381469727px;\">Unlike the majority of Indian restaurants, Namaskar Lounge prides itself on its drinks (<a style=\"color: #cd2127; outline: none; text-decoration: none;\" href=\"http://www.namaskarlounge.com/drinks/\" target=\"_blank\">see the drinks menu here</a>) as well as its food.The wine list ranges from &pound;15 to &pound;20 per bottle, and I was intrigued to see Indian wines included on the list. Beer drinkers can enjoy a decent range in bottles or on draught, but the real focus here is on cocktails.</p>\r\n<p style=\"color: #1c1c1c; font-family: \'palatino linotype\', palatino, serif; font-size: 14px; line-height: 19.600000381469727px;\">At &pound;5.95 &ndash; &pound;6.25, cocktail prices are very reasonable, and in addition to a list of &ldquo;classics&rdquo; you&rsquo;ll find a range of cocktails with an Indian theme, including ingredients such as Darjeeling tea, tamarind and cardamom. Annoyingly, I was having an alcohol-free night, but will definitely be back to try the &ldquo;Indian Summer&rdquo; &ndash; a cocktail starring Mount Gay rum, fresh tropical fruits, chilli and balsamic vinegar.</p>\r\n<p style=\"color: #1c1c1c; font-family: \'palatino linotype\', palatino, serif; font-size: 14px; line-height: 19.600000381469727px;\">Instead, I opted for a non-alcoholic and very refreshing watermelon and cucumber punch&nbsp;<em>(&pound;2.25)</em>&nbsp;to start, followed by a decidedly lurid but very tasty rose and cardamom lassi&nbsp;<em>(&pound;3.20)</em>&nbsp;later on. The bringing &ndash; without asking &ndash; of a Namaskar-branded glass bottle of tap water was also a nice touch.</p>','','BS1 4RR','51.45215','-2.5929671999999755',NULL,NULL,1,0,0,0,NULL,NULL,'2014-07-04 00:00:01','0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(214,NULL,2,'Bristol Raj Bari','bristol_raj_bari','A unique taste of Indian Cuisine in a comfortable, relaxed atmosphere combined with excellent customer service.','<h3 style=\"border: 0px; outline: 0px; font-size: 18px; vertical-align: baseline; margin: 0px 0px 0.5em; padding: 0px; font-family: \'Palatino,;\"><strong style=\"border: 0px; outline: 0px; vertical-align: baseline; margin: 0px; padding: 0px; background: transparent;\">Address:</strong>&nbsp;183 Hotwell Road, Bristol, BS8 4SA<br /><strong style=\"border: 0px; outline: 0px; vertical-align: baseline; margin: 0px; padding: 0px; background: transparent;\">Telephone:</strong>&nbsp;0117 922 7617<br /><strong style=\"border: 0px; outline: 0px; vertical-align: baseline; margin: 0px; padding: 0px; background: transparent;\">Website:</strong>&nbsp;<a style=\"border: 0px; outline: 0px; vertical-align: baseline; margin: 0px; padding: 0px; color: #cd2127; text-decoration: none; background: transparent;\" href=\"http://www.rajbaribristol.co.uk/\" target=\"_blank\">www.rajbaribristol.co.uk</a><br /><strong style=\"border: 0px; outline: 0px; vertical-align: baseline; margin: 0px; padding: 0px; background: transparent;\">Facebook:</strong>&nbsp;<a style=\"border: 0px; outline: 0px; vertical-align: baseline; margin: 0px; padding: 0px; color: #cd2127; text-decoration: none; background: transparent;\" href=\"http://www.facebook.com/group.php?gid=26914368557\" target=\"_blank\">Click here&hellip;</a></h3>\r\n<p style=\"border: 0px; outline: 0px; font-size: 14px; vertical-align: baseline; margin: 0px 0px 1.2em; padding: 0px; line-height: 21px; font-family: Palatino, \'Palatino Linotype\', serif; color: #333333; background-image: initial; background-attachment: initial; background-size: initial; background-origin: initial; background-clip: initial; background-position: initial; background-repeat: initial;\">A unique taste of Indian Cuisine in a comfortable, relaxed atmosphere combined with excellent customer service.</p>','','BS8 4SA','51.449712','-2.615888400000017',NULL,NULL,1,0,0,0,NULL,NULL,'2014-07-04 00:00:01','0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(216,NULL,2,'The Rose Of Denmark','the_rose_of_denmark','The Rose Of Denmark has satiated customers from the late 1800s until the present day.','<h3 style=\"border: 0px; outline: 0px; font-size: 18px; vertical-align: baseline; margin: 0px 0px 0.5em; padding: 0px; font-family: \'Palatino,;\"><strong style=\"border: 0px; outline: 0px; vertical-align: baseline; margin: 0px; padding: 0px; background: transparent;\">Address:</strong>&nbsp;6 Dowry Place, Hotwells, Bristol, BS8 4QL<br /><strong style=\"border: 0px; outline: 0px; vertical-align: baseline; margin: 0px; padding: 0px; background: transparent;\">Telephone:</strong>&nbsp;07709 832626<br /><strong style=\"border: 0px; outline: 0px; vertical-align: baseline; margin: 0px; padding: 0px; background: transparent;\">Website:</strong>&nbsp;<a style=\"border: 0px; outline: 0px; vertical-align: baseline; margin: 0px; padding: 0px; color: #cd2127; text-decoration: none; background: transparent;\" href=\"http://theroseofdenmark.com/\" target=\"_blank\">http://theroseofdenmark.com</a><br /><strong style=\"border: 0px; outline: 0px; vertical-align: baseline; margin: 0px; padding: 0px; background: transparent;\">Twitter:</strong>&nbsp;<a style=\"border: 0px; outline: 0px; vertical-align: baseline; margin: 0px; padding: 0px; color: #cd2127; text-decoration: none; background: transparent;\" href=\"http://twitter.com/roseofdenmark\" target=\"_blank\">@roseofdenmark</a><br /><strong style=\"border: 0px; outline: 0px; vertical-align: baseline; margin: 0px; padding: 0px; background: transparent;\">Facebook:</strong>&nbsp;<a style=\"border: 0px; outline: 0px; vertical-align: baseline; margin: 0px; padding: 0px; color: #cd2127; text-decoration: none; background: transparent;\" href=\"https://www.facebook.com/pages/The-Rose-of-Denmark/264104486955562\" target=\"_blank\">Click here&hellip;</a></h3>\r\n<p style=\"border: 0px; outline: 0px; font-size: 14px; vertical-align: baseline; margin: 0px 0px 1.2em; padding: 0px; line-height: 21px; font-family: Palatino, \'Palatino Linotype\', serif; color: #333333; background-image: initial; background-attachment: initial; background-size: initial; background-origin: initial; background-clip: initial; background-position: initial; background-repeat: initial;\">&nbsp;</p>\r\n<p style=\"border: 0px; outline: 0px; font-size: 14px; vertical-align: baseline; margin: 0px 0px 1.2em; padding: 0px; line-height: 21px; font-family: Palatino, \'Palatino Linotype\', serif; color: #333333; background-image: initial; background-attachment: initial; background-size: initial; background-origin: initial; background-clip: initial; background-position: initial; background-repeat: initial;\">The Rose Of Denmark, alehouse and eatery, has satiated customers from the late 1800s until the present day. A utopic eden amongst the flotsam and jetsam of harbour life. Serving the finest ales, wines and food in a traditional pub environment, log fires, good company and welcoming as hell!</p>\r\n<p style=\"border: 0px; outline: 0px; font-size: 14px; vertical-align: baseline; margin: 0px 0px 1.2em; padding: 0px; line-height: 21px; font-family: Palatino, \'Palatino Linotype\', serif; color: #333333; background-image: initial; background-attachment: initial; background-size: initial; background-origin: initial; background-clip: initial; background-position: initial; background-repeat: initial;\">And with the den brasserie and steakhouse in the cellar, all tastes are catered for.</p>','','BS8 4QL','51.4495676','-2.6210958000000346',NULL,NULL,1,0,1,0,NULL,NULL,'2014-07-04 00:00:01','0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(217,NULL,2,'BrewDog Bristol','brewdog_bristol','Craft beer bar on Baldwin Street, serving beers from Scottish brewery BrewDog and a range of others.','<h3 style=\"border: 0px; outline: 0px; font-size: 18px; vertical-align: baseline; margin: 0px 0px 0.5em; padding: 0px; font-family: \'Palatino,;\"><strong style=\"border: 0px; outline: 0px; vertical-align: baseline; margin: 0px; padding: 0px; background: transparent;\">Address:</strong>&nbsp;58 Baldwin Street, Bristol, BS1 1QW<br /><strong style=\"border: 0px; outline: 0px; vertical-align: baseline; margin: 0px; padding: 0px; background: transparent;\">Telephone:</strong>&nbsp;N/A<br /><strong style=\"border: 0px; outline: 0px; vertical-align: baseline; margin: 0px; padding: 0px; background: transparent;\">Website:</strong>&nbsp;<a style=\"border: 0px; outline: 0px; vertical-align: baseline; margin: 0px; padding: 0px; color: #cd2127; text-decoration: none; background: transparent;\" href=\"http://www.brewdog.com/bars\" target=\"_blank\">www.brewdog.com/bars</a><br /><strong style=\"border: 0px; outline: 0px; vertical-align: baseline; margin: 0px; padding: 0px; background: transparent;\">Twitter:</strong>&nbsp;<a style=\"border: 0px; outline: 0px; vertical-align: baseline; margin: 0px; padding: 0px; color: #cd2127; text-decoration: none; background: transparent;\" href=\"https://twitter.com/brewdogbristol\" target=\"_blank\">@brewdogbristol</a><br /><strong style=\"border: 0px; outline: 0px; vertical-align: baseline; margin: 0px; padding: 0px; background: transparent;\">Facebook:</strong>&nbsp;<a style=\"border: 0px; outline: 0px; vertical-align: baseline; margin: 0px; padding: 0px; color: #cd2127; text-decoration: none; background: transparent;\" href=\"http://www.facebook.com/BrewDogBarBristol\" target=\"_blank\">Click here&hellip;</a></h3>\r\n<p style=\"border: 0px; outline: 0px; font-size: 14px; vertical-align: baseline; margin: 0px 0px 1.2em; padding: 0px; line-height: 21px; font-family: Palatino, \'Palatino Linotype\', serif; color: #333333; background-image: initial; background-attachment: initial; background-size: initial; background-origin: initial; background-clip: initial; background-position: initial; background-repeat: initial;\">&nbsp;</p>\r\n<p style=\"border: 0px; outline: 0px; font-size: 14px; vertical-align: baseline; margin: 0px 0px 1.2em; padding: 0px; line-height: 21px; font-family: Palatino, \'Palatino Linotype\', serif; color: #333333; background-image: initial; background-attachment: initial; background-size: initial; background-origin: initial; background-clip: initial; background-position: initial; background-repeat: initial;\">Craft beer bar on Baldwin Street, serving beers from Scottish brewery BrewDog and a range of others.</p>','','BS1 1QW','51.453536','-2.5927116999999953',NULL,NULL,1,0,0,0,NULL,NULL,'2014-07-04 00:00:01','0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(219,NULL,2,'Banco Lounge','banco_lounge','Totterdown branch of The Lounges, opened in 2010 in the former Lloyds Bank building on Wells Road.','<h3 style=\"border: 0px; outline: 0px; font-size: 18px; vertical-align: baseline; margin: 0px 0px 0.5em; padding: 0px; font-family: \'Palatino,;\"><strong style=\"border: 0px; outline: 0px; vertical-align: baseline; margin: 0px; padding: 0px; background: transparent;\">Address:</strong>&nbsp;107 Wells Road, Totterdown, Bristol, BS4 2BS<br /><strong style=\"border: 0px; outline: 0px; vertical-align: baseline; margin: 0px; padding: 0px; background: transparent;\">Telephone:</strong>&nbsp;0117 908 6010<br /><strong style=\"border: 0px; outline: 0px; vertical-align: baseline; margin: 0px; padding: 0px; background: transparent;\">Website:</strong>&nbsp;<a style=\"border: 0px; outline: 0px; vertical-align: baseline; margin: 0px; padding: 0px; color: #cd2127; text-decoration: none; background: transparent;\" href=\"http://www.thelounges.co.uk/banco-lounge/\" target=\"_blank\">www.thelounges.co.uk/banco-lounge</a><br /><strong style=\"border: 0px; outline: 0px; vertical-align: baseline; margin: 0px; padding: 0px; background: transparent;\">Twitter:</strong>&nbsp;<a style=\"border: 0px; outline: 0px; vertical-align: baseline; margin: 0px; padding: 0px; color: #cd2127; text-decoration: none; background: transparent;\" href=\"https://twitter.com/BancoLounge\" target=\"_blank\">@BancoLounge</a></h3>\r\n<p style=\"border: 0px; outline: 0px; font-size: 14px; vertical-align: baseline; margin: 0px 0px 1.2em; padding: 0px; line-height: 21px; font-family: Palatino, \'Palatino Linotype\', serif; color: #333333; background-image: initial; background-attachment: initial; background-size: initial; background-origin: initial; background-clip: initial; background-position: initial; background-repeat: initial;\">Totterdown branch of The Lounges, opened in 2010 in the former Lloyds Bank building on Wells Road.</p>','','BS4 ','51.4400242','-2.5512776000000486',NULL,NULL,1,0,0,0,NULL,NULL,'2014-07-04 00:00:01','0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(220,NULL,2,'The Richmond, Clifton','the_richmond_clifton','The Richmond has undergone a radical change both in management and direction.','<h3 style=\"border: 0px; outline: 0px; font-size: 18px; vertical-align: baseline; margin: 0px 0px 0.5em; padding: 0px; font-family: \'Palatino,;\"><strong style=\"border: 0px; outline: 0px; vertical-align: baseline; margin: 0px; padding: 0px; background: transparent;\">Address:</strong>&nbsp;33 Gordon Road, Clifton, Bristol, BS8 1AW<br /><strong style=\"border: 0px; outline: 0px; vertical-align: baseline; margin: 0px; padding: 0px; background: transparent;\">Telephone:</strong>&nbsp;0117 923 7542<br /><strong style=\"border: 0px; outline: 0px; vertical-align: baseline; margin: 0px; padding: 0px; background: transparent;\">Website:</strong>&nbsp;<a style=\"border: 0px; outline: 0px; vertical-align: baseline; margin: 0px; padding: 0px; color: #cd2127; text-decoration: none; background: transparent;\" href=\"http://www.therichmondclifton.co.uk/\" target=\"_blank\">www.therichmondclifton.co.uk</a><br /><strong style=\"border: 0px; outline: 0px; vertical-align: baseline; margin: 0px; padding: 0px; background: transparent;\">Twitter:</strong>&nbsp;<a style=\"border: 0px; outline: 0px; vertical-align: baseline; margin: 0px; padding: 0px; color: #cd2127; text-decoration: none; background: transparent;\" href=\"http://twitter.com/richmondclifton\" target=\"_blank\">@richmondclifton</a><br /><strong style=\"border: 0px; outline: 0px; vertical-align: baseline; margin: 0px; padding: 0px; background: transparent;\">Facebook:</strong>&nbsp;<a style=\"border: 0px; outline: 0px; vertical-align: baseline; margin: 0px; padding: 0px; color: #cd2127; text-decoration: none; background: transparent;\" href=\"http://www.facebook.com/richmond.clifton\" target=\"_blank\">Click here&hellip;</a></h3>\r\n<p style=\"border: 0px; outline: 0px; font-size: 14px; vertical-align: baseline; margin: 0px 0px 1.2em; padding: 0px; line-height: 21px; font-family: Palatino, \'Palatino Linotype\', serif; color: #333333; background-image: initial; background-attachment: initial; background-size: initial; background-origin: initial; background-clip: initial; background-position: initial; background-repeat: initial;\">The Richmond has undergone a radical change both in management and direction.</p>\r\n<p style=\"border: 0px; outline: 0px; font-size: 14px; vertical-align: baseline; margin: 0px 0px 1.2em; padding: 0px; line-height: 21px; font-family: Palatino, \'Palatino Linotype\', serif; color: #333333; background-image: initial; background-attachment: initial; background-size: initial; background-origin: initial; background-clip: initial; background-position: initial; background-repeat: initial;\">Excellent British food, including a variety of lighter dishes alongside larger traditional pub meals. We offer no less than six varieties of Sunday Roasts, beautifully presented in a relaxed, traditional English pub setting</p>','','BS8 1AW','51.4558455','-2.6122146000000157',NULL,NULL,1,0,0,0,NULL,NULL,'2014-07-04 00:00:01','0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(221,NULL,2,'Cote','cote','Simple freshly prepared French food at value for money prices.','<h3 style=\"border: 0px; outline: 0px; font-size: 18px; vertical-align: baseline; margin: 0px 0px 0.5em; padding: 0px; font-family: \'Palatino,;\"><strong style=\"border: 0px; outline: 0px; vertical-align: baseline; margin: 0px; padding: 0px; background: transparent;\">Address:</strong>&nbsp;27 The Mall, Clifton, Bristol, BS8 4JG<br /><strong style=\"border: 0px; outline: 0px; vertical-align: baseline; margin: 0px; padding: 0px; background: transparent;\">Telephone:</strong>&nbsp;0117 970 6779<br /><strong style=\"border: 0px; outline: 0px; vertical-align: baseline; margin: 0px; padding: 0px; background: transparent;\">Website:</strong>&nbsp;<a style=\"border: 0px; outline: 0px; vertical-align: baseline; margin: 0px; padding: 0px; color: #cd2127; text-decoration: none; background: transparent;\" href=\"http://www.cote-restaurants.co.uk/Cote_Bristol.html\" target=\"_blank\">www.cote-restaurants.co.uk/Cote_Bristol.html</a></h3>\r\n<p style=\"border: 0px; outline: 0px; font-size: 14px; vertical-align: baseline; margin: 0px 0px 1.2em; padding: 0px; line-height: 21px; font-family: Palatino, \'Palatino Linotype\', serif; color: #333333; background-image: initial; background-attachment: initial; background-size: initial; background-origin: initial; background-clip: initial; background-position: initial; background-repeat: initial;\">Simple freshly prepared French food at value for money prices.</p>\r\n<h3 style=\"border: 0px; outline: 0px; font-size: 18px; vertical-align: baseline; margin: 0px 0px 0.5em; padding: 0px; font-family: \'Palatino,;\">&nbsp;</h3>','','BS8 4JG','51.4560133','-2.6213416000000507',NULL,NULL,1,0,0,0,NULL,NULL,'2014-07-04 00:00:01','0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(222,NULL,2,'Hotel du Vin Bristol','hotel_du_vin_bristol','Previously a collection of Grade II-listed warehouses, Bristol\'s Hotel du Vin includes an award winning bistro and private bar.','<h3 style=\"border: 0px; outline: 0px; font-size: 18px; vertical-align: baseline; margin: 0px 0px 0.5em; padding: 0px; font-family: \'Palatino,;\"><strong style=\"border: 0px; outline: 0px; vertical-align: baseline; margin: 0px; padding: 0px; background: transparent;\">Address:</strong>&nbsp;The Sugar House, Narrow Lewins Mead, Bristol, BS1 2NU<br /><strong style=\"border: 0px; outline: 0px; vertical-align: baseline; margin: 0px; padding: 0px; background: transparent;\">Telephone:</strong>&nbsp;0117 925 5577<br /><strong style=\"border: 0px; outline: 0px; vertical-align: baseline; margin: 0px; padding: 0px; background: transparent;\">Website:</strong>&nbsp;<a style=\"border: 0px; outline: 0px; vertical-align: baseline; margin: 0px; padding: 0px; color: #cd2127; text-decoration: none; background: transparent;\" href=\"http://www.hotelduvin.com/hotels/bristol/bristol.aspx\" target=\"_blank\">www.hotelduvin.com/hotels/bristol/bristol.aspx</a><br /><strong style=\"border: 0px; outline: 0px; vertical-align: baseline; margin: 0px; padding: 0px; background: transparent;\">Twitter:</strong>&nbsp;<a style=\"border: 0px; outline: 0px; vertical-align: baseline; margin: 0px; padding: 0px; color: #cd2127; text-decoration: none; background: transparent;\" href=\"http://twitter.com/hdv_bristol\" target=\"_blank\">@hdv_bristol</a><br /><strong style=\"border: 0px; outline: 0px; vertical-align: baseline; margin: 0px; padding: 0px; background: transparent;\">Facebook:</strong>&nbsp;<a style=\"border: 0px; outline: 0px; vertical-align: baseline; margin: 0px; padding: 0px; color: #cd2127; text-decoration: none; background: transparent;\" href=\"http://www.facebook.com/profile.php?id=100001761484000\" target=\"_blank\">Click here&hellip;</a></h3>\r\n<p style=\"border: 0px; outline: 0px; font-size: 14px; vertical-align: baseline; margin: 0px 0px 1.2em; padding: 0px; line-height: 21px; font-family: Palatino, \'Palatino Linotype\', serif; color: #333333; background-image: initial; background-attachment: initial; background-size: initial; background-origin: initial; background-clip: initial; background-position: initial; background-repeat: initial;\">Previously a collection of Grade II-listed warehouses, Bristol&rsquo;s Hotel du Vin includes an award winning bistro and private bar.</p>','','BS1 2NU','51.4566994','-2.596595500000035',NULL,NULL,1,0,0,0,NULL,NULL,'2014-07-04 00:00:01','0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(226,NULL,2,'The Greenbank pub Bristol','the_greenbank_pub_bristol','Here at the Greenbank, it\'s all about the community.','<div>COMMUNITY PUB / GOOD FOOD / SPECIALIST ALES</div>\r\n<div>\r\n<p>Here at the Greenbank, it\'s all about the community.</p>\r\n<p>About providing the best possible service for the neighbourhood. Whether that\'s serving up a cracking Sunday Roast, a decent pint, glass of wine, great band or space for local groups.</p>\r\n<p>Hope to see you soon. xx</p>\r\n</div>\r\n<div>\r\n<p>Check out our programme of events. It\'s all taking off here at the Greenbank</p>\r\n</div>\r\n<div>\r\n<p>Open: Sun - Thurs 11am - 12midnight (last orders 11.30pm); Fri-Sat 11am - 1am (last orders 12.30pm)</p>\r\n</div>','<p>3</p>',NULL,NULL,NULL,NULL,NULL,1,1,0,0,NULL,NULL,'2014-07-08 00:00:01','0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(231,11,2,'Abba Mania','abba_mania','It is 40 years since ABBA won Eurovision and now itâ€™s your chance to thank ABBA for the music!','<p>It is 40 years since ABBA won Eurovision and now it&rsquo;s your chance to thank ABBA for the music!</p>\r\n<p>ABBA Mania&nbsp;is now accepted as the world&rsquo;s number one touring ABBA tribute production.</p>\r\n<p>Featuring a special concert presentation, which celebrates the music of ABBA in a respectful and enjoyable way, reviving special memories of when ABBA ruled the airwaves....&nbsp;<a id=\"overview_readmore_link\" href=\"http://www.atgtickets.com/shows/abba-mania/bristol-hippodrome/#overview_tab\">Read more&nbsp;&gt;&gt;</a></p>\r\n<p>Running time:&nbsp;2h 20m</p>','','BS4 3EN','51.4426688','-2.5683698999999933',NULL,NULL,1,0,0,0,NULL,NULL,'2014-08-21 00:00:01','0000-00-00 00:00:00','2014-08-07 05:48:14'),
	(232,12,2,'Chas & Dave','chas_dave','Chas & Dave began writing and performing songs together in 1972','<p>Chas &amp; Dave began writing and performing songs together in 1972, having been friends since the early sixties. Now celebrating their 50th anniversary by recording their first original album in 27 years which is a mixture of vintage rock \'n\' roll songs and new renditions of their own rockney classics. The album also features special guest stars such as Jools Holland, Buddy Holly\'s drummer Jerry Allison and Hugh Laurie...</p>\r\n<p>&nbsp;</p>','','BS4 3EN','51.4426688','-2.5683698999999933',NULL,NULL,1,0,0,0,NULL,NULL,'2014-08-22 00:00:01','0000-00-00 00:00:00','2014-08-07 05:47:58'),
	(233,3,2,'Cary Grant Comes Home... for the weekend','cary_grant_comes_home_for_the_weekend','Gala screening of Arsenic and Old Lace, one of Cary Grantâ€™s most memorable roles','<p>Gala screening of&nbsp;Arsenic and Old Lace, one of Cary Grant&rsquo;s most memorable roles, on the big screen in the very theatre where young Bristolian Archie Leach decided to be an actor.</p>\r\n<p>Newly wed drama critic Mortimer Brewster (Cary Grant) tries to embark on his honeymoon, but his plans are scuppered by his ditzy old aunts bumping off elderly gentlemen with their lethal elderberry wine.</p>\r\n<p><a href=\"http://www.atgtickets.com/shows/cary-grant-comes-home-for-the-weekend/bristol-hippodrome/\">Tickets for the Evening Gala of&nbsp;North by Northwest&nbsp;are also available&nbsp;here</a></p>\r\n<p>Double Bill offer:&nbsp;Book both screenings for &pound;26 (plus booking fees over the phone). To get this double bill offer you need to book via the box office or over the phone.</p>','','BS4 3EN','51.4426688','-2.5683698999999933',NULL,NULL,1,0,0,0,NULL,NULL,'2014-08-27 00:00:01','0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(234,13,2,'The Curious Incident of the Dog in the Night-Time','the_curious_incident_of_the_dog_in_the_nighttime','Winner of seven 2013 Olivier Awards, this highly- acclaimed National Theatre production','<p>Winner of seven 2013 Olivier Awards, this highly- acclaimed National Theatre production, embarks on its first ever nationwide tour from December 2014.</p>\r\n<p>Christopher, fifteen years old, has an extraordinary brain &ndash; exceptional at maths while ill-equipped to interpret everyday life. When he falls under suspicion of killing Mrs Shears&rsquo; dog, it takes him on a journey that upturns his world&hellip;</p>','','BS4 3EN','51.4426688','-2.5683698999999933',NULL,NULL,1,0,0,0,NULL,NULL,'2014-08-20 00:00:01','2014-05-00 04:40:00','2014-08-07 05:45:42'),
	(236,7,2,'Barnum','barnum','This exhilarating musical follows the irrepressible imagination and dreams of Phineas ','<p>This exhilarating musical follows the irrepressible imagination and dreams of Phineas T Barnum, America&rsquo;s Greatest Showman.</p>\r\n<p>Barnum is a&nbsp;&lsquo;big, sharp, witty, breathtaking, and emotional&rsquo;&nbsp;(The Observer) show starringBrian Conley&nbsp;(Oliver!,&nbsp;Hairspray,&nbsp;Jolson) andLinzi Hateley&nbsp;(Mary Poppins,&nbsp;Mamma Mia!,Chicago,&nbsp;Les Mis&eacute;rables)....&nbsp;<a id=\"overview_readmore_link\" href=\"http://www.atgtickets.com/shows/barnum/bristol-hippodrome/#overview_tab\">Read more&nbsp;&gt;&gt;</a></p>\r\n<p>Running time:&nbsp;<a href=\"http://www.atgtickets.com/shows/barnum/bristol-hippodrome/\">TBC</a></p>','','BS4 3EN','51.4426688','-2.5683698999999933',NULL,NULL,1,0,0,0,NULL,NULL,'2014-08-25 00:00:01','0000-00-00 00:00:00','2014-08-07 07:20:30'),
	(237,9,2,'An Evening of Burlesque','an_evening_of_burlesque','Come and enjoy Britainâ€™s biggest burlesque extravaganza â€“ we dare you!','<p>Come and enjoy Britain&rsquo;s biggest burlesque extravaganza &ndash; we dare you!</p>\r\n<p>Arriving direct from London&rsquo;s West End, a fresh cast of burlesque all-stars are unveiled for 2014. It&rsquo;s flushed with success &ndash; following a thrilling 100-date UK tour combined with overseas adventures in Milan, Zurich, St Petersburg, Minsk, Leipzig, Verona, Dresden, Riga, Padova, Dessau.</p>\r\n<p>Join this all-new riotous romp into the bizarre world of burlesque and cutting-edge variety....<a id=\"overview_readmore_link\" href=\"http://www.atgtickets.com/shows/an-evening-of-burlesque-2/bristol-hippodrome/#overview_tab\">Read more&nbsp;&gt;&gt;</a></p>','','BS4 3EN','51.4426688','-2.5683698999999933',NULL,NULL,1,2,0,0,NULL,NULL,'2014-08-23 00:00:01','2014-05-00 10:44:00','2014-08-07 05:49:04'),
	(238,26,2,'Dawn French: 30 Million Minutes','dawn_french_30_million_minutes','Dawn French, the Queen of British comedy, performs her first ever solo tour.','<p>Dawn French, the Queen of British comedy, performs her first ever solo tour. The award-winning actor, best-selling novelist and all round very funny lady has written a new show, based on her life and career, called&nbsp;30 Million Minutes....&nbsp;<a id=\"overview_readmore_link\" href=\"http://www.atgtickets.com/shows/dawn-french-30-million-minutes/bristol-hippodrome/#overview_tab\">Read more&nbsp;&gt;&gt;</a></p>','','BS4 3EN','51.44502265337844','-2.5726614344238214',NULL,NULL,1,1,0,0,NULL,NULL,'2014-08-08 00:00:01','0000-00-00 00:00:00','2014-08-07 05:30:59'),
	(239,8,2,'BLOC presents Sister Act','bloc_presents_sister_act','Featuring original music by TonyÂ® and 8-time OscarÂ® winner Alan Menken','<p>Featuring original music by Tony&reg; and 8-time Oscar&reg; winner&nbsp;Alan Menken(Beauty and the Beast, Little Shop of Horrors), Sister Act tells the hilarious story of Deloris Van Cartier, a wannabe diva whose life takes a surprising turn when she witnesses a crime and the cops hide her in the last place anyone would think to look - a convent!...&nbsp;<a id=\"overview_readmore_link\" href=\"http://www.atgtickets.com/shows/sister-act/bristol-hippodrome/#overview_tab\">Read more&nbsp;&gt;&gt;</a></p>\r\n<p>Running time:&nbsp;<a href=\"http://www.atgtickets.com/shows/sister-act/bristol-hippodrome/\">TBC</a></p>','','BS4 3EN','51.4426688','-2.5683698999999933',NULL,NULL,1,0,0,0,NULL,NULL,'2014-08-24 00:00:01','2014-05-00 13:32:00','2014-08-07 07:20:16'),
	(240,6,2,'Calamity Jane','calamity_jane','Following numerous highly acclaimed productions that include Sweeney Todd and Sunset Boulevard','<p>Following numerous highly acclaimed productions that include&nbsp;Sweeney Todd&nbsp;and&nbsp;Sunset Boulevard,&nbsp;The Watermill Theatre&nbsp;returns with a new production of the classic musical&nbsp;Calamity Jane. Starring&nbsp;Jodie Prenger(Oliver!,&nbsp;Spamalot&nbsp;and&nbsp;One Man Two Guvnors) alongside a cast of multi-talented actor/musicians, this brand new production gets to the heart and soul of the musical....&nbsp;<a id=\"overview_readmore_link\" href=\"http://www.atgtickets.com/shows/calamity-jane/bristol-hippodrome/#overview_tab\">Read more&nbsp;&gt;&gt;</a></p>\r\n<p>Running time:&nbsp;<a href=\"http://www.atgtickets.com/shows/calamity-jane/bristol-hippodrome/\">TBC</a></p>','','BS4 3EN','51.4426688','-2.5683698999999933',NULL,NULL,1,0,0,0,NULL,NULL,'2014-08-26 00:00:01','2014-05-00 15:07:00','2014-08-07 07:20:41'),
	(241,25,2,'Jackson Live in Concert','jackson_live_in_concert','Jackson Live in Concert sees long-time fan and hugely talented Ben recreate the Michael Jackson experience with his stunning rendition of all his favo','<p>Jackson Live in Concert&nbsp;sees long-time fan and hugely talented Ben recreate the Michael Jackson experience with his stunning rendition of all his favourite songs.</p>\r\n<p>Ben&rsquo;s portrayal of Jackson&nbsp; has to be the most accurate and exciting tribute to the King of Pop to have ever toured UK theatres. Ben is joined on the stage by his Incredible Band and Dancers who work their way through all the hits. He&rsquo;s got the look, the moonwalk and the voice! His renditions ofThriller,&nbsp;Beat It&nbsp;and&nbsp;Billie Jean&nbsp;are truly sensational....&nbsp;<a id=\"overview_readmore_link\" href=\"http://www.atgtickets.com/shows/jackson-live-in-concert/bristol-hippodrome/#overview_tab\">Read more&nbsp;&gt;&gt;</a></p>\r\n<p>Running time:&nbsp;<a href=\"http://www.atgtickets.com/shows/jackson-live-in-concert/bristol-hippodrome/\">TBC</a></p>','','BS4 3EN','51.4426688','-2.5683698999999933',NULL,NULL,1,1,0,0,NULL,1,'2014-08-09 00:00:01','0000-00-00 00:00:00','2014-08-07 05:38:03'),
	(242,15,2,'Rock of Ages','rock_of_ages','Still rocking after 5 years on Broadway and following 3 years of ovation-inducing ','<p>Still rocking after 5 years on Broadway and following 3 years of ovation-inducing performances in London&rsquo;s West End, the legendary&nbsp;Rock of Ages&nbsp;now heads out on UK Tour starring&nbsp;Ben Richards&nbsp;(9to5 The Musical, Priscilla Queen of the Desert, Guys &amp; Dolls)&nbsp;as rock god Stacee Jaxx and&nbsp;Noel Sullivan(Priscilla Queen of the Desert, We Will Rock You)&nbsp;as Drew Boley.</p>\r\n<p>&nbsp;...&nbsp;<a id=\"overview_readmore_link\" href=\"http://www.atgtickets.com/shows/rock-of-ages/bristol-hippodrome/#overview_tab\">Read more&nbsp;&gt;&gt;</a></p>','','BS4 3EN','51.4426688','-2.5683698999999933',NULL,NULL,1,0,0,0,NULL,NULL,'2014-08-18 00:00:01','2014-05-00 18:31:00','2014-08-07 05:42:58'),
	(243,24,2,'Think Floyd','think_floyd','This extraordinary show, dubbed The Definitive Pink Floyd Experience, is renowned for its stunning celebration of one of the world\'s greatest musical ','<p>This extraordinary show, dubbed The Definitive Pink Floyd Experience, is renowned for its stunning celebration of one of the world\'s greatest musical phenomena.<br /><br />Now in their 20th year, the incredibly talented musicians who make upThink Floyd&nbsp;have managed to faithfully recreate all the atmosphere, visual magnitude and musical excellence of Pink Floyd live on stage. It\'s no wonder they have long been regarded as the UK\'s finest tribute to Pink Floyd....&nbsp;<a id=\"overview_readmore_link\" href=\"http://www.atgtickets.com/shows/think-floyd/bristol-hippodrome/#overview_tab\">Read more&nbsp;&gt;&gt;</a></p>\r\n<p>Running time:&nbsp;<a href=\"http://www.atgtickets.com/shows/think-floyd/bristol-hippodrome/\">TBC</a></p>','','BS4 3EN','51.4426688','-2.5683698999999933',NULL,NULL,1,1,0,0,NULL,1,'2014-08-10 00:00:01','2014-05-00 18:39:00','2014-08-07 05:38:18'),
	(244,15,2,'The Dreamboys','the_dreamboys','he Dreamboys are without a shadow of a doubt the UK\'s top male glamour show, perfect for a girls night out with all your friends','<p>The Dreamboys&nbsp;are without a shadow of a doubt the UK\'s top male glamour show, perfect for a girls night out with all your friends. Their showcase is unquestionably the most famous male stripper act the UK has ever produced. With special guest appearances on some of the UK\'s biggest TV shows such as&nbsp;The X Factor,&nbsp;Britain\'s Got Talent,&nbsp;Celebrity Big Brother,&nbsp;Pineapple Dance Studios,&nbsp;Loose Women,&nbsp;This Morning&nbsp;and&nbsp;The Only Way Is Essex&nbsp;and massive sold out worldwide tours, it\'s no wonder The Dreamboys have earned themselves the title of the only male strip group in history to have celebrity status....&nbsp;<a id=\"overview_readmore_link\" href=\"http://www.atgtickets.com/shows/the-dreamboys/bristol-hippodrome/#overview_tab\">Read more&nbsp;&gt;&gt;</a></p>','','BS4 3EN','51.4426688','-2.5683698999999933',NULL,NULL,1,0,0,0,NULL,0,'2014-08-19 00:00:01','0000-00-00 00:00:00','2014-08-07 05:45:29'),
	(245,16,2,'The Rat Pack Vegas Spectacular Show','the_rat_pack_vegas_spectacular_show','It\'s fun all the way as the \'Purveyors of Cool\' swing into town with a sensational show with live ','<p>It\'s fun all the way as the \'Purveyors of Cool\' swing into town with a sensational show with live orchestra featuring The Greatest Music Of The 20th Century. Wonderful memories of Frank Sinatra, Dean Martin &amp; Sammy Davis Junior in a fabulous production that continues to be successful worldwide.</p>\r\n<p>All totally live and every song is an absolute classic -&nbsp;Come Fly With Me,&nbsp;Under My Skin,Sway,&nbsp;Mr Bojangles,&nbsp;Fly Me to the Moon,&nbsp;That\'s Amore,&nbsp;Mack the Knife, plus many more of your favourites....&nbsp;<a id=\"overview_readmore_link\" href=\"http://www.atgtickets.com/shows/the-rat-pack-vegas-spectacular-2/bristol-hippodrome/#overview_tab\">Read more&nbsp;&gt;&gt;</a></p>','','BS4 3EN','51.4426688','-2.5683698999999933',NULL,NULL,1,2,0,0,NULL,NULL,'2014-08-17 00:00:01','2014-05-00 21:23:00','2014-08-07 05:42:34'),
	(246,23,2,'Sally Morgan: Psychic Sally on the Road','sally_morgan_psychic_sally_on_the_road','Britain\'s best-loved psychic and international star, Sally Morgan returns with her outstanding 2014 nationwide tour. Sally is most well known for bein','<p>Britain\'s best-loved psychic and international star,&nbsp;Sally Morgan&nbsp;returns with her outstanding 2014 nationwide tour. Sally is most well known for being the star of Sky Living&rsquo;s&nbsp;Psychic Sally on the Road!</p>\r\n<p>Sally has built up an extensive client lists reading for celebrities and royalty alike including Katie Price, the late Princess Diana and George Michael, which has lead her to be referred to as the &lsquo;Psychic To The Stars&rsquo;...&nbsp;<a id=\"overview_readmore_link\" href=\"http://www.atgtickets.com/shows/sally-morgan-psychic-sally-on-the-road-3/bristol-hippodrome/#overview_tab\">Read more&nbsp;&gt;&gt;</a></p>\r\n<p>Running time:&nbsp;2h 10m</p>','','BS4 3EN','51.4426688','-2.5683698999999933',NULL,NULL,1,1,0,0,NULL,NULL,'2014-08-11 00:00:01','2014-05-00 21:57:00','2014-08-07 05:38:36'),
	(247,22,2,'The Illegal Eagles','the_illegal_eagles','Following a number of critically acclaimed UK & European Tours and headlining a number of festivals and concerts they have established themselves as n','<p>Following a number of critically acclaimed UK &amp; European Tours and headlining a number of festivals and concerts they have established themselves as not only the ultimate tribute to The Eagles, but as one of the foremost authentic and talented theatrical experiences in the world!</p>\r\n<p>Extremely tight harmonies and an acute attention to detail are now synonymous with The Illegal Eagles. The classic line-up of membersPhil Aldridge,&nbsp;Keith Atack,&nbsp;Al Vosper&nbsp;andDarin Murphy&nbsp;and&nbsp;Garreth Hicklin&nbsp;is now newly joined by vocalist&nbsp;Greg Webb....&nbsp;<a id=\"overview_readmore_link\" href=\"http://www.atgtickets.com/shows/the-illegal-eagles/bristol-hippodrome/#overview_tab\">Read more&nbsp;&gt;&gt;</a></p>\r\n<p>Running time:&nbsp;Approx 1h 55m</p>','','BS4 3EN','51.4426688','-2.5683698999999933',NULL,NULL,1,0,1,0,NULL,0,'2014-08-12 00:00:01','2014-05-00 22:59:00','2014-08-07 07:30:13'),
	(248,17,2,'Hippodrome Choir Concert','hippodrome_choir_concert','Join us for an evening of songs from the musicals performed by the Bristol Hippodrome\'s own choir.','<p>Join us for an evening of songs from the musicals performed by the Bristol Hippodrome\'s own choir. Songs from Singing in the rain, Calamity Jane, Top Hat, Mama Mia and more.</p>\r\n<p>Doors open at 6.30pm</p>\r\n<p>Running time:&nbsp;<a href=\"http://www.atgtickets.com/shows/hippodrome-choir-concert/bristol-hippodrome/\">TBC</a></p>','','BS4 3EN','51.4426688','-2.5683698999999933',NULL,NULL,1,0,1,0,NULL,NULL,'2014-08-16 00:00:01','2014-07-01 00:00:01','2014-08-07 07:33:04'),
	(249,21,2,'One Night of Queen','one_night_of_queen','Over the past 9 years One Night Of Queen has rocked sold out audiences all over the World including UK, Germany, Holland, France, New Zealand. ','<p>Over the past 9 years One Night Of Queen has rocked sold out audiences all over the World including UK, Germany, Holland, France, New Zealand. Fresh from their second tour of the USA Gary Mullen and \'The Works\' return with a stunning live concert featuring fantastic staging and lighting effects.</p>\r\n<p>&nbsp;...&nbsp;<a id=\"overview_readmore_link\" href=\"http://www.atgtickets.com/shows/one-night-of-queen/bristol-hippodrome/#overview_tab\">Read more&nbsp;&gt;&gt;</a></p>\r\n<p>Running time:&nbsp;1h 50m</p>','','BS4 3EN','51.4426688','-2.5683698999999933',NULL,NULL,1,0,1,0,NULL,NULL,'2014-08-13 00:00:01','2014-07-01 00:00:01','2014-08-07 07:32:24'),
	(250,18,2,'Singin\' in the Rain - Tour','singin_in_the_rain_tour','Direct from the West End, this critically acclaimed production of Singinâ€™ in the Rain','<p>Direct from the West End, this critically acclaimed production of&nbsp;Singin&rsquo; in the Rain&nbsp;is a smash hit with critics and audiences alike.&nbsp; It tells the story of the first Hollywood musical, when the silver screen found its voice and left silent movies - and some of its stars &ndash; behind.</p>\r\n<p>Screen star&nbsp;Maxwell Caulfield&nbsp;plays studio boss R F Simpson and Coronation Street favourite&nbsp;Vicky Binns&nbsp;is the &lsquo;uniquely voiced&rsquo; starlet Lina Lamont in this classic musical, full of high energy choreography and sumptuous set design (including 12,000 litres of water!).&nbsp;Singin&rsquo; in the Rain&nbsp;showers you with everything you could w</p>','','BS4 3EN','51.4426688','-2.5683698999999933',NULL,NULL,1,0,1,0,NULL,NULL,'2014-08-15 00:00:01','2014-07-01 00:00:01','2014-08-07 07:32:44'),
	(251,20,2,'Shrek the Musical','shrek_the_musical','Direct from the West End and larger than life!  Based on the award-winning DreamWorks animation film, Shrek the Musical is this yearâ€™s must-see show','<p>Direct from the West End and larger than life!</p>\r\n<p>Based on the award-winning DreamWorks animation film,&nbsp;Shrek the Musical&nbsp;is this year&rsquo;s must-see show for all the family.</p>\r\n<p>Featuring all new songs as well as cult&nbsp;Shrekanthem&nbsp;I&rsquo;m a Believer, Shrek the Musical brings all the much-loved DreamWorks characters to life, live on stage, in an all-singing, all-dancing extravaganza. Join the adventure....&nbsp;<a id=\"overview_readmore_link\" href=\"http://www.atgtickets.com/shows/shrek-the-musical/bristol-hippodrome/#overview_tab\">Read more&nbsp;&gt;&gt;</a></p>\r\n<p>Running time:&nbsp;2h 15m</p>','','BS4 3EN','51.4426688','-2.5683698999999933',NULL,NULL,1,0,1,0,NULL,NULL,'2014-08-14 00:00:01','2014-07-01 00:00:01','2014-08-07 07:32:33'),
	(318,NULL,2,'Two-Course Indian Meal For Two or Four','twocourse-indian-meal-for-two-or-four','from Â£16.95 at Bristol Raj (Up to 54% Off)','<p style=\"box-sizing: border-box; margin: 0px 0px 20px; color: #333333; font-family: OpenSansRegular, \'Helvetica Neue\', Helvetica, Arial, FreeSans, sans-serif; font-size: 13px; line-height: 19.5px;\">Diners can head to this central Clifton restaurant for an authentic taste of the subcontinent, complete with naan bread&nbsp;<em style=\"box-sizing: border-box;\">(usually &pound;2.20)</em>&nbsp;to share between each pair. Starters come in the form of lamp chops&nbsp;<em style=\"box-sizing: border-box;\">(&pound;4.50)</em>, roast pepper with minced lamb and vegetables&nbsp;<em style=\"box-sizing: border-box;\">(&pound;3.95)</em>, or vegetarian garlic mushrooms&nbsp;<em style=\"box-sizing: border-box;\">(&pound;3.25)</em>. For the main event, guests can opt for dishes such as Raj murg, a chicken breast cooked with onion garlic and mango chutney&nbsp;<em style=\"box-sizing: border-box;\">(&pound;9.95)</em>; gosht kata masala, with braised lamb topped with garlic; or a favourite such as chicken tikka masala&nbsp;<em style=\"box-sizing: border-box;\">(&pound;6.95)</em>. Vegetarians are also catered for, with an extensive list of vegetable-based dishes. All meals will be accompanied by a choice of rice&nbsp;<em style=\"box-sizing: border-box;\">(up to &pound;2.20)</em>, such as steamed or pilau.</p>\r\n<p style=\"box-sizing: border-box; margin: 0px 0px 20px; color: #333333; font-family: OpenSansRegular, \'Helvetica Neue\', Helvetica, Arial, FreeSans, sans-serif; font-size: 13px; line-height: 19.5px;\"><em style=\"box-sizing: border-box;\">Choose from the following options for a two-course Indian meal with rice and naan:</em></p>\r\n<ul style=\"box-sizing: border-box; margin: 0px 0px 20px; padding-left: 20px; color: #333333; font-family: OpenSansRegular, \'Helvetica Neue\', Helvetica, Arial, FreeSans, sans-serif; font-size: 13px; line-height: 19.5px;\">\r\n<li style=\"box-sizing: border-box;\">\r\n<p style=\"box-sizing: border-box; margin: 0px 0px 20px;\">&pound;16.95 for two (Up to 52% off)</p>\r\n</li>\r\n<li style=\"box-sizing: border-box;\">\r\n<p style=\"box-sizing: border-box; margin: 0px 0px 20px;\">&pound;32.95 for four (Up to 54% off)</p>\r\n</li>\r\n</ul>','<p><span style=\"color: #333333; font-family: OpenSansRegular, \'Helvetica Neue\', Helvetica, Arial, FreeSans, sans-serif; font-size: 13px; line-height: 19.5px;\">Authentic-tasting Indian cuisine is dished up seven days a week at the central Clifton&nbsp;</span><a style=\"box-sizing: border-box; color: #0185c6; text-decoration: none; font-family: OpenSansRegular, \'Helvetica Neue\', Helvetica, Arial, FreeSans, sans-serif; font-size: 13px; line-height: 19.5px;\" href=\"http://www.bristolraj.com/\">Bristol Raj</a><span style=\"color: #333333; font-family: OpenSansRegular, \'Helvetica Neue\', Helvetica, Arial, FreeSans, sans-serif; font-size: 13px; line-height: 19.5px;\">. With a colourful interior, the restaurant welcomes guests for intimate gatherings and special events, and a takeaway delivery is available throughout the week.</span></p>\r\n<p><span style=\"color: #333333; font-family: OpenSansRegular, \'Helvetica Neue\', Helvetica, Arial, FreeSans, sans-serif; font-size: 13px; line-height: 19.5px;\"><a class=\"hide_desktop\" href=\"b247://category/27/articles?subChannel=70\" rel=\"nofollow\">Here</a><a class=\"hide_tablet hide_mobile\" href=\"http://www.bristol247.com/category/discounts\">Here</a></span></p>','BS4 3EN','51.44111733030139','-2.54622558237304',NULL,NULL,1,1,0,0,NULL,NULL,'2014-07-28 00:00:01','2014-07-28 10:58:30','0000-00-00 00:00:00'),
	(319,NULL,2,'Summer Barbecue Party For 40 from £499','summer-barbecue-party-for-40-from-499','at Racks Bar and Kitchen (Up to 51% Off)','<p><span style=\"color: #333333; font-family: OpenSansRegular, \'Helvetica Neue\', Helvetica, Arial, FreeSans, sans-serif; font-size: 13px; line-height: 19.5px;\">Partygoers can take their pick of items from the Carnival BBQ&nbsp;</span><em style=\"box-sizing: border-box; color: #333333; font-family: OpenSansRegular, \'Helvetica Neue\', Helvetica, Arial, FreeSans, sans-serif; font-size: 13px; line-height: 19.5px;\">(usually &pound;24.95 per person)</em><span style=\"color: #333333; font-family: OpenSansRegular, \'Helvetica Neue\', Helvetica, Arial, FreeSans, sans-serif; font-size: 13px; line-height: 19.5px;\">menu. After proceedings kick off with a Pimm\'s reception along with a selection of crisps and nuts, mains will include burgers, sausages and chicken, along with an array of barbecue sides. A dessert of strawberries and cream is also included, with a vegetarian menu offered to replace the meat dishes.</span></p>','<p style=\"box-sizing: border-box; margin: 0px 0px 20px; color: #333333; font-family: OpenSansRegular, \'Helvetica Neue\', Helvetica, Arial, FreeSans, sans-serif; font-size: 13px; line-height: 19.5px;\"><span style=\"box-sizing: border-box; font-family: OpenSansSemiBold, \'Helvetica Neue\', Arial, Helvetica, FreeSans, sans-serif;\">Party Menu</span></p>\r\n<p style=\"box-sizing: border-box; margin: 0px 0px 20px; color: #333333; font-family: OpenSansRegular, \'Helvetica Neue\', Helvetica, Arial, FreeSans, sans-serif; font-size: 13px; line-height: 19.5px;\"><em style=\"box-sizing: border-box;\">Appetisers</em></p>\r\n<p style=\"box-sizing: border-box; margin: 0px 0px 20px; color: #333333; font-family: OpenSansRegular, \'Helvetica Neue\', Helvetica, Arial, FreeSans, sans-serif; font-size: 13px; line-height: 19.5px;\">Pimm&rsquo;s reception | Crisps and nuts</p>\r\n<p style=\"box-sizing: border-box; margin: 0px 0px 20px; color: #333333; font-family: OpenSansRegular, \'Helvetica Neue\', Helvetica, Arial, FreeSans, sans-serif; font-size: 13px; line-height: 19.5px;\"><em style=\"box-sizing: border-box;\">Mains</em></p>\r\n<p style=\"box-sizing: border-box; margin: 0px 0px 20px; color: #333333; font-family: OpenSansRegular, \'Helvetica Neue\', Helvetica, Arial, FreeSans, sans-serif; font-size: 13px; line-height: 19.5px;\">Homemade beef burger with sun-blushed tomato and shallot relish | Berkshire pork &amp; leek sausage with caramelised red onion chutney | Marinated chicken breast ï¬llets with sweet chilli sauce | Buttered onions | Coleslaw | Chive and new potato salad | Wild rocket, baby tomato, red onion and parmesan salad | Bread rolls</p>\r\n<p style=\"box-sizing: border-box; margin: 0px 0px 20px; color: #333333; font-family: OpenSansRegular, \'Helvetica Neue\', Helvetica, Arial, FreeSans, sans-serif; font-size: 13px; line-height: 19.5px;\"><em style=\"box-sizing: border-box;\">Desserts</em></p>\r\n<p style=\"box-sizing: border-box; margin: 0px 0px 20px; color: #333333; font-family: OpenSansRegular, \'Helvetica Neue\', Helvetica, Arial, FreeSans, sans-serif; font-size: 13px; line-height: 19.5px;\">Strawberries and cream</p>\r\n<p style=\"box-sizing: border-box; margin: 0px 0px 20px; color: #333333; font-family: OpenSansRegular, \'Helvetica Neue\', Helvetica, Arial, FreeSans, sans-serif; font-size: 13px; line-height: 19.5px;\"><em style=\"box-sizing: border-box;\">Vegetarian options</em>&nbsp;(<em style=\"box-sizing: border-box;\">Booked in advance; served instead of meat options</em>)</p>\r\n<p style=\"box-sizing: border-box; margin: 0px 0px 20px; color: #333333; font-family: OpenSansRegular, \'Helvetica Neue\', Helvetica, Arial, FreeSans, sans-serif; font-size: 13px; line-height: 19.5px;\">Veggie burger with sun-blushed tomato and shallot relish | Marinated courgette, red onion and bell pepper skewers with sweet chilli sauce | Char-grilled Mediterranean vegetables with polenta and basil<a class=\"hide_desktop\" href=\"b247://category/27/articles?subChannel=70\" rel=\"nofollow\">Here</a><a class=\"hide_tablet hide_mobile\" href=\"http://www.bristol247.com/category/discounts\">Here</a></p>','BS4 3EN','51.45491820945641','-2.613173519384759',NULL,NULL,1,1,0,0,NULL,NULL,'2014-07-28 00:00:01','2014-07-28 11:12:36','0000-00-00 00:00:00'),
	(320,NULL,2,'Fish and Chips With Wine For Two for £12.95 ','fish-and-chips-with-wine-for-two-for-1295-','at The Dolphin (48% Off)','<p style=\"box-sizing: border-box; margin: 0px 0px 20px; color: #333333; font-family: OpenSansRegular, \'Helvetica Neue\', Helvetica, Arial, FreeSans, sans-serif; font-size: 13px; line-height: 19.5px;\">Seafood fans can tuck into that most traditional of British foods, battered fish and chips, at The Dolphin pub in Weston-super-Mare. Haddock or cod will be served with chips and mushy peas, and guests can also enjoy a glass of wine each.</p>\r\n<p>&nbsp;</p>','<p><a style=\"box-sizing: border-box; color: #0185c6; text-decoration: none; font-family: OpenSansRegular, \'Helvetica Neue\', Helvetica, Arial, FreeSans, sans-serif; font-size: 13px; line-height: 19.5px;\" href=\"http://thedolphin.weebly.com/\">The Dolphin</a><span style=\"color: #333333; font-family: OpenSansRegular, \'Helvetica Neue\', Helvetica, Arial, FreeSans, sans-serif; font-size: 13px; line-height: 19.5px;\">&nbsp;brings pub dining to a Weston-super-Mare location. Hearty grub is available six days a week from midday, including pub classics such as burgers, cottage pie and fish and chips.<a class=\"hide_desktop\" href=\"b247://category/27/articles?subChannel=70\" rel=\"nofollow\">Here</a><a class=\"hide_tablet hide_mobile\" href=\"http://www.bristol247.com/category/discounts\">Here</a></span></p>','BS4 3EN','51.4426688','-2.5683698999999933',NULL,NULL,1,1,0,0,NULL,NULL,'2014-07-28 00:00:01','2014-07-28 11:14:41','0000-00-00 00:00:00'),
	(321,NULL,2,'Saturday Comedy Tickets Plus Meal For Two or Four','saturday-comedy-tickets-plus-meal-for-two-or-four','from Â£25.50 at Komedia Bath (55% Off)','<p><span style=\"color: #333333; font-family: OpenSansRegular, \'Helvetica Neue\', Helvetica, Arial, FreeSans, sans-serif; font-size: 13px; line-height: 19.5px;\">Pairs or groups of four can dine and giggle away at award-winning Komedia Bath. The evening will begin with a main dish such as a slow-cooked beef bourguignon or a mushroom and roast garlic spelt risotto. Once stuffed to satisfaction, guests can get a belly full of laughs as three stand-up comedians take to the stage for a side-splitting evening, with upcoming acts including Edinburgh Comedy Award nominee, Tony Law, and Irish funny man Keith Farnan.</span></p>','<p style=\"box-sizing: border-box; margin: 0px 0px 20px; color: #333333; font-family: OpenSansRegular, \'Helvetica Neue\', Helvetica, Arial, FreeSans, sans-serif; font-size: 13px; line-height: 19.5px;\"><em style=\"box-sizing: border-box;\">Choose from the following options for comedy tickets plus a meal:</em></p>\r\n<ul style=\"box-sizing: border-box; margin: 0px 0px 20px; padding-left: 20px; color: #333333; font-family: OpenSansRegular, \'Helvetica Neue\', Helvetica, Arial, FreeSans, sans-serif; font-size: 13px; line-height: 19.5px;\">\r\n<li style=\"box-sizing: border-box;\">\r\n<p style=\"box-sizing: border-box; margin: 0px 0px 20px;\">&pound;25.50 for two (55% off)</p>\r\n</li>\r\n<li style=\"box-sizing: border-box;\">\r\n<p style=\"box-sizing: border-box; margin: 0px 0px 20px;\">&pound;51 for four (55% off)<a class=\"hide_desktop\" href=\"b247://category/27/articles?subChannel=70\" rel=\"nofollow\">Here</a><a class=\"hide_tablet hide_mobile\" href=\"http://www.bristol247.com/category/discounts\">Here</a></p>\r\n</li>\r\n</ul>','BS4 3EN','51.45192302423471','-2.619267498266595',NULL,NULL,1,1,0,0,NULL,NULL,'2014-07-28 00:00:01','2014-07-28 11:17:06','0000-00-00 00:00:00'),
	(322,NULL,2,'Bristol Cider Festival Tickets For One, Two or Four','bristol-cider-festival-tickets-for-one-two-or-four','from Â£3.25 (Up to 55% Off)','<p><a style=\"box-sizing: border-box; color: #0185c6; text-decoration: none; font-family: OpenSansRegular, \'Helvetica Neue\', Helvetica, Arial, FreeSans, sans-serif; font-size: 13px; line-height: 19.5px;\" href=\"http://www.clstickets.co.uk/product/26-bristol-summer-cider-festival-sat-2nd-aug-7-30pm-11pm#.U75cG_ldVOw\">Bristol Cider Festival</a><span style=\"color: #333333; font-family: OpenSansRegular, \'Helvetica Neue\', Helvetica, Arial, FreeSans, sans-serif; font-size: 13px; line-height: 19.5px;\">&nbsp;opens it doors once again with two days of Scrumpy &amp; Western fun at Brunel\'s Old Passenger Shed in central Bristol. There will be over 100 different ciders and perries to sample, along with a various food outlets including hog roasts and cheese platters to fuel the day. Live entertainment comes courtesy of the Mangledwurzels, who have played many a cider festival throughout the country to get the party going.<a class=\"hide_desktop\" href=\"b247://category/27/articles?subChannel=70\" rel=\"nofollow\">Here</a><a class=\"hide_tablet hide_mobile\" href=\"http://www.bristol247.com/category/discounts\">Here</a></span></p>','<p style=\"box-sizing: border-box; margin: 0px 0px 20px; color: #333333; font-family: OpenSansRegular, \'Helvetica Neue\', Helvetica, Arial, FreeSans, sans-serif; font-size: 13px; line-height: 19.5px;\"><em style=\"box-sizing: border-box;\">hoose from the following options for entry to the Bristol Cider Festival:</em></p>\r\n<ul style=\"box-sizing: border-box; margin: 0px 0px 20px; padding-left: 20px; color: #333333; font-family: OpenSansRegular, \'Helvetica Neue\', Helvetica, Arial, FreeSans, sans-serif; font-size: 13px; line-height: 19.5px;\">\r\n<li style=\"box-sizing: border-box;\">\r\n<p style=\"box-sizing: border-box; margin: 0px 0px 20px;\">&pound;3.25 for one person on Friday 1 August, 7.30pm-11pm (54% off)</p>\r\n</li>\r\n<li style=\"box-sizing: border-box;\">\r\n<p style=\"box-sizing: border-box; margin: 0px 0px 20px;\">&pound;6.50 for two people on Friday 1 August, 7.30pm-11pm (54% off)</p>\r\n</li>\r\n<li style=\"box-sizing: border-box;\">\r\n<p style=\"box-sizing: border-box; margin: 0px 0px 20px;\">&pound;12.50 for four people on Friday 1 August, 7.30pm-11pm (55% off)</p>\r\n</li>\r\n<li style=\"box-sizing: border-box;\">\r\n<p style=\"box-sizing: border-box; margin: 0px 0px 20px;\">&pound;3.25 for one person on Saturday 2 August, 11am-4pm (54% off)</p>\r\n</li>\r\n<li style=\"box-sizing: border-box;\">\r\n<p style=\"box-sizing: border-box; margin: 0px 0px 20px;\">&pound;6.50 for two people on Saturday 2 August, 11am-4pm (54% off)</p>\r\n</li>\r\n<li style=\"box-sizing: border-box;\">\r\n<p style=\"box-sizing: border-box; margin: 0px 0px 20px;\">&pound;12.50 for four people on Saturday 2 August, 11am-4pm (55% off)</p>\r\n</li>\r\n<li style=\"box-sizing: border-box;\">\r\n<p style=\"box-sizing: border-box; margin: 0px 0px 20px;\">&pound;3.25 for one person on Saturday 2 August, 7.30pm-11pm (54% off)</p>\r\n</li>\r\n<li style=\"box-sizing: border-box;\">\r\n<p style=\"box-sizing: border-box; margin: 0px 0px 20px;\">&pound;6.50 for two people on Saturday 2 August, 7.30pm-11pm (54% off)</p>\r\n</li>\r\n<li style=\"box-sizing: border-box;\">\r\n<p style=\"box-sizing: border-box; margin: 0px 0px 20px;\">&pound;12.50 for four people on Saturday 2 August, 7.30pm-11pm (55% off)</p>\r\n</li>\r\n</ul>','BS4 3EN','51.4426688','-2.5683698999999933',NULL,NULL,1,1,0,0,NULL,NULL,'2014-07-28 00:00:01','2014-07-28 11:19:01','0000-00-00 00:00:00'),
	(323,NULL,2,'Steak Meal For Two or Four With Cocktails','steak-meal-for-two-or-four-with-cocktails','from Â£29 at Chicago Rock Cafe Yeovil (Up to 48% Off)','<p><span style=\"color: #333333; font-family: OpenSansRegular, \'Helvetica Neue\', Helvetica, Arial, FreeSans, sans-serif; font-size: 13px; line-height: 19.5px;\">American-style cuisine comes in the form of an 8oz sirloin, T-bone 14oz, or rib eye 10oz steak, accompanied by chips. Each guest will also be served a choice of American martini cocktail for a sophisticated edge. Customers should note that all menu items are subject to change at any time.<a class=\"hide_desktop\" href=\"b247://category/27/articles?subChannel=70\" rel=\"nofollow\">Here</a><a class=\"hide_tablet hide_mobile\" href=\"http://www.bristol247.com/category/discounts\">Here</a></span></p>','<p style=\"box-sizing: border-box; margin: 0px 0px 20px; color: #333333; font-family: OpenSansRegular, \'Helvetica Neue\', Helvetica, Arial, FreeSans, sans-serif; font-size: 13px; line-height: 19.5px;\"><em style=\"box-sizing: border-box;\">Choose from the following options for a steak meal with American martini cocktail per person:</em></p>\r\n<ul style=\"box-sizing: border-box; margin: 0px 0px 20px; padding-left: 20px; color: #333333; font-family: OpenSansRegular, \'Helvetica Neue\', Helvetica, Arial, FreeSans, sans-serif; font-size: 13px; line-height: 19.5px;\">\r\n<li style=\"box-sizing: border-box;\">\r\n<p style=\"box-sizing: border-box; margin: 0px 0px 20px;\">&pound;29 for two (up to 48% off)</p>\r\n</li>\r\n<li style=\"box-sizing: border-box;\">\r\n<p style=\"box-sizing: border-box; margin: 0px 0px 20px;\">&pound;58 for four (up to 48% off)</p>\r\n</li>\r\n</ul>\r\n<p style=\"box-sizing: border-box; margin: 0px 0px 20px; color: #333333; font-family: OpenSansRegular, \'Helvetica Neue\', Helvetica, Arial, FreeSans, sans-serif; font-size: 13px; line-height: 19.5px;\">&nbsp;</p>\r\n<h2 style=\"box-sizing: border-box; line-height: 1.2; font-weight: 400; font-family: OpenSansLight, \'Helvetica Neue\', Arial, Helvetica, FreeSans, sans-serif; font-size: 24px; margin: 20px 0px 10px; color: #333333;\">The Merchant</h2>\r\n<p style=\"box-sizing: border-box; margin: 0px 0px 20px; color: #333333; font-family: OpenSansRegular, \'Helvetica Neue\', Helvetica, Arial, FreeSans, sans-serif; font-size: 13px; line-height: 19.5px;\"><a style=\"box-sizing: border-box; color: #0185c6; text-decoration: none;\" href=\"http://chicagosbars.co.uk/venues/yeovil/\">Chicago Rock Cafe</a>&nbsp;is an American-inspired restaurant and bar, providing guests with an authentic taste of cuisine from across the pond. With an extensive drinks menu of shots, wine and cocktails, the eatery\'s menu features traditional American dishes, from buffalo wild wings to smokey Joe burgers. The Yeovil restaurant is open seven days a week until late, with quiz nights and family funday events taking place throughout the week.</p>','BS4 3EN','51.4426688','-2.5683698999999933',NULL,NULL,1,0,1,0,NULL,NULL,'2014-07-28 00:00:01','2014-07-28 11:21:01','0000-00-00 00:00:00'),
	(324,NULL,2,'Jongleurs Comedy Club Entry For Two (£12) or Four (£21)','jongleurs-comedy-club-entry-for-two-12-or-four-21','at Choice of 12 Venues (Up to 72% Off)','<p><span style=\"color: #333333; font-family: OpenSansRegular, \'Helvetica Neue\', Helvetica, Arial, FreeSans, sans-serif; font-size: 13px; line-height: 19.5px;\">The nationwide&nbsp;</span><a style=\"box-sizing: border-box; color: #0185c6; text-decoration: none; font-family: OpenSansRegular, \'Helvetica Neue\', Helvetica, Arial, FreeSans, sans-serif; font-size: 13px; line-height: 19.5px;\" href=\"http://www.jongleurs.com/\">Jongleurs Comedy Club</a><span style=\"color: #333333; font-family: OpenSansRegular, \'Helvetica Neue\', Helvetica, Arial, FreeSans, sans-serif; font-size: 13px; line-height: 19.5px;\">&nbsp;empire plays host to eclectic line-ups of comedians every weekend at a selection of 12 venues. Lasting around two hours, the shows take in sets from seasoned stand-ups and up-and-coming comics alike, many of whom have a number of TV credits to their name. Tickets are available for two or four visitors at a choice of venue on selected nights.</span></p>','<p style=\"box-sizing: border-box; margin: 0px 0px 20px; color: #333333; font-family: OpenSansRegular, \'Helvetica Neue\', Helvetica, Arial, FreeSans, sans-serif; font-size: 13px; line-height: 19.5px;\"><span style=\"box-sizing: border-box; font-family: OpenSansSemiBold, \'Helvetica Neue\', Arial, Helvetica, FreeSans, sans-serif;\">Available venues:</span></p>\r\n<p style=\"box-sizing: border-box; margin: 0px 0px 20px; color: #333333; font-family: OpenSansRegular, \'Helvetica Neue\', Helvetica, Arial, FreeSans, sans-serif; font-size: 13px; line-height: 19.5px;\"><em style=\"box-sizing: border-box;\">Portsmouth</em>: Tiger Tiger, Gunwharf Quays, Portsmouth, PO1 3TP</p>\r\n<p style=\"box-sizing: border-box; margin: 0px 0px 20px; color: #333333; font-family: OpenSansRegular, \'Helvetica Neue\', Helvetica, Arial, FreeSans, sans-serif; font-size: 13px; line-height: 19.5px;\"><em style=\"box-sizing: border-box;\">Bristol</em>: The Cuban, Habourside, Bristol, BS1 5SZ</p>\r\n<p style=\"box-sizing: border-box; margin: 0px 0px 20px; color: #333333; font-family: OpenSansRegular, \'Helvetica Neue\', Helvetica, Arial, FreeSans, sans-serif; font-size: 13px; line-height: 19.5px;\"><em style=\"box-sizing: border-box;\">Cardiff</em>: Oceana, Greyfriars Road, Cardiff, CF10 3DP</p>\r\n<p style=\"box-sizing: border-box; margin: 0px 0px 20px; color: #333333; font-family: OpenSansRegular, \'Helvetica Neue\', Helvetica, Arial, FreeSans, sans-serif; font-size: 13px; line-height: 19.5px;\"><em style=\"box-sizing: border-box;\">Covent Garden</em>: Sway, 61-65 Great Queen Street, Covent Garden, London, WC2B 5BZ</p>\r\n<p style=\"box-sizing: border-box; margin: 0px 0px 20px; color: #333333; font-family: OpenSansRegular, \'Helvetica Neue\', Helvetica, Arial, FreeSans, sans-serif; font-size: 13px; line-height: 19.5px;\"><em style=\"box-sizing: border-box;\">Nottingham</em>: Oceana, Lower Parliament Street, Nottingham, NG1 3BB</p>\r\n<p style=\"box-sizing: border-box; margin: 0px 0px 20px; color: #333333; font-family: OpenSansRegular, \'Helvetica Neue\', Helvetica, Arial, FreeSans, sans-serif; font-size: 13px; line-height: 19.5px;\"><em style=\"box-sizing: border-box;\">Southampton</em>: Oceana, West Quay Road, Southampton, SO15 1RE</p>\r\n<p style=\"box-sizing: border-box; margin: 0px 0px 20px; color: #333333; font-family: OpenSansRegular, \'Helvetica Neue\', Helvetica, Arial, FreeSans, sans-serif; font-size: 13px; line-height: 19.5px;\"><em style=\"box-sizing: border-box;\">Birmingham</em>: Bar Risa, 259-262 Broad Street, Birmingham, B1 2HF</p>\r\n<p style=\"box-sizing: border-box; margin: 0px 0px 20px; color: #333333; font-family: OpenSansRegular, \'Helvetica Neue\', Helvetica, Arial, FreeSans, sans-serif; font-size: 13px; line-height: 19.5px;\"><em style=\"box-sizing: border-box;\">Camden</em>: 11 East Yard, Chalk Farm Road, London, NW1 8AB</p>\r\n<p style=\"box-sizing: border-box; margin: 0px 0px 20px; color: #333333; font-family: OpenSansRegular, \'Helvetica Neue\', Helvetica, Arial, FreeSans, sans-serif; font-size: 13px; line-height: 19.5px;\"><em style=\"box-sizing: border-box;\">Leeds</em>: Unit 1, 2 &amp; 4, The Cube, Albion Street, Leeds, LS2 8ER</p>\r\n<p style=\"box-sizing: border-box; margin: 0px 0px 20px; color: #333333; font-family: OpenSansRegular, \'Helvetica Neue\', Helvetica, Arial, FreeSans, sans-serif; font-size: 13px; line-height: 19.5px;\"><em style=\"box-sizing: border-box;\">Reading</em>: The Bowery District, 110-117 Friar Street, Berkshire, Reading, RG1 1EP</p>\r\n<p style=\"box-sizing: border-box; margin: 0px 0px 20px; color: #333333; font-family: OpenSansRegular, \'Helvetica Neue\', Helvetica, Arial, FreeSans, sans-serif; font-size: 13px; line-height: 19.5px;\"><em style=\"box-sizing: border-box;\">Watford</em>: 76 The Parade, Watford, WD17 1AW</p>\r\n<p style=\"box-sizing: border-box; margin: 0px 0px 20px; color: #333333; font-family: OpenSansRegular, \'Helvetica Neue\', Helvetica, Arial, FreeSans, sans-serif; font-size: 13px; line-height: 19.5px;\"><em style=\"box-sizing: border-box;\">Brighton</em>: Kingswest, West Street, Brighton, BN1 2RE</p>\r\n<p style=\"box-sizing: border-box; margin: 0px 0px 20px; color: #333333; font-family: OpenSansRegular, \'Helvetica Neue\', Helvetica, Arial, FreeSans, sans-serif; font-size: 13px; line-height: 19.5px;\"><br style=\"box-sizing: border-box;\" /><em style=\"box-sizing: border-box;\">Choose from the following options for live comedy tickets:</em></p>\r\n<ul style=\"box-sizing: border-box; margin: 0px 0px 20px; padding-left: 20px; color: #333333; font-family: OpenSansRegular, \'Helvetica Neue\', Helvetica, Arial, FreeSans, sans-serif; font-size: 13px; line-height: 19.5px;\">\r\n<li style=\"box-sizing: border-box;\">\r\n<p style=\"box-sizing: border-box; margin: 0px 0px 20px;\">&pound;12 for two people to Brighton (50% off)</p>\r\n</li>\r\n<li style=\"box-sizing: border-box;\">\r\n<p style=\"box-sizing: border-box; margin: 0px 0px 20px;\">&pound;21 for four people to Brighton (56% off)</p>\r\n</li>\r\n<li style=\"box-sizing: border-box;\">\r\n<p style=\"box-sizing: border-box; margin: 0px 0px 20px;\">&pound;12 for two people to Portsmouth, Bristol, Cardiff, Nottingham, Southampton or Watford (60% Off)</p>\r\n</li>\r\n<li style=\"box-sizing: border-box;\">\r\n<p style=\"box-sizing: border-box; margin: 0px 0px 20px;\">&pound;21 for four people to Portsmouth, Bristol, Cardiff, Nottingham, Southampton or Watford (65% off)</p>\r\n</li>\r\n<li style=\"box-sizing: border-box;\">\r\n<p style=\"box-sizing: border-box; margin: 0px 0px 20px;\">&pound;12 for two people to Covent Garden, Birmingham or Reading (65% off)</p>\r\n</li>\r\n<li style=\"box-sizing: border-box;\">\r\n<p style=\"box-sizing: border-box; margin: 0px 0px 20px;\">&pound;21 for four people to Covent Garden, Birmingham or Reading (69% off)</p>\r\n</li>\r\n<li style=\"box-sizing: border-box;\">\r\n<p style=\"box-sizing: border-box; margin: 0px 0px 20px;\">&pound;12 for two people to Camden (67% off)</p>\r\n</li>\r\n<li style=\"box-sizing: border-box;\">\r\n<p style=\"box-sizing: border-box; margin: 0px 0px 20px;\">&pound;21 for four people to Camden (71% off)</p>\r\n</li>\r\n<li style=\"box-sizing: border-box;\">\r\n<p style=\"box-sizing: border-box; margin: 0px 0px 20px;\">&pound;12 for two people to Leeds (68% off)</p>\r\n</li>\r\n<li style=\"box-sizing: border-box;\">\r\n<p style=\"box-sizing: border-box; margin: 0px 0px 20px;\">&pound;21 for four people to Leeds (72% off)<a class=\"hide_desktop\" href=\"b247://category/27/articles?subChannel=70\" rel=\"nofollow\">Here</a><a class=\"hide_tablet hide_mobile\" href=\"http://www.bristol247.com/category/discounts\">Here</a></p>\r\n</li>\r\n</ul>','BS4 3EN','51.4426688','-2.5683698999999933',NULL,NULL,1,0,1,0,NULL,NULL,'2014-07-28 00:00:01','2014-07-28 11:23:10','0000-00-00 00:00:00'),
	(325,NULL,2,'Two-Course Meal With Prosecco For Two £29','twocourse-meal-with-prosecco-for-two-29','at Old Manor House Hotel (Up to 50% Off)','<p><span style=\"color: #333333; font-family: OpenSansRegular, \'Helvetica Neue\', Helvetica, Arial, FreeSans, sans-serif; font-size: 13px; line-height: 19.5px;\">A pair of diners can settle down for dinner at the Old Manor House Hotel, with a choice to accompany a main course with either a starter or a dessert. Starters can include goats\' cheese, sun-dried tomato and olive salad; or beer-battered tiger prawns with a garlic aioli</span><em style=\"box-sizing: border-box; color: #333333; font-family: OpenSansRegular, \'Helvetica Neue\', Helvetica, Arial, FreeSans, sans-serif; font-size: 13px; line-height: 19.5px;\">(both usually &pound;6)</em><span style=\"color: #333333; font-family: OpenSansRegular, \'Helvetica Neue\', Helvetica, Arial, FreeSans, sans-serif; font-size: 13px; line-height: 19.5px;\">. The main event serves up a choice of the vegetarian dish of the day&nbsp;</span><em style=\"box-sizing: border-box; color: #333333; font-family: OpenSansRegular, \'Helvetica Neue\', Helvetica, Arial, FreeSans, sans-serif; font-size: 13px; line-height: 19.5px;\">(&pound;14)</em><span style=\"color: #333333; font-family: OpenSansRegular, \'Helvetica Neue\', Helvetica, Arial, FreeSans, sans-serif; font-size: 13px; line-height: 19.5px;\">; or new-season lamb shank braised in real ale served with garlic pomme pur&eacute;e, caramelised Chantenay carrots and lamb jus&nbsp;</span><em style=\"box-sizing: border-box; color: #333333; font-family: OpenSansRegular, \'Helvetica Neue\', Helvetica, Arial, FreeSans, sans-serif; font-size: 13px; line-height: 19.5px;\">(&pound;17)</em><span style=\"color: #333333; font-family: OpenSansRegular, \'Helvetica Neue\', Helvetica, Arial, FreeSans, sans-serif; font-size: 13px; line-height: 19.5px;\">. Dessert&nbsp;</span><em style=\"box-sizing: border-box; color: #333333; font-family: OpenSansRegular, \'Helvetica Neue\', Helvetica, Arial, FreeSans, sans-serif; font-size: 13px; line-height: 19.5px;\">(&pound;5.50)</em><span style=\"color: #333333; font-family: OpenSansRegular, \'Helvetica Neue\', Helvetica, Arial, FreeSans, sans-serif; font-size: 13px; line-height: 19.5px;\">&nbsp;offers up a selection including sticky toffee pudding with rich butterscotch sauce; and traditional cr&egrave;me brul&eacute;e served with shortbread biscuit. Meals are accompanied by a glass of Prosecco each.</span></p>','<p><a style=\"box-sizing: border-box; color: #0185c6; text-decoration: none; font-family: OpenSansRegular, \'Helvetica Neue\', Helvetica, Arial, FreeSans, sans-serif; font-size: 13px; line-height: 19.5px;\" href=\"http://www.oldmanorhousehotel.co.uk/index.html\">The Old Manor House Hotel</a><span style=\"color: #333333; font-family: OpenSansRegular, \'Helvetica Neue\', Helvetica, Arial, FreeSans, sans-serif; font-size: 13px; line-height: 19.5px;\">&nbsp;is a historic, 17th-century hotel, believed to be the oldest Dwelling House in Keynsham Village. The house boasts nine individual en-suite bedrooms, a bar, restaurant, ballroom and walled gardens. Situated between Bath and Bristol, the hotel benefits from a wide variety of transport links, making it an ideal location for business or pleasure.<a class=\"hide_desktop\" href=\"b247://category/27/articles?subChannel=70\" rel=\"nofollow\">Here</a><a class=\"hide_tablet hide_mobile\" href=\"http://www.bristol247.com/category/discounts\">Here</a></span></p>','BS4 3EN','51.4426688','-2.5683698999999933',NULL,NULL,1,0,1,0,NULL,NULL,'2014-07-28 00:00:01','2014-07-28 11:24:53','0000-00-00 00:00:00'),
	(326,NULL,2,'Clifton: Two-Course Meal With Prosecco For Two','clifton-twocourse-meal-with-prosecco-for-two','Â£29 at The Square Club (Up to 55% Off)','<p><span style=\"color: #333333; font-family: OpenSansRegular, \'Helvetica Neue\', Helvetica, Arial, FreeSans, sans-serif; font-size: 13px; line-height: 19.5px;\">Ladies and gents can indulge in two courses of British cuisine, with a meal for two, four or six at The Square Club. Choices from the a la carte menu include starters such as seared venison loin, pickled blackberries, pumpkin and chocolate&nbsp;</span><em style=\"box-sizing: border-box; color: #333333; font-family: OpenSansRegular, \'Helvetica Neue\', Helvetica, Arial, FreeSans, sans-serif; font-size: 13px; line-height: 19.5px;\">(usually &pound;8.50)</em><span style=\"color: #333333; font-family: OpenSansRegular, \'Helvetica Neue\', Helvetica, Arial, FreeSans, sans-serif; font-size: 13px; line-height: 19.5px;\">&nbsp;and seared cod cheeks with seafood black pudding and a pea garnish&nbsp;</span><em style=\"box-sizing: border-box; color: #333333; font-family: OpenSansRegular, \'Helvetica Neue\', Helvetica, Arial, FreeSans, sans-serif; font-size: 13px; line-height: 19.5px;\">(&pound;8.25)</em><span style=\"color: #333333; font-family: OpenSansRegular, \'Helvetica Neue\', Helvetica, Arial, FreeSans, sans-serif; font-size: 13px; line-height: 19.5px;\">. Main dishes include rump of Devon lamb, served with dauphinois, girolles, and baby turnips&nbsp;</span><em style=\"box-sizing: border-box; color: #333333; font-family: OpenSansRegular, \'Helvetica Neue\', Helvetica, Arial, FreeSans, sans-serif; font-size: 13px; line-height: 19.5px;\">(&pound;16.25)</em><span style=\"color: #333333; font-family: OpenSansRegular, \'Helvetica Neue\', Helvetica, Arial, FreeSans, sans-serif; font-size: 13px; line-height: 19.5px;\">&nbsp;and risotto of cepe, black truffle and chervil&nbsp;</span><em style=\"box-sizing: border-box; color: #333333; font-family: OpenSansRegular, \'Helvetica Neue\', Helvetica, Arial, FreeSans, sans-serif; font-size: 13px; line-height: 19.5px;\">(&pound;11.50)</em><span style=\"color: #333333; font-family: OpenSansRegular, \'Helvetica Neue\', Helvetica, Arial, FreeSans, sans-serif; font-size: 13px; line-height: 19.5px;\">. The meal will be accompanied by a glass of Prosecco</span><em style=\"box-sizing: border-box; color: #333333; font-family: OpenSansRegular, \'Helvetica Neue\', Helvetica, Arial, FreeSans, sans-serif; font-size: 13px; line-height: 19.5px;\">(&pound;5.50)</em><span style=\"color: #333333; font-family: OpenSansRegular, \'Helvetica Neue\', Helvetica, Arial, FreeSans, sans-serif; font-size: 13px; line-height: 19.5px;\">&nbsp;each.</span></p>','<p style=\"box-sizing: border-box; margin: 0px 0px 20px; color: #333333; font-family: OpenSansRegular, \'Helvetica Neue\', Helvetica, Arial, FreeSans, sans-serif; font-size: 13px; line-height: 19.5px;\"><em style=\"box-sizing: border-box;\">Choose from the following options for a two-course meal with Prosecco:</em></p>\r\n<ul style=\"box-sizing: border-box; margin: 0px 0px 20px; padding-left: 20px; color: #333333; font-family: OpenSansRegular, \'Helvetica Neue\', Helvetica, Arial, FreeSans, sans-serif; font-size: 13px; line-height: 19.5px;\">\r\n<li style=\"box-sizing: border-box;\">\r\n<p style=\"box-sizing: border-box; margin: 0px 0px 20px;\">&pound;29 for two (Up to 54% off)</p>\r\n</li>\r\n<li style=\"box-sizing: border-box;\">\r\n<p style=\"box-sizing: border-box; margin: 0px 0px 20px;\">&pound;57 for four (Up to 55% off)</p>\r\n</li>\r\n<li style=\"box-sizing: border-box;\">\r\n<p style=\"box-sizing: border-box; margin: 0px 0px 20px;\">&pound;85 for six (Up to 55% off)</p>\r\n</li>\r\n</ul>\r\n<p style=\"box-sizing: border-box; margin: 0px 0px 20px; color: #333333; font-family: OpenSansRegular, \'Helvetica Neue\', Helvetica, Arial, FreeSans, sans-serif; font-size: 13px; line-height: 19.5px;\">&nbsp;</p>\r\n<h2 style=\"box-sizing: border-box; line-height: 1.2; font-weight: 400; font-family: OpenSansLight, \'Helvetica Neue\', Arial, Helvetica, FreeSans, sans-serif; font-size: 24px; margin: 20px 0px 10px; color: #333333;\">The Merchant</h2>\r\n<p style=\"box-sizing: border-box; margin: 0px 0px 20px; color: #333333; font-family: OpenSansRegular, \'Helvetica Neue\', Helvetica, Arial, FreeSans, sans-serif; font-size: 13px; line-height: 19.5px;\"><a style=\"box-sizing: border-box; color: #0185c6; text-decoration: none;\" href=\"http://www.thesquareclub.com/square-kitchen/\">The Square Club</a>&nbsp;offers a wealth of hospitality as a private members\' club, restaurant, private party venue, cocktail bar and boutique wedding venue. The restaurant serves a range of sophisticated British dishes including Sunday roasts, while also hosting Christmas and&nbsp;<a style=\"box-sizing: border-box; color: #0185c6; text-decoration: none;\" href=\"http://www.thesquareclub.com/new-years-eve/\">New Year\'s Eve</a>&nbsp;parties.<a class=\"hide_desktop\" href=\"b247://category/27/articles?subChannel=70\" rel=\"nofollow\">Here</a><a class=\"hide_tablet hide_mobile\" href=\"http://www.bristol247.com/category/discounts\">Here</a></p>','BS4 3EN','51.4426688','-2.5683698999999933',NULL,NULL,1,0,1,0,NULL,NULL,'2014-07-28 00:00:01','2014-07-28 11:26:08','0000-00-00 00:00:00'),
	(327,NULL,2,'Two-Course Meal With Wine For Two or Four','twocourse-meal-with-wine-for-two-or-four','from Â£24.95 at CafÃ© Piano (Up to 54% Off)','<p><span style=\"color: #333333; font-family: OpenSansRegular, \'Helvetica Neue\', Helvetica, Arial, FreeSans, sans-serif; font-size: 13px; line-height: 19.5px;\">Diners seeking culinary treats can enjoy a two-course meal at Caf&eacute; Piano for a starter or dessert and a main. Option to begin with a starter from a varied menu including moules mariniere, chicken and bacon salad, and poached mushrooms in a filo pastry basket with a stilton cream sauce. Main course options include an 8oz butterflied fillet steak, duck breast in a cranberry and Cointreau sauce, and tortellini filled with spinach and ricotta. Meals are accompanied by a glass of house wine each.<a class=\"hide_desktop\" href=\"b247://category/27/articles?subChannel=70\" rel=\"nofollow\">Here</a><a class=\"hide_tablet hide_mobile\" href=\"http://www.bristol247.com/category/discounts\">Here</a></span></p>','<p><span style=\"color: #333333; font-family: OpenSansRegular, \'Helvetica Neue\', Helvetica, Arial, FreeSans, sans-serif; font-size: 13px; line-height: 19.5px;\">Nestled in a quiet courtyard and just a short stroll from the historic sights of Wells Cathedral,&nbsp;</span><a style=\"box-sizing: border-box; color: #0185c6; text-decoration: none; font-family: OpenSansRegular, \'Helvetica Neue\', Helvetica, Arial, FreeSans, sans-serif; font-size: 13px; line-height: 19.5px;\" href=\"http://www.cafepianowells.co.uk/\">Caf&eacute; Piano</a><span style=\"color: #333333; font-family: OpenSansRegular, \'Helvetica Neue\', Helvetica, Arial, FreeSans, sans-serif; font-size: 13px; line-height: 19.5px;\">&nbsp;is open five days a week for lunch or dinner. The menu fuses British classics with Mediterranean dishes, featuring meals such as moules mariniere, Somerset ham, egg and chips, a range of steaks, and pasta dishes. The family-run restaurant hosts weekly sessions of live jazz and blues, and can cater to external events on request.</span></p>','BS4 3EN','51.4426688','-2.5683698999999933',NULL,NULL,1,0,1,0,NULL,NULL,'2014-07-28 00:00:01','2014-07-28 11:27:59','0000-00-00 00:00:00'),
	(328,NULL,2,'Brunel\'s Hat: Steak With Wine For Two or Four','brunels-hat-steak-with-wine-for-two-or-four','from Â£19.95 at Hilton Bristol (Up to 65% Off)','<p><span style=\"color: #333333; font-family: OpenSansRegular, \'Helvetica Neue\', Helvetica, Arial, FreeSans, sans-serif; font-size: 13px; line-height: 19.5px;\">Discerning diners can take their pick of main courses from the a la carte menu, at the Brunel\'s Hat restaurant in the Hilton Bristol. Options include an 8oz sirloin steak with hand-cut chips, tomato, mushroom and a sauce&nbsp;</span><em style=\"box-sizing: border-box; color: #333333; font-family: OpenSansRegular, \'Helvetica Neue\', Helvetica, Arial, FreeSans, sans-serif; font-size: 13px; line-height: 19.5px;\">(usually &pound;21)</em><span style=\"color: #333333; font-family: OpenSansRegular, \'Helvetica Neue\', Helvetica, Arial, FreeSans, sans-serif; font-size: 13px; line-height: 19.5px;\">, pan-fried grey mullet fillet with grilled baby fennel, cherry tomatoes and a dill butter sauce&nbsp;</span><em style=\"box-sizing: border-box; color: #333333; font-family: OpenSansRegular, \'Helvetica Neue\', Helvetica, Arial, FreeSans, sans-serif; font-size: 13px; line-height: 19.5px;\">(&pound;15)</em><span style=\"color: #333333; font-family: OpenSansRegular, \'Helvetica Neue\', Helvetica, Arial, FreeSans, sans-serif; font-size: 13px; line-height: 19.5px;\">, or a filo parcel stuffed with wild mushrooms and spinach, served with saut&eacute;ed Jersey Royals and a tomato salsa</span><em style=\"box-sizing: border-box; color: #333333; font-family: OpenSansRegular, \'Helvetica Neue\', Helvetica, Arial, FreeSans, sans-serif; font-size: 13px; line-height: 19.5px;\">(&pound;14)</em><span style=\"color: #333333; font-family: OpenSansRegular, \'Helvetica Neue\', Helvetica, Arial, FreeSans, sans-serif; font-size: 13px; line-height: 19.5px;\">. Meals will be accompanied by a glass of wine&nbsp;</span><em style=\"box-sizing: border-box; color: #333333; font-family: OpenSansRegular, \'Helvetica Neue\', Helvetica, Arial, FreeSans, sans-serif; font-size: 13px; line-height: 19.5px;\">(&pound;7)</em><span style=\"color: #333333; font-family: OpenSansRegular, \'Helvetica Neue\', Helvetica, Arial, FreeSans, sans-serif; font-size: 13px; line-height: 19.5px;\">&nbsp;each.<a class=\"hide_desktop\" href=\"b247://category/27/articles?subChannel=70\" rel=\"nofollow\">Here</a><a class=\"hide_tablet hide_mobile\" href=\"http://www.bristol247.com/category/discounts\">Here</a></span></p>','<p style=\"box-sizing: border-box; margin: 0px 0px 20px; color: #333333; font-family: OpenSansRegular, \'Helvetica Neue\', Helvetica, Arial, FreeSans, sans-serif; font-size: 13px; line-height: 19.5px;\"><em style=\"box-sizing: border-box;\">Full menu can be found&nbsp;<a style=\"box-sizing: border-box; color: #0185c6; text-decoration: none;\" href=\"http://www3.hilton.com/resources/media/hi/BSTBRHN/en_US/pdf/en_BSTBRHN_BrunelsHatMenu_Jul2013.pdf\">here</a>.</em></p>\r\n<p style=\"box-sizing: border-box; margin: 0px 0px 20px; color: #333333; font-family: OpenSansRegular, \'Helvetica Neue\', Helvetica, Arial, FreeSans, sans-serif; font-size: 13px; line-height: 19.5px;\"><em style=\"box-sizing: border-box;\">Choose from the following options for a main course with glass of wine each:</em></p>\r\n<ul style=\"box-sizing: border-box; margin: 0px 0px 20px; padding-left: 20px; color: #333333; font-family: OpenSansRegular, \'Helvetica Neue\', Helvetica, Arial, FreeSans, sans-serif; font-size: 13px; line-height: 19.5px;\">\r\n<li style=\"box-sizing: border-box;\">\r\n<p style=\"box-sizing: border-box; margin: 0px 0px 20px;\">&pound;19.95 for two (Up to 64% off)</p>\r\n</li>\r\n<li style=\"box-sizing: border-box;\">\r\n<p style=\"box-sizing: border-box; margin: 0px 0px 20px;\">&pound;38.95 for four (Up to 65% off)</p>\r\n</li>\r\n</ul>\r\n<p style=\"box-sizing: border-box; margin: 0px 0px 20px; color: #333333; font-family: OpenSansRegular, \'Helvetica Neue\', Helvetica, Arial, FreeSans, sans-serif; font-size: 13px; line-height: 19.5px;\">&nbsp;</p>\r\n<h2 style=\"box-sizing: border-box; line-height: 1.2; font-weight: 400; font-family: OpenSansLight, \'Helvetica Neue\', Arial, Helvetica, FreeSans, sans-serif; font-size: 24px; margin: 20px 0px 10px; color: #333333;\">The Merchant</h2>\r\n<p style=\"box-sizing: border-box; margin: 0px 0px 20px; color: #333333; font-family: OpenSansRegular, \'Helvetica Neue\', Helvetica, Arial, FreeSans, sans-serif; font-size: 13px; line-height: 19.5px;\">Part of the global hospitality chain, the&nbsp;<a style=\"box-sizing: border-box; color: #0185c6; text-decoration: none;\" href=\"http://www3.hilton.com/en/hotels/united-kingdom/hilton-bristol-BSTBRHN/index.html\">Hilton Bristol</a>&nbsp;offers four-star accommodation on the edge of the city. Rooms come with free Wi-Fi, work desks and 32\" LCD televisions as standard, with suites offering luxuries such as a bathrobe and slippers, welcome tray with drinks, and on-demand movies. Guests can dine in the contemporary Brunel\'s Hat restaurant, which serves British dishes and Sunday lunches, or the lounge bar, where drinks and light bites are available. The hotel features a swimming pool and fitness suite, and hosts corporate functions, weddings and seasonal celebrations.</p>','BS4 3EN','51.4426688','-2.5683698999999933',NULL,NULL,1,0,0,0,NULL,NULL,'2014-07-28 00:00:01','2014-07-28 13:29:11','0000-00-00 00:00:00'),
	(329,NULL,2,'All-You-Can-Eat Chinese Buffet For One or Four','allyoucaneat-chinese-buffet-for-one-or-four','from Â£5.95 at Dragon Kiss (Up to 45% Off)','<p><span style=\"color: #333333; font-family: OpenSansRegular, \'Helvetica Neue\', Helvetica, Arial, FreeSans, sans-serif; font-size: 13px; line-height: 19.5px;\">With a wide range of oriental flavours on offer, diners can help themselves during an all-you-can-eat session. A multitude of starters, desserts, and mains are available, from beef in black bean sauce and crispy aromatic duck to sweet and sour chicken and noodles.</span></p>','<p><span style=\"color: #333333; font-family: OpenSansRegular, \'Helvetica Neue\', Helvetica, Arial, FreeSans, sans-serif; font-size: 13px; line-height: 19.5px;\">The red, black, and chrome decor at Chinese eatery&nbsp;</span><a style=\"box-sizing: border-box; color: #0185c6; text-decoration: none; font-family: OpenSansRegular, \'Helvetica Neue\', Helvetica, Arial, FreeSans, sans-serif; font-size: 13px; line-height: 19.5px;\" href=\"https://www.facebook.com/pages/Dragon-Kiss/100140638248\">Dragon Kiss</a><span style=\"color: #333333; font-family: OpenSansRegular, \'Helvetica Neue\', Helvetica, Arial, FreeSans, sans-serif; font-size: 13px; line-height: 19.5px;\">&nbsp;adds to the contemporary feel at the Weston-Super-Mare restaurant. As well as satisfying tummies, the venue is also a hub for entertaining with dancing, karaoke and an extensive drinks list, with favourite cocktails including China Blue and Pink Dragon.<a class=\"hide_desktop\" href=\"b247://category/27/articles?subChannel=70\" rel=\"nofollow\">Here</a><a class=\"hide_tablet hide_mobile\" href=\"http://www.bristol247.com/category/discounts\">Here</a></span></p>','BS4 3EN','51.4426688','-2.5683698999999933',NULL,NULL,1,0,0,0,NULL,NULL,'2014-07-28 00:00:01','2014-07-28 13:37:23','0000-00-00 00:00:00'),
	(330,NULL,2,'12oz Sirloin On The Stone With Wine For Two','12oz-sirloin-on-the-stone-with-wine-for-two','for Â£19.95 at The White Horse (51% Off)','<p><span style=\"color: #333333; font-family: OpenSansRegular, \'Helvetica Neue\', Helvetica, Arial, FreeSans, sans-serif; font-size: 13px; line-height: 19.5px;\">The White Horse sates appetites in emphatic fashion courtesy of a 12oz sirloin steak prepared to order. The chargrilled meat arrives sizzling on a stone, alongside chips, tomatoes and a mixture of horseradish, mustard and red onion chutney. Fare is suitably accompanied by a glass of house wine each. Customers should note that menu items are subject to change.</span></p>','<p><a style=\"box-sizing: border-box; color: #0185c6; text-decoration: none; font-family: OpenSansRegular, \'Helvetica Neue\', Helvetica, Arial, FreeSans, sans-serif; font-size: 13px; line-height: 19.5px;\" href=\"http://www.whitehorsehambrook.com/\">The White Horse</a><span style=\"color: #333333; font-family: OpenSansRegular, \'Helvetica Neue\', Helvetica, Arial, FreeSans, sans-serif; font-size: 13px; line-height: 19.5px;\">&nbsp;has served meals and refreshments at a traditional setting in Hambrook village for over three decades. The kitchen prepares hearty steaks, meatballs and sausages, as well as seafood, vegetarian and pasta dishes. A bar stocks local ales and international beers, wines and spirits. The interior features a jukebox and dartboard, and regular entertainment includes quiz nights and live music.<a class=\"hide_desktop\" href=\"b247://category/27/articles?subChannel=70\" rel=\"nofollow\">Here</a><a class=\"hide_tablet hide_mobile\" href=\"http://www.bristol247.com/category/discounts\">Here</a></span></p>','BS4 3EN','51.4426688','-2.5683698999999933',NULL,NULL,1,0,0,0,NULL,NULL,'2014-07-28 00:00:01','2014-07-28 13:39:17','0000-00-00 00:00:00'),
	(331,NULL,2,'Summer BBQ Party For 20 People from £175','summer-bbq-party-for-20-people-from-175','at No. 4 Clifton Village (Up to 51% Off*)','<p><span style=\"color: #333333; font-family: OpenSansRegular, \'Helvetica Neue\', Helvetica, Arial, FreeSans, sans-serif; font-size: 13px; line-height: 19.5px;\">The verdant English gardens of No. 4 Clifton Village provide an idyllic party venue for celebrations, work party or just some alfresco merriment during the afternoon or evening. Set within the grounds of a Georgian mansion house, the front garden offers a tree-lined spot for people watching, while the secret walled garden to the rear gives visitors a peaceful retreat from village life. Up to 30 guests can tuck into a BBQ&nbsp;</span><em style=\"box-sizing: border-box; color: #333333; font-family: OpenSansRegular, \'Helvetica Neue\', Helvetica, Arial, FreeSans, sans-serif; font-size: 13px; line-height: 19.5px;\">(usually &pound;17.50 per person)</em><span style=\"color: #333333; font-family: OpenSansRegular, \'Helvetica Neue\', Helvetica, Arial, FreeSans, sans-serif; font-size: 13px; line-height: 19.5px;\">&nbsp;which provides revellers with a selection of meat and vegetarian snacks from beef burgers to Mediterranean vegetables with mozzarella. Guests can also opt to include a glass of Pimms for each person for a little summer-time extra.</span></p>','<p style=\"box-sizing: border-box; margin: 0px 0px 20px; color: #333333; font-family: OpenSansRegular, \'Helvetica Neue\', Helvetica, Arial, FreeSans, sans-serif; font-size: 13px; line-height: 19.5px;\">Spicy chicken, red onion bell pepper brochette | Home made 6oz beef burgers, bacon, cheddar, redonion marmalade | 30 days matured rib-eye steak sandwich | Hand made cumberland sausage hot dogs | Hand cut fries with dips or roasted rosemary and thyme new potatoes | Summer garden salad | Roasted Mediterranean vegetables with mozzarella | Buttered onions | Coleslaw | Potato salad | Seasonal berries and meringues</p>\r\n<p style=\"box-sizing: border-box; margin: 0px 0px 20px; color: #333333; font-family: OpenSansRegular, \'Helvetica Neue\', Helvetica, Arial, FreeSans, sans-serif; font-size: 13px; line-height: 19.5px;\"><em style=\"box-sizing: border-box;\">Choose from the following summer BBQ options:</em></p>\r\n<ul style=\"box-sizing: border-box; margin: 0px 0px 20px; padding-left: 20px; color: #333333; font-family: OpenSansRegular, \'Helvetica Neue\', Helvetica, Arial, FreeSans, sans-serif; font-size: 13px; line-height: 19.5px;\">\r\n<li style=\"box-sizing: border-box;\">\r\n<p style=\"box-sizing: border-box; margin: 0px 0px 20px;\">&pound;175 for 20 people (50% off*)</p>\r\n</li>\r\n<li style=\"box-sizing: border-box;\">\r\n<p style=\"box-sizing: border-box; margin: 0px 0px 20px;\">&pound;215 for 20 people with a glass of Pimms each</p>\r\n</li>\r\n<li style=\"box-sizing: border-box;\">\r\n<p style=\"box-sizing: border-box; margin: 0px 0px 20px;\">&pound;259 for 30 people (51% off*)</p>\r\n</li>\r\n<li style=\"box-sizing: border-box;\">\r\n<p style=\"box-sizing: border-box; margin: 0px 0px 20px;\">&pound;319 for 30 people with a glass of Pimms each<a class=\"hide_desktop\" href=\"b247://category/27/articles?subChannel=70\" rel=\"nofollow\">Here</a><a class=\"hide_tablet hide_mobile\" href=\"http://www.bristol247.com/category/discounts\">Here</a></p>\r\n</li>\r\n</ul>','BS4 3EN','51.4426688','-2.5683698999999933',NULL,NULL,1,0,0,0,NULL,NULL,'2014-07-28 00:00:01','2014-07-28 13:40:56','0000-00-00 00:00:00'),
	(332,NULL,2,'Sharing Meal For Two or Four from £19.95','sharing-meal-for-two-or-four-from-1995','at La Casbah (Up to 50% Off)','<p style=\"box-sizing: border-box; margin: 0px 0px 20px; color: #333333; font-family: OpenSansRegular, \'Helvetica Neue\', Helvetica, Arial, FreeSans, sans-serif; font-size: 13px; line-height: 19.5px;\">No less than eight dishes of flavourful Moroccan and Mediterranean cuisine are on the menu at La Casbah, ready to share between pairs. Meals can begin with olives, followed by favourites like hummus and falafel, before the main is brought out, with choices including lamb tagine and spicy chicken on the bone, served with salad, and rice or couscous. A bring-your-own-bottle service is available with no corking charges.</p>\r\n<p style=\"box-sizing: border-box; margin: 0px 0px 20px; color: #333333; font-family: OpenSansRegular, \'Helvetica Neue\', Helvetica, Arial, FreeSans, sans-serif; font-size: 13px; line-height: 19.5px;\"><em style=\"box-sizing: border-box;\">Choose from the following options for a sharing meal:</em></p>\r\n<ul style=\"box-sizing: border-box; margin: 0px 0px 20px; padding-left: 20px; color: #333333; font-family: OpenSansRegular, \'Helvetica Neue\', Helvetica, Arial, FreeSans, sans-serif; font-size: 13px; line-height: 19.5px;\">\r\n<li style=\"box-sizing: border-box;\">\r\n<p style=\"box-sizing: border-box; margin: 0px 0px 20px;\">&pound;19.95 for two (Up to 50% off)</p>\r\n</li>\r\n<li style=\"box-sizing: border-box;\">\r\n<p style=\"box-sizing: border-box; margin: 0px 0px 20px;\">&pound;39.90 for four (Up to 50% off)</p>\r\n</li>\r\n</ul>','<h3 style=\"box-sizing: border-box; line-height: 1.2; font-weight: 400; font-family: OpenSansSemiBold, \'Helvetica Neue\', Arial, Helvetica, FreeSans, sans-serif; margin: 10px 0px 5px; font-size: 16px; color: #333333;\">Set Menu</h3>\r\n<p style=\"box-sizing: border-box; margin: 0px 0px 20px; color: #333333; font-family: OpenSansRegular, \'Helvetica Neue\', Helvetica, Arial, FreeSans, sans-serif; font-size: 13px; line-height: 19.5px;\"><span style=\"box-sizing: border-box; font-family: OpenSansSemiBold, \'Helvetica Neue\', Arial, Helvetica, FreeSans, sans-serif;\">Starters:</span>&nbsp;Olives | Falafel | Hummus | Zaelok | Tiger prawns |&nbsp;<em style=\"box-sizing: border-box;\">Starters come with salad and pitta bread</em></p>\r\n<p style=\"box-sizing: border-box; margin: 0px 0px 20px; color: #333333; font-family: OpenSansRegular, \'Helvetica Neue\', Helvetica, Arial, FreeSans, sans-serif; font-size: 13px; line-height: 19.5px;\"><span style=\"box-sizing: border-box; font-family: OpenSansSemiBold, \'Helvetica Neue\', Arial, Helvetica, FreeSans, sans-serif;\">Mains:</span>&nbsp;Lamb tagine with fresh vegetables | Dejaj har - spicy chicken on the bone | Spicy cod with mixed peppers | Veggie bake topped with parmesan cheese |&nbsp;<em style=\"box-sizing: border-box;\">Mains come with salad, couscous or rice</em></p>\r\n<p style=\"box-sizing: border-box; margin: 0px 0px 20px; color: #333333; font-family: OpenSansRegular, \'Helvetica Neue\', Helvetica, Arial, FreeSans, sans-serif; font-size: 13px; line-height: 19.5px;\"><span style=\"box-sizing: border-box; font-family: OpenSansSemiBold, \'Helvetica Neue\', Arial, Helvetica, FreeSans, sans-serif;\">Dessert:</span>&nbsp;Baclava to share with ice cream</p>','BS4 3EN','51.4426688','-2.5683698999999933',NULL,NULL,1,0,0,0,NULL,NULL,'0000-00-00 00:00:00','2014-07-28 13:42:15','0000-00-00 00:00:00'),
	(333,NULL,2,'Pub Meal With Wine or Beer For Two','pub-meal-with-wine-or-beer-for-two','Â£14.99 at The White Hart Atworth (Up to 52% Off)','<p><span style=\"color: #333333; font-family: OpenSansRegular, \'Helvetica Neue\', Helvetica, Arial, FreeSans, sans-serif; font-size: 13px; line-height: 19.5px;\">The White Hart sates appetites in typically British fashion with a choice of classic dishes. Diners may opt to tuck in to a choice of scampi and chips, gammon steak topped with an egg or pineapple, with chips and salad, ham, egg and chips or a roasted vegetable lasagne and salad. Fare can be enjoyed with a 175ml glass of wine, pint of beer or choice of soft drink. Customers should note that menu items are subject to change.<a class=\"hide_desktop\" href=\"b247://category/27/articles?subChannel=70\" rel=\"nofollow\">Here</a><a class=\"hide_tablet hide_mobile\" href=\"http://www.bristol247.com/category/discounts\">Here</a></span></p>','<p style=\"box-sizing: border-box; margin: 0px 0px 20px; color: #333333; font-family: OpenSansRegular, \'Helvetica Neue\', Helvetica, Arial, FreeSans, sans-serif; font-size: 13px; line-height: 19.5px;\"><em style=\"box-sizing: border-box;\">hoose from the following options for a main meal with wine, beer or soft drink each:</em></p>\r\n<ul style=\"box-sizing: border-box; margin: 0px 0px 20px; padding-left: 20px; color: #333333; font-family: OpenSansRegular, \'Helvetica Neue\', Helvetica, Arial, FreeSans, sans-serif; font-size: 13px; line-height: 19.5px;\">\r\n<li style=\"box-sizing: border-box;\">\r\n<p style=\"box-sizing: border-box; margin: 0px 0px 20px;\">&pound;14.99 for two people (Up to 51% off)</p>\r\n</li>\r\n<li style=\"box-sizing: border-box;\">\r\n<p style=\"box-sizing: border-box; margin: 0px 0px 20px;\">&pound;28.99 for four people (Up to 52% off)</p>\r\n</li>\r\n</ul>\r\n<p style=\"box-sizing: border-box; margin: 0px 0px 20px; color: #333333; font-family: OpenSansRegular, \'Helvetica Neue\', Helvetica, Arial, FreeSans, sans-serif; font-size: 13px; line-height: 19.5px;\">&nbsp;</p>\r\n<h2 style=\"box-sizing: border-box; line-height: 1.2; font-weight: 400; font-family: OpenSansLight, \'Helvetica Neue\', Arial, Helvetica, FreeSans, sans-serif; font-size: 24px; margin: 20px 0px 10px; color: #333333;\">The Merchant</h2>\r\n<p style=\"box-sizing: border-box; margin: 0px 0px 20px; color: #333333; font-family: OpenSansRegular, \'Helvetica Neue\', Helvetica, Arial, FreeSans, sans-serif; font-size: 13px; line-height: 19.5px;\"><a style=\"box-sizing: border-box; color: #0185c6; text-decoration: none;\" href=\"http://www.whitehartatworth.co.uk/\">The White Hart</a>&nbsp;is housed within a 17th century inn situated in Atworth village. The kitchen prepares hearty classics, vegetarian and seafood dishes, and a range of children\'s favourites. A bar serves local ales and international beers, wines and spirits. Meals can be enjoyed amid the interior\'s traditional decor, at outdoor seating, or at home thanks to a takeaway service. A skittle alley delivers sporting spectacle, and guests can stay the night in an en-suite room.</p>','BS4 3EN','51.4426688','-2.5683698999999933',NULL,NULL,1,0,0,0,NULL,NULL,'2014-07-28 00:00:01','2014-07-28 13:43:14','0000-00-00 00:00:00'),
	(334,NULL,2,'£25 for £40 Towards Food For Two People ','25-for-40-towards-food-for-two-people-','at Marco Pierre White Steakhouse Bar and Grill (Up to 38% Off)','<p><span style=\"color: #333333; font-family: OpenSansRegular, \'Helvetica Neue\', Helvetica, Arial, FreeSans, sans-serif; font-size: 13px; line-height: 19.5px;\">Two diners can settle down to a meal with &pound;40 towards the bill for any combination of food items from the a la carte, dessert or Sunday lunch menus. Potential dishes include the likes of lemon and rosemary chicken with truffle chips and a rocket and parmesan salad&nbsp;</span><em style=\"box-sizing: border-box; color: #333333; font-family: OpenSansRegular, \'Helvetica Neue\', Helvetica, Arial, FreeSans, sans-serif; font-size: 13px; line-height: 19.5px;\">(usually &pound;17.50)</em><span style=\"color: #333333; font-family: OpenSansRegular, \'Helvetica Neue\', Helvetica, Arial, FreeSans, sans-serif; font-size: 13px; line-height: 19.5px;\">, or duck breast with confit leg and French-style peas&nbsp;</span><em style=\"box-sizing: border-box; color: #333333; font-family: OpenSansRegular, \'Helvetica Neue\', Helvetica, Arial, FreeSans, sans-serif; font-size: 13px; line-height: 19.5px;\">(&pound;22.50)</em><span style=\"color: #333333; font-family: OpenSansRegular, \'Helvetica Neue\', Helvetica, Arial, FreeSans, sans-serif; font-size: 13px; line-height: 19.5px;\">. Set Sunday lunch menus&nbsp;</span><em style=\"box-sizing: border-box; color: #333333; font-family: OpenSansRegular, \'Helvetica Neue\', Helvetica, Arial, FreeSans, sans-serif; font-size: 13px; line-height: 19.5px;\">(from &pound;13.50 for one course)</em><span style=\"color: #333333; font-family: OpenSansRegular, \'Helvetica Neue\', Helvetica, Arial, FreeSans, sans-serif; font-size: 13px; line-height: 19.5px;\">&nbsp;are available with mains of fish, beef, chicken or pumpkin risotto with traditional accompaniments, while those with a sweet tooth can indulge in the likes of sticky toffee pudding&nbsp;</span><em style=\"box-sizing: border-box; color: #333333; font-family: OpenSansRegular, \'Helvetica Neue\', Helvetica, Arial, FreeSans, sans-serif; font-size: 13px; line-height: 19.5px;\">(&pound;6.50)</em><span style=\"color: #333333; font-family: OpenSansRegular, \'Helvetica Neue\', Helvetica, Arial, FreeSans, sans-serif; font-size: 13px; line-height: 19.5px;\">&nbsp;or Cambridge burnt cream&nbsp;</span><em style=\"box-sizing: border-box; color: #333333; font-family: OpenSansRegular, \'Helvetica Neue\', Helvetica, Arial, FreeSans, sans-serif; font-size: 13px; line-height: 19.5px;\">(&pound;6.50)</em><span style=\"color: #333333; font-family: OpenSansRegular, \'Helvetica Neue\', Helvetica, Arial, FreeSans, sans-serif; font-size: 13px; line-height: 19.5px;\">.</span></p>','<p><span style=\"color: #333333; font-family: OpenSansRegular, \'Helvetica Neue\', Helvetica, Arial, FreeSans, sans-serif; font-size: 13px; line-height: 19.5px;\">Nestled within the grounds of the Doubletree by Hilton Cadbury House hotel,&nbsp;</span><a style=\"box-sizing: border-box; color: #0185c6; text-decoration: none; font-family: OpenSansRegular, \'Helvetica Neue\', Helvetica, Arial, FreeSans, sans-serif; font-size: 13px; line-height: 19.5px;\" href=\"http://www.mpwsteakhousebristol.co.uk/\">Marco Pierre White Steakhouse Bar &amp; Grill</a><span style=\"color: #333333; font-family: OpenSansRegular, \'Helvetica Neue\', Helvetica, Arial, FreeSans, sans-serif; font-size: 13px; line-height: 19.5px;\">&nbsp;dishes up all manner of British treats with a little European flair. The kitchen goes to great lengths to use locally sourced and sustainable ingredients, while dishes range from grilled or roast meats and seafood to classic English puddings.</span></p>','BS4 3EN','51.4426688','-2.5683698999999933',NULL,NULL,1,0,0,0,NULL,NULL,'2014-07-28 00:00:01','2014-07-28 13:44:55','0000-00-00 00:00:00'),
	(335,NULL,2,'Afternoon Tea For Two or Four from £14','afternoon-tea-for-two-or-four-from-14','at The Fleur de Lis (53% Off)','<p style=\"box-sizing: border-box; margin: 0px 0px 20px; color: #333333; font-family: OpenSansRegular, \'Helvetica Neue\', Helvetica, Arial, FreeSans, sans-serif; font-size: 13px; line-height: 19.5px;\">Afternoon tea at The Fleur de Lis sees visitors tuck into a varied spread of post-meridian treats. Finger sandwiches sport assorted fillings, and are followed by scones with clotted cream and a selection of cakes. Fare is accompanied by a choice of tea or coffee, and can be enjoyed from Monday to Saturday between 2pm and 5pm.</p>\r\n<p style=\"box-sizing: border-box; margin: 0px 0px 20px; color: #333333; font-family: OpenSansRegular, \'Helvetica Neue\', Helvetica, Arial, FreeSans, sans-serif; font-size: 13px; line-height: 19.5px;\"><em style=\"box-sizing: border-box;\">Choose from the following options for afternoon tea:</em></p>\r\n<ul style=\"box-sizing: border-box; margin: 0px 0px 20px; padding-left: 20px; color: #333333; font-family: OpenSansRegular, \'Helvetica Neue\', Helvetica, Arial, FreeSans, sans-serif; font-size: 13px; line-height: 19.5px;\">\r\n<li style=\"box-sizing: border-box;\">\r\n<p style=\"box-sizing: border-box; margin: 0px 0px 20px;\">&pound;14 for two people (53% off)</p>\r\n</li>\r\n<li style=\"box-sizing: border-box;\">\r\n<p style=\"box-sizing: border-box; margin: 0px 0px 20px;\">&pound;28 for four people (53% off)</p>\r\n</li>\r\n</ul>','<p><a style=\"box-sizing: border-box; color: #0185c6; text-decoration: none; font-family: OpenSansRegular, \'Helvetica Neue\', Helvetica, Arial, FreeSans, sans-serif; font-size: 13px; line-height: 19.5px;\" href=\"http://www.fleurdelisbristol.co.uk/\">The Fleur de Lis</a><span style=\"color: #333333; font-family: OpenSansRegular, \'Helvetica Neue\', Helvetica, Arial, FreeSans, sans-serif; font-size: 13px; line-height: 19.5px;\">&nbsp;serves meals and refreshments amid traditional confines in Pucklechurch village. The eatery offers stone-cooked meats and hearty British classics, as well as lighter bites like sandwiches and salads. The interior features framed artwork, open fires and ambient lighting, while a terrace is perfect for sunny months. The venue regularly hosts seasonally themed events, many of which boast special menus.</span></p>','BS4 3EN','51.4426688','-2.5683698999999933',NULL,NULL,1,0,0,0,NULL,NULL,'2014-07-28 00:00:01','2014-07-28 13:45:58','0000-00-00 00:00:00'),
	(336,NULL,2,'Two-Course Indian Meal For Two, Four or Six','twocourse-indian-meal-for-two-four-or-six','from Â£15 at Ahmed\'s Curry Cafe (Up to 61% Off)','<p><span style=\"color: #333333; font-family: OpenSansRegular, \'Helvetica Neue\', Helvetica, Arial, FreeSans, sans-serif; font-size: 13px; line-height: 19.5px;\">This spicy subcontinental sojourn begins with starters such as sheekh kebab&nbsp;</span><em style=\"box-sizing: border-box; color: #333333; font-family: OpenSansRegular, \'Helvetica Neue\', Helvetica, Arial, FreeSans, sans-serif; font-size: 13px; line-height: 19.5px;\">(usually &pound;3.45)</em><span style=\"color: #333333; font-family: OpenSansRegular, \'Helvetica Neue\', Helvetica, Arial, FreeSans, sans-serif; font-size: 13px; line-height: 19.5px;\">, garlic mushrooms&nbsp;</span><em style=\"box-sizing: border-box; color: #333333; font-family: OpenSansRegular, \'Helvetica Neue\', Helvetica, Arial, FreeSans, sans-serif; font-size: 13px; line-height: 19.5px;\">(&pound;3)</em><span style=\"color: #333333; font-family: OpenSansRegular, \'Helvetica Neue\', Helvetica, Arial, FreeSans, sans-serif; font-size: 13px; line-height: 19.5px;\">&nbsp;or lamb dhosa&nbsp;</span><em style=\"box-sizing: border-box; color: #333333; font-family: OpenSansRegular, \'Helvetica Neue\', Helvetica, Arial, FreeSans, sans-serif; font-size: 13px; line-height: 19.5px;\">(&pound;3.60)</em><span style=\"color: #333333; font-family: OpenSansRegular, \'Helvetica Neue\', Helvetica, Arial, FreeSans, sans-serif; font-size: 13px; line-height: 19.5px;\">. The main course will be selected from the World Curries section, which encompasses international offerings such as the tomato-based king prawn shashlik bhuna&nbsp;</span><em style=\"box-sizing: border-box; color: #333333; font-family: OpenSansRegular, \'Helvetica Neue\', Helvetica, Arial, FreeSans, sans-serif; font-size: 13px; line-height: 19.5px;\">(&pound;14.95)</em><span style=\"color: #333333; font-family: OpenSansRegular, \'Helvetica Neue\', Helvetica, Arial, FreeSans, sans-serif; font-size: 13px; line-height: 19.5px;\">, the coconut flavours of Sri Lankan fish curry</span><em style=\"box-sizing: border-box; color: #333333; font-family: OpenSansRegular, \'Helvetica Neue\', Helvetica, Arial, FreeSans, sans-serif; font-size: 13px; line-height: 19.5px;\">(&pound;7.25)</em><span style=\"color: #333333; font-family: OpenSansRegular, \'Helvetica Neue\', Helvetica, Arial, FreeSans, sans-serif; font-size: 13px; line-height: 19.5px;\">&nbsp;or the sweet-and-spicy beef kalia&nbsp;</span><em style=\"box-sizing: border-box; color: #333333; font-family: OpenSansRegular, \'Helvetica Neue\', Helvetica, Arial, FreeSans, sans-serif; font-size: 13px; line-height: 19.5px;\">(&pound;6.95)</em><span style=\"color: #333333; font-family: OpenSansRegular, \'Helvetica Neue\', Helvetica, Arial, FreeSans, sans-serif; font-size: 13px; line-height: 19.5px;\">. Sauces can be mopped up with a plain naan for each pair to share&nbsp;</span><em style=\"box-sizing: border-box; color: #333333; font-family: OpenSansRegular, \'Helvetica Neue\', Helvetica, Arial, FreeSans, sans-serif; font-size: 13px; line-height: 19.5px;\">(&pound;1.75)</em><span style=\"color: #333333; font-family: OpenSansRegular, \'Helvetica Neue\', Helvetica, Arial, FreeSans, sans-serif; font-size: 13px; line-height: 19.5px;\">, and diners can also bring their own booze for a corkage fee of &pound;1.50 per person.</span></p>','<p><a style=\"box-sizing: border-box; color: #0185c6; text-decoration: none; font-family: OpenSansRegular, \'Helvetica Neue\', Helvetica, Arial, FreeSans, sans-serif; font-size: 13px; line-height: 19.5px;\" href=\"http://currycafebristolonline.com/index.php\">Ahmed\'s Curry Cafe</a><span style=\"color: #333333; font-family: OpenSansRegular, \'Helvetica Neue\', Helvetica, Arial, FreeSans, sans-serif; font-size: 13px; line-height: 19.5px;\">&nbsp;offers up classic subcontinental cuisine at a location on Chandos Road in Clifton. Established in 2001, the eatery serves regional Indian and Bangladeshi food alongside dishes from elsewhere around Asia: creamy Goan curries, traditional lamb haandi, Indonesian beef rendang and the lightly spiced tropical Tenga fish are all available. The eatery also allows customers to bring their own drinks, and offers meal deals for eat-in, collection or takeaway.</span></p>','BS4 3EN','51.4426688','-2.5683698999999933',NULL,NULL,1,0,0,0,NULL,NULL,'2014-07-28 00:00:01','2014-07-28 13:47:41','0000-00-00 00:00:00'),
	(373,48,2,'Scooby Doo: The Mystery of the Pyramid','scooby_doo_the_mystery_of_the_pyramid','Scooby-Doo and the gang are back by popular demand and with even more Spooky Mystery','<p>Scooby-Doo&nbsp;and the gang are back by popular demand and with even more Spooky Mystery and fun - this time in the Pyramids... Warner Bros. Cartoon Classic Comes to Life!</p>','<p>Scooby-Doo, Shaggy, Fred, Velma and Daphne arrive in Egypt where they must solve the mystery of Pharaoh Hatchepsouts Pyramid.&nbsp; Easy, you say?&nbsp; Not if the gang has to deal with mysterious mummies plus the wrath of the Pharaoh who will transform anyone who dares to approach the pyramid... into stone!</p>\r\n<p>With hilarious physical comedy, popular tunes and special effects... the whole family will enjoy this 90 minute show... Live On Stage.</p>\r\n<p>Zoinks... book early for best seats!</p>\r\n<p>Please note: Scooby-Doo! The Mystery of the Pyramid is a loud, vibrant, action-packed children\'s show which contains spooky fun and content that may not be suitable for children with a nervous disposition or certain linked medical conditions.&nbsp;&nbsp;Parental discretion is advised.</p>','BS4 3EN','51.452404406541696','-2.5984964716552668',NULL,NULL,1,1,0,NULL,NULL,NULL,'2014-08-07 00:00:01','2014-08-07 00:17:29','0000-00-00 00:00:00'),
	(375,NULL,6,'Kevin creating a test article','kevin-creating-a-test-article','All the news about creating articles','<p style=\"text-align: justify; line-height: 14px; margin: 0px 0px 14px; padding: 0px; font-family: Arial, Helvetica, sans;\">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse dapibus tincidunt rhoncus. Ut dapibus vulputate urna vel pellentesque. Nullam accumsan, libero vitae consequat adipiscing, odio nisl ultricies tortor, in cursus lacus tortor non arcu. Praesent at sem rutrum, placerat enim sit amet, hendrerit risus. Aenean tincidunt neque sed massa congue imperdiet. Donec eget blandit ligula, et laoreet nunc. Aenean scelerisque elit dui. Nam condimentum, justo id tincidunt fringilla, sapien lectus varius nulla, eu vulputate lectus ante in eros. Sed sodales tortor sed quam bibendum viverra. Mauris semper mi sed leo tincidunt accumsan. Mauris a rhoncus massa. Maecenas nec odio vitae dui sollicitudin tristique non et libero.</p>\r\n<p style=\"text-align: justify; line-height: 14px; margin: 0px 0px 14px; padding: 0px; font-family: Arial, Helvetica, sans;\">Aliquam erat volutpat. Phasellus hendrerit, urna dapibus dignissim pharetra, mauris velit aliquam risus, nec venenatis lectus metus quis odio. Cras velit est, sodales et vestibulum eget, ullamcorper non nisl. Ut dictum suscipit mauris, eu vehicula leo consectetur eget. Cras justo velit, posuere eu velit in, tempor sagittis neque. Duis mi lorem, convallis sed dignissim id, posuere vitae elit. Maecenas nec tellus eget magna tincidunt sagittis.</p>','<p>Paragraph. Cras risus sem, convallis eu nisl id, fringilla ornare libero. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam iaculis fermentum lacinia. Nunc tristique leo ipsum, eget porttitor nisi iaculis id. Integer varius augue at dolor vehicula, ac blandit mauris porta. Fusce sagittis sagittis massa, at volutpat massa posuere at. Nunc vehicula semper leo, non gravida mauris vehicula eu.</p>\r\n<blockquote>\r\n<p style=\"text-align: justify; line-height: 14px; margin: 0px 0px 14px; padding: 0px; font-family: Arial, Helvetica, sans;\">This is a blockquote to be pulled out.</p>\r\n</blockquote>\r\n<p style=\"text-align: justify; line-height: 14px; margin: 0px 0px 14px; padding: 0px; font-family: Arial, Helvetica, sans;\">Ut non feugiat lectus, sit amet fringilla tellus. Praesent mattis magna ac convallis tristique. Proin vitae mi dolor. Vestibulum fringilla metus et nibh dignissim eleifend. In sollicitudin dolor sed purus dignissim, nec iaculis erat fringilla. Duis at commodo odio, id sollicitudin dolor. Etiam iaculis quam sit amet tristique fermentum. Nam sed eros libero. Vestibulum sit amet euismod risus. Phasellus imperdiet imperdiet risus vel porta. Praesent vitae nisl est. Sed nec euismod turpis, ut laoreet turpis. Donec bibendum lorem odio, nec dictum dui adipiscing eu.</p>\r\n<p style=\"text-align: justify; line-height: 14px; margin: 0px 0px 14px; padding: 0px; font-family: Arial, Helvetica, sans;\">&nbsp;</p>\r\n<p style=\"text-align: justify; line-height: 14px; margin: 0px 0px 14px; padding: 0px; font-family: Arial, Helvetica, sans;\">&nbsp;</p>\r\n<div style=\"text-align: justify; line-height: 14px; margin: 0px 0px 14px; padding: 0px; font-family: Arial, Helvetica, sans;\">We have a Div?</div>\r\n<pre style=\"text-align: justify; line-height: 14px; margin: 0px 0px 14px; padding: 0px; font-family: Arial, Helvetica, sans;\">What is a pre then?</pre>\r\n<h1 style=\"text-align: justify; line-height: 14px; margin: 0px 0px 14px; padding: 0px; font-family: Arial, Helvetica, sans;\">&nbsp;</h1>\r\n<h1 style=\"text-align: justify; line-height: 14px; margin: 0px 0px 14px; padding: 0px; font-family: Arial, Helvetica, sans;\">Heading 1</h1>\r\n<h2 style=\"text-align: justify; line-height: 14px; margin: 0px 0px 14px; padding: 0px; font-family: Arial, Helvetica, sans;\">Heading 2</h2>\r\n<h3 style=\"text-align: justify; line-height: 14px; margin: 0px 0px 14px; padding: 0px; font-family: Arial, Helvetica, sans;\">heading 3</h3>\r\n<h4 style=\"text-align: justify; line-height: 14px; margin: 0px 0px 14px; padding: 0px; font-family: Arial, Helvetica, sans;\">heading 4</h4>\r\n<h5 style=\"text-align: justify; line-height: 14px; margin: 0px 0px 14px; padding: 0px; font-family: Arial, Helvetica, sans;\">heading 5</h5>\r\n<h6 style=\"text-align: justify; line-height: 14px; margin: 0px 0px 14px; padding: 0px; font-family: Arial, Helvetica, sans;\">heading 6</h6>\r\n<p style=\"text-align: justify; line-height: 14px; margin: 0px 0px 14px; padding: 0px; font-family: Arial, Helvetica, sans;\"><strong>Bold</strong></p>\r\n<p style=\"text-align: justify; line-height: 14px; margin: 0px 0px 14px; padding: 0px; font-family: Arial, Helvetica, sans;\"><em>Italic</em></p>\r\n<p style=\"text-align: justify; line-height: 14px; margin: 0px 0px 14px; padding: 0px; font-family: Arial, Helvetica, sans;\"><span style=\"text-decoration: underline;\">Underline</span></p>\r\n<p style=\"text-align: justify; line-height: 14px; margin: 0px 0px 14px; padding: 0px; font-family: Arial, Helvetica, sans;\"><span style=\"text-decoration: line-through;\">Strikethrough</span></p>\r\n<p style=\"text-align: justify; line-height: 14px; margin: 0px 0px 14px; padding: 0px; font-family: Arial, Helvetica, sans;\"><sup>Superscript</sup></p>\r\n<p style=\"text-align: justify; line-height: 14px; margin: 0px 0px 14px; padding: 0px; font-family: Arial, Helvetica, sans;\"><sub>Subscript</sub></p>\r\n<p style=\"text-align: justify; line-height: 14px; margin: 0px 0px 14px; padding: 0px; font-family: Arial, Helvetica, sans;\"><code>Code</code></p>\r\n<p style=\"text-align: left;\">Left aligned.&nbsp;<span style=\"font-family: Arial, Helvetica, sans; line-height: 14px; text-align: justify;\">Ut non feugiat lectus, sit amet fringilla tellus. Praesent mattis magna ac convallis tristique. Proin vitae mi dolor. Vestibulum fringilla metus et nibh dignissim eleifend. In sollicitudin dolor sed purus dignissim, nec iaculis erat fringilla. Duis at commodo odio, id sollicitudin dolor. Etiam iaculis quam sit amet tristique fermentum. Nam sed eros libero. Vestibulum sit amet euismod risus. Phasellus imperdiet imperdiet risus vel porta. Praesent vitae nisl est. Sed nec euismod turpis, ut laoreet turpis. Donec bibendum lorem odio, nec dictum dui adipiscing eu.</span></p>\r\n<p style=\"text-align: right;\"><span style=\"font-family: Arial, Helvetica, sans; line-height: 14px; text-align: justify;\">Right Aligned.&nbsp;</span><span style=\"font-family: Arial, Helvetica, sans; line-height: 14px; text-align: justify;\">Ut non feugiat lectus, sit amet fringilla tellus. Praesent mattis magna ac convallis tristique. Proin vitae mi dolor. Vestibulum fringilla metus et nibh dignissim eleifend. In sollicitudin dolor sed purus dignissim, nec iaculis erat fringilla. Duis at commodo odio, id sollicitudin dolor. Etiam iaculis quam sit amet tristique fermentum. Nam sed eros libero. Vestibulum sit amet euismod risus. Phasellus imperdiet imperdiet risus vel porta. Praesent vitae nisl est. Sed nec euismod turpis, ut laoreet turpis. Donec bibendum lorem odio, nec dictum dui adipiscing eu.</span></p>\r\n<p style=\"text-align: center;\"><span style=\"font-family: Arial, Helvetica, sans; line-height: 14px; text-align: justify;\">Centre Aligned.</span>&nbsp;<span style=\"font-family: Arial, Helvetica, sans; line-height: 14px; text-align: justify;\">Ut non feugiat lectus, sit amet fringilla tellus. Praesent mattis magna ac convallis tristique. Proin vitae mi dolor. Vestibulum fringilla metus et nibh dignissim eleifend. In sollicitudin dolor sed purus dignissim, nec iaculis erat fringilla. Duis at commodo odio, id sollicitudin dolor. Etiam iaculis quam sit amet tristique fermentum. Nam sed eros libero. Vestibulum sit amet euismod risus. Phasellus imperdiet imperdiet risus vel porta. Praesent vitae nisl est. Sed nec euismod turpis, ut laoreet turpis. Donec bibendum lorem odio, nec dictum dui adipiscing eu.</span></p>\r\n<p style=\"text-align: justify;\">Force Justified.&nbsp;<span style=\"font-family: Arial, Helvetica, sans; line-height: 14px; text-align: justify;\">Ut non feugiat lectus, sit amet fringilla tellus. Praesent mattis magna ac convallis tristique. Proin vitae mi dolor. Vestibulum fringilla metus et nibh dignissim eleifend. In sollicitudin dolor sed purus dignissim, nec iaculis erat fringilla. Duis at commodo odio, id sollicitudin dolor. Etiam iaculis quam sit amet tristique fermentum. Nam sed eros libero. Vestibulum sit amet euismod risus. Phasellus imperdiet imperdiet risus vel porta. Praesent vitae nisl est. Sed nec euismod turpis, ut laoreet turpis. Donec bibendum lorem odio, nec dictum dui adipiscing eu.</span></p>\r\n<p style=\"text-align: justify;\">&nbsp;</p>\r\n<ul>\r\n<li><span style=\"font-family: Arial, Helvetica, sans; line-height: 14px; text-align: justify;\">Bullet</span></li>\r\n<li><span style=\"font-family: Arial, Helvetica, sans; line-height: 14px; text-align: justify;\">Bullet</span></li>\r\n<li><span style=\"font-family: Arial, Helvetica, sans; line-height: 14px; text-align: justify;\">Bullet</span></li>\r\n</ul>\r\n<p style=\"text-align: left;\">&nbsp;</p>\r\n<ol>\r\n<li><span style=\"font-family: Arial, Helvetica, sans; line-height: 14px; text-align: justify;\">1</span></li>\r\n<li><span style=\"font-family: Arial, Helvetica, sans; line-height: 14px; text-align: justify;\">2</span></li>\r\n<li><span style=\"font-family: Arial, Helvetica, sans; line-height: 14px; text-align: justify;\">3</span></li>\r\n</ol>\r\n<p style=\"text-align: left;\">&nbsp;</p>\r\n<p>Left aligned.&nbsp;<span style=\"font-family: Arial, Helvetica, sans; line-height: 14px; text-align: justify;\">Ut non feugiat lectus, sit amet fringilla tellus. Praesent mattis magna ac convallis tristique. Proin vitae mi dolor. Vestibulum fringilla metus et nibh dignissim eleifend. In sollicitudin dolor sed purus dignissim, nec iaculis erat fringilla. Duis at commodo odio, id sollicitudin dolor. Etiam iaculis quam sit amet tristique fermentum. Nam sed eros libero. Vestibulum sit amet euismod risus. Phasellus imperdiet imperdiet risus vel porta. Praesent vitae nisl est. Sed nec euismod turpis, ut laoreet turpis. Donec bibendum lorem odio, nec dictum dui adipiscing eu.</span></p>\r\n<p style=\"padding-left: 30px;\"><span style=\"font-family: Arial, Helvetica, sans; line-height: 14px; text-align: justify;\">Indent</span></p>\r\n<p style=\"padding-left: 60px;\"><span style=\"font-family: Arial, Helvetica, sans; line-height: 14px; text-align: justify;\">indent indent</span></p>\r\n<p style=\"padding-left: 30px;\"><span style=\"font-family: Arial, Helvetica, sans; line-height: 14px; text-align: justify;\">Outdent</span></p>\r\n<p><a title=\"Football\" href=\"http://www.bbc.co.uk/sport/0/football/\" target=\"_blank\">Link to something random</a></p>','BS4 3EN','51.43458781212021','-2.5528018176555634',NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,'2014-08-07 03:19:21','2014-08-07 14:35:14','0000-00-00 00:00:00'),
	(378,NULL,6,'Test article without images','test-article-without-images','Sub heading for article without images','<p style=\"text-align: justify; line-height: 14px; margin: 0px 0px 14px; padding: 0px; font-family: Arial, Helvetica, sans;\">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse dapibus tincidunt rhoncus. Ut dapibus vulputate urna vel pellentesque. Nullam accumsan, libero vitae consequat adipiscing, odio nisl ultricies tortor, in cursus lacus tortor non arcu. Praesent at sem rutrum, placerat enim sit amet, hendrerit risus. Aenean tincidunt neque sed massa congue imperdiet. Donec eget blandit ligula, et laoreet nunc. Aenean scelerisque elit dui. Nam condimentum, justo id tincidunt fringilla, sapien lectus varius nulla, eu vulputate lectus ante in eros. Sed sodales tortor sed quam bibendum viverra. Mauris semper mi sed leo tincidunt accumsan. Mauris a rhoncus massa. Maecenas nec odio vitae dui sollicitudin tristique non et libero.</p>\r\n<p style=\"text-align: justify; line-height: 14px; margin: 0px 0px 14px; padding: 0px; font-family: Arial, Helvetica, sans;\">Aliquam erat volutpat. Phasellus hendrerit, urna dapibus dignissim pharetra, mauris velit aliquam risus, nec venenatis lectus metus quis odio. Cras velit est, sodales et vestibulum eget, ullamcorper non nisl. Ut dictum suscipit mauris, eu vehicula leo consectetur eget. Cras justo velit, posuere eu velit in, tempor sagittis neque. Duis mi lorem, convallis sed dignissim id, posuere vitae elit. Maecenas nec tellus eget magna tincidunt sagittis.</p>','<p style=\"text-align: justify; line-height: 14px; margin: 0px 0px 14px; padding: 0px; font-family: Arial, Helvetica, sans;\">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse dapibus tincidunt rhoncus. Ut dapibus vulputate urna vel pellentesque. Nullam accumsan, libero vitae consequat adipiscing, odio nisl ultricies tortor, in cursus lacus tortor non arcu. Praesent at sem rutrum, placerat enim sit amet, hendrerit risus. Aenean tincidunt neque sed massa congue imperdiet. Donec eget blandit ligula, et laoreet nunc. Aenean scelerisque elit dui. Nam condimentum, justo id tincidunt fringilla, sapien lectus varius nulla, eu vulputate lectus ante in eros. Sed sodales tortor sed quam bibendum viverra. Mauris semper mi sed leo tincidunt accumsan. Mauris a rhoncus massa. Maecenas nec odio vitae dui sollicitudin tristique non et libero.</p>\r\n<p style=\"text-align: justify; line-height: 14px; margin: 0px 0px 14px; padding: 0px; font-family: Arial, Helvetica, sans;\">Aliquam erat volutpat. Phasellus hendrerit, urna dapibus dignissim pharetra, mauris velit aliquam risus, nec venenatis lectus metus quis odio. Cras velit est, sodales et vestibulum eget, ullamcorper non nisl. Ut dictum suscipit mauris, eu vehicula leo consectetur eget. Cras justo velit, posuere eu velit in, tempor sagittis neque. Duis mi lorem, convallis sed dignissim id, posuere vitae elit. Maecenas nec tellus eget magna tincidunt sagittis.</p>\r\n<p>&nbsp;</p>','BS4 3EN','51.4426688','-2.5683698999999933',NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,'2014-08-08 12:24:11','2014-08-08 12:22:16','0000-00-00 00:00:00'),
	(379,NULL,6,'Some of Kev\'s news','some-of-kevs-news','Sub heading for Kev\'s news','<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse dapibus tincidunt rhoncus. Ut dapibus vulputate urna vel pellentesque. Nullam accumsan, libero vitae consequat adipiscing, odio nisl ultricies tortor, in cursus lacus tortor non arcu. Praesent at sem rutrum, placerat enim sit amet, hendrerit risus. Aenean tincidunt neque sed massa congue imperdiet. Donec eget blandit ligula, et laoreet nunc. Aenean scelerisque elit dui. Nam condimentum, justo id tincidunt fringilla, sapien lectus varius nulla, eu vulputate lectus ante in eros. Sed sodales tortor sed quam bibendum viverra. Mauris semper mi sed leo tincidunt accumsan. Mauris a rhoncus massa. Maecenas nec odio vitae dui sollicitudin tristique non et libero.</p>\r\n<p>Aliquam erat volutpat. Phasellus hendrerit, urna dapibus dignissim pharetra, mauris velit aliquam risus, nec venenatis lectus metus quis odio. Cras velit est, sodales et vestibulum eget, ullamcorper non nisl. Ut dictum suscipit mauris, eu vehicula leo consectetur eget. Cras justo velit, posuere eu velit in, tempor sagittis neque. Duis mi lorem, convallis sed dignissim id, posuere vitae elit. Maecenas nec tellus eget magna tincidunt sagittis.</p>\r\n<p>&nbsp;</p>\r\n<p>&nbsp;</p>','<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse dapibus tincidunt rhoncus. Ut dapibus vulputate urna vel pellentesque. Nullam accumsan, libero vitae consequat adipiscing, odio nisl ultricies tortor, in cursus lacus tortor non arcu. Praesent at sem rutrum, placerat enim sit amet, hendrerit risus. Aenean tincidunt neque sed massa congue imperdiet. Donec eget blandit ligula, et laoreet nunc. Aenean scelerisque elit dui. Nam condimentum, justo id tincidunt fringilla, sapien lectus varius nulla, eu vulputate lectus ante in eros. Sed sodales tortor sed quam bibendum viverra. Mauris semper mi sed leo tincidunt accumsan. Mauris a rhoncus massa. Maecenas nec odio vitae dui sollicitudin tristique non et libero.</p>\r\n<p>Aliquam erat volutpat. Phasellus hendrerit, urna dapibus dignissim pharetra, mauris velit aliquam risus, nec venenatis lectus metus quis odio. Cras velit est, sodales et vestibulum eget, ullamcorper non nisl. Ut dictum suscipit mauris, eu vehicula leo consectetur eget. Cras justo velit, posuere eu velit in, tempor sagittis neque. Duis mi lorem, convallis sed dignissim id, posuere vitae elit. Maecenas nec tellus eget magna tincidunt sagittis.</p>','BS4 3EN','51.4426688','-2.5683698999999933',NULL,NULL,0,0,0,NULL,NULL,NULL,NULL,'2014-08-08 13:00:42','0000-00-00 00:00:00'),
	(380,49,6,'Test event for Kevin','test_event_for_kevin','Lots of parties!','<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse dapibus tincidunt rhoncus. Ut dapibus vulputate urna vel pellentesque. Nullam accumsan, libero vitae consequat adipiscing, odio nisl ultricies tortor, in cursus lacus tortor non arcu. Praesent at sem rutrum, placerat enim sit amet, hendrerit risus. Aenean tincidunt neque sed massa congue imperdiet. Donec eget blandit ligula, et laoreet nunc. Aenean scelerisque elit dui. Nam condimentum, justo id tincidunt fringilla, sapien lectus varius nulla, eu vulputate lectus ante in eros. Sed sodales tortor sed quam bibendum viverra. Mauris semper mi sed leo tincidunt accumsan. Mauris a rhoncus massa. Maecenas nec odio vitae dui sollicitudin tristique non et libero.</p>\r\n<p>Aliquam erat volutpat. Phasellus hendrerit, urna dapibus dignissim pharetra, mauris velit aliquam risus, nec venenatis lectus metus quis odio. Cras velit est, sodales et vestibulum eget, ullamcorper non nisl. Ut dictum suscipit mauris, eu vehicula leo consectetur eget. Cras justo velit, posuere eu velit in, tempor sagittis neque. Duis mi lorem, convallis sed dignissim id, posuere vitae elit. Maecenas nec tellus eget magna tincidunt sagittis.</p>\r\n<p>&nbsp;</p>','<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse dapibus tincidunt rhoncus. Ut dapibus vulputate urna vel pellentesque. Nullam accumsan, libero vitae consequat adipiscing, odio nisl ultricies tortor, in cursus lacus tortor non arcu. Praesent at sem rutrum, placerat enim sit amet, hendrerit risus. Aenean tincidunt neque sed massa congue imperdiet. Donec eget blandit ligula, et laoreet nunc. Aenean scelerisque elit dui. Nam condimentum, justo id tincidunt fringilla, sapien lectus varius nulla, eu vulputate lectus ante in eros. Sed sodales tortor sed quam bibendum viverra. Mauris semper mi sed leo tincidunt accumsan. Mauris a rhoncus massa. Maecenas nec odio vitae dui sollicitudin tristique non et libero.</p>\r\n<p>Aliquam erat volutpat. Phasellus hendrerit, urna dapibus dignissim pharetra, mauris velit aliquam risus, nec venenatis lectus metus quis odio. Cras velit est, sodales et vestibulum eget, ullamcorper non nisl. Ut dictum suscipit mauris, eu vehicula leo consectetur eget. Cras justo velit, posuere eu velit in, tempor sagittis neque. Duis mi lorem, convallis sed dignissim id, posuere vitae elit. Maecenas nec tellus eget magna tincidunt sagittis.</p>\r\n<p>&nbsp;</p>','BS4 3EN','51.45315114582281','-2.598109692335129',NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,'0000-00-00 00:00:00','2014-08-08 14:04:00','2014-08-08 02:23:12'),
	(381,NULL,6,'Kev\'s house','kevs_house','Not an open invitation to Kev\'s house','<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse dapibus tincidunt rhoncus. Ut dapibus vulputate urna vel pellentesque. Nullam accumsan, libero vitae consequat adipiscing, odio nisl ultricies tortor, in cursus lacus tortor non arcu. Praesent at sem rutrum, placerat enim sit amet, hendrerit risus. Aenean tincidunt neque sed massa congue imperdiet. Donec eget blandit ligula, et laoreet nunc. Aenean scelerisque elit dui. Nam condimentum, justo id tincidunt fringilla, sapien lectus varius nulla, eu vulputate lectus ante in eros. Sed sodales tortor sed quam bibendum viverra. Mauris semper mi sed leo tincidunt accumsan. Mauris a rhoncus massa. Maecenas nec odio vitae dui sollicitudin tristique non et libero.</p>\r\n<p>Aliquam erat volutpat. Phasellus hendrerit, urna dapibus dignissim pharetra, mauris velit aliquam risus, nec venenatis lectus metus quis odio. Cras velit est, sodales et vestibulum eget, ullamcorper non nisl. Ut dictum suscipit mauris, eu vehicula leo consectetur eget. Cras justo velit, posuere eu velit in, tempor sagittis neque. Duis mi lorem, convallis sed dignissim id, posuere vitae elit. Maecenas nec tellus eget magna tincidunt sagittis.</p>\r\n<p>&nbsp;</p>','<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse dapibus tincidunt rhoncus. Ut dapibus vulputate urna vel pellentesque. Nullam accumsan, libero vitae consequat adipiscing, odio nisl ultricies tortor, in cursus lacus tortor non arcu. Praesent at sem rutrum, placerat enim sit amet, hendrerit risus. Aenean tincidunt neque sed massa congue imperdiet. Donec eget blandit ligula, et laoreet nunc. Aenean scelerisque elit dui. Nam condimentum, justo id tincidunt fringilla, sapien lectus varius nulla, eu vulputate lectus ante in eros. Sed sodales tortor sed quam bibendum viverra. Mauris semper mi sed leo tincidunt accumsan. Mauris a rhoncus massa. Maecenas nec odio vitae dui sollicitudin tristique non et libero.</p>\r\n<p>Aliquam erat volutpat. Phasellus hendrerit, urna dapibus dignissim pharetra, mauris velit aliquam risus, nec venenatis lectus metus quis odio. Cras velit est, sodales et vestibulum eget, ullamcorper non nisl. Ut dictum suscipit mauris, eu vehicula leo consectetur eget. Cras justo velit, posuere eu velit in, tempor sagittis neque. Duis mi lorem, convallis sed dignissim id, posuere vitae elit. Maecenas nec tellus eget magna tincidunt sagittis.</p>\r\n<p>&nbsp;</p>',NULL,NULL,NULL,NULL,NULL,1,0,0,NULL,NULL,NULL,'0000-00-00 00:00:00','2014-08-08 14:35:00','0000-00-00 00:00:00'),
	(382,51,2,'Wicked','wicked','Winner of 90 international awards, Wicked is coming to Bristol','<p>Winner of 90 international awards,&nbsp;Wicked&nbsp;has been casting its magical spell over audiences across the world for a decade and continues to break records at London&rsquo;s Apollo Victoria Theatre, where it is already the 15th longest-running West End musical of all time.</p>','<p>In a brilliantly witty re-imagining of the stories and characters created by L. Frank Baum inThe Wonderful Wizard of Oz, Wicked tells the incredible untold story of an unlikely but profound friendship between two sorcery students. Their extraordinary adventures in Oz will ultimately see them fulfil their destinies as Glinda The Good and the Wicked Witch of the West...</p>',NULL,NULL,NULL,NULL,NULL,1,1,0,NULL,NULL,NULL,'2014-08-18 00:00:01','2014-08-11 09:39:19','2014-08-11 10:07:59'),
	(383,NULL,6,'','','','','','BS4 3EN','51.4426688','-2.5683698999999933',NULL,NULL,0,0,0,NULL,NULL,NULL,NULL,'2014-08-11 14:37:31','0000-00-00 00:00:00'),
	(384,NULL,6,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,0,NULL,NULL,NULL,NULL,'2014-08-11 15:20:00','2014-08-11 15:20:00'),
	(385,NULL,6,'Bristol RPZ: Scheme for St Pauls and Bower Ashton to start','bristol-rpz-scheme-for-st-pauls-and-bower-ashton-to-start','Scheme for Bower Ashton will go live on Sept 29, while St Pauls will be rolled out Oct 20','<p style=\"font-family: \'palatino linotype\', palatino, serif; font-size: 14px; line-height: 21px;\">Two new areas of Bristol have been named as the latest areas to get residents parking zones (RPZ) schemes implemented.</p>\r\n<p style=\"font-family: \'palatino linotype\', palatino, serif; font-size: 14px; line-height: 21px;\">The RPZ scheme for Bower Ashton will go live on September 29, while St Pauls will be rolled out on October 20, Bristol City Council (BCC) announced on Friday.</p>\r\n<p style=\"font-family: \'palatino linotype\', palatino, serif; font-size: 14px; line-height: 21px;\">The St Pauls scheme will operate Monday to Friday from 9am to 5pm with operating conditions mirroring those operating in Redland and Cotham North, a BCC spokesman said.</p>\r\n<p style=\"font-family: \'palatino linotype\', palatino, serif; font-size: 14px; line-height: 21px;\">Currently, in both Redland and Cotham North, visitors can park for up to 30 minutes free of charge using a pay and display ticket or pay &pound;1 an hour to park for up to three hours.</p>\r\n<p style=\"font-family: \'palatino linotype\', palatino, serif; font-size: 14px; line-height: 21px;\">St Pauls residents will receive 50 free visitor permits every year and buy up to another 50 for &pound;1 each.</p>\r\n<p style=\"font-family: \'palatino linotype\', palatino, serif; font-size: 14px; line-height: 21px;\">Meanwhile, those living in the small, self-contained Bower Ashton RPZ area haven been given different parking regulations to live under.</p>\r\n<p style=\"font-family: \'palatino linotype\', palatino, serif; font-size: 14px; line-height: 21px;\">The area experiences specific parking pressures from Ashton Court Estate, Ashton Park School, the UWE campus as well as matchday parking from nearby Bristol City Football Club.</p>\r\n<p style=\"font-family: \'palatino linotype\', palatino, serif; font-size: 14px; line-height: 21px;\">Most roads within the area will be included in a Permit Parking Area in operation 24 hours a day, seven days a week. There will also be some mixed-use parking bays on Kennel Lodge Road.</p>\r\n<p style=\"font-family: \'palatino linotype\', palatino, serif; font-size: 14px; line-height: 21px;\">Residents will receive 70 free visitor permits per year and can buy another 70 for &pound;1 each.</p>\r\n<p style=\"font-family: \'palatino linotype\', palatino, serif; font-size: 14px; line-height: 21px;\">&nbsp;</p>','<p style=\"font-family: \'palatino linotype\', palatino, serif; font-size: 14px; line-height: 21px;\">St Pauls and Bower Ashton are the sixth and seventh RPZ areas to be approved in the current programme of 12 areas. More details are due to be posted on the&nbsp;<a style=\"color: #cd1613; outline: none; text-decoration: none; font-weight: bold;\" href=\"http://www.bristol247.com/2014/08/11/bristol-rpz-scheme-for-st-pauls-and-bower-ashton-to-start-90390/www.bristol.gov.uk/rps\" target=\"_blank\">BCC website</a>&nbsp;soon.</p>\r\n<p style=\"font-family: \'palatino linotype\', palatino, serif; font-size: 14px; line-height: 21px;\">Mayor of Bristol, George Ferguson, said the two schemes were &ldquo;further evidence that we are taking a very flexible approach to designing these schemes deferring to local characteristics and demand&rdquo;.</p>\r\n<p style=\"font-family: \'palatino linotype\', palatino, serif; font-size: 14px; line-height: 21px;\">He added that he had received &ldquo;very positive reactions from those living in the four new RPZ areas that are now up and running&rdquo;.</p>\r\n<p style=\"font-family: \'palatino linotype\', palatino, serif; font-size: 14px; line-height: 21px;\">But the mayor has not yet announced whether he will attend a council committee to answer questions over the implementation of the scheme as a whole.</p>\r\n<p style=\"font-family: \'palatino linotype\', palatino, serif; font-size: 14px; line-height: 21px;\">Last week, it emerged the Place Scrutiny Commission had issued a summons for him to appear at their next meeting on September 19 to answer questions.</p>\r\n<p>&nbsp;</p>\r\n<p style=\"font-family: \'palatino linotype\', palatino, serif; font-size: 14px; line-height: 21px;\">Notably, the councillors &ndash; chaired by vocal critic of the mayor Cllr Christian Martin &ndash; want to know why a report delivered by a cross-party working group into the design and implementation of the RPZ scheme has been in their opinion ignored.</p>\r\n<p style=\"font-family: \'palatino linotype\', palatino, serif; font-size: 14px; line-height: 21px;\"><a class=\"hide_desktop\" href=\"b247://articles?subchannel=4&amp;category=1&amp;article=10\" rel=\"nofollow\">A story should go here...</a><a class=\"hide_tablet hide_mobile\" href=\"http://www.bristol247.com/channel/arrest-made-in-walkabout-bar-rape-investigation\">A story should go here...</a></p>','BS4 3EN','51.44036832606594','-2.6378069269775324',NULL,NULL,1,1,0,NULL,NULL,NULL,'2014-08-11 09:23:39','2014-08-11 21:09:04','2014-08-11 10:02:27'),
	(386,52,6,'Kevin\'s listing','kevins_listing','Sub heading for Kevin\'s listing','<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque purus nunc, consectetur eu suscipit sagittis, tempus ac justo. Sed laoreet tortor id enim euismod lobortis. Vestibulum tristique dolor vel imperdiet imperdiet. Aenean iaculis, risus ut lacinia blandit, sapien ligula molestie dui, nec adipiscing nibh sem eget tortor. Duis commodo ipsum sollicitudin metus dignissim, id fringilla neque congue. Suspendisse nec mattis ante. Nulla elit risus, ullamcorper nec vehicula et, tincidunt vitae enim. Aliquam consectetur in massa non convallis. Sed varius ultricies justo in aliquet. Phasellus et quam a massa molestie pulvinar in sed sem. Aliquam ut volutpat purus, eget consequat massa. Aliquam eu dui pulvinar, consectetur est sed, mollis augue. Fusce eu erat mauris. Aliquam accumsan, nisl ac facilisis pharetra, ligula mauris cursus justo, nec tincidunt mauris ligula vel tortor. Fusce vitae euismod urna, non placerat nisi.</p>\r\n<p>Aenean nec elit eget lorem eleifend interdum et nec risus. Donec sit amet sollicitudin odio. Etiam sed eros at erat iaculis rhoncus id a nulla. Nullam hendrerit nec lectus in rutrum. Ut et congue odio, sed ornare purus. Aliquam erat volutpat. Vivamus dignissim turpis ut blandit dictum. Aliquam dapibus, nisi et bibendum luctus, sapien dolor pulvinar tortor, at sodales lectus erat eget nulla. Cras eget nisi auctor, pellentesque nibh vitae, cursus lorem. Pellentesque eget risus eu diam accumsan laoreet.</p>\r\n<p>&nbsp;</p>','<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque purus nunc, consectetur eu suscipit sagittis, tempus ac justo. Sed laoreet tortor id enim euismod lobortis. Vestibulum tristique dolor vel imperdiet imperdiet. Aenean iaculis, risus ut lacinia blandit, sapien ligula molestie dui, nec adipiscing nibh sem eget tortor. Duis commodo ipsum sollicitudin metus dignissim, id fringilla neque congue. Suspendisse nec mattis ante. Nulla elit risus, ullamcorper nec vehicula et, tincidunt vitae enim. Aliquam consectetur in massa non convallis. Sed varius ultricies justo in aliquet. Phasellus et quam a massa molestie pulvinar in sed sem. Aliquam ut volutpat purus, eget consequat massa. Aliquam eu dui pulvinar, consectetur est sed, mollis augue. Fusce eu erat mauris. Aliquam accumsan, nisl ac facilisis pharetra, ligula mauris cursus justo, nec tincidunt mauris ligula vel tortor. Fusce vitae euismod urna, non placerat nisi.</p>\r\n<p>Aenean nec elit eget lorem eleifend interdum et nec risus. Donec sit amet sollicitudin odio. Etiam sed eros at erat iaculis rhoncus id a nulla. Nullam hendrerit nec lectus in rutrum. Ut et congue odio, sed ornare purus. Aliquam erat volutpat. Vivamus dignissim turpis ut blandit dictum. Aliquam dapibus, nisi et bibendum luctus, sapien dolor pulvinar tortor, at sodales lectus erat eget nulla. Cras eget nisi auctor, pellentesque nibh vitae, cursus lorem. Pellentesque eget risus eu diam accumsan laoreet.</p>\r\n<p>&nbsp;</p>',NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,'0000-00-00 00:00:00','2014-08-12 12:11:56','2014-08-12 12:22:19');

/*!40000 ALTER TABLE `article` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table article_asset
# ------------------------------------------------------------

DROP TABLE IF EXISTS `article_asset`;

CREATE TABLE `article_asset` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `article_id` int(11) NOT NULL,
  `asset_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `img -> article_idx` (`article_id`),
  KEY `article -> img_idx` (`asset_id`),
  CONSTRAINT `img -> article` FOREIGN KEY (`article_id`) REFERENCES `article` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `article -> asset` FOREIGN KEY (`asset_id`) REFERENCES `asset` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `article_asset` WRITE;
/*!40000 ALTER TABLE `article_asset` DISABLE KEYS */;

INSERT INTO `article_asset` (`id`, `article_id`, `asset_id`)
VALUES
	(5,1,20),
	(6,1,21),
	(7,2,22),
	(8,2,23),
	(9,2,24),
	(11,2,26),
	(13,2,28),
	(14,2,29),
	(15,2,30),
	(16,2,31),
	(17,2,32),
	(18,2,33),
	(19,2,34),
	(20,2,35),
	(21,2,36),
	(22,2,37),
	(23,2,38),
	(24,1,39),
	(25,1,40),
	(26,1,41),
	(27,1,42),
	(28,1,43),
	(29,1,44),
	(30,1,45),
	(31,1,46),
	(32,1,47),
	(33,4,48),
	(34,4,49),
	(35,4,50),
	(36,4,51),
	(37,4,52),
	(38,4,53),
	(39,4,54),
	(40,4,55),
	(41,4,56),
	(42,4,57),
	(43,4,58),
	(44,5,59),
	(45,5,60),
	(46,5,61),
	(47,5,62),
	(48,5,63),
	(49,5,64),
	(50,5,65),
	(51,5,66),
	(52,5,67),
	(53,5,68),
	(54,5,69),
	(55,6,70),
	(56,6,71),
	(57,6,72),
	(58,6,73),
	(59,6,74),
	(60,6,75),
	(61,6,76),
	(62,6,77),
	(63,6,78),
	(64,6,79),
	(65,6,80),
	(66,7,81),
	(67,7,82),
	(68,7,83),
	(69,7,84),
	(70,7,85),
	(71,7,86),
	(72,7,87),
	(73,7,88),
	(74,7,89),
	(75,7,90),
	(76,7,91),
	(77,8,92),
	(78,8,93),
	(79,8,94),
	(80,8,95),
	(81,8,96),
	(82,8,97),
	(83,8,98),
	(84,8,99),
	(85,8,100),
	(86,8,101),
	(87,8,102),
	(88,9,103),
	(89,9,104),
	(90,9,105),
	(91,9,106),
	(92,9,107),
	(93,9,108),
	(94,9,109),
	(95,9,110),
	(96,9,111),
	(97,9,112),
	(98,9,113),
	(99,10,114),
	(100,10,115),
	(101,10,116),
	(103,10,118),
	(104,11,119),
	(105,11,120),
	(106,12,121),
	(107,12,122),
	(108,13,123),
	(109,14,124),
	(110,15,125),
	(111,15,126),
	(112,16,127),
	(113,16,128),
	(114,16,129),
	(115,17,130),
	(116,17,131),
	(117,19,132),
	(118,20,133),
	(119,21,134),
	(120,238,135),
	(121,198,136),
	(122,198,137),
	(123,198,138),
	(124,198,139),
	(125,198,140),
	(126,198,141),
	(127,146,142),
	(128,146,143),
	(129,146,144),
	(130,147,145),
	(131,194,146),
	(132,193,147),
	(133,192,148),
	(134,190,149),
	(135,191,150),
	(136,189,151),
	(137,188,152),
	(138,187,153),
	(139,185,154),
	(140,183,155),
	(141,182,156),
	(142,181,157),
	(143,180,158),
	(144,178,159),
	(145,177,160),
	(146,176,161),
	(147,175,162),
	(148,174,163),
	(149,173,164),
	(150,172,165),
	(151,171,166),
	(152,170,167),
	(153,168,168),
	(154,167,169),
	(155,145,170),
	(156,145,171),
	(157,154,172),
	(158,154,173),
	(159,165,174),
	(160,166,175),
	(161,238,176),
	(162,241,177),
	(163,241,178),
	(164,243,179),
	(165,243,180),
	(166,246,181),
	(167,246,182),
	(168,247,183),
	(169,247,184),
	(170,249,185),
	(171,249,186),
	(172,251,187),
	(173,251,188),
	(174,250,189),
	(175,250,190),
	(176,248,191),
	(177,248,192),
	(178,245,193),
	(179,245,194),
	(180,242,195),
	(181,242,196),
	(182,244,197),
	(183,244,198),
	(184,234,199),
	(185,234,200),
	(186,232,201),
	(187,232,202),
	(188,231,203),
	(189,231,204),
	(190,237,205),
	(191,237,206),
	(192,239,207),
	(193,239,208),
	(194,236,209),
	(195,236,210),
	(196,240,211),
	(197,240,212),
	(198,233,213),
	(199,233,214),
	(200,226,215),
	(201,226,216),
	(202,222,217),
	(203,222,218),
	(204,221,219),
	(205,221,220),
	(206,220,221),
	(207,220,222),
	(208,219,223),
	(209,219,224),
	(210,217,225),
	(211,217,226),
	(212,216,227),
	(213,216,228),
	(214,214,229),
	(215,214,230),
	(216,213,231),
	(217,213,232),
	(218,212,233),
	(219,212,234),
	(220,211,235),
	(221,211,236),
	(222,210,237),
	(223,210,238),
	(224,209,239),
	(225,208,240),
	(226,208,241),
	(227,202,242),
	(228,202,243),
	(229,336,244),
	(230,336,245),
	(231,335,246),
	(232,335,247),
	(233,334,248),
	(234,334,249),
	(235,332,250),
	(236,332,251),
	(237,169,252),
	(238,184,253),
	(239,186,254),
	(240,179,255),
	(241,195,256),
	(242,196,257),
	(243,197,258),
	(244,164,259),
	(245,333,260),
	(246,331,261),
	(247,330,262),
	(248,329,263),
	(249,328,264),
	(250,327,265),
	(251,326,266),
	(252,325,267),
	(253,324,268),
	(254,323,269),
	(255,322,270),
	(256,321,271),
	(257,320,272),
	(258,319,273),
	(259,373,342),
	(260,375,343),
	(261,375,344),
	(262,375,345),
	(263,375,346),
	(264,375,347),
	(265,375,348),
	(266,375,349),
	(267,375,350),
	(268,379,351),
	(269,379,352),
	(270,379,353),
	(271,380,354),
	(272,380,355),
	(273,380,356),
	(274,380,357),
	(275,380,358),
	(276,381,359),
	(277,381,360),
	(278,381,361),
	(279,381,362),
	(280,381,363),
	(281,381,364),
	(282,381,365),
	(283,382,366),
	(284,385,367),
	(285,385,368),
	(286,386,369),
	(287,386,370),
	(288,386,371),
	(289,386,372),
	(290,386,373);

/*!40000 ALTER TABLE `article_asset` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table article_author
# ------------------------------------------------------------

DROP TABLE IF EXISTS `article_author`;

CREATE TABLE `article_author` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `author_id` int(11) DEFAULT NULL,
  `article_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  KEY `article_id -> article` (`article_id`),
  KEY `author_id` (`author_id`),
  CONSTRAINT `article_id -> article id` FOREIGN KEY (`article_id`) REFERENCES `article` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `author_id -> author id` FOREIGN KEY (`author_id`) REFERENCES `authors` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `article_author` WRITE;
/*!40000 ALTER TABLE `article_author` DISABLE KEYS */;

INSERT INTO `article_author` (`id`, `author_id`, `article_id`)
VALUES
	(1,2,1),
	(2,2,2),
	(3,2,4),
	(4,2,5),
	(5,2,6),
	(6,2,7),
	(7,2,8),
	(8,2,9),
	(9,2,10),
	(10,2,11),
	(11,2,12),
	(12,2,13),
	(13,2,14),
	(14,2,15),
	(15,2,16),
	(16,2,17),
	(17,2,18),
	(18,2,19),
	(19,2,20),
	(20,2,21),
	(21,2,145),
	(22,2,146),
	(23,2,147),
	(24,2,148),
	(25,2,149),
	(26,2,150),
	(27,2,151),
	(28,2,152),
	(29,2,153),
	(30,2,154),
	(31,2,155),
	(32,2,156),
	(33,2,157),
	(34,2,158),
	(35,2,159),
	(36,2,160),
	(37,2,161),
	(38,2,162),
	(39,2,163),
	(40,2,164),
	(41,2,165),
	(42,2,166),
	(43,2,167),
	(44,2,168),
	(45,2,169),
	(46,2,170),
	(47,2,171),
	(48,2,172),
	(49,2,173),
	(50,2,174),
	(51,2,175),
	(52,2,176),
	(53,2,177),
	(54,2,178),
	(55,2,179),
	(56,2,180),
	(57,2,181),
	(58,2,182),
	(59,2,183),
	(60,2,184),
	(61,2,185),
	(62,2,186),
	(63,2,187),
	(64,2,188),
	(65,2,189),
	(66,2,190),
	(67,2,191),
	(68,2,192),
	(69,2,193),
	(70,2,194),
	(71,2,195),
	(72,2,196),
	(73,2,197),
	(74,2,198),
	(75,2,202),
	(76,2,207),
	(77,2,208),
	(78,2,209),
	(79,2,210),
	(80,2,211),
	(81,2,212),
	(82,2,213),
	(83,2,214),
	(84,2,216),
	(85,2,217),
	(86,2,219),
	(87,2,220),
	(88,2,221),
	(89,2,222),
	(90,2,226),
	(91,2,231),
	(92,2,232),
	(93,2,233),
	(94,2,234),
	(95,2,236),
	(96,2,237),
	(97,2,238),
	(98,2,239),
	(99,2,240),
	(100,2,241),
	(101,2,242),
	(102,2,243),
	(103,2,244),
	(104,2,245),
	(105,2,246),
	(106,2,247),
	(107,2,248),
	(108,2,249),
	(109,2,250),
	(110,2,251),
	(111,2,318),
	(112,2,319),
	(113,2,320),
	(114,2,321),
	(115,2,322),
	(116,2,323),
	(117,2,324),
	(118,2,325),
	(119,2,326),
	(120,2,327),
	(121,2,328),
	(122,2,329),
	(123,2,330),
	(124,2,331),
	(125,2,332),
	(126,2,333),
	(127,2,334),
	(128,2,335),
	(129,2,336),
	(168,2,373),
	(170,6,375),
	(173,6,378),
	(174,6,379),
	(175,6,380),
	(176,6,381),
	(177,2,382),
	(178,6,383),
	(179,6,384),
	(180,6,385),
	(181,6,386);

/*!40000 ALTER TABLE `article_author` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table article_competition
# ------------------------------------------------------------

DROP TABLE IF EXISTS `article_competition`;

CREATE TABLE `article_competition` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `article_id` int(11) DEFAULT NULL,
  `competition_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table article_location
# ------------------------------------------------------------

DROP TABLE IF EXISTS `article_location`;

CREATE TABLE `article_location` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `article_id` int(11) NOT NULL,
  `channel_id` int(11) NOT NULL,
  `sub_channel_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `article -> cat_idx` (`article_id`),
  KEY `article_cat -> cat_idx` (`category_id`),
  KEY `article_sub -> channel_idx` (`sub_channel_id`),
  KEY `article_chan ->channel_idx` (`channel_id`),
  CONSTRAINT `article -> cat` FOREIGN KEY (`article_id`) REFERENCES `article` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `article_cat -> cat` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `article_sub -> channel` FOREIGN KEY (`sub_channel_id`) REFERENCES `channel` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `article_chan ->channel` FOREIGN KEY (`channel_id`) REFERENCES `channel` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `article_location` WRITE;
/*!40000 ALTER TABLE `article_location` DISABLE KEYS */;

INSERT INTO `article_location` (`id`, `article_id`, `channel_id`, `sub_channel_id`, `category_id`)
VALUES
	(1,1,1,4,1),
	(2,2,1,4,1),
	(3,4,1,4,1),
	(4,5,1,4,1),
	(5,6,1,4,1),
	(6,7,1,4,1),
	(7,8,1,4,1),
	(8,9,1,4,1),
	(9,10,1,4,1),
	(10,11,1,4,1),
	(11,12,1,4,1),
	(12,13,1,4,1),
	(13,14,1,4,1),
	(14,15,1,4,1),
	(15,16,1,4,1),
	(16,17,1,4,1),
	(17,18,1,4,1),
	(18,19,1,4,1),
	(19,20,1,4,1),
	(20,21,1,4,1),
	(21,145,1,4,2),
	(22,146,1,4,2),
	(23,147,1,4,2),
	(24,148,1,4,2),
	(25,149,1,4,2),
	(26,150,1,4,2),
	(27,151,1,4,2),
	(28,152,1,4,2),
	(29,153,1,4,2),
	(30,154,1,4,2),
	(31,155,1,4,2),
	(32,156,1,4,2),
	(33,157,1,4,2),
	(34,158,1,4,2),
	(35,159,1,4,2),
	(36,160,1,4,2),
	(37,161,1,4,2),
	(38,162,1,4,2),
	(39,163,1,4,2),
	(40,164,1,4,2),
	(41,165,1,5,4),
	(42,166,1,5,4),
	(43,167,1,5,4),
	(44,168,1,5,4),
	(45,169,1,5,4),
	(46,170,1,5,4),
	(47,171,1,5,4),
	(48,172,1,5,4),
	(49,173,1,5,4),
	(50,174,1,5,4),
	(51,175,1,5,4),
	(52,176,1,5,4),
	(53,177,1,5,4),
	(54,178,1,5,4),
	(55,179,1,5,4),
	(56,180,1,5,4),
	(57,181,1,5,4),
	(58,182,1,5,4),
	(59,183,1,5,4),
	(60,184,1,5,4),
	(61,185,1,5,3),
	(62,186,1,5,3),
	(63,187,1,5,3),
	(64,188,1,5,3),
	(65,189,1,5,3),
	(66,190,1,5,3),
	(67,191,1,5,3),
	(68,192,1,5,3),
	(69,193,1,5,3),
	(70,194,1,5,3),
	(71,195,1,5,3),
	(72,196,1,5,3),
	(73,197,1,5,3),
	(74,198,1,5,3),
	(75,231,2,6,5),
	(76,232,2,6,5),
	(77,233,2,6,5),
	(78,234,2,6,5),
	(79,236,2,6,5),
	(80,237,2,6,5),
	(81,238,2,6,5),
	(82,239,2,6,5),
	(83,240,2,6,5),
	(84,241,2,6,5),
	(85,242,2,6,5),
	(86,243,2,6,5),
	(87,244,2,6,5),
	(88,245,2,6,5),
	(89,246,2,6,5),
	(90,247,2,6,5),
	(91,248,2,6,5),
	(92,249,2,6,5),
	(93,250,2,6,5),
	(94,251,2,6,5),
	(95,318,3,8,7),
	(96,319,3,8,7),
	(97,320,3,8,7),
	(98,321,3,8,7),
	(99,322,3,8,7),
	(100,323,3,8,7),
	(101,324,3,8,7),
	(102,325,3,8,7),
	(103,326,3,8,7),
	(104,327,3,8,7),
	(105,328,3,8,7),
	(106,329,3,8,7),
	(107,330,3,8,7),
	(108,331,3,8,7),
	(109,332,3,8,7),
	(110,333,3,8,7),
	(111,334,3,8,7),
	(112,335,3,8,7),
	(113,336,3,8,7),
	(114,202,3,7,6),
	(115,208,3,7,6),
	(116,209,3,7,6),
	(117,210,3,7,6),
	(118,211,3,7,6),
	(119,212,3,7,6),
	(120,213,3,7,6),
	(121,214,3,7,6),
	(122,216,3,7,6),
	(123,217,3,7,6),
	(125,219,3,7,6),
	(126,220,3,7,6),
	(127,221,3,7,6),
	(128,222,3,7,6),
	(129,226,3,7,6),
	(130,373,2,6,5),
	(131,375,1,4,2),
	(132,378,1,5,4),
	(133,380,2,6,5),
	(134,381,3,7,6),
	(135,382,2,6,5),
	(136,385,1,4,2),
	(137,386,2,6,5);

/*!40000 ALTER TABLE `article_location` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table article_promotion
# ------------------------------------------------------------

DROP TABLE IF EXISTS `article_promotion`;

CREATE TABLE `article_promotion` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `article_id` int(11) DEFAULT NULL,
  `promotion_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table article_related
# ------------------------------------------------------------

DROP TABLE IF EXISTS `article_related`;

CREATE TABLE `article_related` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `article_id` int(11) NOT NULL,
  `related_article` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  KEY `article_id -> article` (`article_id`),
  KEY `related_id -> article` (`related_article`),
  CONSTRAINT `article_id -> article_id` FOREIGN KEY (`article_id`) REFERENCES `article` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `related_id -> article_id` FOREIGN KEY (`related_article`) REFERENCES `article` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table article_venue
# ------------------------------------------------------------

DROP TABLE IF EXISTS `article_venue`;

CREATE TABLE `article_venue` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `article_id` int(11) NOT NULL,
  `venue_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `article_id -> article` (`article_id`),
  KEY `venue_id -> venue` (`venue_id`),
  CONSTRAINT `venue - id` FOREIGN KEY (`venue_id`) REFERENCES `venue` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `article -> id` FOREIGN KEY (`article_id`) REFERENCES `article` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table article_video
# ------------------------------------------------------------

DROP TABLE IF EXISTS `article_video`;

CREATE TABLE `article_video` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `article_id` int(11) NOT NULL,
  `video_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  KEY `video -> article_id` (`article_id`),
  KEY `video -> video_asset` (`video_id`),
  CONSTRAINT `article_video->article_id` FOREIGN KEY (`article_id`) REFERENCES `article` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `article_video` WRITE;
/*!40000 ALTER TABLE `article_video` DISABLE KEYS */;

INSERT INTO `article_video` (`id`, `article_id`, `video_id`)
VALUES
	(30,198,65),
	(31,197,39),
	(32,196,40),
	(33,195,41),
	(34,196,42),
	(35,194,43),
	(36,193,44),
	(37,192,45),
	(38,191,46),
	(39,190,47),
	(40,189,48),
	(41,188,47),
	(42,186,48),
	(43,185,49),
	(44,185,49),
	(45,184,50),
	(46,183,51),
	(47,182,52),
	(48,187,55),
	(49,181,55),
	(50,180,56),
	(51,179,66),
	(52,178,67),
	(53,172,68),
	(54,9,69),
	(55,375,70),
	(56,382,71),
	(57,10,72),
	(58,385,73);

/*!40000 ALTER TABLE `article_video` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table asset
# ------------------------------------------------------------

DROP TABLE IF EXISTS `asset`;

CREATE TABLE `asset` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `filepath` varchar(150) NOT NULL,
  `alt` varchar(100) DEFAULT NULL,
  `title` varchar(150) DEFAULT NULL,
  `width` int(11) DEFAULT NULL,
  `height` int(11) DEFAULT NULL,
  `filesize` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `image_type` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `asset -> image_type` (`image_type`),
  CONSTRAINT `image_type -> type` FOREIGN KEY (`image_type`) REFERENCES `image_type` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `asset` WRITE;
/*!40000 ALTER TABLE `asset` DISABLE KEYS */;

INSERT INTO `asset` (`id`, `filepath`, `alt`, `title`, `width`, `height`, `filesize`, `created_at`, `updated_at`, `image_type`)
VALUES
	(20,'abstract-q-c-800-450-9-1406732805.jpg','alt','title',800,450,16883,'0000-00-00 00:00:00','0000-00-00 00:00:00',1),
	(21,'test2-1406725587.jpg','2','2',800,450,12873,'0000-00-00 00:00:00',NULL,2),
	(22,'1-4x6kx8gru7dpviih57wvpa-1406732005.jpeg','alt','title',800,450,91485,'0000-00-00 00:00:00',NULL,1),
	(23,'6n-news-800x450-1406732044.jpg','alt','title',800,450,65286,'0000-00-00 00:00:00',NULL,2),
	(24,'681-itok=87ndoi1d-1406732089.jpg','alt','title',800,450,120372,'0000-00-00 00:00:00',NULL,2),
	(26,'800px-random-madness-1366x768-1406732119.jpg','alt','title',800,450,49922,'0000-00-00 00:00:00',NULL,2),
	(28,'2284-itok=aqw0bu7b-1406732224.jpg','image','title',800,450,29722,'0000-00-00 00:00:00',NULL,2),
	(29,'00303606-1406732288.jpg','alt','title',800,450,118428,'0000-00-00 00:00:00',NULL,2),
	(30,'10321536_284326148414240_2862092212177505151_o-df5baeead79156644d33ad5c7190b01c-1406732306.jpg','alt','title',800,450,348292,'0000-00-00 00:00:00',NULL,2),
	(31,'20140716180202-1916624-b-1406732322.jpg','alt','title',800,450,36369,'0000-00-00 00:00:00',NULL,2),
	(32,'abstract-q-c-800-450-1-1406732349.jpg','alt','title',800,450,62522,'0000-00-00 00:00:00',NULL,2),
	(33,'abstract-q-c-800-450-2-1406732371.jpg','alt','title',800,450,13091,'0000-00-00 00:00:00',NULL,3),
	(34,'abstract-q-c-800-450-3-1406732416.jpg','alt','title',800,450,48445,'0000-00-00 00:00:00',NULL,3),
	(35,'abstract-q-c-800-450-4-1406732485.jpg','alt','title',800,450,36828,'0000-00-00 00:00:00',NULL,3),
	(36,'abstract-q-c-800-450-5-1406732505.jpg','alt','title',800,450,77897,'0000-00-00 00:00:00',NULL,3),
	(37,'abstract-q-c-800-450-6-1406732517.jpg','alt','title',800,450,27363,'0000-00-00 00:00:00',NULL,3),
	(38,'abstract-q-c-800-450-7-1406732570.jpg','alt','title',800,450,43750,'0000-00-00 00:00:00',NULL,3),
	(39,'abstract-q-c-800-450-10-1406732823.jpg','alt','title',800,450,75243,'0000-00-00 00:00:00',NULL,2),
	(40,'abu-dhabi-web-1406732840.jpg','alt','title',800,450,146916,'0000-00-00 00:00:00',NULL,2),
	(41,'after-earth-51463d71e847f-1406732855.jpg','alt','title',800,450,122342,'0000-00-00 00:00:00',NULL,2),
	(42,'animals-q-c-800-450-1-1406732877.jpg','alt','title',800,450,44576,'0000-00-00 00:00:00',NULL,2),
	(43,'animals-q-c-800-450-2-1406732905.jpg','alt','title',800,450,82223,'0000-00-00 00:00:00',NULL,3),
	(44,'animals-q-c-800-450-3-1406732920.jpg','alt','title',800,450,56828,'0000-00-00 00:00:00',NULL,3),
	(45,'animals-q-c-800-450-4-1406732936.jpg','alt','title',800,450,65847,'0000-00-00 00:00:00',NULL,3),
	(46,'animals-q-c-800-450-5-1406732950.jpg','alt','title',800,450,67792,'0000-00-00 00:00:00',NULL,3),
	(47,'animals-q-c-800-450-6-1406732972.jpg','alt','title',800,450,71052,'0000-00-00 00:00:00',NULL,3),
	(48,'animals-q-c-800-450-7-1406733118.jpg','alt','title',800,450,48511,'0000-00-00 00:00:00',NULL,1),
	(49,'animals-q-c-800-450-9-1406733134.jpg','alt','title',800,450,73359,'0000-00-00 00:00:00',NULL,2),
	(50,'animals-q-c-800-450-10-1406733146.jpg','alt','title',800,450,39113,'0000-00-00 00:00:00',NULL,2),
	(51,'archive_4png-1406733161.png','alt','title',800,450,450413,'0000-00-00 00:00:00',NULL,2),
	(52,'au1145201-1406733173.jpg','alt','title',800,450,112208,'0000-00-00 00:00:00',NULL,2),
	(53,'banksy-studio-interview-wide-1406733187.jpg','alt','title',800,450,228816,'0000-00-00 00:00:00',NULL,2),
	(54,'barna_crop_0-1406733198.jpg','alt','title',800,450,84014,'0000-00-00 00:00:00',NULL,3),
	(55,'block10-(1)-1406733223.jpg','alt','title',800,450,73845,'0000-00-00 00:00:00',NULL,3),
	(56,'block10-(2)-1406733241.jpg','alt','title',800,450,41887,'0000-00-00 00:00:00',NULL,3),
	(57,'block10-1406733252.jpg','alt','title',800,450,48345,'0000-00-00 00:00:00',NULL,3),
	(58,'bony_706-1406733299.jpg','alt','title',800,450,52662,'0000-00-00 00:00:00',NULL,3),
	(59,'business-q-c-800-450-1-1406733498.jpg','alt','title',800,450,27051,'0000-00-00 00:00:00',NULL,1),
	(60,'business-q-c-800-450-2-1406733513.jpg','alt','title',800,450,30844,'0000-00-00 00:00:00',NULL,2),
	(61,'business-q-c-800-450-3-1406733534.jpg','alt','title',800,450,45866,'0000-00-00 00:00:00',NULL,2),
	(62,'business-q-c-800-450-4-1406733553.jpg','alt','title',800,450,36866,'0000-00-00 00:00:00',NULL,2),
	(63,'business-q-c-800-450-5-1406733571.jpg','alt','title',800,450,57049,'0000-00-00 00:00:00',NULL,2),
	(64,'business-q-c-800-450-6-1406733595.jpg','alt','title',800,450,52010,'0000-00-00 00:00:00',NULL,2),
	(65,'business-q-c-800-450-7-1406733609.jpg','alt','title',800,450,20274,'0000-00-00 00:00:00',NULL,3),
	(66,'business-q-c-800-450-8-1406733663.jpg','alt','title',800,450,50204,'0000-00-00 00:00:00',NULL,3),
	(67,'business-q-c-800-450-9-1406733701.jpg','alt','title',800,450,20777,'0000-00-00 00:00:00',NULL,3),
	(68,'business-q-c-800-450-10-1406733713.jpg','alt','title',800,450,31637,'0000-00-00 00:00:00',NULL,3),
	(69,'byqsfr-watch-prairie-dogs-do-the-wave-fkqy-1406733744.jpeg','alt','title',800,450,249910,'0000-00-00 00:00:00',NULL,3),
	(70,'cc-1407370439.jpg','','',800,450,182550,'0000-00-00 00:00:00','0000-00-00 00:00:00',1),
	(71,'cats-q-c-800-450-2-1406733884.jpg','alt','title',800,450,43214,'0000-00-00 00:00:00',NULL,2),
	(72,'cats-q-c-800-450-4-1406733897.jpg','alt','title',800,450,32303,'0000-00-00 00:00:00',NULL,2),
	(73,'cats-q-c-800-450-5-1406733919.jpg','alt','title',800,450,19104,'0000-00-00 00:00:00',NULL,2),
	(74,'cats-q-c-800-450-6-1406733974.jpg','alt','title',800,450,38281,'0000-00-00 00:00:00',NULL,2),
	(75,'cats-q-c-800-450-7-1406733989.jpg','alt','title',800,450,44288,'0000-00-00 00:00:00',NULL,2),
	(76,'cats-q-c-800-450-8-1406734041.jpg','alt','title',800,450,31771,'0000-00-00 00:00:00',NULL,3),
	(77,'cats-q-c-800-450-9-1406734162.jpg','alt','title',800,450,44211,'0000-00-00 00:00:00',NULL,3),
	(78,'cats-q-c-800-450-10-1406734176.jpg','alt','title',800,450,33848,'0000-00-00 00:00:00',NULL,3),
	(79,'citylive-carousel-image-1406734190.jpg','alt','title',800,450,122155,'0000-00-00 00:00:00',NULL,3),
	(80,'cityofmanchesterstadium_reception_front-1406734497.jpg','alt','title',800,450,394990,'0000-00-00 00:00:00',NULL,3),
	(81,'city-q-c-800-450-1-1406734840.jpg','alt','title',800,450,38259,'0000-00-00 00:00:00',NULL,1),
	(82,'city-q-c-800-450-2-1406734858.jpg','alt','title',800,450,37311,'0000-00-00 00:00:00',NULL,2),
	(83,'city-q-c-800-450-3-1406734905.jpg','alt','title',800,450,59785,'0000-00-00 00:00:00',NULL,2),
	(84,'city-q-c-800-450-4-1406734921.jpg','alt','title',800,450,37537,'0000-00-00 00:00:00',NULL,2),
	(85,'city-q-c-800-450-6-1406734939.jpg','alt','title',800,450,33554,'0000-00-00 00:00:00',NULL,2),
	(86,'city-q-c-800-450-7-1406735060.jpg','alt','title',800,450,34733,'0000-00-00 00:00:00',NULL,2),
	(87,'city-q-c-800-450-8-1406735073.jpg','alt','title',800,450,74510,'0000-00-00 00:00:00',NULL,3),
	(88,'city-q-c-800-450-9-1406735083.jpg','alt','title',800,450,49584,'0000-00-00 00:00:00',NULL,3),
	(89,'city-q-c-800-450-10-1406735100.jpg','alt','title',800,450,63493,'0000-00-00 00:00:00',NULL,3),
	(90,'cityscapes-city-woot-city-skyline-1920x1080-wallpaper_www.wallmay.com_47-1406735124.jpg','alt','title',800,450,298821,'0000-00-00 00:00:00',NULL,3),
	(91,'cityscapes-mirrors-edge-city-skyline_www.wallpaperfly.com_59-1406735141.jpg','alt','title',800,450,342674,'0000-00-00 00:00:00',NULL,3),
	(92,'cityscapes-night-traffic-city-lights-tiltshift-street-2560x1440-wallpaper_www.wallmay.com_13-1406735281.jpg','','',800,450,230212,'0000-00-00 00:00:00',NULL,1),
	(93,'comshield_2-1406735297.jpg','alt','title',800,450,321589,'0000-00-00 00:00:00',NULL,2),
	(94,'daftside-800x450-1406735313.jpg','alt','title',800,450,15105,'0000-00-00 00:00:00',NULL,2),
	(95,'download-(1)-1406735326.jpg','alt','title',800,450,47488,'0000-00-00 00:00:00',NULL,2),
	(96,'download-1406735339.jpg','alt','title',800,450,39308,'0000-00-00 00:00:00',NULL,2),
	(97,'dsc_7232-lowres-1406735357.jpg','alt','title',800,450,71367,'0000-00-00 00:00:00',NULL,2),
	(98,'eko-atlantic-city-project-2012-pdp-1406735373.jpg','alt','title',800,450,262729,'0000-00-00 00:00:00',NULL,3),
	(99,'fashion-q-c-800-450-1-1406735389.jpg','alt','title',800,450,63543,'0000-00-00 00:00:00',NULL,3),
	(100,'fashion-q-c-800-450-3-1406735410.jpg','alt','title',800,450,38345,'0000-00-00 00:00:00',NULL,3),
	(101,'fashion-q-c-800-450-4-1406735426.jpg','alt','title',800,450,39373,'0000-00-00 00:00:00',NULL,3),
	(102,'fashion-q-c-800-450-5-1406735458.jpg','alt','title',800,450,42711,'0000-00-00 00:00:00',NULL,3),
	(103,'fashion-q-c-800-450-6-1406735614.jpg','alt','title',800,450,44913,'0000-00-00 00:00:00',NULL,1),
	(104,'fashion-q-c-800-450-7-1406735629.jpg','alt','title',800,450,56206,'0000-00-00 00:00:00',NULL,2),
	(105,'fashion-q-c-800-450-8-1406735642.jpg','alt','title',800,450,42640,'0000-00-00 00:00:00',NULL,2),
	(106,'fashion-q-c-800-450-9-1406735675.jpg','alt','title',800,450,56484,'0000-00-00 00:00:00',NULL,2),
	(107,'fashion-q-c-800-450-10-1406735695.jpg','alt','title',800,450,42133,'0000-00-00 00:00:00',NULL,2),
	(108,'food-q-c-800-450-1-1406735712.jpg','alt','title',800,450,53647,'0000-00-00 00:00:00',NULL,2),
	(109,'food-q-c-800-450-2-1406735726.jpg','alt','title',800,450,41881,'0000-00-00 00:00:00',NULL,3),
	(110,'food-q-c-800-450-3-1406735742.jpg','alt','title',800,450,42179,'0000-00-00 00:00:00',NULL,3),
	(111,'food-q-c-800-450-4-1406735754.jpg','alt','title',800,450,35032,'0000-00-00 00:00:00',NULL,3),
	(112,'food-q-c-800-450-5-1406735770.jpg','alt','title',800,450,40086,'0000-00-00 00:00:00',NULL,3),
	(113,'food-q-c-800-450-6-1406735788.jpg','alt','title',800,450,56426,'0000-00-00 00:00:00',NULL,3),
	(114,'','test 2','test 2',800,450,0,'0000-00-00 00:00:00','0000-00-00 00:00:00',1),
	(115,'food-q-c-800-450-8-1406735969.jpg','alt','title',800,450,31923,'0000-00-00 00:00:00',NULL,2),
	(116,'food-q-c-800-450-9-1406736298.jpg','alt','title',800,450,32227,'0000-00-00 00:00:00',NULL,2),
	(118,'football_news-arsene-wenger-arsenal-1406736728.jpg','alt','title',800,450,117046,'0000-00-00 00:00:00',NULL,2),
	(119,'garylive2ass-1406737019.png','alt','title',800,450,531733,'0000-00-00 00:00:00',NULL,1),
	(120,'golf-news--carlota-ciganda-1406737043.jpg','alt','title',800,450,103078,'0000-00-00 00:00:00',NULL,2),
	(121,'grid_2__koenigsegg_agera_r_by_ultam1t3rac3r-d633b4o-1406737155.png','alt','title',800,450,283307,'0000-00-00 00:00:00',NULL,1),
	(122,'hurricane-news-1406737173.jpg','alt','title',800,450,280831,'0000-00-00 00:00:00',NULL,2),
	(123,'au1145201-1406737303.jpg','alt','title',800,450,112208,'0000-00-00 00:00:00',NULL,1),
	(124,'','alt','title',800,450,6803,'0000-00-00 00:00:00',NULL,1),
	(125,'iohsunset11-24-13-1406737586.jpg','alt','title',800,450,185215,'0000-00-00 00:00:00',NULL,1),
	(126,'technics-q-c-800-450-1-1406737606.jpg','alt','title',800,450,27034,'0000-00-00 00:00:00',NULL,2),
	(127,'landscapes-cityscapes-bridges-towns-city-skyline-rainbow-bridge_www.wallmay.net_80-1406737699.jpg','alt','title',800,450,251643,'0000-00-00 00:00:00',NULL,1),
	(128,'latest_news_large-1406737715.jpg','alt','title',800,450,39757,'0000-00-00 00:00:00',NULL,2),
	(129,'maximemermoz800sb_rdax_60-1406737730.jpg','alt','title',800,450,35383,'0000-00-00 00:00:00',NULL,2),
	(130,'nacho-monreal-of-arsenal-1406737810.jpg','alt','title',800,450,375337,'0000-00-00 00:00:00',NULL,1),
	(131,'nature-q-c-800-450-1-1406737821.jpg','alt','titlre',800,450,33914,'0000-00-00 00:00:00',NULL,2),
	(132,'news_image.3077063-1406738051.jpg','alt','title',800,450,129055,'0000-00-00 00:00:00',NULL,1),
	(133,'nature-q-c-800-450-2-1406738125.jpg','alt','title',800,450,49996,'0000-00-00 00:00:00',NULL,1),
	(134,'news-from-nowhere-03-1406738208.jpg','alt','title',800,450,73767,'0000-00-00 00:00:00',NULL,1),
	(135,'1-4x6kx8gru7dpviih57wvpa-1406797365.jpeg','','',800,450,91485,'0000-00-00 00:00:00','0000-00-00 00:00:00',1),
	(136,'nature-q-c-800-450-1-1406794346.jpg','','',800,450,33914,'0000-00-00 00:00:00',NULL,1),
	(137,'abstract-q-c-800-450-10-1406794359.jpg','','',800,450,75243,'0000-00-00 00:00:00',NULL,2),
	(138,'night-rchitecture-buildings-new-yorkcity-1406794370.jpg','','',800,450,365863,'0000-00-00 00:00:00',NULL,2),
	(139,'food-q-c-800-450-7-1406794383.jpg','','',800,450,42694,'0000-00-00 00:00:00',NULL,2),
	(140,'img-20140517-wa0004-1406794406.jpg','','',800,450,71030,'0000-00-00 00:00:00',NULL,3),
	(141,'fashion-q-c-800-450-8-1406794417.jpg','','',800,450,42640,'0000-00-00 00:00:00',NULL,3),
	(142,'block10-1406794488.jpg','','',800,450,48345,'0000-00-00 00:00:00',NULL,1),
	(143,'abu-dhabi-web-1406794504.jpg','','',800,450,146916,'0000-00-00 00:00:00',NULL,2),
	(144,'transport-q-c-800-450-7-1406794527.jpg','','',800,450,62658,'0000-00-00 00:00:00',NULL,2),
	(145,'business-q-c-800-450-2-1406794552.jpg','','',800,450,30844,'0000-00-00 00:00:00',NULL,1),
	(146,'richemond_news_019-1406794576.jpg','','',800,450,150265,'0000-00-00 00:00:00',NULL,1),
	(147,'news-from-nowhere-04-1406794605.jpg','','',800,450,140116,'0000-00-00 00:00:00',NULL,1),
	(148,'barna_crop_0-1406794626.jpg','','',800,450,84014,'0000-00-00 00:00:00',NULL,1),
	(149,'animals-q-c-800-450-1-1406794951.jpg','','',800,450,44576,'0000-00-00 00:00:00','0000-00-00 00:00:00',1),
	(150,'fashion-q-c-800-450-6-1406794866.jpg','','',800,450,44913,'0000-00-00 00:00:00',NULL,1),
	(151,'citylive-carousel-image-1406794981.jpg','','',800,450,122155,'0000-00-00 00:00:00',NULL,1),
	(152,'city-q-c-800-450-4-1406795012.jpg','','',800,450,37537,'0000-00-00 00:00:00',NULL,1),
	(153,'news-from-nowhere-03-1406795047.jpg','','',800,450,73767,'0000-00-00 00:00:00',NULL,1),
	(154,'city-q-c-800-450-6-1406795073.jpg','','',800,450,33554,'0000-00-00 00:00:00',NULL,1),
	(155,'people-q-c-800-450-1-1406795191.jpg','','',800,450,31127,'0000-00-00 00:00:00','0000-00-00 00:00:00',1),
	(156,'people-q-c-800-450-4-1406795273.jpg','','',800,450,54953,'0000-00-00 00:00:00',NULL,1),
	(157,'fashion-q-c-800-450-5-1406795336.jpg','','',800,450,42711,'0000-00-00 00:00:00','0000-00-00 00:00:00',1),
	(158,'harvest-city-haiti-9-1406795364.png','','',800,450,704198,'0000-00-00 00:00:00',NULL,1),
	(159,'what-not-to-wear-to-work1-1406795396.jpg','','',800,450,141153,'0000-00-00 00:00:00',NULL,1),
	(160,'vlcsnap-2011-06-26-15h51m01s103-1406795423.png','','',800,450,646132,'0000-00-00 00:00:00',NULL,1),
	(161,'nightlife-q-c-800-450-10-1406795484.jpg','','',800,450,38919,'0000-00-00 00:00:00',NULL,1),
	(162,'unnamed13-1406795514.jpg','','',800,450,116111,'0000-00-00 00:00:00',NULL,1),
	(163,'transport-q-c-800-450-8-1406795599.jpg','','',800,450,39413,'0000-00-00 00:00:00','0000-00-00 00:00:00',1),
	(164,'transport-q-c-800-450-7-1406795653.jpg','','',800,450,62658,'0000-00-00 00:00:00',NULL,1),
	(165,'transport-q-c-800-450-3-1406795705.jpg','','',800,450,54178,'0000-00-00 00:00:00','0000-00-00 00:00:00',1),
	(166,'transport-q-c-800-450-2-1406795733.jpg','','',800,450,36470,'0000-00-00 00:00:00',NULL,1),
	(167,'transport-q-c-800-450-1-1406795758.jpg','','',800,450,37716,'0000-00-00 00:00:00',NULL,1),
	(168,'technics-q-c-800-450-10-1406795782.jpg','','',800,450,37412,'0000-00-00 00:00:00',NULL,1),
	(169,'p1230557-version-2-1406797316.jpg','','',800,450,204154,'0000-00-00 00:00:00','0000-00-00 00:00:00',1),
	(170,'technics-q-c-800-450-9-1406797106.jpg','','',800,450,39463,'0000-00-00 00:00:00',NULL,1),
	(171,'technics-q-c-800-450-8-1406797117.jpg','','',800,450,35313,'0000-00-00 00:00:00',NULL,2),
	(172,'bony_706-1406797184.jpg','','',800,450,52662,'0000-00-00 00:00:00',NULL,1),
	(173,'animals-q-c-800-450-2-1406797193.jpg','','',800,450,82223,'0000-00-00 00:00:00',NULL,2),
	(174,'people-q-c-800-450-9-1406797268.jpg','','',800,450,42688,'0000-00-00 00:00:00',NULL,1),
	(175,'cats-q-c-800-450-10-1406797289.jpg','','',800,450,33848,'0000-00-00 00:00:00',NULL,1),
	(176,'6n-news-800x450-1406797376.jpg','','',800,450,65286,'0000-00-00 00:00:00',NULL,2),
	(177,'681-itok=87ndoi1d-1406797396.jpg','','',800,450,120372,'0000-00-00 00:00:00',NULL,1),
	(178,'800px-random-madness-1366x768-1406797408.jpg','','',800,450,49922,'0000-00-00 00:00:00',NULL,2),
	(179,'2284-itok=aqw0bu7b-1406797591.jpg','','',800,450,29722,'0000-00-00 00:00:00',NULL,1),
	(180,'00303606-1406797600.jpg','','',800,450,118428,'0000-00-00 00:00:00',NULL,2),
	(181,'20140716180202-1916624-b-1406797649.jpg','','',800,450,36369,'0000-00-00 00:00:00',NULL,1),
	(182,'abstract-q-c-800-450-1-1406797656.jpg','','',800,450,62522,'0000-00-00 00:00:00',NULL,2),
	(183,'abstract-q-c-800-450-5-1406798002.jpg','','',800,450,77897,'0000-00-00 00:00:00','0000-00-00 00:00:00',1),
	(184,'abstract-q-c-800-450-4-1406797691.jpg','','',800,450,36828,'0000-00-00 00:00:00',NULL,2),
	(185,'abstract-q-c-800-450-6-1406798100.jpg','','',800,450,27363,'0000-00-00 00:00:00',NULL,1),
	(186,'abstract-q-c-800-450-7-1406798231.jpg','','',800,450,43750,'0000-00-00 00:00:00',NULL,2),
	(187,'abstract-q-c-800-450-9-1406798383.jpg','','',800,450,16883,'0000-00-00 00:00:00',NULL,1),
	(188,'abstract-q-c-800-450-10-1406798389.jpg','','',800,450,75243,'0000-00-00 00:00:00',NULL,2),
	(189,'abu-dhabi-web-1406798709.jpg','','',800,450,146916,'0000-00-00 00:00:00',NULL,1),
	(190,'after-earth-51463d71e847f-1406798716.jpg','','',800,450,122342,'0000-00-00 00:00:00',NULL,2),
	(191,'animals-q-c-800-450-1-1406798741.jpg','','',800,450,44576,'0000-00-00 00:00:00',NULL,1),
	(192,'animals-q-c-800-450-2-1406798760.jpg','','',800,450,82223,'0000-00-00 00:00:00',NULL,2),
	(193,'animals-q-c-800-450-3-1406798794.jpg','','',800,450,56828,'0000-00-00 00:00:00',NULL,1),
	(194,'animals-q-c-800-450-4-1406798806.jpg','','',800,450,65847,'0000-00-00 00:00:00',NULL,2),
	(195,'animals-q-c-800-450-5-1406798840.jpg','','',800,450,67792,'0000-00-00 00:00:00',NULL,1),
	(196,'animals-q-c-800-450-6-1406798849.jpg','','',800,450,71052,'0000-00-00 00:00:00',NULL,2),
	(197,'animals-q-c-800-450-7-1406798884.jpg','','',800,450,48511,'0000-00-00 00:00:00',NULL,1),
	(198,'animals-q-c-800-450-9-1406798890.jpg','','',800,450,73359,'0000-00-00 00:00:00',NULL,2),
	(199,'animals-q-c-800-450-10-1406799267.jpg','','',800,450,39113,'0000-00-00 00:00:00',NULL,1),
	(200,'archive_4png-1406799276.png','','',800,450,450413,'0000-00-00 00:00:00',NULL,2),
	(201,'au1145201-1406799312.jpg','','',800,450,112208,'0000-00-00 00:00:00',NULL,1),
	(202,'banksy-studio-interview-wide-1406799320.jpg','','',800,450,228816,'0000-00-00 00:00:00',NULL,2),
	(203,'barna_crop_0-1406799340.jpg','','',800,450,84014,'0000-00-00 00:00:00',NULL,1),
	(204,'block10-(1)-1406799349.jpg','','',800,450,73845,'0000-00-00 00:00:00',NULL,2),
	(205,'block10-(2)-1406799369.jpg','','',800,450,41887,'0000-00-00 00:00:00',NULL,1),
	(206,'block10-1406799376.jpg','','',800,450,48345,'0000-00-00 00:00:00',NULL,2),
	(207,'bony_706-1406799454.jpg','','',800,450,52662,'0000-00-00 00:00:00',NULL,1),
	(208,'business-q-c-800-450-1-1406799459.jpg','','',800,450,27051,'0000-00-00 00:00:00',NULL,2),
	(209,'business-q-c-800-450-2-1406799493.jpg','','',800,450,30844,'0000-00-00 00:00:00',NULL,1),
	(210,'business-q-c-800-450-3-1406799501.jpg','','',800,450,45866,'0000-00-00 00:00:00',NULL,2),
	(211,'business-q-c-800-450-6-1406799527.jpg','','',800,450,52010,'0000-00-00 00:00:00',NULL,1),
	(212,'business-q-c-800-450-7-1406799534.jpg','','',800,450,20274,'0000-00-00 00:00:00',NULL,2),
	(213,'cats-q-c-800-450-1-1406799558.jpg','','',800,450,42245,'0000-00-00 00:00:00',NULL,1),
	(214,'cats-q-c-800-450-2-1406799565.jpg','','',800,450,43214,'0000-00-00 00:00:00',NULL,2),
	(215,'citylive-carousel-image-1406799596.jpg','','',800,450,122155,'0000-00-00 00:00:00',NULL,1),
	(216,'cityofmanchesterstadium_reception_front-1406799603.jpg','','',800,450,394990,'0000-00-00 00:00:00',NULL,2),
	(217,'city-q-c-800-450-1-1406799626.jpg','','',800,450,38259,'0000-00-00 00:00:00',NULL,1),
	(218,'city-q-c-800-450-2-1406799636.jpg','','',800,450,37311,'0000-00-00 00:00:00',NULL,2),
	(219,'city-q-c-800-450-3-1406799659.jpg','','',800,450,59785,'0000-00-00 00:00:00',NULL,1),
	(220,'city-q-c-800-450-4-1406799667.jpg','','',800,450,37537,'0000-00-00 00:00:00',NULL,2),
	(221,'city-q-c-800-450-4-1406799703.jpg','','',800,450,37537,'0000-00-00 00:00:00',NULL,1),
	(222,'city-q-c-800-450-6-1406799711.jpg','','',800,450,33554,'0000-00-00 00:00:00',NULL,2),
	(223,'city-q-c-800-450-7-1406799941.jpg','','',800,450,34733,'0000-00-00 00:00:00',NULL,1),
	(224,'city-q-c-800-450-8-1406799948.jpg','','',800,450,74510,'0000-00-00 00:00:00',NULL,2),
	(225,'city-q-c-800-450-10-1406801780.jpg','','',800,450,63493,'0000-00-00 00:00:00',NULL,1),
	(226,'cityscapes-city-woot-city-skyline-1920x1080-wallpaper_www.wallmay.com_47-1406801789.jpg','','',800,450,298821,'0000-00-00 00:00:00',NULL,2),
	(227,'cityscapes-mirrors-edge-city-skyline_www.wallpaperfly.com_59-1406801820.jpg','','',800,450,342674,'0000-00-00 00:00:00',NULL,1),
	(228,'cityscapes-night-traffic-city-lights-tiltshift-street-2560x1440-wallpaper_www.wallmay.com_13-1406801831.jpg','','',800,450,230212,'0000-00-00 00:00:00',NULL,2),
	(229,'comshield_2-1406801859.jpg','','',800,450,321589,'0000-00-00 00:00:00',NULL,1),
	(230,'daftside-800x450-1406801868.jpg','','',800,450,15105,'0000-00-00 00:00:00',NULL,2),
	(231,'download-(1)-1406801893.jpg','','',800,450,47488,'0000-00-00 00:00:00',NULL,1),
	(232,'download-1406801905.jpg','','',800,450,39308,'0000-00-00 00:00:00',NULL,2),
	(233,'dsc_7232-lowres-1406801926.jpg','','',800,450,71367,'0000-00-00 00:00:00',NULL,1),
	(234,'eko-atlantic-city-project-2012-pdp-1406801935.jpg','','',800,450,262729,'0000-00-00 00:00:00',NULL,2),
	(235,'fashion-q-c-800-450-1-1406801968.jpg','','',800,450,63543,'0000-00-00 00:00:00',NULL,1),
	(236,'fashion-q-c-800-450-3-1406801979.jpg','','',800,450,38345,'0000-00-00 00:00:00',NULL,2),
	(237,'fashion-q-c-800-450-4-1406802007.jpg','','',800,450,39373,'0000-00-00 00:00:00',NULL,1),
	(238,'fashion-q-c-800-450-5-1406802019.jpg','','',800,450,42711,'0000-00-00 00:00:00',NULL,2),
	(239,'fashion-q-c-800-450-7-1406802048.jpg','','',800,450,56206,'0000-00-00 00:00:00','0000-00-00 00:00:00',1),
	(240,'fashion-q-c-800-450-8-1406802073.jpg','','',800,450,42640,'0000-00-00 00:00:00',NULL,1),
	(241,'fashion-q-c-800-450-10-1406802083.jpg','','',800,450,42133,'0000-00-00 00:00:00',NULL,2),
	(242,'food-q-c-800-450-1-1406802121.jpg','','',800,450,53647,'0000-00-00 00:00:00',NULL,1),
	(243,'food-q-c-800-450-2-1406802131.jpg','','',800,450,41881,'0000-00-00 00:00:00',NULL,2),
	(244,'world-cup-aloft-1406802176.jpg','','',800,450,80082,'0000-00-00 00:00:00',NULL,1),
	(245,'what-not-to-wear-to-work1-1406802186.jpg','','',800,450,141153,'0000-00-00 00:00:00',NULL,2),
	(246,'technics-q-c-800-450-4-1406802249.jpg','','',800,450,43176,'0000-00-00 00:00:00','0000-00-00 00:00:00',1),
	(247,'technics-q-c-800-450-3-1406802297.jpg','','',800,450,23512,'0000-00-00 00:00:00',NULL,2),
	(248,'technics-q-c-800-450-2-1406802317.jpg','','',800,450,74616,'0000-00-00 00:00:00',NULL,1),
	(249,'technics-q-c-800-450-1-1406802326.jpg','','',800,450,27034,'0000-00-00 00:00:00',NULL,2),
	(250,'super-smash-bros.16-1406802348.jpg','','',800,450,107102,'0000-00-00 00:00:00',NULL,1),
	(251,'sunset-streets-new-york-city-the-sun-cities-1920x1080-wallpaper_www.wallmay.com_61-1406802365.jpg','','',800,450,329213,'0000-00-00 00:00:00',NULL,2),
	(252,'byqsfr-watch-prairie-dogs-do-the-wave-fkqy-1406802457.jpeg','','',800,450,249910,'0000-00-00 00:00:00',NULL,1),
	(253,'fashion-q-c-800-450-4-1406802481.jpg','','',800,450,39373,'0000-00-00 00:00:00',NULL,1),
	(254,'dsc_7232-lowres-1406802502.jpg','','',800,450,71367,'0000-00-00 00:00:00',NULL,1),
	(255,'landscapes-cityscapes-bridges-towns-city-skyline-rainbow-bridge_www.wallmay.net_80-1406802528.jpg','','',800,450,251643,'0000-00-00 00:00:00',NULL,1),
	(256,'p1230557-version-2-1406802549.jpg','','',800,450,204154,'0000-00-00 00:00:00',NULL,1),
	(257,'latest_news_large-1406802568.jpg','','',800,450,39757,'0000-00-00 00:00:00',NULL,1),
	(258,'nature-q-c-800-450-1-1406802584.jpg','','',800,450,33914,'0000-00-00 00:00:00',NULL,1),
	(259,'nightlife-q-c-800-450-5-1406802608.jpg','','',800,450,31234,'0000-00-00 00:00:00',NULL,1),
	(260,'food-q-c-800-450-3-1406802662.jpg','','',800,450,42179,'0000-00-00 00:00:00',NULL,1),
	(261,'shop-in-the-city-1406802678.jpg','','',800,450,63631,'0000-00-00 00:00:00',NULL,1),
	(262,'nightlife-q-c-800-450-7-1406802692.jpg','','',800,450,64777,'0000-00-00 00:00:00',NULL,1),
	(263,'paris-cityscapes-city-urban-1920x1080-wallpaper_www.wallmay.com_35-1406802710.jpg','','',800,450,369923,'0000-00-00 00:00:00',NULL,1),
	(264,'cats-q-c-800-450-1-1406802723.jpg','','',800,450,42245,'0000-00-00 00:00:00',NULL,1),
	(265,'cats-q-c-800-450-2-1406802740.jpg','','',800,450,43214,'0000-00-00 00:00:00',NULL,1),
	(266,'cats-q-c-800-450-5-1406802758.jpg','','',800,450,19104,'0000-00-00 00:00:00',NULL,1),
	(267,'hurricane-news-1406802792.jpg','','',800,450,280831,'0000-00-00 00:00:00','0000-00-00 00:00:00',1),
	(268,'city-q-c-800-450-1-1406802850.jpg','','',800,450,38259,'0000-00-00 00:00:00','0000-00-00 00:00:00',1),
	(269,'people-q-c-800-450-2-1406802867.jpg','','',800,450,54031,'0000-00-00 00:00:00',NULL,1),
	(270,'people-q-c-800-450-5-1406802883.jpg','','',800,450,51217,'0000-00-00 00:00:00',NULL,1),
	(271,'news-from-nowhere-03-1406802907.jpg','','',800,450,73767,'0000-00-00 00:00:00',NULL,1),
	(272,'nightlife-q-c-800-450-2-1406802926.jpg','','',800,450,33030,'0000-00-00 00:00:00',NULL,1),
	(273,'sports-q-c-800-450-7-1406802978.jpg','','',800,450,57261,'0000-00-00 00:00:00','0000-00-00 00:00:00',1),
	(275,'n-c_daily_banner-1407203046.jpg','2','2',600,100,23057,'0000-00-00 00:00:00',NULL,4),
	(276,'n-c_daily_crime_1_banner-1407204176.jpg','1','1',600,100,24503,'0000-00-00 00:00:00',NULL,4),
	(277,'n-c_daily_crime_2_banner-1407204263.jpg','1','1',600,100,24612,'0000-00-00 00:00:00',NULL,4),
	(278,'n-c_daily_crime_3_banner-1407204333.jpg','1','1',600,100,24598,'0000-00-00 00:00:00',NULL,4),
	(279,'n-c_daily_crime_4_banner-1407204367.jpg','1','1',600,100,24553,'0000-00-00 00:00:00',NULL,4),
	(280,'n-c_daily_crime_5_banner-1407204396.jpg','2','2',600,100,24589,'0000-00-00 00:00:00',NULL,4),
	(281,'n-c_daily_media_1_banner-1407204437.jpg','1','1',600,100,24554,'0000-00-00 00:00:00',NULL,4),
	(282,'n-c_daily_media_2_banner-1407204472.jpg','2','2',600,100,24773,'0000-00-00 00:00:00',NULL,4),
	(283,'n-c_daily_media_3_banner-1407204508.jpg','2','2',600,100,24698,'0000-00-00 00:00:00',NULL,4),
	(284,'n-c_daily_media_4_banner-1407204545.jpg','2','2',600,100,24681,'0000-00-00 00:00:00',NULL,4),
	(285,'n-c_daily_media_5_banner-1407204583.jpg','2','2',600,100,24698,'0000-00-00 00:00:00',NULL,4),
	(286,'n-c_features_health_1_banner-1407204632.jpg','3','3',600,100,25003,'0000-00-00 00:00:00',NULL,4),
	(287,'n-c_features_health_2_banner-1407204667.jpg','3','3',600,100,25112,'0000-00-00 00:00:00',NULL,4),
	(288,'n-c_features_health_3_banner-1407204724.jpg','3','3',600,100,25111,'0000-00-00 00:00:00',NULL,4),
	(289,'n-c_features_health_4_banner-1407204758.jpg','3','3',600,100,25063,'0000-00-00 00:00:00',NULL,4),
	(290,'n-c_features_health_5_banner-1407204806.jpg','3','3',600,100,25085,'0000-00-00 00:00:00',NULL,4),
	(291,'n-c_features_enviro_1_banner-1407204837.jpg','4','4',600,100,24998,'0000-00-00 00:00:00',NULL,4),
	(292,'n-c_features_enviro_2_banner-1407204875.jpg','4','4',600,100,25067,'0000-00-00 00:00:00',NULL,4),
	(293,'n-c_features_enviro_4_banner-1407204925.jpg','4','4',600,100,25019,'0000-00-00 00:00:00',NULL,4),
	(294,'n-c_features_enviro_3_banner-1407204949.jpg','4','4',600,100,25073,'0000-00-00 00:00:00',NULL,4),
	(295,'n-c_features_enviro_4_banner-1407204987.jpg','4','4',600,100,25019,'0000-00-00 00:00:00',NULL,4),
	(296,'n-c_features_health_5_banner-1407205029.jpg','4','4',600,100,25085,'0000-00-00 00:00:00',NULL,4),
	(297,'n-c_features_enviro_5_banner-1407205046.jpg','4','4',600,100,25058,'0000-00-00 00:00:00',NULL,4),
	(298,'w-o_theatre_comedy_1_banner-1407205096.jpg','5','5',600,100,24091,'0000-00-00 00:00:00',NULL,4),
	(299,'w-o_theatre_comedy_2_banner-1407205128.jpg','5','5',600,100,24186,'0000-00-00 00:00:00',NULL,4),
	(300,'w-o_theatre_comedy_3_banner-1407205155.jpg','5','5',600,100,24190,'0000-00-00 00:00:00',NULL,4),
	(301,'w-o_theatre_comedy_2_banner-1407205176.jpg','5','5',600,100,24186,'0000-00-00 00:00:00',NULL,4),
	(302,'w-o_theatre_comedy_3_banner-1407205209.jpg','5','5',600,100,24190,'0000-00-00 00:00:00',NULL,4),
	(303,'w-o_theatre_comedy_4_banner-1407205238.jpg','5','5',600,100,24148,'0000-00-00 00:00:00',NULL,4),
	(304,'w-o_theatre_comedy_5_banner-1407205274.jpg','5','5',600,100,24170,'0000-00-00 00:00:00',NULL,4),
	(305,'f-d_guide_italian_1_banner-1407205644.jpg','6','6',600,100,8082,'0000-00-00 00:00:00',NULL,4),
	(306,'f-d_guide_italian_2_banner-1407205675.jpg','6','6',600,100,8233,'0000-00-00 00:00:00',NULL,4),
	(307,'f-d_guide_italian_3_banner-1407205702.jpg','6','6',600,100,8240,'0000-00-00 00:00:00',NULL,4),
	(308,'f-d_guide_italian_4_banner-1407205731.jpg','6','6',600,100,8206,'0000-00-00 00:00:00',NULL,4),
	(309,'f-d_guide_italian_5_banner-1407205757.jpg','6','6',600,100,8208,'0000-00-00 00:00:00',NULL,4),
	(310,'f-d_o-c_indian_6_banner-1407205785.jpg','7','7',600,100,8235,'0000-00-00 00:00:00',NULL,4),
	(311,'f-d_o-c_indian_7_banner-1407205817.jpg','7','7',600,100,8236,'0000-00-00 00:00:00',NULL,4),
	(312,'f-d_o-c_indian_8_banner-1407205848.jpg','7','7',600,100,8275,'0000-00-00 00:00:00',NULL,4),
	(313,'f-d_o-c_indian_9_banner-1407205878.jpg','7','7',600,100,8266,'0000-00-00 00:00:00',NULL,4),
	(314,'f-d_o-c_indian_10_banner-1407205903.jpg','7','7',600,100,8423,'0000-00-00 00:00:00',NULL,4),
	(315,'n-c_daily_crime_1_banner-1407212694.jpg','1','1',600,100,41174,'0000-00-00 00:00:00',NULL,4),
	(316,'n-c_daily_crime_2_banner-1407212860.jpg','1','1',600,100,41410,'0000-00-00 00:00:00',NULL,4),
	(317,'n-c_daily_crime_3_banner-1407212887.jpg','1','1',600,100,41348,'0000-00-00 00:00:00',NULL,4),
	(318,'n-c_daily_crime_4_banner-1407212914.jpg','1','1',600,100,41319,'0000-00-00 00:00:00',NULL,4),
	(319,'n-c_daily_crime_5_banner-1407212936.jpg','1','1',600,100,41362,'0000-00-00 00:00:00',NULL,4),
	(320,'n-c_daily_media_1_banner-1407212971.jpg','1','1',600,100,41356,'0000-00-00 00:00:00',NULL,4),
	(321,'n-c_daily_media_2_banner-1407213000.jpg','1','1',600,100,41604,'0000-00-00 00:00:00',NULL,4),
	(322,'n-c_daily_media_3_banner-1407213028.jpg','1','1',600,100,41578,'0000-00-00 00:00:00',NULL,4),
	(323,'n-c_daily_media_4_banner-1407213058.jpg','1','1',600,100,41568,'0000-00-00 00:00:00',NULL,4),
	(324,'n-c_daily_media_5_banner-1407213083.jpg','1','1',600,100,41533,'0000-00-00 00:00:00',NULL,4),
	(325,'n-c_features_health_1_banner-1407213120.jpg','1','1',600,100,41692,'0000-00-00 00:00:00',NULL,4),
	(326,'n-c_features_health_2_banner-1407213151.jpg','1','1',600,100,41921,'0000-00-00 00:00:00',NULL,4),
	(327,'n-c_features_health_3_banner-1407213180.jpg','1','1',600,100,41917,'0000-00-00 00:00:00',NULL,4),
	(328,'n-c_features_health_4_banner-1407213214.jpg','1','1',600,100,41877,'0000-00-00 00:00:00',NULL,4),
	(329,'n-c_features_health_5_banner-1407213239.jpg','1','1',600,100,41903,'0000-00-00 00:00:00',NULL,4),
	(330,'n-c_features_enviro_1_banner-1407213284.jpg','1','1',600,100,41668,'0000-00-00 00:00:00',NULL,4),
	(331,'n-c_features_enviro_2_banner-1407213316.jpg','1','1',600,100,41780,'0000-00-00 00:00:00',NULL,4),
	(332,'n-c_features_enviro_3_banner-1407213357.jpg','1','1',600,100,41748,'0000-00-00 00:00:00',NULL,4),
	(333,'n-c_features_enviro_4_banner-1407213382.jpg','1','1',600,100,41710,'0000-00-00 00:00:00',NULL,4),
	(334,'n-c_features_enviro_5_banner-1407213407.jpg','1','1',600,100,41733,'0000-00-00 00:00:00',NULL,4),
	(335,'w-o_theatre_comedy_1_banner-1407213452.jpg','1','1',600,100,41195,'0000-00-00 00:00:00',NULL,4),
	(336,'w-o_theatre_comedy_2_banner-1407213480.jpg','1','1',600,100,41295,'0000-00-00 00:00:00',NULL,4),
	(337,'w-o_theatre_comedy_2_banner-1407213509.jpg','1','1',600,100,41295,'0000-00-00 00:00:00',NULL,4),
	(338,'w-o_theatre_comedy_3_banner-1407213537.jpg','1','1',600,100,41270,'0000-00-00 00:00:00',NULL,4),
	(339,'w-o_theatre_comedy_4_banner-1407213553.jpg','1','1',600,100,41233,'0000-00-00 00:00:00',NULL,4),
	(340,'w-o_theatre_comedy_4_banner-1407213563.jpg','1','1',600,100,41233,'0000-00-00 00:00:00',NULL,4),
	(341,'w-o_theatre_comedy_5_banner-1407213587.jpg','1','1',600,100,41273,'0000-00-00 00:00:00',NULL,4),
	(342,'sd-1407370843.jpg','','',800,450,179728,'0000-00-00 00:00:00',NULL,1),
	(343,'article-hero-image-1407424376.jpg','Alt info for hero image','Hero Image for test',800,450,143571,'0000-00-00 00:00:00','0000-00-00 00:00:00',1),
	(344,'carouselle-image-1-1407424403.jpg','image one','Top image one',800,450,144006,'0000-00-00 00:00:00',NULL,2),
	(345,'carouselle-image-2-1407424451.jpg','alt info for 2','Top image two',800,450,144106,'0000-00-00 00:00:00',NULL,2),
	(346,'carouselle-image-3-1407424588.jpg','image three ','Carrouselle 3',800,450,144075,'0000-00-00 00:00:00',NULL,2),
	(347,'gallery-image-1-1407424608.jpg','alt gallery 1','Gallery 1',800,450,143984,'0000-00-00 00:00:00',NULL,3),
	(348,'gallery-image-2-1407424624.jpg','alt gallery 2','Gallery 2',800,450,144068,'0000-00-00 00:00:00',NULL,3),
	(349,'gallery-image-3-1407424644.jpg','alt gallery 3','Gallery 3',800,450,144075,'0000-00-00 00:00:00',NULL,3),
	(350,'gallery-image-4-1407424686.jpg','alt gallery 4','gallery 4',800,450,144078,'0000-00-00 00:00:00',NULL,3),
	(351,'carouselle-image-1-1407503048.jpg','test hero image','Hero image',800,450,144006,'0000-00-00 00:00:00','0000-00-00 00:00:00',1),
	(352,'carouselle-image-2-1407503094.jpg','Alt for top','Top image',800,450,144106,'0000-00-00 00:00:00',NULL,2),
	(353,'gallery-image-1-1407503138.jpg','bottom','Test bottom',800,450,143984,'0000-00-00 00:00:00',NULL,3),
	(354,'article-hero-image-1407506997.jpg','Alt info','Hero image',800,450,143571,'0000-00-00 00:00:00',NULL,1),
	(355,'carouselle-image-1-1407507023.jpg','alt','Top image 1',800,450,144006,'0000-00-00 00:00:00',NULL,2),
	(356,'carouselle-image-2-1407507043.jpg','alt','Top image 2',800,450,144106,'0000-00-00 00:00:00',NULL,2),
	(357,'gallery-image-1-1407507066.jpg','Alst','bottom image 1',800,450,143984,'0000-00-00 00:00:00',NULL,3),
	(358,'gallery-image-2-1407507097.jpg','alt','Bottom 2',800,450,144068,'0000-00-00 00:00:00',NULL,3),
	(359,'article-hero-image-1407508653.jpg','alt','The library',800,450,143571,'0000-00-00 00:00:00',NULL,1),
	(360,'carouselle-image-1-1407508674.jpg','alt','Top 1',800,450,144006,'0000-00-00 00:00:00',NULL,2),
	(361,'gallery-image-2-1407508693.jpg','alt','top 2',800,450,144068,'0000-00-00 00:00:00',NULL,2),
	(362,'carouselle-image-3-1407508719.jpg','alt','top 3',800,450,144075,'0000-00-00 00:00:00',NULL,2),
	(363,'gallery-image-1-1407508777.jpg','alt','Bottom 1',800,450,143984,'0000-00-00 00:00:00',NULL,3),
	(364,'gallery-image-2-1407508797.jpg','alt','bottom 2',800,450,144068,'0000-00-00 00:00:00',NULL,3),
	(365,'gallery-image-3-1407508809.jpg','alt','Bottom 3',800,450,144075,'0000-00-00 00:00:00',NULL,3),
	(366,'wicked-1407750141.jpg','Witches','wicked show',800,450,75713,'0000-00-00 00:00:00',NULL,1),
	(367,'test-1407791674.jpg','hero1','hero1',800,450,138809,'0000-00-00 00:00:00',NULL,1),
	(368,'','balloon1','balloon1',800,450,66410,'0000-00-00 00:00:00',NULL,2),
	(369,'article-hero-image-1407845625.jpg','alt text','Hero image',800,450,143571,'0000-00-00 00:00:00',NULL,1),
	(370,'carouselle-image-1-1407845649.jpg','alt','Top image 1',800,450,144006,'0000-00-00 00:00:00',NULL,2),
	(371,'gallery-image-2-1407845675.jpg','alt gallery 1','Top image 2',800,450,144068,'0000-00-00 00:00:00',NULL,2),
	(372,'gallery-image-1-1407845701.jpg','alt','bottom 1',800,450,143984,'0000-00-00 00:00:00',NULL,3),
	(373,'gallery-image-3-1407845756.jpg','alt','bottom 3',800,450,144075,'0000-00-00 00:00:00',NULL,3);

/*!40000 ALTER TABLE `asset` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table authors
# ------------------------------------------------------------

DROP TABLE IF EXISTS `authors`;

CREATE TABLE `authors` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(60) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `authors` WRITE;
/*!40000 ALTER TABLE `authors` DISABLE KEYS */;

INSERT INTO `authors` (`id`, `name`, `created_at`)
VALUES
	(2,'David Woodall',NULL),
	(4,'David Puddefoot',NULL),
	(5,'David Woodall',NULL),
	(6,'Kevin Broadly',NULL);

/*!40000 ALTER TABLE `authors` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table category
# ------------------------------------------------------------

DROP TABLE IF EXISTS `category`;

CREATE TABLE `category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `icon_img_id` int(11) DEFAULT NULL,
  `name` varchar(100) NOT NULL,
  `sef_name` varchar(100) NOT NULL,
  `colour` varchar(45) DEFAULT NULL,
  `is_active` tinyint(4) NOT NULL DEFAULT '1',
  `is_deleted` tinyint(4) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `icon -> asset_idx` (`icon_img_id`),
  CONSTRAINT `icon -> asset` FOREIGN KEY (`icon_img_id`) REFERENCES `asset` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `category` WRITE;
/*!40000 ALTER TABLE `category` DISABLE KEYS */;

INSERT INTO `category` (`id`, `icon_img_id`, `name`, `sef_name`, `colour`, `is_active`, `is_deleted`, `created_at`, `updated_at`)
VALUES
	(1,NULL,'Crime','crime',NULL,1,NULL,'2014-07-30 14:40:55','2014-07-30 14:40:55'),
	(2,NULL,'Media','media',NULL,1,NULL,'2014-07-30 14:42:48','2014-07-30 14:42:48'),
	(3,NULL,'Health','health',NULL,1,NULL,'2014-07-30 14:43:05','2014-07-30 14:43:05'),
	(4,NULL,'Environment','environment',NULL,1,NULL,'2014-07-30 14:43:17','2014-07-30 14:43:17'),
	(5,NULL,'Comedy','comedy',NULL,1,NULL,'2014-07-30 14:43:59','2014-07-30 14:43:59'),
	(6,NULL,'Italian','italian',NULL,1,NULL,'2014-07-30 14:44:05','2014-07-30 14:44:05'),
	(7,NULL,'Indian','indian',NULL,1,NULL,'2014-07-30 14:44:10','2014-07-30 14:44:10'),
	(9,NULL,'Politics','politics',NULL,1,NULL,'2014-08-11 22:04:47','2014-08-11 22:04:47'),
	(10,NULL,'George Ferguson','george_ferguson',NULL,1,NULL,'2014-08-11 22:06:09','2014-08-11 22:06:09');

/*!40000 ALTER TABLE `category` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table channel
# ------------------------------------------------------------

DROP TABLE IF EXISTS `channel`;

CREATE TABLE `channel` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `display_type` int(11) NOT NULL,
  `parent_channel` int(11) DEFAULT NULL,
  `icon_img_id` int(11) DEFAULT NULL,
  `name` varchar(100) NOT NULL,
  `sef_name` varchar(100) NOT NULL,
  `colour` varchar(45) DEFAULT NULL,
  `secondary_colour` varchar(45) DEFAULT NULL,
  `is_active` tinyint(4) NOT NULL DEFAULT '1',
  `is_deleted` tinyint(4) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `display_type -> type_idx` (`display_type`),
  CONSTRAINT `channel_display_type -> type` FOREIGN KEY (`display_type`) REFERENCES `display_type` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `channel` WRITE;
/*!40000 ALTER TABLE `channel` DISABLE KEYS */;

INSERT INTO `channel` (`id`, `display_type`, `parent_channel`, `icon_img_id`, `name`, `sef_name`, `colour`, `secondary_colour`, `is_active`, `is_deleted`, `created_at`, `updated_at`)
VALUES
	(1,1,NULL,NULL,'News and Comment','news-comment','#33b9f8','#222c5c',1,0,'2014-06-09 08:59:10','2014-06-09 08:59:10'),
	(2,2,NULL,NULL,'Whats On','whats-on','#56cd6c','#295e4e',1,0,'2014-06-09 08:59:10','2014-06-09 08:59:10'),
	(3,1,NULL,NULL,'Food and Drink','food-drink','#d6ab29','#7b473a',1,0,'2014-06-09 08:59:10','2014-06-09 08:59:10'),
	(4,1,1,NULL,'Daily','daily',NULL,NULL,1,0,'2014-07-30 00:00:00','2014-06-25 00:00:00'),
	(5,1,1,NULL,'Features','features',NULL,NULL,1,0,'2014-07-30 00:00:00','2014-07-30 00:00:00'),
	(6,2,2,NULL,'Theatre','theatre',NULL,NULL,1,0,'2014-07-30 00:00:00','2014-07-30 00:00:00'),
	(7,3,3,NULL,'Guide','guide',NULL,NULL,1,0,'2014-07-30 00:00:00','2014-07-30 00:00:00'),
	(8,4,3,NULL,'Offers and Competitions ','offers-competitions ',NULL,NULL,0,0,'2014-07-30 00:00:00','2014-07-30 00:00:00'),
	(10,1,1,NULL,'Kevin\'s news','kevins_news',NULL,NULL,0,NULL,'0000-00-00 00:00:00',NULL);

/*!40000 ALTER TABLE `channel` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table channel_category
# ------------------------------------------------------------

DROP TABLE IF EXISTS `channel_category`;

CREATE TABLE `channel_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `channel_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `channel category_idx` (`category_id`),
  KEY `category channel_idx` (`channel_id`),
  CONSTRAINT `channel category` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `category channel` FOREIGN KEY (`channel_id`) REFERENCES `channel` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `channel_category` WRITE;
/*!40000 ALTER TABLE `channel_category` DISABLE KEYS */;

INSERT INTO `channel_category` (`id`, `channel_id`, `category_id`)
VALUES
	(1,4,1),
	(2,4,2),
	(3,5,4),
	(4,5,3),
	(5,8,7),
	(6,7,6),
	(7,6,5),
	(12,4,9),
	(13,4,10);

/*!40000 ALTER TABLE `channel_category` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table competition
# ------------------------------------------------------------

DROP TABLE IF EXISTS `competition`;

CREATE TABLE `competition` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(150) DEFAULT NULL,
  `valid_from` datetime DEFAULT NULL,
  `valid_to` datetime DEFAULT NULL,
  `terms` text,
  `is_active` tinyint(4) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table competition_answer
# ------------------------------------------------------------

DROP TABLE IF EXISTS `competition_answer`;

CREATE TABLE `competition_answer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `competition_id` int(11) NOT NULL,
  `answer` varchar(255) NOT NULL DEFAULT '',
  `is_correct_answer` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `comp_ques_id -> question` (`competition_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table competition_question
# ------------------------------------------------------------

DROP TABLE IF EXISTS `competition_question`;

CREATE TABLE `competition_question` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `competition_id` int(11) NOT NULL,
  `question` text NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `offer_id` (`competition_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table display_type
# ------------------------------------------------------------

DROP TABLE IF EXISTS `display_type`;

CREATE TABLE `display_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(45) NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `display_type` WRITE;
/*!40000 ALTER TABLE `display_type` DISABLE KEYS */;

INSERT INTO `display_type` (`id`, `type`, `updated_at`, `created_at`)
VALUES
	(1,'Article',NULL,'2014-06-23 10:40:30'),
	(2,'Listing',NULL,'2014-06-23 10:41:11'),
	(3,'Directory',NULL,'2014-06-23 10:41:20'),
	(4,'Promotion',NULL,'2014-06-23 10:41:34');

/*!40000 ALTER TABLE `display_type` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table event
# ------------------------------------------------------------

DROP TABLE IF EXISTS `event`;

CREATE TABLE `event` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `venue_id` int(11) NOT NULL,
  `title` varchar(150) NOT NULL,
  `sef_name` varchar(150) DEFAULT NULL,
  `url` varchar(150) DEFAULT NULL,
  `is_active` tinyint(4) NOT NULL DEFAULT '1',
  `is_deleted` tinyint(4) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `event -> venue_idx` (`venue_id`),
  CONSTRAINT `event -> venue` FOREIGN KEY (`venue_id`) REFERENCES `venue` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `event` WRITE;
/*!40000 ALTER TABLE `event` DISABLE KEYS */;

INSERT INTO `event` (`id`, `venue_id`, `title`, `sef_name`, `url`, `is_active`, `is_deleted`, `created_at`, `updated_at`)
VALUES
	(1,1,'Coppelia','coppelia','http://www.atgtickets.com/shows/coppelia/bristol-hippodrome/',1,NULL,'2014-05-22 14:12:10','2014-07-10 14:27:53'),
	(3,1,'Cary Grant Comes Home... for the weekend','cary-grant-comes-home-for-the-weekend','http://www.atgtickets.com/shows/cary-grant-comes-home-for-the-weekend-2/bristol-hippodrome/',1,NULL,'2014-06-09 15:40:45','2014-07-10 14:39:46'),
	(6,1,'Calamity Jane','calamity-jane','http://www.atgtickets.com/shows/calamity-jane/bristol-hippodrome/',1,NULL,'2014-06-09 16:36:45','2014-07-10 14:30:19'),
	(7,1,'Barnum','barnum','http://www.atgtickets.com/shows/barnum/bristol-hippodrome/',1,NULL,'2014-06-09 16:37:05','2014-07-10 14:29:41'),
	(8,1,'BLOC presents Sister Act','bloc-presents-sister-act','http://www.atgtickets.com/shows/sister-act/bristol-hippodrome/',1,NULL,'2014-06-10 08:08:25','2014-07-10 14:31:05'),
	(9,1,'An Evening of Burlesque','an-evening-of-burlesque','http://www.atgtickets.com/shows/an-evening-of-burlesque-2/bristol-hippodrome/',1,NULL,'2014-06-10 08:09:28','2014-07-10 14:29:54'),
	(10,1,'Al Murray: One Man, One Guvnor','al-murray-one-man-one-guvnor','http://www.atgtickets.com/shows/al-murray-one-man-one-guvnor/bristol-hippodrome/',1,NULL,'2014-06-10 08:09:34','2014-07-10 14:28:01'),
	(11,1,'Abba Mania','abba-mania','http://www.atgtickets.com/shows/abba-mania/bristol-hippodrome/',1,NULL,'2014-06-10 13:13:33','2014-07-10 14:28:09'),
	(12,1,'Chas & Dave','chas-dave','http://www.atgtickets.com/shows/chas-and-dave/bristol-hippodrome/',1,NULL,'2014-07-04 12:51:25','2014-07-10 14:28:40'),
	(13,1,'The Curious Incident of the Dog in the Night-Time','the-curious-incident-of-the-dog-in-the-night-time','http://www.atgtickets.com/shows/the-curious-incident-of-the-dog-in-the-night-time/bristol-hippodrome/',1,NULL,'2014-07-04 12:53:20','2014-07-10 14:29:26'),
	(14,1,'Rock of Ages','rock-of-ages','http://www.atgtickets.com/shows/rock-of-ages/bristol-hippodrome/#performance_tabs=tab_tour&showinfotabs=overview,showtimes',1,NULL,'2014-07-10 14:35:04','2014-07-10 14:35:04'),
	(15,1,'The Dreamboys','the-dreamboys','http://www.atgtickets.com/shows/the-dreamboys/bristol-hippodrome/#performance_tabs=tab_calendar,tab_performances,tab_tour',1,NULL,'2014-07-10 14:38:07','2014-07-10 14:38:07'),
	(16,1,'The Rat Pack Vegas Spectacular Show','the-rat-pack-vegas-spectacular-show','http://www.atgtickets.com/shows/the-rat-pack-vegas-spectacular-2/bristol-hippodrome/',1,NULL,'2014-07-10 14:39:17','2014-07-10 14:39:17'),
	(17,1,'Hippodrome Choir Concert','hippodrome-choir-concert','http://www.atgtickets.com/shows/hippodrome-choir-concert/bristol-hippodrome/',1,NULL,'2014-07-10 14:41:56','2014-07-10 14:41:56'),
	(18,1,'Singin\' in the Rain - Tour','singin-in-the-rain-tour','http://www.atgtickets.com/shows/singin-in-the-rain-tour/bristol-hippodrome/',1,NULL,'2014-07-10 14:42:52','2014-07-10 14:42:52'),
	(19,1,'Russell Howard: Wonderbox','russell-howard-wonderbox','http://www.atgtickets.com/shows/russell-howard/bristol-hippodrome/',1,NULL,'2014-07-10 14:44:12','2014-07-10 14:44:22'),
	(20,1,'Shrek the Musical','shrek-the-musical','http://www.atgtickets.com/shows/shrek-the-musical/bristol-hippodrome/',1,NULL,'2014-07-10 14:45:53','2014-07-10 14:45:53'),
	(21,1,'One Night of Queen','one-night-of-queen','http://www.atgtickets.com/shows/one-night-of-queen/bristol-hippodrome/',1,NULL,'2014-07-10 14:49:02','2014-07-10 14:49:02'),
	(22,1,'The Illegal Eagles','the-illegal-eagles','http://www.atgtickets.com/shows/the-illegal-eagles/bristol-hippodrome/',1,NULL,'2014-07-10 14:49:56','2014-07-10 14:49:56'),
	(23,1,'Sally Morgan: Psychic Sally on the Road','sally-morgan-psychic-sally-on-the-road','http://www.atgtickets.com/shows/sally-morgan-psychic-sally-on-the-road-3/bristol-hippodrome/',1,NULL,'2014-07-10 14:51:41','2014-07-10 14:51:41'),
	(24,1,'Think Floyd','think-floyd','http://www.atgtickets.com/shows/think-floyd/bristol-hippodrome/',1,NULL,'2014-07-10 14:52:52','2014-07-10 14:52:52'),
	(25,1,'Jackson Live in Concert','jackson-live-in-concert','http://www.atgtickets.com/shows/jackson-live-in-concert/bristol-hippodrome/',1,NULL,'2014-07-10 14:55:12','2014-07-10 14:55:12'),
	(26,1,'Dawn French: 30 Million Minutes','dawn-french-30-million-minutes','http://www.atgtickets.com/shows/dawn-french-30-million-minutes/bristol-hippodrome/',1,NULL,'2014-08-06 14:56:04','2014-08-06 14:56:04'),
	(27,9,'ONE MAN AND HIS COW','one-man-and-his-cow','http://www.tobaccofactorytheatres.com/shows/detail/one_man_and_his_cow/',1,NULL,'2014-07-14 10:02:59','2014-07-14 10:02:59'),
	(28,9,'TRIPLE BILL','triple-bill','http://www.tobaccofactorytheatres.com/shows/detail/triple_bill/',1,NULL,'2014-07-14 10:03:40','2014-07-14 10:03:40'),
	(29,9,'BROUHAHA: SARA PASCOE & LUCY PORTER','brouhaha-sara-pascoe-lucy-porter','http://www.tobaccofactorytheatres.com/shows/detail/double_bill_sara_pascoe_lucy_porter/',1,NULL,'2014-07-14 10:04:11','2014-07-14 10:04:11'),
	(30,9,'BROUHAHA: NATHAN CATON & ZOE LYONS','brouhaha-nathan-caton-zoe-lyons','http://www.tobaccofactorytheatres.com/shows/detail/double_bill_nathan_caton_zoe_lyons/',1,NULL,'2014-07-14 10:04:46','2014-07-14 10:04:46'),
	(31,9,'PAUL MERTON AND SUKI WEBSTER: MY OBSESSION','paul-merton-and-suki-webster-my-obsession','http://www.tobaccofactorytheatres.com/shows/detail/paul_merton_and_suki_webster/',1,NULL,'2014-07-14 10:05:15','2014-07-14 10:05:15'),
	(32,9,'BROUHAHA: LLOYD LANGFORD & JARLATH REGAN','brouhaha-lloyd-langford-jarlath-regan','http://www.tobaccofactorytheatres.com/shows/detail/double_bill_lloyd_langford_jarlath_regan/',1,NULL,'2014-07-14 10:06:04','2014-07-14 10:06:04'),
	(33,9,'THE TIGER AND THE MOUSTACHE','the-tiger-and-the-moustache','http://www.tobaccofactorytheatres.com/shows/detail/the_tiger_and_the_moustache1/',1,NULL,'2014-07-14 10:06:43','2014-07-14 10:06:43'),
	(34,9,'BROUHAHA: ERICH MCELROY & CAIMH MCDONNELL','brouhaha-erich-mcelroy-caimh-mcdonnell','http://www.tobaccofactorytheatres.com/shows/detail/double_bill_erich_mcelroy_caimh_mcdonnell/',1,NULL,'2014-07-14 10:07:10','2014-07-14 10:07:10'),
	(35,9,'BROUHAHA: JOHN ROBINS & CAREY MARX','brouhaha-john-robins-carey-marx','http://www.tobaccofactorytheatres.com/shows/detail/double_bill_john_robins_carey_marx/',1,NULL,'2014-07-14 10:07:39','2014-07-14 10:07:39'),
	(36,9,'DON QUIXOTE','don-quixote','http://www.tobaccofactorytheatres.com/shows/category/programmed/P10/',1,NULL,'2014-07-14 10:08:13','2014-07-14 10:08:13'),
	(37,9,'BROUHAHA: JARRED CHRISTMAS & TOM ALLEN','brouhaha-jarred-christmas-tom-allen','http://www.tobaccofactorytheatres.com/shows/category/programmed/P10/',1,NULL,'2014-07-14 10:08:29','2014-07-14 10:08:29'),
	(38,9,' Ablutions','ablutions','http://www.tobaccofactorytheatres.com/shows/detail/ablutions',1,NULL,'2014-07-14 10:09:22','2014-07-14 10:09:22'),
	(39,9,'Stalins daughter','stalins-daughter','http://www.tobaccofactorytheatres.com/shows/detail/stalins_daughter',1,NULL,'2014-07-14 10:09:55','2014-07-14 10:09:55'),
	(40,9,'Mimic','mimic','http://www.tobaccofactorytheatres.com/shows/detail/mimic',1,NULL,'2014-07-14 10:10:19','2014-07-14 10:10:19'),
	(41,9,'Macbeth','macbeth','http://www.tobaccofactorytheatres.com/shows/detail/macbeth1',1,NULL,'2014-07-14 10:17:39','2014-07-14 10:18:43'),
	(42,9,'Tim Key','tim-key','http://www.tobaccofactorytheatres.com/shows/detail/tim_key_single_white_slut',1,NULL,'2014-07-14 10:19:11','2014-07-14 10:19:11'),
	(43,9,'Mark Steel\'s back in town','mark-steels-back-in-town','http://www.tobaccofactorytheatres.com/shows/detail/mark_steels_back_in_town',1,NULL,'2014-07-14 10:19:56','2014-07-14 10:20:28'),
	(44,9,'Masterclass Quarantine','masterclass-quarantine','http://www.tobaccofactorytheatres.com/plus/events/masterclass_quarantine/',1,NULL,'2014-07-14 10:21:04','2014-07-14 10:21:04'),
	(45,9,'Tom Stade','tom-stade','http://www.tobaccofactorytheatres.com/shows/detail/tom_stade_decisions_decisions_uk_tour',1,NULL,'2014-07-14 10:21:26','2014-07-14 10:21:26'),
	(46,9,'Madame Butterfly','madame-butterfly','http://www.tobaccofactorytheatres.com/shows/detail/puccinis_madame_butterfly',1,NULL,'2014-07-14 10:21:44','2014-07-14 10:21:44'),
	(47,9,'John Shuttleworth','john-shuttleworth','http://www.tobaccofactorytheatres.com/shows/detail/john_shuttleworth_a_wee_ken_to_remember',1,NULL,'2014-07-14 10:22:04','2014-07-14 10:22:04'),
	(48,1,'Scooby Doo: The Mystery of the Pyramid Overview','scooby_doo_the_mystery_of_the_pyramid_overview','http://www.atgtickets.com/shows/scooby-doo/bristol-hippodrome/#overview_tab',1,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(49,1,'Kevins test event','kevins_test_event','http://www.atgtickets.com/venues/bristol-hippodrome/',1,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(51,1,'Wicked','wicked','http://www.atgtickets.com/shows/wicked/bristol-hippodrome/',1,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(52,1,'Kevins new test event','kevins_new_test_event','http://www.atgtickets.com/venues/bristol-hippodrome/',1,NULL,'2014-08-12 12:19:38','2014-08-12 12:19:38');

/*!40000 ALTER TABLE `event` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table event_showtimes
# ------------------------------------------------------------

DROP TABLE IF EXISTS `event_showtimes`;

CREATE TABLE `event_showtimes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `event_id` int(11) DEFAULT NULL,
  `showtime` datetime NOT NULL,
  `showend` datetime NOT NULL,
  `price` decimal(8,2) NOT NULL,
  `venue_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  KEY `venue_id -> venue` (`venue_id`),
  CONSTRAINT `venue_id -> venue` FOREIGN KEY (`venue_id`) REFERENCES `venue` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `event_showtimes` WRITE;
/*!40000 ALTER TABLE `event_showtimes` DISABLE KEYS */;

INSERT INTO `event_showtimes` (`id`, `event_id`, `showtime`, `showend`, `price`, `venue_id`)
VALUES
	(1,1,'2014-08-23 19:30:00','2014-08-23 20:30:00',11.90,1),
	(2,3,'2014-08-24 15:00:00','2014-08-24 16:00:00',18.90,1),
	(3,6,'2014-08-25 19:30:00','2014-08-25 20:30:00',12.90,1),
	(4,7,'2014-08-26 19:30:00','2014-08-26 20:30:00',12.50,1),
	(5,8,'2014-08-27 19:30:00','2014-08-27 20:30:00',14.40,1),
	(6,9,'2014-08-28 20:00:00','2014-08-28 21:00:00',24.40,1),
	(7,10,'2014-08-29 19:30:00','2014-08-29 20:30:00',29.40,1),
	(8,11,'2014-08-30 19:30:00','2014-08-30 20:30:00',16.40,1),
	(9,12,'2014-08-08 19:30:00','2014-08-01 20:30:00',27.40,1),
	(10,13,'2014-08-02 19:30:00','2014-08-02 20:30:00',11.90,1),
	(11,14,'2014-08-03 19:30:00','2014-08-03 20:30:00',21.90,1),
	(12,15,'2014-08-04 19:30:00','2014-08-04 20:30:00',23.90,1),
	(13,16,'2014-08-05 19:30:00','2014-08-05 20:30:00',19.00,1),
	(14,17,'2014-08-06 19:30:00','2014-08-06 20:30:00',10.00,1),
	(15,18,'2014-07-07 19:30:00','2014-08-07 20:30:00',12.50,1),
	(16,19,'2014-08-08 19:30:00','2014-08-08 20:30:00',31.40,1),
	(17,20,'2014-08-09 19:30:00','2014-08-09 20:30:00',15.00,1),
	(18,21,'2014-08-10 19:30:00','2014-08-10 20:30:00',21.40,1),
	(19,22,'2014-08-11 19:00:00','2014-08-11 20:00:00',26.40,1),
	(20,23,'2014-07-12 19:30:00','2014-07-12 20:30:00',28.40,1),
	(21,24,'2014-07-13 19:30:00','2014-07-13 20:30:00',19.00,1),
	(22,25,'2014-07-14 19:30:00','2014-07-14 20:30:00',22.40,1),
	(23,26,'2014-07-15 19:30:00','2014-07-15 20:30:00',38.90,1),
	(24,27,'2014-08-08 20:00:00','2014-08-08 21:00:00',14.99,1),
	(25,28,'2014-08-07 19:30:00','2014-08-07 20:30:00',10.00,1),
	(26,29,'2014-08-09 20:00:00','2014-08-09 21:00:00',10.00,1),
	(27,30,'2014-08-01 20:00:00','2014-08-01 21:00:00',10.00,1),
	(28,31,'2014-08-01 19:30:00','2014-08-01 20:30:00',8.00,1),
	(29,32,'2014-08-01 20:00:00','2014-08-01 21:00:00',10.00,1),
	(30,33,'2014-08-01 20:15:00','2014-08-01 21:15:00',11.00,1),
	(31,34,'2014-08-01 20:00:00','2014-08-01 21:00:00',10.50,1),
	(32,35,'2014-08-01 20:00:00','2014-08-01 21:00:00',10.00,1),
	(33,36,'2014-08-01 19:30:00','2014-08-01 20:30:00',10.00,1),
	(34,37,'2014-08-01 20:00:00','2014-08-01 21:00:00',10.00,1),
	(35,38,'2014-08-01 20:00:00','2014-08-01 21:00:00',8.00,1),
	(36,39,'2014-08-01 19:30:00','2014-08-01 20:30:00',10.00,1),
	(37,40,'2014-08-01 19:30:00','2014-08-01 20:30:00',8.00,1),
	(38,41,'2014-08-01 20:00:00','2014-08-01 21:00:00',10.00,1),
	(39,42,'2014-08-01 20:00:00','2014-07-01 21:00:00',8.00,1),
	(40,43,'2014-08-01 20:00:00','2014-07-01 21:00:00',10.00,1),
	(41,44,'2014-08-01 20:00:00','2014-07-01 21:00:00',10.00,1),
	(42,45,'2014-08-01 20:00:00','2014-07-01 21:00:00',8.00,1),
	(43,46,'2014-07-01 20:00:00','2014-07-01 21:00:00',0.00,1),
	(44,47,'2014-07-01 20:00:00','2014-07-01 21:00:00',8.00,1),
	(45,26,'2014-08-04 18:00:00','2014-08-04 19:00:00',38.90,1),
	(46,26,'2014-08-05 19:30:00','2014-08-05 20:30:00',38.90,1),
	(47,26,'2014-08-06 20:00:00','2014-08-06 21:00:00',38.90,1),
	(48,26,'2014-08-07 19:30:00','2014-08-07 20:30:00',38.90,1),
	(49,26,'2014-08-08 15:30:00','2014-08-08 16:30:00',38.90,1),
	(50,25,'2014-08-04 20:00:00','2014-08-04 21:00:00',22.40,1),
	(51,25,'2014-08-05 21:00:00','2014-08-05 22:00:00',22.40,1),
	(52,25,'2014-08-06 20:00:00','2014-08-06 21:00:00',22.40,1),
	(53,25,'2014-08-07 19:30:00','2014-08-07 20:30:00',22.40,1),
	(54,25,'2014-08-08 20:00:00','2014-08-08 21:00:00',22.40,1),
	(55,24,'2014-08-04 13:00:00','2014-08-04 14:00:00',19.00,1),
	(56,24,'2014-08-05 19:55:00','2014-08-05 20:55:00',19.00,1),
	(57,24,'2014-08-06 19:00:00','2014-08-06 20:00:00',19.00,1),
	(58,24,'2014-08-06 21:00:00','2014-08-06 22:00:00',19.00,1),
	(59,24,'2014-08-07 20:00:00','2014-08-07 21:00:00',19.00,1),
	(60,23,'2014-08-04 20:00:00','2014-08-04 21:00:00',28.40,1),
	(61,23,'2014-08-05 22:00:00','2014-08-05 23:00:00',28.40,1),
	(62,23,'2014-08-06 21:00:00','2014-08-06 22:00:00',28.40,1),
	(63,23,'2014-08-07 19:30:00','2014-08-07 20:30:00',28.40,1),
	(64,23,'2014-08-08 20:00:00','2014-08-08 21:00:00',28.40,1),
	(65,22,'2014-08-04 18:00:00','2014-08-04 19:00:00',26.40,1),
	(66,22,'2014-08-04 19:30:00','2014-08-04 20:30:00',26.40,1),
	(67,22,'2014-08-05 18:00:00','2014-08-05 19:00:00',26.40,1),
	(68,22,'2014-08-06 19:30:00','2014-08-06 20:30:00',26.40,1),
	(69,22,'2014-08-07 20:00:00','2014-08-07 21:00:00',26.40,1),
	(70,22,'2014-08-08 21:00:00','2014-08-08 22:00:00',26.40,1),
	(71,21,'2014-08-04 20:15:00','2014-08-04 21:15:00',21.40,1),
	(72,21,'2014-08-05 21:00:00','2014-08-05 22:00:00',21.40,1),
	(73,21,'2014-08-06 21:15:00','2014-08-06 22:15:00',21.40,1),
	(74,21,'2014-08-07 19:00:00','2014-08-07 20:00:00',21.40,1),
	(75,21,'2014-08-07 21:00:00','2014-08-07 22:00:00',21.40,1),
	(76,17,'2014-08-04 18:45:00','2014-08-04 19:45:00',10.00,1),
	(77,17,'2014-08-05 19:45:00','2014-08-05 20:45:00',10.00,1),
	(78,17,'2014-08-06 20:00:00','2014-08-06 21:00:00',10.00,1),
	(79,17,'2014-08-07 18:30:00','2014-08-07 19:30:00',10.00,1),
	(80,17,'2014-08-08 19:30:00','2014-08-08 20:30:00',10.00,1),
	(81,26,'2014-08-09 14:30:00','2014-08-09 15:30:00',38.90,21),
	(82,48,'2014-08-08 21:10:00','2014-08-07 23:00:00',21.40,1),
	(83,49,'2014-08-11 17:00:00','2014-08-11 19:30:00',14.00,1),
	(84,49,'2014-08-12 17:30:00','2014-08-12 19:30:00',11.00,1),
	(85,49,'2014-08-13 19:30:00','2014-08-13 21:30:00',13.00,1),
	(86,3,'2014-08-25 15:30:00','2014-08-25 16:45:00',14.00,1),
	(87,3,'2014-08-26 16:40:00','2014-08-26 17:45:00',10.00,1),
	(88,3,'2014-08-27 17:30:00','2014-08-27 18:45:00',9.00,1),
	(89,51,'2014-08-18 19:30:00','2014-08-18 21:00:00',20.00,1);

/*!40000 ALTER TABLE `event_showtimes` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table image_type
# ------------------------------------------------------------

DROP TABLE IF EXISTS `image_type`;

CREATE TABLE `image_type` (
  `id` tinyint(4) NOT NULL AUTO_INCREMENT,
  `type` tinyint(4) NOT NULL COMMENT '1 - hero ',
  `title` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `image_type` WRITE;
/*!40000 ALTER TABLE `image_type` DISABLE KEYS */;

INSERT INTO `image_type` (`id`, `type`, `title`)
VALUES
	(1,1,'Hero Image'),
	(2,2,'Top slider'),
	(3,3,'Gallery'),
	(4,4,'ad');

/*!40000 ALTER TABLE `image_type` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table promotion
# ------------------------------------------------------------

DROP TABLE IF EXISTS `promotion`;

CREATE TABLE `promotion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `venue_id` int(11) NOT NULL,
  `valid_from` datetime NOT NULL,
  `valid_to` datetime NOT NULL,
  `details` text NOT NULL,
  `terms` text NOT NULL,
  `code` varchar(100) NOT NULL,
  `template` text NOT NULL,
  `upper_limit` int(11) NOT NULL,
  `is_active` tinyint(4) DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `provider_id -> provider` (`venue_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table search
# ------------------------------------------------------------

DROP TABLE IF EXISTS `search`;

CREATE TABLE `search` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `term` varchar(30) NOT NULL,
  `count` int(11) NOT NULL,
  `max_results` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `search` WRITE;
/*!40000 ALTER TABLE `search` DISABLE KEYS */;

INSERT INTO `search` (`id`, `term`, `count`, `max_results`, `created_at`, `updated_at`)
VALUES
	(1,'Bristol',79,28,'2014-07-31 16:16:50','2014-08-08 17:28:29'),
	(2,'nvnerovenv',1,0,'2014-08-04 12:47:17','2014-08-04 12:47:17'),
	(3,'nerngnrevner',1,0,'2014-08-04 12:48:45','2014-08-04 12:48:45'),
	(4,'mkkkmkmk',3,0,'2014-08-04 12:52:34','2014-08-04 12:53:11'),
	(5,'vherigviern',1,0,'2014-08-04 12:54:44','2014-08-04 12:54:44'),
	(6,'nv',1,3,'2014-08-04 12:54:51','2014-08-04 12:54:51'),
	(7,'fish',1,1,'2014-08-04 15:44:46','2014-08-04 15:44:46'),
	(8,'search',1,0,'2014-08-04 16:05:34','2014-08-04 16:05:34'),
	(9,'Giigfg',1,0,'2014-08-05 11:35:55','2014-08-05 11:35:55'),
	(10,'Hchxxgv',1,0,'2014-08-05 11:40:27','2014-08-05 11:40:27'),
	(11,'Hdhdjd',2,0,'2014-08-05 11:51:39','2014-08-05 11:52:18'),
	(12,'design',1,1,'2014-08-05 21:19:11','2014-08-05 21:19:11'),
	(13,'hippo',1,1,'2014-08-08 16:19:17','2014-08-08 16:19:17'),
	(14,'scoo',1,1,'2014-08-08 16:23:08','2014-08-08 16:23:08'),
	(15,'kev',1,3,'2014-08-08 16:25:13','2014-08-08 16:25:13');

/*!40000 ALTER TABLE `search` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table sponsor
# ------------------------------------------------------------

DROP TABLE IF EXISTS `sponsor`;

CREATE TABLE `sponsor` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `image_id` int(11) DEFAULT NULL,
  `title` varchar(100) NOT NULL,
  `url` varchar(150) NOT NULL,
  `sponsor_type` int(11) DEFAULT NULL,
  `display_start` datetime DEFAULT NULL,
  `display_end` datetime DEFAULT NULL,
  `is_active` tinyint(4) NOT NULL DEFAULT '1',
  `impressions` int(11) DEFAULT NULL,
  `clicks` int(11) DEFAULT NULL,
  `is_mobile` tinyint(4) DEFAULT NULL,
  `is_tablet` tinyint(4) DEFAULT NULL,
  `is_desktop` tinyint(4) DEFAULT NULL,
  `is_deleted` tinyint(4) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sponsor -> image_idx` (`image_id`),
  KEY `sponsor_type -> type id` (`sponsor_type`),
  CONSTRAINT `sponsor_ibfk_1` FOREIGN KEY (`sponsor_type`) REFERENCES `sponsor_type` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `sponsor -> image` FOREIGN KEY (`image_id`) REFERENCES `asset` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `sponsor` WRITE;
/*!40000 ALTER TABLE `sponsor` DISABLE KEYS */;

INSERT INTO `sponsor` (`id`, `image_id`, `title`, `url`, `sponsor_type`, `display_start`, `display_end`, `is_active`, `impressions`, `clicks`, `is_mobile`, `is_tablet`, `is_desktop`, `is_deleted`, `created_at`, `updated_at`)
VALUES
	(1,275,'1','http://www.bristol247.com/',1,'2014-08-05 00:00:01','2014-09-30 23:59:59',1,NULL,NULL,NULL,NULL,NULL,NULL,'2014-08-04 13:56:23','2014-08-05 02:02:02'),
	(2,276,'2','http://www.bristol247.com/',1,'2014-08-05 00:00:01','2014-09-30 23:59:59',1,NULL,NULL,NULL,NULL,NULL,NULL,'2014-08-05 02:02:31','2014-08-05 02:03:06'),
	(3,277,'1','http://www.bristol247.com/',1,'2014-08-05 00:00:01','2014-09-30 23:59:59',1,NULL,NULL,NULL,NULL,NULL,NULL,'2014-08-05 02:04:03','2014-08-05 02:04:26'),
	(4,278,'4','http://www.bristol247.com/',1,'2014-08-05 00:00:01','2014-09-30 23:59:59',1,NULL,NULL,NULL,NULL,NULL,NULL,'2014-08-05 02:04:34','2014-08-05 02:05:35'),
	(5,279,'5','http://www.bristol247.com/',1,'2014-08-05 00:00:01','2014-09-30 23:59:59',1,NULL,NULL,NULL,NULL,NULL,NULL,'2014-08-05 02:05:44','2014-08-05 02:06:10'),
	(6,280,'6','http://www.bristol247.com/',1,'2014-08-05 00:00:01','2014-09-30 23:59:59',1,NULL,NULL,NULL,NULL,NULL,NULL,'2014-08-05 02:06:18','2014-08-05 02:06:39'),
	(7,281,'7','http://www.bristol247.com/',1,'2014-08-05 00:00:01','2014-09-30 23:59:59',1,NULL,NULL,NULL,NULL,NULL,NULL,'2014-08-05 02:06:54','2014-08-05 02:07:19'),
	(8,282,'8','http://www.bristol247.com/',1,'2014-08-05 00:00:01','2014-09-30 23:59:59',1,NULL,NULL,NULL,NULL,NULL,NULL,'2014-08-05 02:07:27','2014-08-05 02:07:55'),
	(9,283,'9','http://www.bristol247.com/',1,'2014-08-05 00:00:01','2014-09-30 23:59:59',1,NULL,NULL,NULL,NULL,NULL,NULL,'2014-08-05 02:08:00','0000-00-00 00:00:00'),
	(10,284,'10','http://www.bristol247.com/',1,'2014-08-05 00:00:01','2014-09-30 23:59:59',1,NULL,NULL,NULL,NULL,NULL,NULL,'2014-08-05 02:08:42','2014-08-05 02:09:07'),
	(11,285,'11','http://www.bristol247.com/',1,'2014-08-05 00:00:01','2014-09-30 23:59:59',1,NULL,NULL,NULL,NULL,NULL,NULL,'2014-08-05 02:09:23','2014-08-05 02:09:46'),
	(12,286,'12','http://www.bristol247.com/',1,'2014-08-05 00:00:01','2014-09-30 23:59:59',1,NULL,NULL,NULL,NULL,NULL,NULL,'2014-08-05 02:10:01','2014-08-05 02:10:35'),
	(13,287,'13','http://www.bristol247.com/',1,'2014-08-05 00:00:01','2014-09-30 23:59:59',1,NULL,NULL,NULL,NULL,NULL,NULL,'2014-08-05 02:10:43','2014-08-05 02:11:10'),
	(14,288,'14','http://www.bristol247.com/',1,'2014-08-05 00:00:01','2014-09-30 23:59:59',1,NULL,NULL,NULL,NULL,NULL,NULL,'2014-08-05 02:11:39','2014-08-05 02:12:07'),
	(15,289,'15','http://www.bristol247.com/',1,'2014-08-05 00:00:01','2014-09-30 23:59:59',1,NULL,NULL,NULL,NULL,NULL,NULL,'2014-08-05 02:12:13','2014-08-05 02:12:42'),
	(16,290,'16','http://www.bristol247.com/',1,'2014-08-05 00:00:01','2014-09-30 23:59:59',1,NULL,NULL,NULL,NULL,NULL,NULL,'2014-08-05 02:13:03','2014-08-05 02:13:29'),
	(17,291,'17','http://www.bristol247.com/',1,'2014-08-05 00:00:01','2014-09-30 23:59:59',1,NULL,NULL,NULL,NULL,NULL,NULL,'2014-08-05 02:13:35','2014-08-05 02:14:01'),
	(18,292,'18','http://www.bristol247.com/',1,'2014-08-05 00:00:01','2014-09-30 23:59:59',1,NULL,NULL,NULL,NULL,NULL,NULL,'2014-08-05 02:14:08','2014-08-05 02:14:38'),
	(19,294,'19','http://www.bristol247.com/',1,'2014-08-05 00:00:01','2014-09-25 23:59:59',1,NULL,NULL,NULL,NULL,NULL,NULL,'2014-08-05 02:14:59','0000-00-00 00:00:00'),
	(20,295,'20','http://www.bristol247.com/',1,'2014-08-05 00:00:01','2014-09-26 23:59:59',1,NULL,NULL,NULL,NULL,NULL,NULL,'2014-08-05 02:16:04','2014-08-05 02:16:31'),
	(21,297,'21','http://www.bristol247.com/',1,'2014-08-05 00:00:01','2014-09-27 23:59:59',1,NULL,NULL,NULL,NULL,NULL,NULL,'2014-08-05 02:16:36','0000-00-00 00:00:00'),
	(22,298,'22','http://www.bristol247.com/',1,'2014-08-05 00:00:01','2014-09-30 23:59:59',1,NULL,NULL,NULL,NULL,NULL,NULL,'2014-08-05 02:17:48','2014-08-05 02:18:18'),
	(23,301,'23','http://www.bristol247.com/',1,'2014-08-05 00:00:01','2014-09-18 23:59:59',1,NULL,NULL,NULL,NULL,NULL,NULL,'2014-08-05 02:18:24','0000-00-00 00:00:00'),
	(24,302,'24','http://www.bristol247.com/',1,'2014-08-05 00:00:01','2014-09-29 23:59:59',1,NULL,NULL,NULL,NULL,NULL,NULL,'2014-08-05 02:19:45','2014-08-05 02:20:14'),
	(25,303,'25','http://www.bristol247.com/',1,'2014-08-05 00:00:01','2014-09-28 23:59:59',1,NULL,NULL,NULL,NULL,NULL,NULL,'2014-08-05 02:20:17','2014-08-05 02:20:40'),
	(26,304,'26','http://www.bristol247.com/',1,'2014-08-05 00:00:01','2014-09-29 23:59:59',1,NULL,NULL,NULL,NULL,NULL,NULL,'2014-08-05 02:20:47','2014-08-05 02:21:18'),
	(27,305,'27','http://www.bristol247.com/',1,'2014-08-05 00:00:01','2014-09-26 23:59:59',1,NULL,NULL,NULL,NULL,NULL,NULL,'2014-08-05 02:27:01','2014-08-05 02:27:27'),
	(28,306,'28','http://www.bristol247.com/',1,'2014-08-05 00:00:01','2014-09-25 23:59:59',1,NULL,NULL,NULL,NULL,NULL,NULL,'2014-08-05 02:27:35','2014-08-05 02:27:57'),
	(29,307,'29','http://www.bristol247.com/',1,'2014-08-05 00:00:01','2014-09-26 23:59:59',1,NULL,NULL,NULL,NULL,NULL,NULL,'2014-08-05 02:28:02','2014-08-05 02:28:24'),
	(30,308,'30','http://www.bristol247.com/',1,'2014-08-05 00:00:01','2014-09-25 23:59:59',1,NULL,NULL,NULL,NULL,NULL,NULL,'2014-08-05 02:28:27','2014-08-05 02:28:54'),
	(31,309,'31','http://www.bristol247.com/',1,'2014-08-05 00:00:01','2014-09-25 23:59:59',1,NULL,NULL,NULL,NULL,NULL,NULL,'2014-08-05 02:28:59','2014-08-05 02:29:20'),
	(32,310,'32','http://www.bristol247.com/',1,'2014-08-05 00:00:01','2014-09-24 23:59:59',1,NULL,NULL,NULL,NULL,NULL,NULL,'2014-08-05 02:29:26','2014-08-05 02:29:47'),
	(33,311,'33','http://www.bristol247.com/',1,'2014-08-05 00:00:01','2014-09-27 23:59:59',1,NULL,NULL,NULL,NULL,NULL,NULL,'2014-08-05 02:29:54','2014-08-05 02:30:19'),
	(34,312,'34','http://www.bristol247.com/',1,'2014-08-05 00:00:01','2014-09-26 23:59:59',1,NULL,NULL,NULL,NULL,NULL,NULL,'2014-08-05 02:30:25','2014-08-05 02:30:51'),
	(35,313,'35','http://www.bristol247.com/',1,'2014-08-05 00:00:01','2014-09-25 23:59:59',1,NULL,NULL,NULL,NULL,NULL,NULL,'2014-08-05 02:30:58','2014-08-05 02:31:20'),
	(36,314,'36','http://www.bristol247.com/',1,'2014-08-05 00:00:01','2014-09-18 23:59:59',1,NULL,NULL,NULL,NULL,NULL,NULL,'2014-08-05 02:31:24','2014-08-05 02:31:46'),
	(37,315,'37','http://www.bristol247.com/',2,'2014-08-05 00:00:01','2014-09-26 23:59:59',1,NULL,NULL,NULL,NULL,NULL,NULL,'2014-08-05 04:15:14','0000-00-00 00:00:00'),
	(38,316,'38','http://www.bristol247.com/',2,'2014-08-05 00:00:01','2014-09-26 23:59:59',1,NULL,NULL,NULL,NULL,NULL,NULL,'2014-08-05 04:27:19','2014-08-05 04:27:42'),
	(39,317,'39','http://www.bristol247.com/',2,'2014-08-05 00:00:01','2014-09-25 23:59:59',1,NULL,NULL,NULL,NULL,NULL,NULL,'2014-08-05 04:27:48','2014-08-05 04:28:10'),
	(40,318,'40','http://www.bristol247.com/',2,'2014-08-05 00:00:01','2014-09-25 23:59:59',1,NULL,NULL,NULL,NULL,NULL,NULL,'2014-08-05 04:28:15','2014-08-05 04:28:36'),
	(41,319,'41','http://www.bristol247.com/',2,'2014-08-05 00:00:01','2014-09-19 23:59:59',1,NULL,NULL,NULL,NULL,NULL,NULL,'2014-08-05 04:28:39','2014-08-05 04:28:59'),
	(42,320,'42','http://www.bristol247.com/',2,'2014-08-05 00:00:01','2014-09-25 23:59:59',1,NULL,NULL,NULL,NULL,NULL,NULL,'2014-08-05 04:29:05','2014-08-05 04:29:34'),
	(43,321,'43','http://www.bristol247.com/',2,'2014-08-05 00:00:01','2014-09-26 23:59:59',1,NULL,NULL,NULL,NULL,NULL,NULL,'2014-08-05 04:29:38','2014-08-05 04:30:03'),
	(44,322,'44','http://www.bristol247.com/',2,'2014-08-05 00:00:01','2014-09-18 23:59:59',1,NULL,NULL,NULL,NULL,NULL,NULL,'2014-08-05 04:30:07','2014-08-05 04:30:32'),
	(45,323,'45','http://www.bristol247.com/',2,'2014-08-05 00:00:01','2014-09-26 23:59:59',1,NULL,NULL,NULL,NULL,NULL,NULL,'2014-08-05 04:30:36','2014-08-05 04:31:00'),
	(46,324,'46','http://www.bristol247.com/',2,'2014-08-05 00:00:01','2014-09-26 23:59:59',1,NULL,NULL,NULL,NULL,NULL,NULL,'2014-08-05 04:31:04','2014-08-05 04:31:26'),
	(47,325,'47','http://www.bristol247.com/',2,'2014-08-05 00:00:01','2014-09-26 23:59:59',1,NULL,NULL,NULL,NULL,NULL,NULL,'2014-08-05 04:31:31','2014-08-05 04:32:04'),
	(48,326,'48','http://www.bristol247.com/',2,'2014-08-05 00:00:01','2014-09-25 23:59:59',1,NULL,NULL,NULL,NULL,NULL,NULL,'2014-08-05 04:32:09','2014-08-05 04:32:34'),
	(49,327,'49','http://www.bristol247.com/',2,'2014-08-05 00:00:01','2014-09-26 23:59:59',1,NULL,NULL,NULL,NULL,NULL,NULL,'2014-08-05 04:32:36','2014-08-05 04:33:03'),
	(50,328,'50','http://www.bristol247.com/',2,'2014-08-05 00:00:01','2014-09-18 23:59:59',1,NULL,NULL,NULL,NULL,NULL,NULL,'2014-08-05 04:33:08','2014-08-05 04:33:37'),
	(51,329,'51','http://www.bristol247.com/',2,'2014-08-05 00:00:01','2014-09-19 23:59:59',1,NULL,NULL,NULL,NULL,NULL,NULL,'2014-08-05 04:33:40','2014-08-05 04:34:01'),
	(52,330,'52','http://www.bristol247.com/',2,'2014-08-05 00:00:01','2014-09-24 23:59:59',1,NULL,NULL,NULL,NULL,NULL,NULL,'2014-08-05 04:34:11','2014-08-05 04:34:46'),
	(53,331,'53','http://www.bristol247.com/',2,'2014-08-05 00:00:01','2014-09-19 23:59:59',1,NULL,NULL,NULL,NULL,NULL,NULL,'2014-08-05 04:34:53','2014-08-05 04:35:18'),
	(54,332,'54','http://www.bristol247.com/',2,'2014-08-05 00:00:01','2014-09-19 23:59:59',1,NULL,NULL,NULL,NULL,NULL,NULL,'2014-08-05 04:35:28','2014-08-05 04:35:59'),
	(55,333,'55','http://www.bristol247.com/',2,'2014-08-05 00:00:01','2014-09-26 23:59:59',1,NULL,NULL,NULL,NULL,NULL,NULL,'2014-08-05 04:36:01','2014-08-05 04:36:24'),
	(56,334,'56','http://www.bristol247.com/',2,'2014-08-05 00:00:01','2014-09-26 23:59:59',1,NULL,NULL,NULL,NULL,NULL,NULL,'2014-08-05 04:36:27','2014-08-05 04:36:49'),
	(57,335,'57','http://www.bristol247.com/',2,'2014-08-05 00:00:01','2014-09-25 23:59:59',1,NULL,NULL,NULL,NULL,NULL,NULL,'2014-08-05 04:37:03','2014-08-05 04:37:34'),
	(58,336,'58','http://www.bristol247.com/',2,'2014-08-05 00:00:01','2014-09-19 23:59:59',1,NULL,NULL,NULL,NULL,NULL,NULL,'2014-08-05 04:37:40','2014-08-05 04:38:03'),
	(59,337,'59','http://www.bristol247.com/',2,'2014-08-05 00:00:01','2014-09-26 23:59:59',1,NULL,NULL,NULL,NULL,NULL,NULL,'2014-08-05 04:38:08','2014-08-05 04:38:31'),
	(60,340,'60','http://www.bristol247.com/',2,'2014-08-05 00:00:01','2014-09-26 23:59:59',1,NULL,NULL,NULL,NULL,NULL,NULL,'2014-08-05 04:38:38','0000-00-00 00:00:00'),
	(61,341,'61','http://www.bristol247.com/',2,'2014-08-05 00:00:01','2014-09-26 23:59:59',1,NULL,NULL,NULL,NULL,NULL,NULL,'2014-08-05 04:39:30','2014-08-05 04:39:50'),
	(62,NULL,'','',NULL,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,'2014-08-08 15:19:11','2014-08-08 15:19:11');

/*!40000 ALTER TABLE `sponsor` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table sponsor_location
# ------------------------------------------------------------

DROP TABLE IF EXISTS `sponsor_location`;

CREATE TABLE `sponsor_location` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sponsor_id` int(11) NOT NULL,
  `channel_id` int(11) DEFAULT NULL,
  `sub_channel_id` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  KEY `sponsor_id -> sponsor` (`sponsor_id`),
  KEY `channel_id -> channel` (`channel_id`),
  KEY `sub_channel_id -> channel` (`sub_channel_id`),
  CONSTRAINT `sponsor -> sponsor_id` FOREIGN KEY (`sponsor_id`) REFERENCES `sponsor` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `channel -> channel_id` FOREIGN KEY (`channel_id`) REFERENCES `channel` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `sub_channel -> channel_id` FOREIGN KEY (`sub_channel_id`) REFERENCES `channel` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `sponsor_location` WRITE;
/*!40000 ALTER TABLE `sponsor_location` DISABLE KEYS */;

INSERT INTO `sponsor_location` (`id`, `sponsor_id`, `channel_id`, `sub_channel_id`, `category_id`)
VALUES
	(7,1,1,4,1),
	(8,2,1,4,1),
	(9,3,1,4,1),
	(10,4,1,4,1),
	(11,5,1,4,1),
	(12,6,1,4,1),
	(13,7,1,4,2),
	(14,8,1,4,2),
	(15,9,1,4,2),
	(16,10,1,4,2),
	(17,11,1,4,2),
	(18,12,1,5,3),
	(19,13,1,5,3),
	(20,14,1,5,3),
	(21,15,1,5,3),
	(22,16,1,5,3),
	(23,17,1,5,4),
	(24,18,1,5,4),
	(25,19,1,5,4),
	(26,20,1,5,4),
	(27,21,1,5,4),
	(28,22,2,6,5),
	(29,23,2,6,5),
	(30,24,2,6,5),
	(31,25,2,6,5),
	(32,26,2,6,5),
	(33,27,3,7,6),
	(34,28,3,7,6),
	(35,29,3,7,6),
	(36,30,3,7,6),
	(37,31,3,7,6),
	(38,32,3,8,7),
	(39,33,3,8,7),
	(40,34,3,8,7),
	(41,35,3,8,7),
	(42,36,3,8,7),
	(43,37,1,4,1),
	(44,38,1,4,1),
	(45,39,1,4,1),
	(46,40,1,4,1),
	(47,41,1,4,1),
	(48,42,1,4,2),
	(49,43,1,4,2),
	(50,44,1,4,2),
	(51,45,1,4,2),
	(52,46,1,4,2),
	(53,47,1,5,3),
	(54,48,1,5,3),
	(55,49,1,5,3),
	(56,50,1,5,3),
	(57,51,1,5,3),
	(58,52,1,5,4),
	(59,53,1,5,4),
	(60,54,1,5,4),
	(61,55,1,5,4),
	(62,56,1,5,4),
	(63,57,2,6,5),
	(64,58,2,6,5),
	(65,59,2,6,5),
	(66,60,2,6,5),
	(67,61,2,6,5);

/*!40000 ALTER TABLE `sponsor_location` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table sponsor_type
# ------------------------------------------------------------

DROP TABLE IF EXISTS `sponsor_type`;

CREATE TABLE `sponsor_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(45) DEFAULT NULL COMMENT '1) Letterbox',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `sponsor_type` WRITE;
/*!40000 ALTER TABLE `sponsor_type` DISABLE KEYS */;

INSERT INTO `sponsor_type` (`id`, `type`)
VALUES
	(1,'letterbox'),
	(2,'mpu');

/*!40000 ALTER TABLE `sponsor_type` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table user
# ------------------------------------------------------------

DROP TABLE IF EXISTS `user`;

CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `access_key` varchar(45) NOT NULL COMMENT '''This is the unique identifier for making API requests. It is also used as the salt for verifying the user\\''s password''',
  `first_name` varchar(75) NOT NULL,
  `last_name` varchar(75) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(65) NOT NULL,
  `originating_ip` varchar(30) DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `last_login_ip` varchar(30) DEFAULT NULL,
  `is_active` tinyint(4) DEFAULT NULL,
  `is_deleted` tinyint(4) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;

INSERT INTO `user` (`id`, `access_key`, `first_name`, `last_name`, `email`, `password`, `originating_ip`, `last_login`, `last_login_ip`, `is_active`, `is_deleted`, `created_at`, `updated_at`)
VALUES
	(2,'B0368EF69C3EC9B','Foo','Bar','ben+1407768068@calvium.com','$2y$10$ZR4xXsRR0HBYc03nx8k7veH42IBSRijUjlp.MC68g48vehVvxvrhC',NULL,NULL,NULL,NULL,NULL,'2014-08-11 15:41:08','2014-08-11 15:41:08'),
	(3,'E965DB3028A93A5','Foo','Bar','ben+1407768099@calvium.com','$2y$10$XNnQkYzfRYE77m/n0GusHu9VW.BfCz2O6d806jdQ11ps/kx1Oy7pm',NULL,NULL,NULL,NULL,NULL,'2014-08-11 15:41:38','2014-08-11 15:41:38'),
	(4,'BDB9DE94BA81613','Foo','Bar','ben+1407768153@calvium.com','$2y$10$h.NQv1d7MUcHRL6NnncyXeyV4sIXLcH7CMYBEYFIdGiRLamLPIOFS',NULL,NULL,NULL,NULL,NULL,'2014-08-11 15:42:33','2014-08-11 15:42:33'),
	(5,'49E850DF453570E','Foo','Bar','ben+1407768174@calvium.com','$2y$10$lBfU0fYI3Wb31xQo/Y/H2.S0zotAhhaDq7BdSthkVyOo6Nro34C9C',NULL,NULL,NULL,NULL,NULL,'2014-08-11 15:42:53','2014-08-11 15:42:53'),
	(6,'A2334637304BF91','Foo','Bar','ben+1407768214@calvium.com','$2y$10$m99FzCX.Et8O0VihawRgdOHWhhqF6nVSgprdKftAupjxm0Gbhyiwa',NULL,NULL,NULL,NULL,NULL,'2014-08-11 15:43:33','2014-08-11 15:43:33'),
	(7,'8DFEC14A5C2D659','David','Scholes','david@yepyep.co.uk','$2y$10$hSWW0Ts4zj51kqH1rvsCqeHzvh7sdCRIM7/LMARzVu3Rz9.xNAN/G',NULL,NULL,NULL,NULL,NULL,'2014-08-13 10:37:14','2014-08-13 10:37:14'),
	(8,'B1931152F2D30C4','David','Scholes','p.schneider1@yahoo.co.uk','$2y$10$1De66OSEp9rsRq9gIq3oMu1PaAEmEcAI5k8rxhkTTBujB3Ed3/ZPa',NULL,NULL,NULL,NULL,NULL,'2014-08-13 10:38:27','2014-08-13 10:38:27'),
	(9,'74B01323819DFDF','Pablo','Carrillo','pablo+1@gmail.com','$2y$10$oCv1B7ISBIIf.s2zPXo0.u3m7Hs2CGudmRYjdq7uv1tXaY41QCBJK',NULL,NULL,NULL,NULL,NULL,'2014-08-13 10:42:21','2014-08-13 10:42:21');

/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table user_article
# ------------------------------------------------------------

DROP TABLE IF EXISTS `user_article`;

CREATE TABLE `user_article` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `article_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `pw_hash -> article_idx` (`article_id`),
  KEY `article -> user_idx` (`user_id`),
  CONSTRAINT `user -> article` FOREIGN KEY (`article_id`) REFERENCES `article` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `article -> user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table user_competition_answer
# ------------------------------------------------------------

DROP TABLE IF EXISTS `user_competition_answer`;

CREATE TABLE `user_competition_answer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `competition_id` int(11) NOT NULL,
  `competition_answer_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table user_inactive_category
# ------------------------------------------------------------

DROP TABLE IF EXISTS `user_inactive_category`;

CREATE TABLE `user_inactive_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `sub_channel_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_cat -> cat_idx` (`category_id`),
  KEY `cat -> user_idx` (`user_id`),
  KEY `cat -> sc_idx` (`sub_channel_id`),
  CONSTRAINT `user_cat -> cat` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `cat -> user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `cat -> sc` FOREIGN KEY (`sub_channel_id`) REFERENCES `channel` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table user_inactive_channel
# ------------------------------------------------------------

DROP TABLE IF EXISTS `user_inactive_channel`;

CREATE TABLE `user_inactive_channel` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `channel_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `channel -> user_idx` (`user_id`),
  KEY `user -> channel _idx` (`channel_id`),
  CONSTRAINT `channel -> user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `user -> channel ` FOREIGN KEY (`channel_id`) REFERENCES `channel` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table user_profile
# ------------------------------------------------------------

DROP TABLE IF EXISTS `user_profile`;

CREATE TABLE `user_profile` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `age_group_id` int(11) DEFAULT NULL,
  `nickname` varchar(45) DEFAULT NULL,
  `facebook` varchar(75) DEFAULT NULL,
  `twitter` varchar(75) DEFAULT NULL,
  `postcode` varchar(15) DEFAULT NULL,
  `lat` varchar(20) DEFAULT NULL,
  `lon` varchar(20) DEFAULT NULL,
  `area` varchar(75) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `profile -> user_idx` (`user_id`),
  KEY `user->age_idx` (`age_group_id`),
  CONSTRAINT `profile -> user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `user->age` FOREIGN KEY (`age_group_id`) REFERENCES `age_group` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table user_redeemed_promotion
# ------------------------------------------------------------

DROP TABLE IF EXISTS `user_redeemed_promotion`;

CREATE TABLE `user_redeemed_promotion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `promotion_id` int(11) NOT NULL,
  `requested_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `user_id ->user` (`user_id`),
  CONSTRAINT `user_redeemed_promotion_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table venue
# ------------------------------------------------------------

DROP TABLE IF EXISTS `venue`;

CREATE TABLE `venue` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `sef_name` varchar(100) DEFAULT NULL,
  `address_line_1` varchar(50) NOT NULL,
  `address_line_2` varchar(50) NOT NULL,
  `address_line_3` varchar(50) DEFAULT NULL,
  `postcode` varchar(15) NOT NULL,
  `email` varchar(150) DEFAULT NULL,
  `lat` varchar(20) DEFAULT NULL,
  `lon` varchar(20) DEFAULT NULL,
  `area` varchar(75) DEFAULT NULL,
  `facebook` varchar(75) DEFAULT NULL,
  `twitter` varchar(75) DEFAULT NULL,
  `phone` varchar(30) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `is_active` tinyint(4) NOT NULL DEFAULT '1',
  `is_deleted` tinyint(4) DEFAULT NULL,
  `is_directory` tinyint(1) NOT NULL,
  `website` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `venue` WRITE;
/*!40000 ALTER TABLE `venue` DISABLE KEYS */;

INSERT INTO `venue` (`id`, `name`, `sef_name`, `address_line_1`, `address_line_2`, `address_line_3`, `postcode`, `email`, `lat`, `lon`, `area`, `facebook`, `twitter`, `phone`, `created_at`, `updated_at`, `is_active`, `is_deleted`, `is_directory`, `website`)
VALUES
	(1,'Bristol Hippodrome','bristol-hippodrome','St Augustines Parade','945 Finn Pass','Bristol','BS1 4UZ','trishhodson@theambassadors.com',NULL,NULL,NULL,'BristolHippodrome','BristolHipp','0844 871 7615','2014-05-22 14:10:04','2014-07-04 14:58:48',1,NULL,0,''),
	(2,'Cineworld','cineworld','Hengrove Leisure Pk','Hengrove Way','Bristol','BS14 0HR','katrine24@mitchell.com',NULL,NULL,NULL,'cineworld','cineworld','0844 815 7747','2014-06-10 07:35:11','2014-07-04 15:20:17',1,NULL,0,''),
	(3,'Odeon Bristol','odeon-bristol','Union St','Bristol','Avon','BS1 2DS','lhilll@gmail.com',NULL,NULL,NULL,'odeon','ODEONCinemas','0871 224 4007','2014-06-10 07:42:10','2014-07-04 15:26:25',1,NULL,0,''),
	(4,'Showcase Bristol Cinema de Lux','showcase-bristol-cinema-de-lux','Glass House','Cabot Circus','Bristol','BS1 3BX','ukcs@national-amusements.com',NULL,NULL,NULL,'ShowcaseCinemasUK','showcasecinemas','0871 220 1000','2014-06-10 07:42:13','2014-07-04 15:28:03',1,NULL,0,''),
	(5,'Vue Bristol Longwell Green','vue-bristol-longwell-green','Aspects Leisure Park - Unit 2','Avon Ring Road, Longwell Green','Bristol','BS15 9LA','brionna69@veumritchie.info',NULL,NULL,NULL,'vuecinemas','vuecinemas','08712 240 240','2014-06-10 07:42:17','2014-07-04 15:33:01',1,NULL,0,''),
	(6,'Vue Bristol Cribbs Causeway','vue-bristol-cribbs-causeway','The Venue, Cribbs Causeway','Merlin Road','Bristol','BS10 7SR','benton.rempel@kossdenesik.com',NULL,NULL,NULL,'vuecinemas','vuecinemas','08712 240 240','2014-07-04 15:34:44','2014-07-04 15:34:44',1,NULL,0,''),
	(7,'The Little Black Box Theatre','the-little-black-box-theatre','2 Chandos Road','Bristol','Jaskolskiburgh','BS6 6PE','info@thelittleblackbox.net',NULL,NULL,NULL,'tlbbbristol','BlackBoxBristol','0117 909 9399','2014-07-04 15:50:39','2014-07-04 15:50:39',1,NULL,0,''),
	(8,'Bristol Old Vic Theatre','bristol-old-vic-theatre','King Street','Old City','Bristol','BS1 4ED','stagedoor@bristololdvic.org.uk',NULL,NULL,NULL,'bristololdvic','BristolOldVic','0117 987 7877','2014-07-04 15:52:55','2014-07-04 15:52:55',1,NULL,0,''),
	(9,'Tobacco Factory Theatres','tobacco-factory-theatres','Raleigh Road','Southville','Bristol','BS3 1TF','tickets@tobaccofactorytheatres.com',NULL,NULL,NULL,'tobaccofactorytheatres','tftheatres','0117 9020345','2014-07-04 15:56:01','2014-07-04 15:56:01',1,NULL,0,''),
	(11,'The Greenbank pub Bristol','the_greenbank_pub_bristol','57 Belle vue road','Easton','Bristol','BS56dp','INFO@THEGREENBANKBRISTOL.CO.UK','51.4676893','-2.5615691000000425',NULL,'https://www.facebook.com/nick.pennock.33','https://twitter.com/GreenbankEaston','0117 939 3771','0000-00-00 00:00:00','0000-00-00 00:00:00',0,NULL,0,'http://thegreenbankbristol.co.uk/'),
	(14,'Piazza di Roma','piazza_di_roma','178 Whiteladies Road','Clifton','Bristol','BS8 2XU','','51.4703224','-2.615590099999963',NULL,'https://www.facebook.com/PiazzadiRoma','','','0000-00-00 00:00:00','0000-00-00 00:00:00',0,NULL,0,'http://www.piazzadiroma.co.uk'),
	(15,'Cibo Restaurant','cibo_restaurant','289 Gloucester Rd','Bristol','','BS7 8NY','info@ciboristorante.co.uk','51.479171','-2.589170500000023',NULL,'https://www.facebook.com/pages/CIBO-Ristorante/123782687639956','https://twitter.com/Cibo_Bristol','0117 942 9475','0000-00-00 00:00:00','0000-00-00 00:00:00',0,NULL,0,'http://www.ciboristorante.co.uk'),
	(16,'Europa','europa','37-38 St. Stephens Street','Bristol','','BS1 1JX','europaitalianrestaurant@btconnect.com','51.4536968','-2.594699799999944',NULL,'https://www.facebook.com/europarestaurantbristol','','0117 929 7818','0000-00-00 00:00:00','0000-00-00 00:00:00',0,NULL,0,'www.europarestaurant.co.uk'),
	(17,'The Old Police Station','the-old-police-station','The Old Police Station, 6 St Peterâs Court','Bottelinoâs','Bristol','BS3 4AQ','','51.4440711','-2.593840900000032',NULL,'','','0117 966 6676','0000-00-00 00:00:00','0000-00-00 00:00:00',0,NULL,0,'http://www.bottelinos.net/'),
	(18,'Mamma Mia','mamma_mia','10a Park Row','','Bristol','BS1 5LJ','','51.4552938','-2.6006790000000137',NULL,'','','0117 926 8891','0000-00-00 00:00:00','0000-00-00 00:00:00',0,NULL,0,'www.mammamiabristol.co.uk'),
	(19,'Coronation Curry House','coronation_curry_house','190 Coronation Road','','Bristol','BS3 1RF','','51.4457853','-2.610223700000006',NULL,'','','0117 966 4569','0000-00-00 00:00:00','0000-00-00 00:00:00',0,NULL,0,''),
	(20,'The Raj Indian Restaurant','the_raj_indian_restaurant','35 King Street','','Bristol','BS1 4DZ','','51.45194249999999','-2.59487850000005',NULL,'','','0117 929 1132','0000-00-00 00:00:00','0000-00-00 00:00:00',0,NULL,0,'http://www.raj-bristol.co.uk'),
	(21,'4,500 Miles From Delhi','4500_miles_from_delhi','8 Colston Avenue','','Bristol','BS1 4ST','','51.4539205','-2.5966743999999835',NULL,'','','0117 929 2224','0000-00-00 00:00:00','0000-00-00 00:00:00',0,NULL,0,'http://4500miles.co.uk/bristol'),
	(22,'Namaskar Lounge','namaskar_lounge','Welsh Back','','Bristol','BS1 4RR','','51.45215','-2.5929671999999755',NULL,'','https://twitter.com/namaskarlounge','0117 929 8276','0000-00-00 00:00:00','0000-00-00 00:00:00',0,NULL,0,'http://www.namaskarlounge.com'),
	(23,'Bristol Raj Bari','bristol_raj_bari','183 Hotwell Road','','Bristol','BS8 4SA','','51.449712','-2.615888400000017',NULL,'https://www.facebook.com/pages/Raj-Bari-Indian-Restaurant-Bristol/342007089','','0117 922 7617','0000-00-00 00:00:00','0000-00-00 00:00:00',0,NULL,0,'http://www.rajbaribristol.co.uk'),
	(24,'Hotel du Vin Bristol','hotel_du_vin_bristol','The Sugar House','Narrow Lewins Mead','Bristol','BS1 2NU','','51.4566994','-2.596595500000035',NULL,'','https://twitter.com/hdv_bristol','0117 925 5577','0000-00-00 00:00:00','0000-00-00 00:00:00',0,NULL,0,'http://www.hotelduvin.com/hotels/bristol/bristol.aspx'),
	(25,'Cote','cote','27 The Mall','Clifton','Bristol','BS8 4JG','','51.4560133','-2.6213416000000507',NULL,'','','0117 970 6779','0000-00-00 00:00:00','0000-00-00 00:00:00',0,NULL,0,'http://www.cote-restaurants.co.uk'),
	(26,'The Richmond, Clifton','the_richmond_clifton','33 Gordon Road','Clifton','Bristol','BS8 1AW','','51.4558455','-2.6122146000000157',NULL,'https://www.facebook.com/richmond.clifton','https://twitter.com/richmondclifton','0117 923 7542','0000-00-00 00:00:00','0000-00-00 00:00:00',0,NULL,0,'www.therichmondclifton.co.uk'),
	(27,'Kevin\'s party','kevins_party','The Paintworks','The Bath Road','Bristol','BS4 3EN','kevin@kevinbroadley.com','51.4426688','-2.5683698999999933',NULL,'','','011797311150','0000-00-00 00:00:00','0000-00-00 00:00:00',0,NULL,0,'http://www.wildfirecomms.co.uk/'),
	(28,'V-shed','vshed','Canons Road','','Bristol','BS1 5UH',NULL,'51.4506834','-2.5984598000000005',NULL,NULL,NULL,'0117 943 1200','0000-00-00 00:00:00',NULL,1,NULL,0,'http://visitbristol.co.uk/'),
	(32,'The Palace','the_palace','Penthouse','Top level','','BS43LG','test@kevin.com','51.4348693','-2.552232799999956',NULL,'','','011797111111','2014-08-08 14:35:00','0000-00-00 00:00:00',0,NULL,0,'http://www.atgtickets.com/venues/bristol-hippodrome/'),
	(33,'',NULL,'','',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2014-08-11 15:20:00','2014-08-11 15:20:00',0,NULL,0,'');

/*!40000 ALTER TABLE `venue` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table video
# ------------------------------------------------------------

DROP TABLE IF EXISTS `video`;

CREATE TABLE `video` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content_link` text NOT NULL,
  `content_embed` text NOT NULL,
  `content_host` tinyint(4) NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `video` WRITE;
/*!40000 ALTER TABLE `video` DISABLE KEYS */;

INSERT INTO `video` (`id`, `content_link`, `content_embed`, `content_host`, `created_at`)
VALUES
	(38,'//www.youtube.com/embed/sWbhiuN8W5s?list=PLS3XGZxi7cBVNadbxDqZCUgISvabEpu-g','<iframe src=\"//www.youtube.com/embed/sWbhiuN8W5s?list=PLS3XGZxi7cBVNadbxDqZCUgISvabEpu-g\" frameborder=\"0\" allowfullscreen></iframe>',0,'0000-00-00 00:00:00'),
	(39,'//www.youtube.com/embed/ToOmjUrV2Ic?list=PLS3XGZxi7cBVNadbxDqZCUgISvabEpu-g','<iframe src=\"//www.youtube.com/embed/ToOmjUrV2Ic?list=PLS3XGZxi7cBVNadbxDqZCUgISvabEpu-g\" frameborder=\"0\" allowfullscreen></iframe>',0,'0000-00-00 00:00:00'),
	(40,'//www.youtube.com/embed/6VddeufIB7M?list=PLS3XGZxi7cBVNadbxDqZCUgISvabEpu-g','<iframe src=\"//www.youtube.com/embed/6VddeufIB7M?list=PLS3XGZxi7cBVNadbxDqZCUgISvabEpu-g\" frameborder=\"0\" allowfullscreen></iframe>',0,'0000-00-00 00:00:00'),
	(41,'//www.youtube.com/embed/P70H_HYlVII?list=PLS3XGZxi7cBVNadbxDqZCUgISvabEpu-g','<iframe src=\"//www.youtube.com/embed/P70H_HYlVII?list=PLS3XGZxi7cBVNadbxDqZCUgISvabEpu-g\" frameborder=\"0\" allowfullscreen></iframe>',0,'0000-00-00 00:00:00'),
	(42,'//www.youtube.com/embed/qJw_cqzVdeA?list=PLS3XGZxi7cBVNadbxDqZCUgISvabEpu-g','<iframe src=\"//www.youtube.com/embed/qJw_cqzVdeA?list=PLS3XGZxi7cBVNadbxDqZCUgISvabEpu-g\" frameborder=\"0\" allowfullscreen></iframe>',0,'0000-00-00 00:00:00'),
	(43,'//www.youtube.com/embed/gnqSr62JTzg?list=PLS3XGZxi7cBVNadbxDqZCUgISvabEpu-g','<iframe src=\"//www.youtube.com/embed/gnqSr62JTzg?list=PLS3XGZxi7cBVNadbxDqZCUgISvabEpu-g\" frameborder=\"0\" allowfullscreen></iframe>',0,'0000-00-00 00:00:00'),
	(44,'//www.youtube.com/embed/hvdLDMUPty8?list=PLS3XGZxi7cBVNadbxDqZCUgISvabEpu-g','<iframe src=\"//www.youtube.com/embed/hvdLDMUPty8?list=PLS3XGZxi7cBVNadbxDqZCUgISvabEpu-g\" frameborder=\"0\" allowfullscreen></iframe>',0,'0000-00-00 00:00:00'),
	(45,'//www.youtube.com/embed/62Rlckel4Qo?list=PLS3XGZxi7cBVNadbxDqZCUgISvabEpu-g','<iframe src=\"//www.youtube.com/embed/62Rlckel4Qo?list=PLS3XGZxi7cBVNadbxDqZCUgISvabEpu-g\" frameborder=\"0\" allowfullscreen></iframe>',0,'0000-00-00 00:00:00'),
	(46,'//www.youtube.com/embed/w3f-CYsBMEI?list=PLS3XGZxi7cBVNadbxDqZCUgISvabEpu-g','<iframe src=\"//www.youtube.com/embed/w3f-CYsBMEI?list=PLS3XGZxi7cBVNadbxDqZCUgISvabEpu-g\" frameborder=\"0\" allowfullscreen></iframe>',0,'0000-00-00 00:00:00'),
	(47,'//www.youtube.com/embed/5TgQ2XGVUvo?list=PLS3XGZxi7cBVNadbxDqZCUgISvabEpu-g','<iframe src=\"//www.youtube.com/embed/5TgQ2XGVUvo?list=PLS3XGZxi7cBVNadbxDqZCUgISvabEpu-g\" frameborder=\"0\" allowfullscreen></iframe>',0,'0000-00-00 00:00:00'),
	(48,'//www.youtube.com/embed/i-1UOBarIPg?list=PLS3XGZxi7cBVNadbxDqZCUgISvabEpu-g','<iframe src=\"//www.youtube.com/embed/i-1UOBarIPg?list=PLS3XGZxi7cBVNadbxDqZCUgISvabEpu-g\" frameborder=\"0\" allowfullscreen></iframe>',0,'0000-00-00 00:00:00'),
	(49,'//www.youtube.com/embed/KQysQWEYIno?list=PLS3XGZxi7cBVNadbxDqZCUgISvabEpu-g','<iframe src=\"//www.youtube.com/embed/KQysQWEYIno?list=PLS3XGZxi7cBVNadbxDqZCUgISvabEpu-g\" frameborder=\"0\" allowfullscreen></iframe>',0,'0000-00-00 00:00:00'),
	(50,'//www.youtube.com/embed/jbTPAj-EnFA?list=PLS3XGZxi7cBVNadbxDqZCUgISvabEpu-g','<iframe src=\"//www.youtube.com/embed/jbTPAj-EnFA?list=PLS3XGZxi7cBVNadbxDqZCUgISvabEpu-g\" frameborder=\"0\" allowfullscreen></iframe>',0,'0000-00-00 00:00:00'),
	(51,'//www.youtube.com/embed/PyHF_TrarvA?list=PLS3XGZxi7cBVNadbxDqZCUgISvabEpu-g','<iframe src=\"//www.youtube.com/embed/PyHF_TrarvA?list=PLS3XGZxi7cBVNadbxDqZCUgISvabEpu-g\" frameborder=\"0\" allowfullscreen></iframe>',0,'0000-00-00 00:00:00'),
	(52,'//www.youtube.com/embed/u-Qb4_sCx38?list=PLS3XGZxi7cBVNadbxDqZCUgISvabEpu-g','<iframe src=\"//www.youtube.com/embed/u-Qb4_sCx38?list=PLS3XGZxi7cBVNadbxDqZCUgISvabEpu-g\" frameborder=\"0\" allowfullscreen></iframe>',0,'0000-00-00 00:00:00'),
	(53,'//www.youtube.com/embed/WoB2HDTLIos?list=PLS3XGZxi7cBVNadbxDqZCUgISvabEpu-g','<iframe src=\"//www.youtube.com/embed/WoB2HDTLIos?list=PLS3XGZxi7cBVNadbxDqZCUgISvabEpu-g\" frameborder=\"0\" allowfullscreen></iframe>',0,'0000-00-00 00:00:00'),
	(54,'//www.youtube.com/embed/z0qEDYy7ZDs?list=PLS3XGZxi7cBVNadbxDqZCUgISvabEpu-g','<iframe src=\"//www.youtube.com/embed/z0qEDYy7ZDs?list=PLS3XGZxi7cBVNadbxDqZCUgISvabEpu-g\" frameborder=\"0\" allowfullscreen></iframe>',0,'0000-00-00 00:00:00'),
	(55,'//www.youtube.com/embed/4Da4Lx7og7Y?list=PLS3XGZxi7cBVNadbxDqZCUgISvabEpu-g','<iframe src=\"//www.youtube.com/embed/4Da4Lx7og7Y?list=PLS3XGZxi7cBVNadbxDqZCUgISvabEpu-g\" frameborder=\"0\" allowfullscreen></iframe>',0,'0000-00-00 00:00:00'),
	(56,'//www.youtube.com/embed/1F4Fg03XCv4?list=PLS3XGZxi7cBVNadbxDqZCUgISvabEpu-g','<iframe src=\"//www.youtube.com/embed/1F4Fg03XCv4?list=PLS3XGZxi7cBVNadbxDqZCUgISvabEpu-g\" frameborder=\"0\" allowfullscreen></iframe>',0,'0000-00-00 00:00:00'),
	(57,'//www.youtube.com/embed/cPXpPWSBct0?list=PLS3XGZxi7cBVNadbxDqZCUgISvabEpu-g','<iframe src=\"//www.youtube.com/embed/cPXpPWSBct0?list=PLS3XGZxi7cBVNadbxDqZCUgISvabEpu-g\" frameborder=\"0\" allowfullscreen></iframe>',0,'0000-00-00 00:00:00'),
	(58,'//www.youtube.com/embed/v1I1xJksfCk?list=PLS3XGZxi7cBVNadbxDqZCUgISvabEpu-g','<iframe src=\"//www.youtube.com/embed/v1I1xJksfCk?list=PLS3XGZxi7cBVNadbxDqZCUgISvabEpu-g\" frameborder=\"0\" allowfullscreen></iframe>',0,'0000-00-00 00:00:00'),
	(59,'//www.youtube.com/v/w9TGj2jrJk8?version=3&amp;hl=en_GB','<iframe src=\"//www.youtube.com/v/w9TGj2jrJk8?version=3&amp;hl=en_GB\" frameborder=\"0\" allowfullscreen></iframe>',0,'0000-00-00 00:00:00'),
	(65,'//www.youtube.com/v/w9TGj2jrJk8?version=3&hl=en_GB','<iframe src=\"//www.youtube.com/v/w9TGj2jrJk8?version=3&hl=en_GB\" frameborder=\"0\" allowfullscreen></iframe>',0,'0000-00-00 00:00:00'),
	(66,'//www.youtube.com/embed/AKbvYHNxNxY','<iframe src=\"//www.youtube.com/embed/AKbvYHNxNxY\" frameborder=\"0\" allowfullscreen></iframe>',0,'0000-00-00 00:00:00'),
	(67,'//www.youtube.com/embed/wf2omN4WLSQ','<iframe src=\"//www.youtube.com/embed/wf2omN4WLSQ\" frameborder=\"0\" allowfullscreen></iframe>',0,'0000-00-00 00:00:00'),
	(68,'//www.youtube.com/embed/wf2omN4WLSQ','<iframe src=\"//www.youtube.com/embed/wf2omN4WLSQ\" frameborder=\"0\" allowfullscreen></iframe>',0,'0000-00-00 00:00:00'),
	(69,'//www.youtube.com/embed/0xihXAzral0','<iframe src=\"//www.youtube.com/embed/0xihXAzral0\" frameborder=\"0\" allowfullscreen></iframe>',0,'0000-00-00 00:00:00'),
	(70,'http://vimeo.com/102550866','<iframe src=\"http://vimeo.com/102550866\" frameborder=\"0\" allowfullscreen></iframe>',0,'0000-00-00 00:00:00'),
	(71,'//www.youtube.com/embed/CFf22EBv_Oo','<iframe src=\"//www.youtube.com/embed/CFf22EBv_Oo\" frameborder=\"0\" allowfullscreen></iframe>',0,'0000-00-00 00:00:00'),
	(72,'http://www.bristol247.com/wp-content/uploads/2014/08/RPS-St-Pauls.jpg','<iframe src=\"http://www.bristol247.com/wp-content/uploads/2014/08/RPS-St-Pauls.jpg\" frameborder=\"0\" allowfullscreen></iframe>',0,'0000-00-00 00:00:00'),
	(73,'http://youtu.be/enUJB5RS6NE','<iframe src=\"http://youtu.be/enUJB5RS6NE\" frameborder=\"0\" allowfullscreen></iframe>',0,'0000-00-00 00:00:00');

/*!40000 ALTER TABLE `video` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
