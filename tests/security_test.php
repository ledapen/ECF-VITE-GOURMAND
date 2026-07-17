<?php
declare(strict_types=1);

function assertTrue(bool $value, string $message): void {
    if (!$value) {
        echo "ECHEC: $message\n";
        exit(1);
    }
}

$password = 'Admin1234!';
$hash = password_hash($password, PASSWORD_DEFAULT);
assertTrue(password_verify($password, $hash), 'password_hash/password_verify');

$weak = 'abc';
$strong = 'Abcdef123!';
$regex = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^A-Za-z\d]).{10,}$/';

assertTrue(!preg_match($regex, $weak), 'mot de passe faible refusé');
assertTrue((bool)preg_match($regex, $strong), 'mot de passe fort accepté');

$input = '<script>alert(1)</script>';
$escaped = htmlspecialchars($input, ENT_QUOTES, 'UTF-8');
assertTrue($escaped !== $input, 'échappement XSS');

echo "OK security tests\n";
