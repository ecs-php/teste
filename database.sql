CREATE TABLE releases (
  id INT UNSIGNED NOT NULL AUTO_INCREMENT,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  description TEXT NULL,
  link VARCHAR(255) NOT NULL,
  tags JSON NULL,
  title VARCHAR(255) NULL,
  updated_at TIMESTAMP NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  UNIQUE INDEX link (link ASC),
  INDEX title (title ASC),
  FULLTEXT INDEX search (title ASC, description ASC),
  INDEX created_at (created_at ASC));

CREATE TABLE users (
  id INT UNSIGNED NOT NULL AUTO_INCREMENT,
  password CHAR(32) NOT NULL,
  token CHAR(32) NULL,
  username VARCHAR(255) NOT NULL,
  PRIMARY KEY (id),
  UNIQUE INDEX username (username ASC),
  INDEX login (username ASC, password ASC),
  INDEX token (token ASC));

INSERT INTO users (username, password) VALUES("gft", MD5('1234'));

INSERT INTO releases (description, link, tags, title) VALUES ('The economic and regulatory environment of recent years has placed a powerful downward pressure on any real investment within banks and other financial services firms, whilst at the same time diverting a significant portion of remaining resources to coping with rapidly evolving regulatory requirements.','http://www.gft.com/br/pt/index/discovery/publicacoes/the-complexity-challenge/','["Mercado de capitais","Regulatory Compliance","Operational efficiency"]','The complexity challenge');
INSERT INTO releases (description, link, tags, title) VALUES ('The financial services regulatory environment is in a state of constant flux. Many legislative bodies around the globe publish regulations that are growing in both volume and complexity.','http://www.gft.com/br/pt/index/discovery/publicacoes/delivering-regulatory-change-management-time-for-a-smart-approach/','["Mercado de capitais","Regulatory Compliance","Regulatory Change Management Service"]','Delivering regulatory change management: Time for a smart approach?');
INSERT INTO releases (description, link, tags, title) VALUES ('Information technology is increasingly pervading every aspect of our lives, promising fantastic opportunities for improving our health, wealth, knowledge and the way we live together.','http://www.gft.com/br/pt/index/discovery/publicacoes/general-data-protection-regulation-a-route-to-nirvana-for-client-data/','["Mercado de capitais","Regulatory Compliance","Banking","Regulatory Compliance"]','General Data Protection Regulation - a route to nirvana for client data?');
INSERT INTO releases (description, link, tags, title) VALUES ('There is still uncertainty regarding the extent of capital impact, it falls within tight parameters, as neatly expressed in the recent ISDA FRTB QIS4 Refresh summary slide, which puts capital increase factor in the range 2.4 and 1.5. ','http://www.gft.com/br/pt/index/discovery/publicacoes/frtb-now-that-the-ink-has-dried/','["Mercado de capitais","Regulatory Compliance","Risk Management"]','FRTB: Now that the ink has dried ...');
INSERT INTO releases (description, link, tags, title) VALUES ('GFT collateral specialists, led by Nick Nicholls, analyse how Triparty facilities could be an integral part of the holistic model.','http://www.gft.com/br/pt/index/discovery/publicacoes/the-triparty-otc-collateral-conundrum/','["Mercado de capitais","Regulatory Compliance","Collateral Optimiser","Risk Management"]','The Triparty OTC collateral conundrum');
INSERT INTO releases (description, link, tags, title) VALUES ('In this new digital world, complex and multi-faceted interaction with information has created tremendous challenges for design research. Though how does a researcher capture a holistic perspective from which to design?','http://www.gft.com/br/pt/index/discovery/publicacoes/mixed-methods-effectively-gaining-research-insights-in-the-new-digital-world/','["Mercado de capitais"]','Mixed Methods - Effectively gaining research insights in the new digital world');
INSERT INTO releases (description, link, tags, title) VALUES ('GFT regulation specialists analyse the best way to break down MiFID II and why this is no time to delay.  ','http://www.gft.com/br/pt/index/discovery/publicacoes/mifid-ll-how-to-eat-the-elephant/','["Mercado de capitais"]','MiFID II: How to eat the elephant');
INSERT INTO releases (description, link, tags, title) VALUES ('GFT specialists look into the recent Blockchain phenomenon and provide a blueprint for initiating business change.','http://www.gft.com/br/pt/index/discovery/publicacoes/a-blueprint-for-initiating-business-change-using-blockchain/','["Mercado de capitais"]','A blueprint for initiating business change using Blockchain');
INSERT INTO releases (description, link, tags, title) VALUES ('Agile Banking provides a new path to compete with both FinTechs and major internet players who enter the world of banking. 
','http://www.gft.com/br/pt/index/discovery/publicacoes/agile-banking/','["Banking"]','Agile Banking');