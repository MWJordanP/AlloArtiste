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
     * @param string      $token
     * @param string|null $role
     *
     * @return User
     */
    public function getToken($token, $role = null)
    {
        /** @var User $user */
        $user = $this->userManager->findUserBy(['token' => $token]);
        if ($user !== null) {
            if (null !== $role) {
                if ($user->hasRole($role)) {
                    return $user;
                }
            } else {
                return $user;
            }
        }

        return null;
    }

    /**
     * @param integer $id
     *
     * @return User
     */
    public function getById($id)
    {
        $user = $this->repository->find($id);

        return $user;
    }

    /**
     * @param User $user
     *
     * @return string
     */
    public function password(User $user)
    {
        $password = substr(md5(rand()), 0, 7);
        $user->setPlainPassword($password);
        $this->userManager->updateUser($user);

        return $password;
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
            /** @var User $user */
            foreach ($data as $user) {
                $array[] = [
                    'Id'           => $user->getId(),
                    'LastName'     => $user->getLastName(),
                    'FirsName'     => $user->getFirstName(),
                    'Phone'        => $user->getPhone(),
                    'Email'        => $user->getEmail(),
                    'Picture'      => $user->getPicture(),
                    'Token'        => $user->getToken(),
                    'Street'       => $user->getStreet(),
                    'StreetNumber' => $user->getStreetNumber(),
                ];
            }

            return $array;
        } else {
            return [
                'Id'           => $data->getId(),
                'LastName'     => $data->getLastName(),
                'FirsName'     => $data->getFirstName(),
                'Phone'        => $data->getPhone(),
                'Email'        => $data->getEmail(),
                'Picture'      => $data->getPicture(),
                'Token'        => $data->getToken(),
                'Street'       => $data->getStreet(),
                'StreetNumber' => $data->getStreetNumber(),
            ];
        }
    }
}
