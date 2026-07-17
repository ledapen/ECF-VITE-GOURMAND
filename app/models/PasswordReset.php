<?php
declare(strict_types=1);

class PasswordReset
{
    public static function create(string $email): ?string
    {
        $user = User::findByEmail($email);
        if (!$user) {
            return null;
        }

        $token = bin2hex(random_bytes(32));
        $pdo = Database::getConnection();

        $pdo->prepare("DELETE FROM password_reset WHERE email = :email")->execute(['email' => $email]);

        $stmt = $pdo->prepare("INSERT INTO password_reset (email, token, expires_at)
                               VALUES (:email, :token, DATE_ADD(NOW(), INTERVAL 1 HOUR))");
        $stmt->execute([
            'email' => $email,
            'token' => password_hash($token, PASSWORD_DEFAULT)
        ]);

        return $token;
    }

    public static function verify(string $email, string $token): bool
    {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("SELECT * FROM password_reset
                               WHERE email = :email AND expires_at > NOW()
                               ORDER BY created_at DESC LIMIT 1");
        $stmt->execute(['email' => $email]);
        $row = $stmt->fetch();

        return $row && password_verify($token, $row['token']);
    }

    public static function delete(string $email): void
    {
        Database::getConnection()->prepare("DELETE FROM password_reset WHERE email = :email")
            ->execute(['email' => $email]);
    }
}
