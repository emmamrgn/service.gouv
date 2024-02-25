DROP TABLE IF EXISTS `Cantine`;
DROP TABLE IF EXISTS `Citoyen`;
DROP TABLE IF EXISTS `Classe`;
DROP TABLE IF EXISTS `Commune`;
DROP TABLE IF EXISTS `Contrat`;
DROP TABLE IF EXISTS `Demande`;
DROP TABLE IF EXISTS `Département`;
DROP TABLE IF EXISTS `Ecole`;
DROP TABLE IF EXISTS `Enfant`;
DROP TABLE IF EXISTS `inscrit`;
DROP TABLE IF EXISTS `Justificatifs`;
DROP TABLE IF EXISTS `Lieu`;
DROP TABLE IF EXISTS `Repas`;
DROP TABLE IF EXISTS `Région`;
DROP TABLE IF EXISTS `Service`;
DROP TABLE IF EXISTS `ServiceElections`;
DROP TABLE IF EXISTS `ServiceEtatCivil`;
DROP TABLE IF EXISTS `ServiceRestauration`;
DROP TABLE IF EXISTS `ServiceScolaire`;
DROP TABLE IF EXISTS `ServiceSignalement`;
DROP TABLE IF EXISTS `ServiceUnionCivile`;
DROP TABLE IF EXISTS `FreeTrial`;
DROP TABLE IF EXISTS `ServiceFreeTrial`;



CREATE TABLE Région(
   idReg INT NOT NULL AUTO_INCREMENT,
   nomR VARCHAR(50),
   codeINSEE_R VARCHAR(50) NOT NULL,
   PRIMARY KEY(idReg)
);

CREATE TABLE Citoyen(
   idCit INT NOT NULL AUTO_INCREMENT,
   nomCit VARCHAR(50),
   prénomCit VARCHAR(50),
   dateNaissanceCit DATE,
   adresseCit VARCHAR(50),
   téléphone VARCHAR(50),
   email VARCHAR(50),
   PRIMARY KEY(idCit)
);

CREATE TABLE Lieu(
   idLieu INT NOT NULL AUTO_INCREMENT,
   nomL VARCHAR(50),
   type VARCHAR(50),
   longL DECIMAL(38,38),
   latL DECIMAL(38,38),
   PRIMARY KEY(idLieu)
);

CREATE TABLE Contrat(
   idContrat INT NOT NULL AUTO_INCREMENT,
   idCit INT NOT NULL,
   idCit_1 INT NOT NULL,
   PRIMARY KEY(idContrat),
   FOREIGN KEY(idCit) REFERENCES Citoyen(idCit),
   FOREIGN KEY(idCit_1) REFERENCES Citoyen(idCit)
);

CREATE TABLE Ecole(
   idEcole INT NOT NULL AUTO_INCREMENT,
   adresseE VARCHAR(50),
   nbClasse INT,
   idLieu INT NOT NULL,
   PRIMARY KEY(idEcole),
   FOREIGN KEY(idLieu) REFERENCES Lieu(idLieu)
);

CREATE TABLE Classe(
   idClasse INT NOT NULL AUTO_INCREMENT,
   idEcole INT NOT NULL,
   PRIMARY KEY(idClasse),
   FOREIGN KEY(idEcole) REFERENCES Ecole(idEcole)
);

CREATE TABLE Cantine(
   idCantine INT NOT NULL AUTO_INCREMENT,
   nomCa VARCHAR(50),
   adresseCa VARCHAR(50),
   nbPlaces INT,
   nbServices INT,
   longCa DECIMAL(38,38),
   latCa DECIMAL(38,38),
   PRIMARY KEY(idCantine)
);

CREATE TABLE Département(
   idDep INT NOT NULL AUTO_INCREMENT,
   nomDep VARCHAR(50),
   codeINSEE_Dep VARCHAR(50),
   idReg INT NOT NULL,
   PRIMARY KEY(idDep),
   FOREIGN KEY(idReg) REFERENCES Région(idReg)
);

