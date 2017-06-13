<?php

namespace AppBundle\Manager;

use AppBundle\Entity\Job;
use AppBundle\Entity\User;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Knp\Component\Pager\Paginator;
use Symfony\Component\HttpFoundation\RequestStack;
use FOS\UserBundle\Doctrine\UserManager as BaseUser;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

/**
 * Class UserManager
 */
class UserManager extends AbstractManager
{
    /**
     * @var EntityRepository
     */
    protected $repository;

    /**
     * @var BaseUser
     */
    public $userManager;

    /**
     * @var AuthorizationCheckerInterface
     */
    public $authorizationChecker;

    /**
     * UserManager constructor.
     *
     * @param EntityManager                 $entityManager
     * @param Paginator                     $paginator
     * @param RequestStack                  $requestStack
     * @param BaseUser                      $userManager
     * @param AuthorizationCheckerInterface $authorizationChecker
     */
    public function __construct(
        EntityManager $entityManager,
        Paginator $paginator,
        RequestStack $requestStack,
        BaseUser $userManager,
        AuthorizationCheckerInterface $authorizationChecker
    ) {
        parent::__construct($entityManager, $paginator, $requestStack);
        $this->repository           = $entityManager->getRepository('AppBundle:User');
        $this->userManager          = $userManager;
        $this->authorizationChecker = $authorizationChecker;
    }

    /**
     * @param string $token
     * @param string $role
     *
     * @return User
     */
    public function getToken($token, $role)
    {
        /** @var User $user */
        $user = $this->userManager->findUserBy(['token' => $token]);
        if ($user !== null) {
            if ($this->authorizationChecker->isGranted($role, $user)) {
                return $user;
            }
        }

        return null;
    }

    /**
     * @param mixed $data
     *
     * @return array
     */
    public function convertArray($data)
    {
        if (is_array($data)) {
            $array = [];
            /** @var Job $job */
            foreach ($data as $job) {
                $array[] = [
                    'Id'   => $job->getId(),
                    'Name' => $job->getName(),
                ];
            }

            return $array;
        } else {
            return [
                'Id'   => $data->getId(),
                'Name' => $data->getName(),
            ];
        }
    }
}
