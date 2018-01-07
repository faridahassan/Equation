<?php

namespace Crm\NotificationBundle\DAO;

use DoctrineExtensions\Query\Mysql\Day;

/**
 * LeadRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class DealNotificationRepository extends \Doctrine\ORM\EntityRepository
{
	public function getDigestReport()
	{
		$query = $this->getEntityManager()->createQuery(
			'SELECT  dn.type,count(dn) as number
			from CrmNotificationBundle:DealNotification  dn
			where dn.system = true
			and dn.seen = false
			group by  dn.type
			')
		;
		return ($query->getResult());
	}
	public function getDigestNotifications()
	{
		$query = $this->getEntityManager()->createQuery(
			'SELECT  dn
			from CrmNotificationBundle:DealNotification  dn
			where dn.system = true
			')
		;
		return ($query->getResult());
	}

}