CREATE TABLE Enfant(
   idEnfant INT NOT NULL AUTO_INCREMENT,
   nomEnf VARCHAR(50),
   prénomEnf VARCHAR(50),
   idCantine INT NOT NULL,
   idClasse INT NOT NULL,
   PRIMARY KEY(idEnfant),
   FOREIGN KEY(idCantine) REFERENCES Cantine(idCantine),
   FOREIGN KEY(idClasse) REFERENCES Classe(idClasse)
);

CREATE TABLE Repas(
   idRepas INT NOT NULL AUTO_INCREMENT,
   debutPeriode DATE,
   finPeriode DATE,
   nbJoursAbsence INT,
   idEnfant INT NOT NULL,
   PRIMARY KEY(idRepas),
   FOREIGN KEY(idEnfant) REFERENCES Enfant(idEnfant)
);

CREATE TABLE Commune(
   idComm INT NOT NULL AUTO_INCREMENT,
   codeP INT,
   nomCo VARCHAR(50),
   longCo DECIMAL(38,38),
   latCo DECIMAL(38,38),
   codeINSEE_Co VARCHAR(50),
   adresseMairie VARCHAR(50),
   idDep INT NOT NULL,
   PRIMARY KEY(idComm),
   FOREIGN KEY(idDep) REFERENCES Département(idDep)
);

CREATE TABLE Service(
   idService INT NOT NULL AUTO_INCREMENT,
   libellé VARCHAR(50),
   description TEXT,
   debutOuverture VARCHAR(20),
   finOuverture VARCHAR(20),
   coût VARCHAR(50),
   idComm INT NOT NULL,
   PRIMARY KEY(idService),
   FOREIGN KEY(idComm) REFERENCES Commune(idComm)
);

CREATE TABLE Demande(
   idDmd INT NOT NULL AUTO_INCREMENT,
   dateDemande DATE,
   message TEXT,
   idService INT NOT NULL,
   idCit INT NOT NULL,
   PRIMARY KEY(idDmd),
   FOREIGN KEY(idService) REFERENCES Service(idService),
   FOREIGN KEY(idCit) REFERENCES Citoyen(idCit)
);

CREATE TABLE Justificatifs(
   idJ INT NOT NULL AUTO_INCREMENT,
   numéro INT,
   type VARCHAR(50),
   description TEXT,
   cheminFichier VARCHAR(50),
   idDmd INT NOT NULL,
   PRIMARY KEY(idJ),
   FOREIGN KEY(idDmd) REFERENCES Demande(idDmd)
);

CREATE TABLE ServiceEtatCivil(
   idService INT NOT NULL,
   dateMiseDispoDoc DATE,
   typeDocs VARCHAR(50),
   PRIMARY KEY(idService),
   FOREIGN KEY(idService) REFERENCES Service(idService)
);

CREATE TABLE ServiceElections(
   idService INT NOT NULL,
   bureauVote VARCHAR(50),
   PRIMARY KEY(idService),
   FOREIGN KEY(idService) REFERENCES Service(idService)
);

CREATE TABLE ServiceSignalement(
   idService INT NOT NULL,
   type VARCHAR(50),
   idLieu INT NOT NULL,
   PRIMARY KEY(idService),
   FOREIGN KEY(idService) REFERENCES Service(idService),
   FOREIGN KEY(idLieu) REFERENCES Lieu(idLieu)
);

CREATE TABLE ServiceUnionCivile(
   idService INT NOT NULL,
   datePrévue DATE,
   type VARCHAR(50),
   idCit INT NOT NULL,
   PRIMARY KEY(idService),
   FOREIGN KEY(idService) REFERENCES Service(idService),
   FOREIGN KEY(idCit) REFERENCES Citoyen(idCit)
);

