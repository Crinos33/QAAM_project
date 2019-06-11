<?php

/*
 * This file is part of the FOSUserBundle package.
 *
 * (c) FriendsOfSymfony <http://friendsofsymfony.github.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Event;

use FOS\UserBundle\Event\UserEvent;
use FOS\UserBundle\Model\UserInterface;
use Symfony\Component\HttpFoundation\Request;

class FilterUserRegistrationEvent extends UserEvent
{
    /**
     * FilterUserRegistrationEvent constructor.
     *
     * @param UserInterface $user
     * @param Request       $request
     */
    public function __construct(UserInterface $user, Request $request)
    {
        parent::__construct($user, $request);
    }
}
