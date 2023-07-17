<?php

namespace App\Security;

use Symfony\Component\Validator\Constraints as Assert;

class Security
{
    public function secureData(string $data) : string
    {
        return trim(stripslashes(htmlspecialchars($data)));
    }

}