CREATE TABLE ServiceScolaire(
   idService INT NOT NULL,
   nomContact VARCHAR(50),
   numTelContact VARCHAR(50),
   idEnfant INT,
   PRIMARY KEY(idService),
   FOREIGN KEY(idService) REFERENCES Service(idService),
   FOREIGN KEY(idEnfant) REFERENCES Enfant(idEnfant)
);

CREATE TABLE ServiceRestauration(
   idService INT NOT NULL,
   tarifsRéduits BOOLEAN,
   idCantine INT NOT NULL,
   PRIMARY KEY(idService),
   FOREIGN KEY(idService) REFERENCES Service(idService),
   FOREIGN KEY(idCantine) REFERENCES Cantine(idCantine)
);

CREATE TABLE inscrit(
   idEnfant INT NOT NULL,
   premièreInscription BOOLEAN,
   changementEcole BOOLEAN,
   renouvellement BOOLEAN,
   idEcole INT NOT NULL,
   PRIMARY KEY(idEnfant),
   FOREIGN KEY(idEnfant) REFERENCES Enfant(idEnfant),
   FOREIGN KEY(idEcole) REFERENCES Ecole(idEcole)
);

CREATE TABLE FreeTrial(
   idTrial INT NOT NULL AUTO_INCREMENT,
   nomCo VARCHAR(50),
   duréeFreeTrial INT NOT NULL,
   debutFreeTrial VARCHAR(20),
   finFreeTrial VARCHAR(20),
   PRIMARY KEY(idTrial)
);

CREATE TABLE ServiceFreeTrial( 
   idServiceFT INT NOT NULL AUTO_INCREMENT, 
   idTrial INT NOT NULL, 
   libellé VARCHAR(50), 
   idService INT NOT NULL, 
   PRIMARY KEY(idServiceFT), 
   FOREIGN KEY(idService) REFERENCES Service(idService), 
   FOREIGN KEY(idTrial) REFERENCES FreeTrial(idTrial) 
); 

/* AJOUT DE LIEUX */

INSERT INTO Lieu(nomL,type,longL,latL) VALUES ('INSA', 'Ecole', 4.875989, 45.783091);
INSERT INTO Lieu(nomL, type, longL, latL) VALUES("Ecole Jean Jaurès", "Ecole", 4.8501111, 45.7642299 );
INSERT INTO Lieu(nomL, type, longL, latL)VALUES("Ecole Jean Macé", "Ecole",4.0000, 45.455599);

/* AJOUT D'ECOLES, DE CLASSES ET DE CANTINES*/
INSERT INTO Ecole (adresseE, nbClasse,idlieu) VALUES ('20 Av. Albert Einstein, 69100 Villeurbanne', 180,1);
INSERT INTO Classe(idEcole) VALUES (1);
INSERT INTO Cantine(nomCa, adresseCa, nbPlaces, nbServices, longCa, latCa) VALUES ('R.I','8 Av. Jean Capelle O, 69100 Villeurbanne', 600, NULL, '4.87372', '45.780911');
INSERT INTO Ecole(adresseE, nbClasse, idLieu) VALUES ("46 Rue Robert, 69006 Lyon", 250, 2);
INSERT INTO Classe(idEcole) VALUES (2);
INSERT INTO Cantine(nomCa, adresseCa) VALUES ("Cantine Jean Jaurès", "46 Rue Robert, 69006 Lyon");
INSERT INTO Ecole(adresseE, nbClasse, idLieu) VALUES ("50 Rue Robert, 69007 Lyon", 250, 3);
INSERT INTO Classe(idEcole) VALUES (3);
INSERT INTO Cantine(nomCa, adresseCa) VALUES ("Cantine Jean Macé","50 Rue Robert, 69007 Lyon");
INSERT INTO Lieu(nomL,type, longL,latL) VALUES("Université Lyon 1", "Université","4.868155","45.781665");
INSERT INTO Lieu(nomL,type, longL,latL) VALUES("Université Lyon 3", "Université","4.868155","45.781665");
INSERT INTO Lieu(nomL,type, longL,latL) VALUES("Université Lyon 2", "Université"," 4.864803","45.745519");
INSERT INTO Ecole(adresseE,nbClasse,idLieu) VALUES ("43 Bd du 11 Novembre 1918, 69100 Villeurbanne", 100,4  );
INSERT INTO Ecole(adresseE,nbClasse,idLieu) VALUES ("86 Rue Pasteur, 69007 Lyon", 100,6 );
INSERT INTO Ecole(adresseE,nbClasse,idLieu) VALUES ("Avenue des Frères Lumière, 69008 Lyon", 125,5 );
INSERT INTO Classe(idEcole) VALUES (4);
INSERT INTO Classe(idEcole) VALUES (5);
INSERT INTO Classe(idEcole) VALUES (6);
INSERT INTO Cantine(nomCa,nbPlaces) VALUES("CROUS UNIV LYON 1",300);
INSERT INTO Cantine(nomCa,nbPlaces) VALUES("CROUS UNIV LYON 2",150);
INSERT INTO Cantine(nomCa,nbPlaces) VALUES("CROUS UNIV LYON 3",200);


