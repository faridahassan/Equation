<?php

/*
 * This file is part of the FOSUserBundle package.
 *
 * (c) FriendsOfSymfony <http://friendsofsymfony.github.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Crm\FosUserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RegistrationFormType extends AbstractType
{
	
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
        $builder->add('name');
	}

	public function getParent()
	{
		return 'fos_user_registration';
	}

	public function getName()
	{
		return 'app_user_registration';
	}
}
