SELECT email from users GROUP BY email HAVING count(email) > 1;

SELECT u.login FROM users u LEFT JOIN orders o on u.id = o.user_id WHERE o.user_id IS NULL;

SELECT u.login FROM users u WHERE u.id IN
    (SELECT o.user_id FROM orders o GROUP BY o.user_id HAVING count(o.user_id) > 2);