/* AJOUT D'ENFANTS */
INSERT INTO Enfant(nomEnf, prénomEnf, idCantine, idClasse) VALUES ('Jacques', 'Jean',1,1);
INSERT INTO Enfant(nomEnf, prénomEnf, idCantine, idClasse) VALUES ("Dupont", "Pierre", 2,2);
INSERT INTO Enfant(nomEnf, prénomEnf, idCantine, idClasse) VALUES ("Dupont", "Pierre", 3, 3);
INSERT INTO Enfant(nomEnf, prénomEnf, idCantine, idClasse)  VALUES ('Momme', 'Maxime', 1,1);
INSERT INTO Enfant(nomEnf, prénomEnf, idCantine, idClasse)  VALUES ('Momme', 'André', 5,6);
INSERT INTO Enfant(nomEnf, prénomEnf, idCantine, idClasse)  VALUES ('Duteuil', 'Mini', 1,1);



INSERT INTO Service(libellé, description, debutOuverture, finOuverture, coût, idComm) 
    VALUES ('Libellé service 1', 'description service 1','01-01-1970','01-01-2033',0, 4170);
INSERT INTO Service(libellé, description, debutOuverture, finOuverture, coût, idComm) 
    VALUES ('Libellé service 2', 'description service 2','01-01-2022','01-01-2023',20, 4171);

/* AJOUT DE CITOYEN */
INSERT INTO Citoyen(nomCit, prénomCit, dateNaissanceCit, adresseCit)
    VALUES ('Dupont', 'Bernard', '1975-08-01','2 Rue Robert, 69007 Lyon');
INSERT INTO Citoyen(nomCit, prénomCit, dateNaissanceCit, adresseCit)
    VALUES ('Dupont', 'Julie', '1974-11-21','2 Rue Robert, 69007 Lyon');
INSERT INTO Citoyen(nomCit, prénomCit, dateNaissanceCit, adresseCit) 
    VALUES ('Marchand', 'Rémy', '1968-02-06', '13, Rue des Petits Poids');
INSERT INTO Citoyen(nomCit, prénomCit, dateNaissanceCit, adresseCit) 
    VALUES ('Bonhomme', 'Henriette', '1970-01-24', '13, Rue des Petits Poids');
INSERT INTO Citoyen(nomCit, prénomCit, dateNaissanceCit, adresseCit)
    VALUES ('Momme', 'Laure', '1974-11-06','4 Cours Lafayette, 69003 Lyon');
INSERT INTO Citoyen(nomCit, prénomCit, dateNaissanceCit, adresseCit)
    VALUES ('Momme', 'Maxime', '2000-08-24','4 Cours Lafayette, 69003 Lyon');
