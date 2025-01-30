<?php

namespace App\Repository\Credit;

use App\Entity\Credit\Request\Request;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Request>
 */
class RequestRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Request::class);
    }

	public function save(Request $request): Request
	{
		$em = $this->getEntityManager();

		$em->persist($request);
		$em->flush();

		return $request;
	}
}
