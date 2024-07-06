-- MySQL dump 10.13  Distrib 8.0.37, for Linux (x86_64)
--
-- Host: localhost    Database: BDDPCS
-- ------------------------------------------------------
-- Server version	8.0.37-0ubuntu0.24.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `abonnement`

-- Debug statement
USE BDDPCS;
SELECT 'Initialization Script Running...' AS message;

--

DROP TABLE IF EXISTS `abonnement`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `abonnement` (
  `IDAbonnement` int NOT NULL AUTO_INCREMENT,
  `Type` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `Prix` float DEFAULT NULL,
  `IDUtilisateur` int DEFAULT NULL,
  PRIMARY KEY (`IDAbonnement`),
  KEY `IDUtilisateur` (`IDUtilisateur`),
  CONSTRAINT `abonnement_ibfk_1` FOREIGN KEY (`IDUtilisateur`) REFERENCES `utilisateur` (`IDUtilisateur`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `abonnement`
--

LOCK TABLES `abonnement` WRITE;
/*!40000 ALTER TABLE `abonnement` DISABLE KEYS */;
/*!40000 ALTER TABLE `abonnement` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bienimmobilier`
--

DROP TABLE IF EXISTS `bienimmobilier`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `bienimmobilier` (
  `IDBien` int NOT NULL AUTO_INCREMENT,
  `Adresse` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `Type_bien` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `Description` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `Superficie` varchar(200) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `NbChambres` int DEFAULT NULL,
  `Tarif` float DEFAULT NULL,
  `type_conciergerie` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `Disponibilite` time DEFAULT NULL,
  `IDUtilisateur` int DEFAULT NULL,
  `pays` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `type_location` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `capacite` int NOT NULL,
  PRIMARY KEY (`IDBien`),
  KEY `IDUtilisateur` (`IDUtilisateur`),
  CONSTRAINT `bienimmobilier_ibfk_1` FOREIGN KEY (`IDUtilisateur`) REFERENCES `utilisateur` (`IDUtilisateur`)
) ENGINE=InnoDB AUTO_INCREMENT=119 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bienimmobilier`
--

LOCK TABLES `bienimmobilier` WRITE;
/*!40000 ALTER TABLE `bienimmobilier` DISABLE KEYS */;
INSERT INTO `bienimmobilier` VALUES (1,'35 avenue du val de beauté - Nogent sur marne','Maison','Grande maison pas loin des bords de marnes, 5 chambres, deux salles de bains, deux jardins, 10 min du RER A et 20 min du RER E, animaux bienvenus !','230',5,45,'Void Management','00:00:00',28,'France','Logement Complet',5),(2,'3 rue pasteur','Maison','Maison au bord du lac tranquillou','59',5,250,'Void Management','00:00:28',28,'','Logement complet',12),(95,'31 rue du port - Nogent sur Marne','Appartement','Bords de marne 10 min du centre ville piscine tennis stade','55',2,49,'',NULL,28,'','Bed & Breakfast',2),(112,'45 avenue de la liberté, 75012 Paris 12ème','Appartement','Petite maison au coeur de paris pres d\'un parc, a coté du métro 1.','87',3,49,'Autre',NULL,1,'France','Logement complet',6),(118,'78 avenue du gouda, 75012 Paris 12eme','Appartement','Petite maison sympa a coté du métro, quartier tranquille','85',3,65,'Autre',NULL,1,'France','Logement complet',7);
/*!40000 ALTER TABLE `bienimmobilier` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `demandebailleurs`
--

DROP TABLE IF EXISTS `demandebailleurs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `demandebailleurs` (
  `id` int NOT NULL AUTO_INCREMENT,
  `type_conciergerie` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `autre_conciergerie` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `adresse` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `pays` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `type_bien` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `type_location` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `superficie` int NOT NULL,
  `nombre_chambres` int NOT NULL,
  `capacite` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `nom` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `telephone` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `heure_contact` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `date_demande` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `etat` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `utilisateur_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `utilisateur_id` (`utilisateur_id`),
  CONSTRAINT `demandebailleurs_ibfk_1` FOREIGN KEY (`utilisateur_id`) REFERENCES `utilisateur` (`IDUtilisateur`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `demandebailleurs`
--

LOCK TABLES `demandebailleurs` WRITE;
/*!40000 ALTER TABLE `demandebailleurs` DISABLE KEYS */;
INSERT INTO `demandebailleurs` VALUES (36,'Autre','Saucisse party tout les 12 du mois','78 avenue du gouda, 75012 Paris 12eme','France','Appartement','Logement complet',85,3,'7','Petite maison sympa a coté du métro, quartier tranquille','Jean Pierre PAPAIN','JPAP1@behpourquoi.fr','0102030405','Avant 12h00','2024-07-04 00:00:00','acceptee',1);
/*!40000 ALTER TABLE `demandebailleurs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `demandes_prestataires`
--

DROP TABLE IF EXISTS `demandes_prestataires`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `demandes_prestataires` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `prenom` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `siret` varchar(14) COLLATE utf8mb4_general_ci NOT NULL,
  `adresse` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `telephone` int NOT NULL,
  `domaine` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `demandes_prestataires`
--

LOCK TABLES `demandes_prestataires` WRITE;
/*!40000 ALTER TABLE `demandes_prestataires` DISABLE KEYS */;
INSERT INTO `demandes_prestataires` VALUES (5,'Verrecchia','Lucas','12345678912345','37 Avenue du Val de beauté','Lucas.verrecchia@gmail.com',629463796,'Ornithologie','Acceptée'),(6,'Verrecchia','Lucas','12345678912345','37 Avenue du Val de beauté','Lucas.verrecchia@gmail.com',629463796,'Electricien','En attente');
/*!40000 ALTER TABLE `demandes_prestataires` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `disponibilite`
--

DROP TABLE IF EXISTS `disponibilite`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `disponibilite` (
  `IDDisponibilite` int NOT NULL AUTO_INCREMENT,
  `IDBien` int NOT NULL,
  `DateDebut` date NOT NULL,
  `DateFin` date NOT NULL,
  PRIMARY KEY (`IDDisponibilite`),
  KEY `IDBien` (`IDBien`),
  CONSTRAINT `fk_disponibilite_bienimmobilier` FOREIGN KEY (`IDBien`) REFERENCES `bienimmobilier` (`IDBien`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `disponibilite`
--

LOCK TABLES `disponibilite` WRITE;
/*!40000 ALTER TABLE `disponibilite` DISABLE KEYS */;
INSERT INTO `disponibilite` VALUES (1,1,'2024-05-23','2025-05-23'),(2,2,'2024-05-22','2025-05-22'),(3,95,'2024-05-23','2025-05-22'),(8,118,'2024-07-04','2025-07-04'),(9,112,'2024-07-04','2025-07-04');
/*!40000 ALTER TABLE `disponibilite` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `evaluation`
--

DROP TABLE IF EXISTS `evaluation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `evaluation` (
  `IDEvaluation` int NOT NULL AUTO_INCREMENT,
  `Note` int DEFAULT NULL,
  `Commentaire` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `DateEvaluation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `IDUtilisateur` int DEFAULT NULL,
  `IDPrestation` int DEFAULT NULL,
  `IDReservation` int DEFAULT NULL,
  PRIMARY KEY (`IDEvaluation`),
  KEY `IDUtilisateur` (`IDUtilisateur`),
  KEY `IDPrestation` (`IDPrestation`),
  KEY `IDReservation` (`IDReservation`),
  CONSTRAINT `evaluation_ibfk_1` FOREIGN KEY (`IDUtilisateur`) REFERENCES `utilisateur` (`IDUtilisateur`),
  CONSTRAINT `evaluation_ibfk_2` FOREIGN KEY (`IDPrestation`) REFERENCES `prestation` (`IDPrestation`),
  CONSTRAINT `evaluation_ibfk_3` FOREIGN KEY (`IDReservation`) REFERENCES `reservation` (`IDReservation`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `evaluation`
--

LOCK TABLES `evaluation` WRITE;
/*!40000 ALTER TABLE `evaluation` DISABLE KEYS */;
/*!40000 ALTER TABLE `evaluation` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `facture`
--

DROP TABLE IF EXISTS `facture`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `facture` (
  `IDFacture` int NOT NULL AUTO_INCREMENT,
  `Montant` float DEFAULT NULL,
  `Description` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `IDPrestation` int DEFAULT NULL,
  PRIMARY KEY (`IDFacture`),
  KEY `IDPrestation` (`IDPrestation`),
  CONSTRAINT `facture_ibfk_1` FOREIGN KEY (`IDPrestation`) REFERENCES `prestation` (`IDPrestation`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `facture`
--

LOCK TABLES `facture` WRITE;
/*!40000 ALTER TABLE `facture` DISABLE KEYS */;
/*!40000 ALTER TABLE `facture` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `message`
--

DROP TABLE IF EXISTS `message`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `message` (
  `IDMessage` int NOT NULL AUTO_INCREMENT,
  `Nom` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `Contenu` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `Date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `IDUtilisateurEmetteur` int DEFAULT NULL,
  `IDPrestataireEmetteur` int DEFAULT NULL,
  `IDPrestataireDestinataire` int DEFAULT NULL,
  `IDUtilisateurDestinataire` int DEFAULT NULL,
  PRIMARY KEY (`IDMessage`),
  KEY `IDUtilisateurEmetteur` (`IDUtilisateurEmetteur`),
  KEY `IDPrestataireEmetteur` (`IDPrestataireEmetteur`),
  KEY `IDPrestataireDestinataire` (`IDPrestataireDestinataire`),
  KEY `IDUtilisateurDestinataire` (`IDUtilisateurDestinataire`),
  CONSTRAINT `message_ibfk_1` FOREIGN KEY (`IDUtilisateurEmetteur`) REFERENCES `utilisateur` (`IDUtilisateur`),
  CONSTRAINT `message_ibfk_2` FOREIGN KEY (`IDPrestataireEmetteur`) REFERENCES `prestataire` (`IDPrestataire`),
  CONSTRAINT `message_ibfk_3` FOREIGN KEY (`IDPrestataireDestinataire`) REFERENCES `prestataire` (`IDPrestataire`),
  CONSTRAINT `message_ibfk_4` FOREIGN KEY (`IDUtilisateurDestinataire`) REFERENCES `utilisateur` (`IDUtilisateur`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `message`
--

LOCK TABLES `message` WRITE;
/*!40000 ALTER TABLE `message` DISABLE KEYS */;
/*!40000 ALTER TABLE `message` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `photobienimmobilier`
--

DROP TABLE IF EXISTS `photobienimmobilier`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `photobienimmobilier` (
  `IDphoto` int NOT NULL AUTO_INCREMENT,
  `IDbien` int DEFAULT NULL,
  `cheminPhoto` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `IDdemande` int DEFAULT NULL,
  PRIMARY KEY (`IDphoto`),
  KEY `IDbien` (`IDbien`),
  KEY `fk_IDdemande` (`IDdemande`),
  CONSTRAINT `fk_IDdemande` FOREIGN KEY (`IDdemande`) REFERENCES `demandebailleurs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `photobienimmobilier_ibfk_1` FOREIGN KEY (`IDbien`) REFERENCES `bienimmobilier` (`IDBien`)
) ENGINE=InnoDB AUTO_INCREMENT=189 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `photobienimmobilier`
--

LOCK TABLES `photobienimmobilier` WRITE;
/*!40000 ALTER TABLE `photobienimmobilier` DISABLE KEYS */;
INSERT INTO `photobienimmobilier` VALUES (151,1,'img/PhotosBienImmobilier/6685d8a5c9fcd-MaisonsPCS3.jpg',NULL),(153,1,'img/PhotosBienImmobilier/6685d8b0e36db-Salon2PCS.jpg',NULL),(154,95,'img/PhotosBienImmobilier/6685d8e13614c-TerasseAppartPCS.jpg',NULL),(155,95,'img/PhotosBienImmobilier/6685d8f19d626-SaleAMangerPCS2.jpg',NULL),(156,95,'img/PhotosBienImmobilier/6685d8f19d6bb-SalonLoftPCS.jpg',NULL),(159,2,'img/PhotosBienImmobilier/66865470a1fa5-MaisonPCS3.jpg',NULL),(160,2,'img/PhotosBienImmobilier/66865470a1ff8-SALONPCS3.jpg',NULL),(161,2,'img/PhotosBienImmobilier/66865470a204a-SDB2PCS.jpg',NULL),(162,2,'img/PhotosBienImmobilier/668654932bb77-CHAMBRE5PCSs.jpg',NULL),(163,2,'img/PhotosBienImmobilier/668654932bc1f-CHAMBREPCS4.jpg',NULL),(170,1,'img/PhotosBienImmobilier/66865a0db6818-ChambrePCS1.jpg',NULL),(184,118,'img/PhotosBienImmobilier/66865cea38c0a-ChambrePCS1.jpg',36),(185,118,'img/PhotosBienImmobilier/66865cea38cfe-MaisonPCS3.jpg',36),(186,118,'img/PhotosBienImmobilier/66865cea38d5f-SALONPCS3.jpg',36),(187,118,'img/PhotosBienImmobilier/66865cea38dad-SDBPCS.jpg',36),(188,118,'img/PhotosBienImmobilier/66865cea38df3-TerasseAppartPCS.jpg',36);
/*!40000 ALTER TABLE `photobienimmobilier` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `prestataire`
--

DROP TABLE IF EXISTS `prestataire`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `prestataire` (
  `IDPrestataire` int NOT NULL AUTO_INCREMENT,
  `Nom` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `Prenom` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `NSiret` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `Adresse` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `Email` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `Telephone` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `Domaine` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `Mdp` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`IDPrestataire`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `prestataire`
--

LOCK TABLES `prestataire` WRITE;
/*!40000 ALTER TABLE `prestataire` DISABLE KEYS */;
INSERT INTO `prestataire` VALUES (1,'Verrecchia','Lucas','12345678912345','37 Avenue du Val de beauté','Lucas.verrecchia@gmail.com','629463796','Ornithologie','$2y$10$9RrvBEOo3bgzEcfxE3XLjexKo3ZLmlTG9X986MbtU4nkwJlHzBmbO'),(2,'Le Clodo','Jo','01254857952654','2 rue des tulipes','KoukouCNous@Plomberie.fr','0102030405','Plomberie','Lol');
/*!40000 ALTER TABLE `prestataire` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `prestation`
--

DROP TABLE IF EXISTS `prestation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `prestation` (
  `IDPrestation` int NOT NULL AUTO_INCREMENT,
  `Type` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `Description` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `Montant` float DEFAULT NULL,
  `id_reservation` int NOT NULL,
  `TempsEstime` time DEFAULT NULL,
  `Status` tinyint(1) DEFAULT NULL,
  `IDPrestataire` int DEFAULT NULL,
  PRIMARY KEY (`IDPrestation`),
  KEY `IDPrestataire` (`IDPrestataire`),
  KEY `id_reservation` (`id_reservation`),
  CONSTRAINT `prestation_ibfk_1` FOREIGN KEY (`IDPrestataire`) REFERENCES `prestataire` (`IDPrestataire`),
  CONSTRAINT `prestation_ibfk_2` FOREIGN KEY (`id_reservation`) REFERENCES `reservation` (`IDReservation`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `prestation`
--

LOCK TABLES `prestation` WRITE;
/*!40000 ALTER TABLE `prestation` DISABLE KEYS */;
/*!40000 ALTER TABLE `prestation` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reservation`
--

DROP TABLE IF EXISTS `reservation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `reservation` (
  `IDReservation` int NOT NULL AUTO_INCREMENT,
  `Description` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `Tarif` float DEFAULT NULL,
  `NbVoyageurs` int NOT NULL,
  `IDUtilisateur` int DEFAULT NULL,
  `IDBien` int DEFAULT NULL,
  `DateDebut` date NOT NULL,
  `DateFin` date NOT NULL,
  `Status` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `IDService` int DEFAULT NULL,
  `Prestations` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `isPaid` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`IDReservation`),
  KEY `IDUtilisateur` (`IDUtilisateur`),
  KEY `IDBien` (`IDBien`),
  CONSTRAINT `reservation_ibfk_1` FOREIGN KEY (`IDUtilisateur`) REFERENCES `utilisateur` (`IDUtilisateur`),
  CONSTRAINT `reservation_ibfk_2` FOREIGN KEY (`IDBien`) REFERENCES `bienimmobilier` (`IDBien`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reservation`
--

LOCK TABLES `reservation` WRITE;
/*!40000 ALTER TABLE `reservation` DISABLE KEYS */;
INSERT INTO `reservation` VALUES (23,'Réservation de 95',49,2,28,95,'2024-06-27','2024-06-29','Accepted',NULL,'',0),(24,'Réservation de 95',49,2,28,95,'2024-07-25','2024-07-30','Accepted',NULL,'',0),(30,'Réservation de 1',45,2,28,1,'2024-07-08','2024-07-13','Accepted',NULL,'',0),(33,'Réservation de 1',45,4,28,1,'2024-07-23','2024-07-27','Pending',NULL,'',0);
/*!40000 ALTER TABLE `reservation` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `service`
--

DROP TABLE IF EXISTS `service`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `service` (
  `IDService` int NOT NULL AUTO_INCREMENT,
  `Description` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `Type` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `Tarif` float DEFAULT NULL,
  `IDUtilisateur` int DEFAULT NULL,
  PRIMARY KEY (`IDService`),
  KEY `IDUtilisateur` (`IDUtilisateur`),
  CONSTRAINT `service_ibfk_1` FOREIGN KEY (`IDUtilisateur`) REFERENCES `utilisateur` (`IDUtilisateur`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `service`
--

LOCK TABLES `service` WRITE;
/*!40000 ALTER TABLE `service` DISABLE KEYS */;
/*!40000 ALTER TABLE `service` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tickets`
--

DROP TABLE IF EXISTS `tickets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tickets` (
  `id` int NOT NULL AUTO_INCREMENT,
  `categorie` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `status` tinyint(1) NOT NULL,
  `id_utilisateur` int NOT NULL,
  `id_bien` int DEFAULT NULL,
  `id_prestation` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_utilisateur` (`id_utilisateur`),
  KEY `fk_bienimmobilier` (`id_bien`),
  KEY `fk_prestation` (`id_prestation`),
  CONSTRAINT `fk_bienimmobilier` FOREIGN KEY (`id_bien`) REFERENCES `bienimmobilier` (`IDBien`),
  CONSTRAINT `fk_prestation` FOREIGN KEY (`id_prestation`) REFERENCES `prestation` (`IDPrestation`),
  CONSTRAINT `fk_utilisateur` FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateur` (`IDUtilisateur`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tickets`
--

LOCK TABLES `tickets` WRITE;
/*!40000 ALTER TABLE `tickets` DISABLE KEYS */;
INSERT INTO `tickets` VALUES (1,'Bailleurs','Bonjour, ceci est un test : modifier adresse logement, appeler au 06blabla',0,28,NULL,NULL);
/*!40000 ALTER TABLE `tickets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `utilisateur`
--

DROP TABLE IF EXISTS `utilisateur`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `utilisateur` (
  `IDUtilisateur` int NOT NULL AUTO_INCREMENT,
  `Nom` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `Prenom` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `Email` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `Telephone` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `Mdp` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `DateInscription` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `DroitAdmin` tinyint DEFAULT NULL,
  `EstBailleur` tinyint DEFAULT NULL,
  `token` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`IDUtilisateur`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `utilisateur`
--

LOCK TABLES `utilisateur` WRITE;
/*!40000 ALTER TABLE `utilisateur` DISABLE KEYS */;
INSERT INTO `utilisateur` VALUES (1,'client','client','client@test.fr','0102030405','$2y$10$bdqv6Zg4wxtuqEyyaFfNtew0UatLSK5XSm4/I2fNi8Ix2Knp50AM6','2024-07-04 18:51:24',NULL,1,'a917ec09efd16d53a3f165d47e9b8052'),(28,'Verrecchia','Lucas','Lucas.verrecchia@gmail.com','0629463796','$2y$10$ZEFYyAi.i5/R7txv0DObCu8wEAKWIwRZr5SkaKbDgAjrokBE.4eUq','2024-07-04 19:00:48',1,1,'06fa54e534b3c0469e6abf79136facc5'),(33,'Jo','LeClodo','Lucaasdas.verrecchia@gmail.com','0629463796','$2y$10$cLWN0GwV7QyLSXSTL0fqjuGPiWbh0/78obWYQCfqiiLr0Trw2hGzm','2024-05-02 10:54:35',NULL,1,'723bd1d0ce011e220062fc1564e1bc68'),(37,'bsila','ylian','ylianbsila22@gmail.com','0695058040','$2y$10$muk94Vkj7LwB5IqG04ufOe4Xs8IbIbk9hWuTJcVYHuPPQftRt9VaW','2024-07-03 20:26:45',NULL,NULL,'1354d66a47dfe3004fb6300513621b86');
/*!40000 ALTER TABLE `utilisateur` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-07-05 18:38:20
