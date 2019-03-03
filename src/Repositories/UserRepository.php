<?php

namespace App\Repositories;
use Doctrine\ODM\MongoDB\DocumentRepository;
use Doctrine\ODM\MongoDB\DocumentManager;
use App\Document\User;

class UserRepository extends DocumentRepository
{
    public function __construct(DocumentManager $dm)
    {
        $uow = $dm->getUnitOfWork();
        $classMetaData = $dm->getClassMetadata(User::class);
        parent::__construct($dm, $uow, $classMetaData);
    }

    /**
     * @return mixed
     */
    public function findAll()
        {
            return
                $this->createQueryBuilder('User')
                    ->sort('firstname', 'desc')
                    ->getQuery()
                    ->execute();
        }

    /**
     * @param string $field
     * @param string $data
     *
     * @return array|null|object
     */
    public function findOneByProperty($field, $data)
    {
        return
            $this->createQueryBuilder('User')
                ->field($field)->equals($data)
                ->getQuery()
                ->getSingleResult();
    }

}
