<?php

namespace Crm\SandboxBundle\DAO;

use Crm\SandboxBundle\Entity\Task;
/**
 * CallRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class TaskRepository extends \Doctrine\ORM\EntityRepository
{
	public function getDueTasks($user)
	{
		$query = $this->getEntityManager()->createQuery(
			'SELECT t
			from CrmSandboxBundle:Task t
			where t.user = :userId
			and t.done = false
			and t.canceled = false
			and t.date < CURRENT_DATE() + 1

			'
			)
			->setParameter('userId', $user->getId());
			return ($query->getResult());
	}
	public function getDailyTasks($user)
	{
		$query = $this->getEntityManager()->createQuery(
			'SELECT t.type,count(t.type) as number
			from CrmSandboxBundle:Task t
			where t.user = :userId
			and t.done = false
			and t.canceled = false
			and t.date < CURRENT_DATE() + 1
			and t.date > CURRENT_DATE() - 1
			group by t.type
			'
			)
			->setParameter('userId', $user->getId());
			return ($query->getResult());
	}
	public function getMeetingsOn($user,$beginDate,$endDate)
	{
		$query = $this->getEntityManager()->createQuery(
			"
			SELECT t
			from CrmSandboxBundle:Task t
			where t.user = :userId
			and t.done = false
			and t.canceled = false
			and t.type = 'meeting'
			and t.date > :begindate
			and t.date < :enddate
			"
			)
			->setParameter('userId', $user)
			->setParameter('begindate', $beginDate)
			->setParameter('enddate', $endDate)
			;
			return ($query->getResult());
	}


	///////////////// USER TASKS /////////////////////
	public function getPendingTasks($user)
	{
		$query = $this->getEntityManager()->createQuery(
			"SELECT t 
			from CrmSandboxBundle:Task t
			where t.user = :userId
			and t.done = false
			and t.canceled = false
			and t.type = 'call'
			and t.date < CURRENT_DATE() 
			"
			)
			->setParameter('userId', $user->getId());

		$calls= $query->getResult();
		$query = $this->getEntityManager()->createQuery(
			"SELECT t 
			from CrmSandboxBundle:Task t
			where t.user = :userId
			and t.done = false
			and t.canceled = false
			and t.type = 'meeting'
			and t.date < CURRENT_DATE() 
			"
			)
			->setParameter('userId', $user->getId());
		$meetings = $query->getResult();

		$result['calls'] = $calls;
		$result['meetings'] = $meetings;
		return $result;

	}
	public function getTodaysTasks($user)
	{
		$query = $this->getEntityManager()->createQuery(
			"SELECT t 
			from CrmSandboxBundle:Task t
			where t.user = :userId
			and t.done = false
			and t.canceled = false
			and t.type = 'call'
			and t.date < CURRENT_DATE() + 1
			and t.date > CURRENT_DATE() - 1
			"
			)
			->setParameter('userId', $user->getId());

		$calls= $query->getResult();
		$query = $this->getEntityManager()->createQuery(
			"SELECT t 
			from CrmSandboxBundle:Task t
			where t.user = :userId
			and t.done = false
			and t.canceled = false
			and t.type = 'meeting'
			and t.date < CURRENT_DATE() + 1
			and t.date > CURRENT_DATE() - 1
			"
			)
			->setParameter('userId', $user->getId());
		$meetings = $query->getResult();

		$result['calls'] = $calls;
		$result['meetings'] = $meetings;
		return $result;
	}
	public function getUpcomingTasks($user)
	{
		$query = $this->getEntityManager()->createQuery(
			"SELECT t 
			from CrmSandboxBundle:Task t
			where t.user = :userId
			and t.done = false
			and t.canceled = false
			and t.type = 'call'
			and t.date > CURRENT_DATE() +1
			"
			)
			->setParameter('userId', $user->getId());

		$calls= $query->getResult();
		$query = $this->getEntityManager()->createQuery(
			"SELECT t 
			from CrmSandboxBundle:Task t
			where t.user = :userId
			and t.done = false
			and t.canceled = false
			and t.type = 'meeting'
			and t.date > CURRENT_DATE() +1
			"
			)
			->setParameter('userId', $user->getId());
		$meetings = $query->getResult();

		$result['calls'] = $calls;
		$result['meetings'] = $meetings;
		// dump($meetings);
		// exit;
		return $result;
	}
	public function getCancelledTasks($user)
	{
		$query = $this->getEntityManager()->createQuery(
			"SELECT t 
			from CrmSandboxBundle:Task t
			where t.user = :userId
			and t.canceled = true
			and t.type = 'call'
			and t.cancelDate < CURRENT_DATE() + 1
			and t.cancelDate > CURRENT_DATE() - 7
			"
			)
			->setParameter('userId', $user->getId());

		$calls= $query->getResult();
		$query = $this->getEntityManager()->createQuery(
			"SELECT t 
			from CrmSandboxBundle:Task t
			where t.user = :userId
			and t.canceled = true
			and t.type = 'meeting'
			and t.cancelDate < CURRENT_DATE() + 1
			and t.cancelDate > CURRENT_DATE() - 7
			"
			)
			->setParameter('userId', $user->getId());
		$meetings = $query->getResult();

		$result['calls'] = $calls;
		$result['meetings'] = $meetings;
		// dump($meetings);
		// exit;
		return $result;
	}
	/////////////////// END USER TASKS ///////////////////////


	///////////////// TEAM TASKS /////////////////////
	public function getTeamPendingTasks($team)
	{
		
		$query = $this->getEntityManager()->createQuery(
			"SELECT t 
			from CrmSandboxBundle:Task t
			join t.user u
			join u.team team
			where team.id = :teamId
			and t.done = false
			and t.canceled = false
			and t.type = 'call'
			and t.date < CURRENT_DATE() 
			"
			)
			->setParameter('teamId', $team->getId());

		$calls= $query->getResult();
		$query = $this->getEntityManager()->createQuery(
			"SELECT t 
			from CrmSandboxBundle:Task t
			join t.user u
			join u.team team
			where team.id = :teamId
			and t.done = false
			and t.canceled = false
			and t.type = 'meeting'
			and t.date < CURRENT_DATE() 
			"
			)
			->setParameter('teamId', $team->getId());

		$meetings = $query->getResult();

		$result['calls'] = $calls;
		$result['meetings'] = $meetings;
		return $result;

	}
	public function getTeamTodaysTasks($team)
	{
		$query = $this->getEntityManager()->createQuery(
			"SELECT t 
			from CrmSandboxBundle:Task t
			join t.user u
			join u.team team
			where team.id = :teamId
			and t.done = false
			and t.canceled = false
			and t.type = 'call'
			and t.date < CURRENT_DATE() + 1
			and t.date > CURRENT_DATE() - 1
			"
			)
			->setParameter('teamId', $team->getId());

		$calls= $query->getResult();
		$query = $this->getEntityManager()->createQuery(
			"SELECT t 
			from CrmSandboxBundle:Task t
			join t.user u
			join u.team team
			where team.id = :teamId
			and t.done = false
			and t.canceled = false
			and t.type = 'meeting'
			and t.date < CURRENT_DATE() + 1
			and t.date > CURRENT_DATE() - 1
			"
			)
			->setParameter('teamId', $team->getId());

		$meetings = $query->getResult();

		$result['calls'] = $calls;
		$result['meetings'] = $meetings;
		return $result;
	}
	public function getTeamUpcomingTasks($team)
	{
		$query = $this->getEntityManager()->createQuery(
			"SELECT t 
			from CrmSandboxBundle:Task t
			join t.user u
			join u.team team
			where team.id = :teamId
			and t.done = false
			and t.canceled = false
			and t.type = 'call'
			and t.date > CURRENT_DATE() +1 
			"
			)
			->setParameter('teamId', $team->getId());

		$calls= $query->getResult();
		$query = $this->getEntityManager()->createQuery(
			"SELECT t 
			from CrmSandboxBundle:Task t
			join t.user u
			join u.team team
			where team.id = :teamId
			and t.done = false
			and t.canceled = false
			and t.type = 'meeting'
			and t.date > CURRENT_DATE() +1 
			"
			)
			->setParameter('teamId', $team->getId());

		$meetings = $query->getResult();

		$result['calls'] = $calls;
		$result['meetings'] = $meetings;
		return $result;
	}
	public function getTeamCancelledTasks($team)
	{
		$query = $this->getEntityManager()->createQuery(
			"SELECT t 
			from CrmSandboxBundle:Task t
			join t.user u
			join u.team team
			where team.id = :teamId
			and t.canceled = true
			and t.type = 'call'
			"
			)
			->setParameter('teamId', $team->getId());

		$calls= $query->getResult();
		$query = $this->getEntityManager()->createQuery(
			"SELECT t 
			from CrmSandboxBundle:Task t
			join t.user u
			join u.team team
			where team.id = :teamId
			and t.canceled = true
			and t.type = 'meeting'
			"
			)
			->setParameter('teamId', $team->getId());

		$meetings = $query->getResult();

		$result['calls'] = $calls;
		$result['meetings'] = $meetings;
		return $result;
	}
	/////////////////// END TEAM TASKS ///////////////////////
}
