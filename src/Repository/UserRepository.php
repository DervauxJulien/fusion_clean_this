<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
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
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', $user::class));
        }

        $user->setPassword($newHashedPassword);
        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();
    }

    public function findOrCreateFromGoogleOauth(GoogleUser $googleUser): User
    {
        // Rechercher l'utilisateur par son ID Google
        $user = $this->createQueryBuilder('u')
            ->where('u.googleId = :googleId')
            ->setParameter('googleId', $googleUser->getId())
            ->getQuery()
            ->getOneOrNullResult();

        // Si l'utilisateur existe, le retourner
        if ($user) {
            return $user;
        }

        // Sinon, créer un nouvel utilisateur
        $user = (new User())
            ->setRoles(['ROLE_USER'])
            ->setGoogleId($googleUser->getId())
            ->setEmail($googleUser->getEmail());

        $em = $this->getEntityManager();
        $em->persist($user);
        $em->flush();

        return $user;
    }
}
