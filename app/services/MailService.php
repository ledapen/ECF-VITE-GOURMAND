<?php
declare(strict_types=1);

class MailService
{
    public static function send(string $to, string $subject, string $message): bool
    {
        // Version simple pour l'ECF.
        // En production, remplacer par Symfony Mailer, PHPMailer ou un SMTP sécurisé.
        $headers = [
            'From: contact@vitegourmand.fr',
            'Content-Type: text/plain; charset=UTF-8'
        ];

        return mail($to, $subject, $message, implode("\r\n", $headers));
    }

    public static function welcome(string $email, string $prenom): void
    {
        self::send(
            $email,
            'Bienvenue chez Vite & Gourmand',
            "Bonjour {$prenom},\n\nVotre compte a bien été créé.\nVous pouvez maintenant commander vos menus en ligne.\n\nVite & Gourmand"
        );
    }

    public static function orderConfirmation(string $email, string $menuTitle, float $total): void
    {
        self::send(
            $email,
            'Confirmation de votre commande',
            "Bonjour,\n\nVotre commande du menu {$menuTitle} est enregistrée.\nMontant total : {$total} €.\n\nVite & Gourmand"
        );
    }
}
