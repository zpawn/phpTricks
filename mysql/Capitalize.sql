-- Capitalize One Word
UPDATE cscart_users SET firstname = LOWER(firstname);
UPDATE cscart_users SET firstname = CONCAT(UCASE(LEFT(firstname, 1)), SUBSTRING(firstname, 2));
