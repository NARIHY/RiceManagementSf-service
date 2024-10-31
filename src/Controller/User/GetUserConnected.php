<?php 
namespace App\Controller\User;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class GetUserConnected extends AbstractController 
{
    public function __invoke() {
         $user = $this->getUser();
         if ($user) {
             $user->eraseCredentials();
         }
         return $this->json($user);
    }
}