INSERT INTO Citoyen(nomCit, prénomCit, dateNaissanceCit, adresseCit)
    VALUES ('Duteuil', 'Mini', '2000-08-24','4 Cours Lafayette, 69003 Lyon');
INSERT INTO Citoyen(nomCit, prénomCit, dateNaissanceCit, adresseCit)
    VALUES ('Momme', 'Frederic', '1971-02-21','4 Cours Lafayette, 69003 Lyon');
INSERT INTO Citoyen(nomCit, prénomCit, dateNaissanceCit, adresseCit)
    VALUES ('Momme', 'Maxime', '1992-01-28','69300 Caluire-et-Cuire');


INSERT INTO Service(libellé,description, debutOuverture, finOuverture, coût, idComm) VALUES ("Restauration", "Service de restauration de Cantine pour les écoles", "01-01", "31-12", 20,3541);
INSERT INTO ServiceRestauration(idService,tarifsRéduits,idCantine) VALUES (1,TRUE,1);

INSERT INTO Service(libellé,description, debutOuverture, finOuverture, coût, idComm) VALUES ("Elections", "Service des éléctions communales","01-01", "31-12", 0,3541);
INSERT INTO ServiceElections(idService,bureauVote) VALUES (2,"Villeurbanne");

INSERT INTO Service(libellé,description, debutOuverture, finOuverture, coût, idComm) VALUES ("Union Civile", "Service pour les unions entre citoyens","01-01", "31-12", 0,3541);
INSERT INTO Contrat(idCit,idCit_1) VALUES (1,2);

INSERT INTO Service(libellé,description, debutOuverture, finOuverture, coût, idComm) VALUES ("Scolaire", "Service pour les inscriptions scolaire","01-01", "31-12", 0,3541);
INSERT INTO ServiceScolaire(idService,nomContact, numTelContact, idEnfant ) VALUES (4, "Dupont", 0612345678,)

INSERT INTO Service(libellé,description, debutOuverture, finOuverture, coût, idComm) VALUES ("Signalement", "Service pour les signalements communaux","01-01", "31-12", 0,3541);

INSERT INTO Service(libellé,description, debutOuverture, finOuverture, coût, idComm) VALUES ("Etat Civil", "Service pour les Etats Civil","01-01", "31-12", 0,3541);


INSERT INTO Demande(dateDemande, message, idService, idCit) VALUES ("2011-01-01", "mariage avec ma femme",3,1);
INSERT INTO ServiceUnionCivile(idDmd,datePrévue,type,idCit,idService) VALUES (1,"2012-05-16","mariage",1,3);
INSERT INTO Contrat(idCit,idCit_1) VALUES (1,2);

INSERT INTO Demande(dateDemande, message, idService, idCit) VALUES ("2018-07-11", "mariage svp",3,4);
INSERT INTO ServiceUnionCivile(idDmd,datePrévue,type,idCit,idService) VALUES (2,"2018-06-09","mariage",4,3);

INSERT INTO Demande(dateDemande,message, idService,idCit) VALUES("2021-09-12", "inscrire mon fils a la cantine",1, 1);
INSERT INTO ServiceRestauration(idDmd,tarifsRéduits,idCantine,idService) VALUES(3,TRUE,1,1);
                                
INSERT INTO Demande(dateDemande, message, idService, idCit) VALUES("2023-08-28", "inscrire mon fils a l'ecole", 4,2);
INSERT INTO ServiceScolaire(idDmd, nomContact, numTelContact, idEnfant, idService ) VALUES (1,"Dupont Pierre", NULL, 2, 4);

INSERT INTO Demande(dateDemande, message, idService, idCit) VALUES("2023-12-01", "refaire mon passeport", 6,3);
INSERT INTO ServiceEtatCivil(idDmd, dateMiseDispoDoc, typeDocs, idService) VALUES (9,"2023-12-03", "passeport", 6);