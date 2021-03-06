<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Form\NewMdpType;
use App\Form\RegistrationFormType;
use App\Form\OubliFormType;
use App\Repository\UtilisateurRepository;
// use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;


class RegistrationController extends AbstractController
{
    /**
     * @var int 
     */
    private $apiDelaiActivation;

    /**
     * @var int 
     */
    private $apiDelaiReinitialisation;

    /**
     * @var Security
     */
    private $security;


    public function __construct(int $apiDelaiActivation, int $apiDelaiReinitialisation, Security $security)
    {
        $this->apiDelaiActivation = $apiDelaiActivation;
        $this->apiDelaiReinitialisation = $apiDelaiReinitialisation;
        $this->security = $security;
    }




    /**
     * @return string
     * @throws \Exception
     */
    private function generateToken()
    {
        return rtrim(strtr(base64_encode(random_bytes(32)), '+/', '-_'), '=');
    }

    /**
     * 
     * METHODE APPELEE LORS DE LA CREATION D'UN NOUVEL UTILISATEUR
     * @Route("/admin/utilisateurs/ajouter", name="app_register")
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @return Response
     * @throws \Exception
     */
    public function register(Request $request, \Swift_Mailer $mailer): Response
    {
        $user = new Utilisateur();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);
        $password = "AttenteValidation";
        $regexEmail = '/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix';
        $roles = $user->getRoles();

        if ($form->isSubmitted() && $form->isValid()) {

            if (preg_match($regexEmail, $form->get('email')->getData())) {
                // le mot de passe temporaire n'est pas hash?? volontairement. La m??thode login hash le mdp.
                // Le formulaire de login ne pourra donc jamais envoy?? "AttenteValidation" en clair.
                // On ajoute un token dat??, un token hash??, et le status inactif.
                $user->setPassword($password);
                $user->setTokenCreatedAt(new \DateTime());
                $user->setConfirmationToken($this->generateToken());
                $user->setIsActif(false);
                if (in_array("ROLE_FORMATEUR_TRE", $roles) && !in_array("ROLE_FORMATEUR", $roles)) {
                    array_push($roles, "ROLE_FORMATEUR");
                    $user->setRoles($roles);
                }

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($user);
                $entityManager->flush();

                // On r??cup??re le token cr???? pr??c??demment ainsi que l'email du user pour les ins??rer au mail.
                $token = $user->getConfirmationToken();
                $email = $user->getEmail();
                $delaiExpiration = $this->apiDelaiActivation;

                $url = $this->generateUrl('confirm_account', ['token' => $token], UrlGeneratorInterface::ABSOLUTE_URL);

                // Ici on envoie le mail contenant les informations souhait??es
                $message = (new \Swift_Message('Activation de votre compte'))
                    // on attribut l'exp??diteur
                    ->setFrom('projetsuivitp.hb@gmail.com')
                    // le destinataire
                    ->setTo($form->get('email')->getData())

                    // on creer le contenu
                    ->setBody(
                        $this->renderView(
                            // templates/emails/registration.html.twig
                            'emails/registration.html.twig',
                            [
                                'email' => $email,
                                'token' => $token,
                                'url' => $url,
                                'delaiExpiration' => $delaiExpiration
                            ]
                        ),
                        'text/html'
                    );

                //On envoie le message
                $mailer->send($message);
                $this->addFlash('success', "Le nouveau compte a bien ??t?? cr???? et un mail d'activation a ??t?? envoy?? ?? l'utilisateur !");
                return $this->redirectToRoute('app_register');
            } else {
                $this->addFlash('warning', "Renseignez une adresse email valide.");
                return $this->render('registration/register.html.twig', [
                    'utilisateurForm' => $form->createView(),
                ]);
            }
        }

