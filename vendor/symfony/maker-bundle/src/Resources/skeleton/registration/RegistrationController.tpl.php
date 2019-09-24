<?= "<?php\n" ?>

namespace <?= $namespace; ?>;

use <?= $user_full_class_name ?>;
use <?= $form_full_class_name ?>;
<?php if ($authenticator_full_class_name): ?>
use <?= $authenticator_full_class_name; ?>;
<?php endif; ?>
use Symfony\Bundle\FrameworkBundle\Controller\<?= $parent_class_name; ?>;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
<?php if ($authenticator_full_class_name): ?>
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
<?php endif; ?>

class <?= $class_name; ?> extends <?= $parent_class_name; ?><?= "\n" ?>
{
    /**
     * @Route("<?= $route_path ?>", name="<?= $route_name ?>")
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder<?= $authenticator_full_class_name ? sprintf(', GuardAuthenticatorHandler $guardHandler, %s $authenticator', $authenticator_class_name) : '' ?>): Response
    {
        $user = new <?= $user_class_name ?>();
        $form = $this->createForm(<?= $form_class_name ?>::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->set<?= ucfirst($password_field) ?>(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            // do anything else you need here, like send an email

<?php if ($authenticator_full_class_name): ?>
            return $guardHandler->authenticateUserAndHandleSuccess(
                $user,
                $request,
                $authenticator,
                '<?= $firewall_name; ?>' // firewall name in security.yaml
            );
<?php else: ?>
            return $this->redirectToRoute('<?= $redirect_route_name ?>');
<?php endif; ?>
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}
