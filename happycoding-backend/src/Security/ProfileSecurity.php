<?php

namespace App\Security;

use Symfony\Component\Validator\Constraints as Assert;

class ProfileSecurity
{
    public function emailContraints()
    {
        $contraints = new Assert\Collection([
            'old' => [
                new Assert\NotBlank(message: "Vous devez saisir un mot de passe !"),
            ],
            'new' => [
                new Assert\NotBlank(['message' => "Vous devez saisir un mot de passe !"]),
                new Assert\Length(
                    min: 8,
                    max: 20,
                    minMessage: "Le mot de passe doit comporter au minimum 8 caractères !",
                    maxMessage: "Le mot de passe ne doit pas comporter plus de 20 caractères !"
                ),
                new Assert\Regex(
                    pattern: "/[A-Z]/",
                    message: "Vous devez respecter le format du mot de passe !"
                ),
                new Assert\Regex(
                    pattern: "/[a-z]/",
                    message: "Vous devez respecter le format du mot de passe !"
                ),
                new Assert\Regex(
                    pattern: "/[\d]/",
                    message: "Vous devez respecter le format du mot de passe !"
                ),
                new Assert\Regex(
                    pattern: "/[ç&#@%\$€µ£=*\-+\/%_?.,;:!\"'<>^(){}[\]|°§¤]/",
                    message: "Vous devez respecter le format du mot de passe !"
                ),
                new Assert\Regex(
                    pattern: "/[^\wç&#@%\$€µ£=*\-+\/%_?.,;:!\"'<>^(){}[\]|°§¤]/",
                    match: false,
                    message: "Vous devez respecter le format du mot de passe !"
                ),
            ],
        ]);

        return $contraints;

    }

}
