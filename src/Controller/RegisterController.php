<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegisterController extends AbstractController
{
    /**
     * @Route("/register", name="register")
     * @param Request $request
     * @param UserPasswordEncoderInterface $encoder
     * @return Response
     */
    public function register(Request $request, UserPasswordEncoderInterface $encoder): Response
    {
        $form = $this->createFormBuilder()
            ->add('username', TextType::class, [
                'required' => true,
                'label' => 'Username'
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'required' => true,
                'first_options' => ['label' => 'Password'],
                'second_options' => ['label' => 'Confirm Password']
            ])
            ->add('register', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-success'
                ]
            ])
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $data = $form->getData();

            if ($this->checkIfUsernameExists($data)) {
                $this->addFlash('register_error', 'Username is allready in use!');

                return $this->redirectToRoute('register');
            }
            if (!isset($data['password'])) {
                $this->addFlash('register_error', 'Passwords are not matching!');

                return $this->redirectToRoute('register');
            }
            $user = $this->setUserData($data, $encoder);
            $this->flushUserData($user);

            return $this->redirectToRoute('app_login');
        }

        return $this->render('register/index.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @param $data
     * @param UserPasswordEncoderInterface $encoder
     * @return User
     */
    private function setUserData(array $data, UserPasswordEncoderInterface $encoder): User
    {
        $user = new User();
        $user->setUsername($data['username']);
        $user->setPassword(
            $encoder->encodePassword($user, $data['password'])
        );
        return $user;
    }

    /**
     * @param User $user
     */
    private function flushUserData(User $user): void
    {
        $em = $this->getEntityManager();
        $em->persist($user);
        $em->flush();
    }

    /**
     * @return ObjectManager
     */
    private function getEntityManager(): ObjectManager
    {
        return $this->getDoctrine()->getManager();
    }

    /**
     * @param $data
     * @return bool
     */
    private function checkIfUsernameExists($data): bool
    {
        $em = $this->getEntityManager();
        if (count($users = $em->getRepository(User::class)->findBy(array('username' => $data))) > 0) {
            return true;
        } else {
            return false;
        }
    }
}
