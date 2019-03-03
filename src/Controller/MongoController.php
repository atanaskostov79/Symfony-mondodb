<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Document\User;
use App\Repositories\UserRepository;
use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doctrine\ODM\MongoDB\DocumentRepository;


class MongoController  extends Controller
{
    

    private $documentManager;
    private $userRepository;

    public function __construct(
        DocumentManager $documentManager,
        UserRepository $userRepository
    ) {
        $this->documentManager = $documentManager;
        $this->userRepository = $userRepository;
    }
    
    
    /**
     * @Route("/mongoTest", methods={"GET"})
     */
    public function mongoTest(DocumentManager $dm)
    {
        for ($r = 0; $r <= 1000000; $r++){

        echo $r."\n\r";
        $user = new User();
        $user->setEmail("ankostov@gmail.com");
        $user->setFirstname("Atanas " . $r);
        $user->setLastname("Kostov");
        $user->setPassword(md5("!QWERTY"));

        $dm->persist($user);
        $dm->flush();
        }
        return new JsonResponse(array('Status' => 'OK'));
    }

    /**
     * @return mixed
     * @Route("/mongoLoad", methods={"GET"})
     */
    public function findAll()
    {
        $users = $this->userRepository->findAll();
       // var_dump($users);
        $i = 0;
        $result = [];
        foreach ($users as $user) {
            $result[$i]['id'] = (string)$user->getId();
            $result[$i]['firstname'] = $user->getFirstname();


            $i++;
        }
        return new JsonResponse($result);
    }
}