        return $this->render('registration/register.html.twig', [
            'utilisateurForm' => $form->createView(),
        ]);
    }

    /**
     * 
     * GENERATION D'UN NOUVEAU TOKEN D'ACTIVATION DE COMPTE
     * @Route("/admin/utilisateurs/{id}/nouveau_mail", name="app_generate_new_token", methods={"GET"})
     * @param Request $request
     * @param $id
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @return Response
     * @throws \Exception
     */
    public function generateNewToken(Request $request, \Swift_Mailer $mailer, $id): Response
    {
        $user = $this->getDoctrine()->getRepository(Utilisateur::class)->findOneBy(['id' => $id]);

        $user->setTokenCreatedAt(new \DateTime());
        $user->setConfirmationToken($this->generateToken());

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($user);
        $entityManager->flush();

        // On r??cup??re le token cr???? pr??c??demment ainsi que l'email du user pour les ins??rer au mail.
        $token = $user->getConfirmationToken();
        $email = $user->getEmail();

        $delaiExpiration = $this->apiDelaiActivation;

        $url = $this->generateUrl('confirm_account', ['token' => $token], UrlGeneratorInterface::ABSOLUTE_URL);

        // Ici on envoie le mail contenant les informations souhait??es
        $message = (new \Swift_Message('Activation de votre compte'))
            // on attribut l'exp??diteur
            ->setFrom('projetsuivitp.hb@gmail.com')
            // le destinataire
            ->setTo($email)

            // on creer le contenu
            ->setBody(
                $this->renderView(
                    // templates/emails/registration.html.twig
                    'emails/registration.html.twig',
                    [
                        'email' => $email,
                        'token' => $token,
                        'url' => $url,
                        'delaiExpiration' => $delaiExpiration
                    ]
                ),
                'text/html'
            );

        //On envoie le message
        $mailer->send($message);
        $this->addFlash('success', "Un nouveau mail d'activation a bien ??t?? envoy?? ?? l'utilisateur !");
        return $this->redirectToRoute('utilisateurs_index');
    }

    /**
     * 
     * CETTE FONCTION EST APPELEE LORSQUE L'UTILISATEUR CLIQUE SUR SON MAIL D'ACTIVATION
     * ELLE ENVOIE SUR LE FORMULAIRE DE CREATION DE MOT DE PASSE
     * 
     * @Route("/confirmation_compte/{token}", name="confirm_account")
     * @param $token
     */
    public function confirmAccount(Request $request, $token, UserPasswordEncoderInterface $passwordEncoder)
    {
        $user = $this->getDoctrine()->getRepository(Utilisateur::class)->findOneBy(['confirmationToken' => $token]);

        // Si $user est null, c'est qu'il n'y a plus de token, donc que l'utilisateur est d??j?? activ??
        if (!$user) {
            // throw new CustomUserMessageAuthenticationException("Toto ! ");
            $this->addFlash('error', "Le lien d'activation n'existe pas ! Il se peut que votre compte soit d??j?? activ??. Essayer de vous identifier ou veuillez vous rapprocher de Human Booster.");
            return $this->redirectToRoute('app_login');
        }

        $userConnecte = $this->security->getUser();
        if ($userConnecte) {
            $this->addFlash(
                'error',
                "Vous ne pouvez pas activer un compte en ??tant connect?? : 
        veuillez vous d??connecter puis cliquez ?? nouveau sur le lien d'activation 
        re??u par mail."
            );
            return $this->redirectToRoute('dashboard');
        }

        $tokenBdd = $user->getConfirmationToken();
        $tokenCreatedAt = $user->getTokenCreatedAt();
        $delaiExpiration = $this->apiDelaiActivation;

        $tokenCreatedAt->modify('+' . $delaiExpiration . 'days');
        $today = new \DateTime();

        // Regex pour v??rification du mot de passe
        // minimum 8 charact??res, une minuscule et une, et au moins un chiffre
        $regexMdp = '^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$^';

        // On v??rifie que le token ait moins de 30 jours
        if ($tokenCreatedAt > $today) {
            // On v??rifie que le token en base de donn??e soit le m??me que celui du mail de l'utilisateur
            // L'utilisateur ne peut donc pas se r??activer deux fois avec le m??me mail
            if ($token === $tokenBdd) {

                if ($request->isMethod(('POST')) && ($request->get('token') === $token)) {
                    if (preg_match($regexMdp, $request->get('password')) && ($request->get('password') == $request->get('confirmation'))) {

                        // On chiffre le mot de passe
                        $user->setPassword(
                            $passwordEncoder->encodePassword(
                                $user,
                                $request->get('password')
                            )
                        );

                        // On supprime le token de l'utilisateur et on le passe en actif
                        $user->setConfirmationToken(null);
                        $user->setTokenCreatedAt(null);
                        $user->setIsActif(true);

                        $entityManager = $this->getDoctrine()->getManager();
                        $entityManager->persist($user);
                        $entityManager->flush();

                        $this->addFlash('success', "Votre compte a bien ??t?? activ?? ! Vous pouvez maintenant vous identifier.");
                        return $this->redirectToRoute('app_login');
                    } else {
                        $this->addFlash('error', "Les mots de passe doivent ??tre identiques et contenir au minimum 8 charact??res, une minuscule et une majuscule, et au moins un nombre.");
                        return $this->render('security/first_mdp.html.twig', [
                            'token' => $token
                        ]);
                    }
                } else {
                    return $this->render('security/first_mdp.html.twig', [
                        'token' => $token
                    ]);
                }
            } else {
                $this->addFlash('error', "Le lien d'activation n'est pas correct ! Veuillez le v??rifier ou rapprochez-vous de Human Booster.");
                return $this->redirectToRoute('app_login');
            }
        } else {
            $this->addFlash('error', "Votre lien d'activation a expir?? ! Veuillez vous rapprocher de Human Booster pour en g??n??rer un nouveau.");
            return $this->redirectToRoute('app_login');
        }
    }

    /**
     * 
     * FONCTION APPELEE QUAND ON CLIQUE SUR MOT DE PASSE OUBLIE (SUR LA PAGE LOGIN)
     * 
     * @Route("/oubli_mdp", name="app_oubli_mdp")
     */
    public function oubliPassword(Request $request, UtilisateurRepository $utilisateurRepository, \Swift_Mailer $mailer, TokenGeneratorInterface $tokenGenerator): Response
    {
        // On cr??e le formulaire
        $form = $this->createForm(OubliFormType::class);

        //On fait le traitement du formulaire
        $form->handleRequest($request);

        // Si le formulaire est valide
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            // on cherche si un utilisateur ?? cet email
            $user = $utilisateurRepository->findOneByEmail($data['email']);

            // Si l'utilisateur n'existe pas
            if (!$user) {
                // On envoie un message flash
                $this->addFlash('error', "Cette adresse mail est inconnue. Veuillez saisir une nouvelle adresse mail.");

                return $this->redirectToRoute('app_oubli_mdp');
            }

            // Sinon on g??n??re un token
            $token = $tokenGenerator->generateToken();

            try {
                // On insert un token dans reset_token
                $user->setResetToken($token);
                $user->setPassword('AttenteNouveau');
                $user->setTokenMailCreatedAt(new \DateTime());

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($user);
                $entityManager->flush();
                // Si il y a un erreur, cela g??n??re un message d'erreur
            } catch (\Exception $e) {
                $this->addFlash('warning', 'une erreur est survenue : ' . $e->getMessage());
                return $this->redirectToRoute('app_login');
            }

            // On g??n??re l'URL de r??initialisation de mot de passe
            $url = $this->generateUrl('app_new_mdp', ['token' => $token], UrlGeneratorInterface::ABSOLUTE_URL);

            // On envoie le message
            $message = (new \Swift_Message('HumanBooster : mot de passe oubli??'))
                // on attribut l'exp??diteur
                ->setFrom('projetsuivitp.hb@gmail.com')
                // le destinataire
                ->setTo($user->getEmail())
                // on creer le contenu
                ->setBody(
                    "<p>Bonjour,</p>
                    <p>Une demande de mot de passe oubli?? a ??t?? effectu??e.<br>
                    Pour le modifier, veuillez cliquer sur le lien suivant : <a href='$url'>" . $url . "</a></p>",

                    'text/html'
                );

            //On envoie le message
            $mailer->send($message);
            // On cr??e le message flash
            $this->addFlash('success', 'Votre mail de r??initialisation a bien ??t?? envoy?? sur cette adresse mail !');

            return $this->redirectToRoute('app_login');
        }

        // On envoie vers la page de demande de l'email
        return $this->render('security/oubli_mdp_form.html.twig', [
            'oubliForm' => $form->createView()
        ]);
    }

    /**
     * 
     * METHODE APPELEE PAR LE LIEN ENVOYE QUAND MOT DE PASSE OUBLIE
     * ENVOIE SUR LE FORMULAIRE DE CREATION D'UN NOUVEAU MOT DE PASSE
     * 
     * @Route("/nouveau_mdp/{token}", name="app_new_mdp")
     */
    public function newPassword(Request $request, $token, UserPasswordEncoderInterface $passwordEncoder)
    {
        // On va chercher l'utilisateur avec le token fournit
        $user = $this->getDoctrine()->getRepository(Utilisateur::class)->findOneBy(['reset_token' => $token]);

        // Regex pour v??rification du mot de passe
        // minimum 8 charact??res, une minuscule et une, et au moins un chiffre
        $regexMdp = '^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$^';

        if (is_null($user)) {
            $this->addFlash('warning', 'Ce lien de r??initialisation est incorrect ou le mot de passe a d??j?? ??t?? modifi??. Veuillez renouveller votre demande de r??initialisation de mot de passe.');
            return $this->redirectToRoute('app_oubli_mdp');
        }

        // $tokenBdd = $user->getResetToken();
        $tokenMailCreatedAt = $user->getTokenMailCreatedAt();
        $delaiExpiration = $this->apiDelaiReinitialisation;

        $tokenMailCreatedAt->modify('+' . $delaiExpiration . 'hours');
        $today = new \DateTime();

        if ($tokenMailCreatedAt > $today) {

            if ($request->isMethod(('POST')) && ($request->get('token') === $token)) {

                if (preg_match($regexMdp, $request->get('password')) && ($request->get('password') == $request->get('confirmation'))) {

                    // Si le formulaire est envoy?? en methode POST et que le token du mail = celui de la BDD

                    // dd($user, $request->get('token'));
                    // On supprime le token de l'utilisateur
                    $user->setResetToken(null);
                    $user->setTokenMailCreatedAt(null);

                    // On chiffre le mot de passe
                    $user->setPassword(
                        $passwordEncoder->encodePassword(
                            $user,
                            $request->get('password')
                        )
                    );

                    $entityManager = $this->getDoctrine()->getManager();
                    $entityManager->persist($user);
                    $entityManager->flush();

                    $this->addFlash('success', 'Mot de passe modifi?? avec succ??s !');

                    return $this->redirectToRoute('app_login');
                } else {
                    $this->addFlash('error', "Les mots de passe doivent ??tre identiques et contenir au minimum 8 charact??res, une minuscule et une majuscule, et au moins un nombre.");
                    return $this->render('security/new_mdp.html.twig', [
                        'token' => $token
                    ]);
                }
            } else {
                return $this->render('security/new_mdp.html.twig', [
                    'token' => $token
                ]);
            }
        } else {
            $this->addFlash('error', "Votre lien de r??initialisation a expir?? ! Veuillez utiliser la fonction de mot de passe perdu ?? nouveau.");
            return $this->redirectToRoute('app_login');
        }
    }
}
