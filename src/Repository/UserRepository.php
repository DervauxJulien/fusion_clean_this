<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;
use League\OAuth2\Client\Provider\GoogleUser;

/**
 * @extends ServiceEntityRepository<User>
 *
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" sont pas supportées.', $user::class));
        }

        $user->setPassword($newHashedPassword);
        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();
    }

    public function findOrCreateFromGoogleOauth(GoogleUser $googleUser, EntityManagerInterface $em): User
    {
        $user = $this->createQueryBuilder('u')
            ->where('u.username = :username')
            ->setParameter('google_id', $googleUser->getId())
            ->getQuery()
            ->getOneOrNullResult();

        if ($user) {
            return $user;
        }

        $email = $googleUser->getEmail();
        $user = $this->findOneBy(['email' => $email]);

        if ($user) {
            $user->setGoogleId($googleUser->getId());
            $em->persist($user);
            $em->flush();
            return $user;
        }

        throw new \Exception('Utilisateur non trouvé');
    }
}
