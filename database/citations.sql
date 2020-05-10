-- Table auteur
CREATE TABLE auteur (
  id INTEGER,
  nom VARCHAR(64) NOT NULL,
  prenom VARCHAR(64) NOT NULL,
  PRIMARY KEY(id)
);
INSERT INTO auteur (id, nom, prenom) VALUES
(1, 'de Montesquieu', 'Charles'),
(2, 'Hugo', 'Victor'),
(3, 'Marx', 'Karl'),
(4, 'Bernard', 'Tristan'),
(5, 'de La Fontaine', 'Jean');
-- Table siecle
CREATE TABLE siecle (
        id INTEGER,
        numero INTEGER,
        PRIMARY KEY(id)
);
INSERT INTO siecle (id, numero) VALUES
(2, 17),
(3, 18),
(4, 19),
(5, 20);
-- Table citation
CREATE TABLE citation (
  id INTEGER,
  phrase VARCHAR(255) NOT NULL,
  auteurid INTEGER,
  siecleid INTEGER,
  PRIMARY KEY(id),
  FOREIGN KEY(auteurid) REFERENCES auteur(id),
  FOREIGN KEY(siecleid) REFERENCES siecle(id)
);
INSERT INTO citation (id, phrase, auteurid, siecleid) VALUES
(1, 'Ne sentirons-nous jamais que le ridicule des autres?', 1, 3),
(2, 'L''animal a cet avantage sur l''homme qu''il ne peut être sot.', 2, 4),
(3, 'L''homme est un loup pour l''homme ', 3, 4),
(4, 'Les hommes sont toujours sincères. Ils changent de sincérité, voilà tout.', 4, 5),
(5, 'L''histoire de l''humanité est l''histoire de la lutte des classes.', 3, 4),
(6, 'Rien ne sert de courir, il faut partir à point ', 5, 2);


