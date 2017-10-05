-- Lisää CREATE TABLE lauseet tähän tiedostoon

CREATE TABLE Customer(
    id SERIAL PRIMARY KEY,
    name varchar(50) NOT NULL,
    password_hash varchar(50) NOT NULL,
    salt varchar(10)
); 

CREATE TABLE Recipe(
    id SERIAL PRIMARY KEY,
    customer_id INTEGER REFERENCES Customer(id),
    name varchar(100) NOT NULL,
    instructions varchar(5000)
);

CREATE TABLE Ingredient (
    id SERIAL PRIMARY KEY,
    name varchar(50) NOT NULL
);

CREATE TABLE Unit (
    id SERIAL PRIMARY KEY,
    name varchar(20) NOT NULL
);

CREATE TABLE IngredientOfARecipe (
    id SERIAL PRIMARY KEY,
    recipe_id INTEGER REFERENCES Recipe(id),
    ingredient_id INTEGER REFERENCES Ingredient(id),
    unit_id INTEGER REFERENCES Unit(id),
    amount decimal,
    listorder INTEGER 
);

CREATE TABLE Tag (
    id SERIAL PRIMARY KEY,
    name varchar(100) NOT NULL
);

CREATE TABLE TagOfARecipe (
    id SERIAL PRIMARY KEY,
    recipe_id INTEGER REFERENCES Recipe(id),
    tag_id INTEGER REFERENCES Tag(id)
);

CREATE TABLE FavoriteRecipe (
    recipe_id INTEGER REFERENCES Recipe(id),
    customer_id INTEGER REFERENCES Customer(id)
);
