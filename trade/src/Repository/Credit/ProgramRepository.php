<?php

namespace App\Repository\Credit;

use App\Entity\Credit\Program\Program;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Program>
 */
class ProgramRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Program::class);
    }

	public function findByCondition(float $minDownPaymentPercent, int $loanTerm): ?Program
	{
		$queryBuilder = $this->createQueryBuilder('p');
		$query = $queryBuilder
			->andWhere('p.minDownPaymentPercent <= :minDownPaymentPercent and p.loanTerm > :loan_term')
			->setParameter('minDownPaymentPercent', $minDownPaymentPercent)
			->setParameter('loan_term', $loanTerm)
			->orWhere('p.isDefault = 1')
			->addOrderBy('p.interestRate', 'ASC')
			->setMaxResults(1)
		;

		return $query->getQuery()->getOneOrNullResult();
	}
}
