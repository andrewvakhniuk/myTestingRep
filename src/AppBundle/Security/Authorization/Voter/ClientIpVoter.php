<?php
namespace AppBundle\Security\Authorization\Voter;
/**
 * Created by PhpStorm.
 * User: Andrew
 * Date: 3/9/2017
 * Time: 9:45 AM
 */

use AppBundle\Entity\User;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Doctrine\ORM\EntityManager;



class ClientIpVoter implements VoterInterface
{
    protected $entityManager;
    protected $container;
    public function __construct(ContainerInterface $container, EntityManager $entityManager)
    {
        $this->container     = $container;
        $this->entityManager = $entityManager;
    }

    public function supportsAttribute($attribute)
    {
        // we won't check against a user attribute, so we return true
        return true;
    }
    public function supportsClass($class)
    {
        // our voter supports all type of token classes, so we return true
        return true;
    }
    function vote(TokenInterface $token, $object, array $attributes)
    {
        //if user is logged in then dont check for bad ip
        if(!$token->getUser() instanceof User) {
            $request = $this->container->get('request_stack')->getCurrentRequest();
//   ***         message
            $request->getSession()->getFlashBag()->add('info', "Voter is used, AppBundle_Security_Authorization_Voter!");

            $dayAgo = new \DateTime('now');
            $dayAgo->modify('-1 day');

            $queryBuilder = $this->entityManager->createQueryBuilder();
            $queryBuilder->
            select('count(login_history.id)')->
            from('AppBundle:LoginHistory', 'login_history')->
            andWhere($queryBuilder->expr()->gte('login_history.dateTime', ':dayAgo'))->
            setParameter('dayAgo', $dayAgo)->
            andWhere($queryBuilder->expr()->eq('login_history.success', 0))->
            andWhere($queryBuilder->expr()->eq('login_history.ip', ':ip'))->
            setParameter('ip', $request->getClientIp())->
            andWhere('login_history.user is NULL');

            //Atempts during last 24 hours
            $attempts = $queryBuilder->getQuery()->getSingleScalarResult();


            $request->getSession()->getFlashBag()->add('info', "attempts: ".$attempts);
            if ($attempts >= 3) {
//            this exception is caught in AccessDeniedListener
                throw new AccessDeniedHttpException('ERROR_BLOCKED_IP_AppBundle/Security/Authorization/Voter/ClientIpVoter');
//                return VoterInterface::ACCESS_DENIED;
            }
        }

        return VoterInterface::ACCESS_ABSTAIN;
    }
}