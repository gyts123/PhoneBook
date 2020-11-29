<?php

namespace App\Controller;

use App\Entity\User;
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

            if (!isset($data['password'])) {
                $this->addFlash('passwords_not_matching', 'Passwords are not matching!');

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
    protected function setUserData(array $data, UserPasswordEncoderInterface $encoder): User
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
    protected function flushUserData(User $user): void
    {
        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();
    }
}
