<?php

namespace AppBundle\Manager;

use AppBundle\Entity\User;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Knp\Component\Pager\Paginator;
use Symfony\Component\HttpFoundation\Request;
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
     * @param null $city
     * @param null $job
     * @param null $tag
     *
     * @return array
     */
    public function search($city = null, $job = null, $tag = null)
    {
        return $this->repository->search($city, $job, $tag);
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
                    'id'           => $user->getId(),
                    'username'     => $user->getUsername(),
                    'lastName'     => $user->getLastName(),
                    'firsName'     => $user->getFirstName(),
                    'phone'        => $user->getPhone(),
                    'email'        => $user->getEmail(),
                    'images'       => $user->displayPictures(),
                    'description'  => $user->getDescription(),
                    'picture'      => $user->getPicture(),
                    'token'        => $user->getToken(),
                    'street'       => $user->getStreet(),
                    'streetNumber' => $user->getStreetNumber(),
                    'job'          => $user->displayJob(),
                    'tags'         => $user->displayTags(),
                    'city'         => $user->displayCity(),
                    'longitude'    => null !== $user->getCity() ? $user->getCity()->getLongitude() : null,
                    'latitude'     => null !== $user->getCity() ? $user->getCity()->getLatitude() : null,
                ];
            }

            return $array;
        } else {
            return [
                'id'           => $data->getId(),
                'username'     => $data->getUsername(),
                'lastName'     => $data->getLastName(),
                'firsName'     => $data->getFirstName(),
                'phone'        => $data->getPhone(),
                'email'        => $data->getEmail(),
                'images'       => $data->displayPictures(),
                'description'  => $data->getDescription(),
                'picture'      => $data->getPicture(),
                'token'        => $data->getToken(),
                'street'       => $data->getStreet(),
                'streetNumber' => $data->getStreetNumber(),
                'job'          => $data->displayJob(),
                'tags'         => $data->displayTags(),
                'city'         => $data->displayCity(),
                'longitude'    => null !== $data->getCity() ? $data->getCity()->getLongitude() : null,
                'latitude'     => null !== $data->getCity() ? $data->getCity()->getLatitude() : null,
            ];
        }
    }

    /**
     * @param Request $request
     * @param User    $user
     *
     * @return bool
     */
    public function updateProfile(Request $request, User $user)
    {
        $username     = $request->request->get('username');
        $lastName     = $request->request->get('lastName');
        $firsName     = $request->request->get('firsName');
        $email        = $request->request->get('email');
        $streetNumber = $request->request->get('streetNumber');
        $phone        = $request->request->get('phone');
        $street       = $request->request->get('street');
        $job          = $request->request->get('job');
        $tags         = $request->request->get('tags');
        $city         = $request->request->get('city');
        $description  = $request->request->get('description');

        $job  = $this->em->getRepository('AppBundle:Job')->findOneBy(['id' => intval($job)]);
        $city = $this->em->getRepository('AppBundle:City')->findOneBy(['id' => intval($city)]);

        if (null !== $job && $job !== $user->getJob()) {
            $user->setJob($job);
        }
        if (null !== $city && $city !== $user->getCity()) {
            $user->setCity($city);
        }

        $user
            ->setUsername($username)
            ->setLastName($lastName)
            ->setFirstName($firsName)
            ->setEmail($email)
            ->setPhone($phone)
            ->setStreet($street)
            ->setStreetNumber($streetNumber)
            ->setDescription($description);

        $user->getTags()->clear();

        foreach ($tags as $value) {
            $tag = $this->em->getRepository('AppBundle:Tag')->findOneBy(['id' => intval($value)]);
            if (null !== $tag) {
                if (!$user->getTags()->contains($tag)) {
                    $user->getTags()->add($tag);
                }
            }
        }

        try {
            $this->userManager->updateUser($user);

            return true;
        } catch (\Exception $exception) {
            return $exception->getMessage();
        }
    }

    /**
     * @param mixed $data
     *
     * @return array
     */
    public function convertArraySearch($data)
    {
        if (is_array($data)) {
            $array = [];
            /** @var User $user */
            foreach ($data as $user) {
                $array[] = [
                    'id'           => $user->getId(),
                    'username'     => $user->getUsername(),
                    'picture'      => $user->getPicture(),
                    'street'       => $user->getStreet(),
                    'streetNumber' => $user->getStreetNumber(),
                    'job'          => $user->displayJob(),
                    'city'         => $user->displayCity(),
                    'longitude'    => null !== $user->getCity() ? $user->getCity()->getLongitude() : null,
                    'latitude'     => null !== $user->getCity() ? $user->getCity()->getLatitude() : null,
                ];
            }

            return $array;
        } else {
            return [
                'id'           => $data->getId(),
                'username'     => $data->getUsername(),
                'picture'      => $data->getPicture(),
                'street'       => $data->getStreet(),
                'streetNumber' => $data->getStreetNumber(),
                'job'          => $data->displayJob(),
                'city'         => $data->displayCity(),
                'longitude'    => null !== $data->getCity() ? $data->getCity()->getLongitude() : null,
                'latitude'     => null !== $data->getCity() ? $data->getCity()->getLatitude() : null,
            ];
        }
    }
}
