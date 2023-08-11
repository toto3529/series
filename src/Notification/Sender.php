<?php

namespace App\Notification;

use Symfony\Component\Security\Core\User\UserInterface;

class Sender
{
    public function sendNewUserNotificationToAdmin(UserInterface $user)

    {
        //pour tester pour vérifer que la méthode fonctionne bien
        //file_put_contents('debug.txt', $user->getEmail());
    }

}