<?php

namespace App\Repository;

use App\Entity\Vote;
use App\Entity\Joueur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Vote>
 *
 * @method Vote|null find($id, $lockMode = null, $lockVersion = null)
 * @method Vote|null findOneBy(array $criteria, array $orderBy = null)
 * @method Vote[]    findAll()
 * @method Vote[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VoteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Vote::class);
    }

    public function getVotesByJoueur($id): array
    {
        return $this->createQueryBuilder('v')
            ->join('v.JouerVote', 'j')
            ->where('j.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getResult();
    }
    


}
