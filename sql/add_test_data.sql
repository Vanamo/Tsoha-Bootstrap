-- Lisää INSERT INTO lauseet tähän tiedostoon

--Test data for the Customer table
INSERT INTO Customer (name, password_hash, salt) VALUES ('Vanamo', 'sala123', 'da#?');
INSERT INTO Customer (name, password_hash, salt) VALUES ('Esko', 'E123O', 'da#?');
INSERT INTO Customer (name, password_hash, salt) VALUES ('Testi', 'testi', 'da#?');

--Test data for the Ingredient table
INSERT INTO Ingredient (name) VALUES ('kananmuna');
INSERT INTO Ingredient (name) VALUES ('vehnäjauho');
INSERT INTO Ingredient (name) VALUES ('pakastepinaatti');
INSERT INTO Ingredient (name) VALUES ('maito');
INSERT INTO Ingredient (name) VALUES ('suola');

--Test data for the Unit table
INSERT INTO Unit (name) VALUES ('kpl');
INSERT INTO Unit (name) VALUES ('rkl');
INSERT INTO Unit (name) VALUES ('dl');
INSERT INTO Unit (name) VALUES ('pss');

--Test data for the Tag table
INSERT INTO Tag (name) VALUES ('kasvisruoka');
INSERT INTO Tag (name) VALUES ('helppo');

--Test data for the Recipe table
INSERT INTO Recipe (customer_id, name, instructions)
    VALUES ((SELECT id FROM Customer WHERE name = 'Vanamo'), 
            'Pinaattiletut', 'Sekoita aineet keskenään. Paista 200 asteessa 30 min.');
INSERT INTO Recipe (customer_id, name, instructions)
    VALUES ((SELECT id FROM Customer WHERE name = 'Vanamo'), 
            'Munakas', 'Vatkaa munat. Lisää vesi ja mausteet, sekoita. Paista pannulla.');


--Test data for the IngredientOfARecipe table
INSERT INTO IngredientOfARecipe (recipe_id, ingredient_id, unit_id, amount, listOrder)
    VALUES ((SELECT id FROM Recipe WHERE name = 'Pinaattiletut'),
            (SELECT id FROM Ingredient WHERE name = 'kananmuna'),
            (SELECT id FROM Unit WHERE name = 'kpl'), 2, 1);
INSERT INTO IngredientOfARecipe (recipe_id, ingredient_id, unit_id, amount, listOrder)
    VALUES ((SELECT id FROM Recipe WHERE name = 'Pinaattiletut'),
            (SELECT id FROM Ingredient WHERE name = 'vehnäjauho'),
            (SELECT id FROM Unit WHERE name = 'dl'), 3, 2);
INSERT INTO IngredientOfARecipe (recipe_id, ingredient_id, unit_id, amount, listOrder)
    VALUES ((SELECT id FROM Recipe WHERE name = 'Pinaattiletut'),
            (SELECT id FROM Ingredient WHERE name = 'pakastepinaatti'),
            (SELECT id FROM Unit WHERE name = 'pss'), 1, 3);

--Test data for the TagOfARecipe table
INSERT INTO TagOfARecipe (recipe_id, tag_id)
    VALUES ((SELECT id FROM Recipe WHERE name = 'Pinaattiletut'),
            (SELECT id FROM Tag WHERE name = 'kasvisruoka'));