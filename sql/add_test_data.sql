-- Lisää INSERT INTO lauseet tähän tiedostoon
#Test data for the Customer table
INSERT INTO Customer (name, password) VALUES ('Vanamo', 'sala123');
INSERT INTO Customer (name, password) VALUES ('Esko', 'E123O');

#Test data for the Ingredient table
INSERT INTO Ingredient (name) VALUES ('kananmuna');
INSERT INTO Ingredient (name) VALUES ('vehnäjauho');
INSERT INTO Ingredient (name) VALUES ('pakastepinaatti');
INSERT INTO Ingredient (name) VALUES ('maito');
INSERT INTO Ingredient (name) VALUES ('suola');

#Test data for the Unit table
INSERT INTO Unit (name) VALUES ('kpl');
INSERT INTO Unit (name) VALUES ('rkl');
INSERT INTO Unit (name) VALUES ('dl');

#Test data for the Tag table
INSERT INTO Tag (name) VALUES ('kasvisruoka');
INSERT INTO Tag (name) VALUES ('helppo');

#Test data for the Recipe table
INSERT INTO Recipe (customer_id, name, instructions)
    VALUES ((select id from Customer where name = 'Vanamo'), 
            'Pinaattiletut', 'Sekoita aineet keskenään. Paista 200 asteessa 30 min.');
