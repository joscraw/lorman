<?php


namespace App\Controller;


use App\Model\Message;
use Silex\Application;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Model\Contact;
use Symfony\Component\Validator\Validation;
use App\Mailer\ContactFormMailer;

/**
 * Class MainController
 * @package App\Controller
 *
 * @author Josh Crawmer <jcrawmer@lorman.com> - wishful thinking ;)
 */
class MainController
{

    const SUCCESS_MESSAGE = 'A Dealer Inspire Representative Will Contact You At ("%s") Within 24 Hours';

    /**
     * @var ContactFormMailer
     */
    private $mailer;

    public function __construct(ContactFormMailer $mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * @param Request $request
     * @param Application $app
     * @return mixed
     */
    public function indexAction(Request $request, Application $app)
    {

        if ($request->isMethod('POST')) {
            $fullName = $request->request->get('fullName');
            $email = $request->request->get('email');
            $phone = $request->request->get('phone');
            $message = $request->request->get('message');

            $contact = new Contact();
            $contact->setFullName($fullName);
            $contact->setEmail($email);
            $contact->setPhone($phone);
            $contact->setMessage($message);

            $errors = $app['validator']->validate($contact);

            if (count($errors) === 0) {
                // add flash message
                $app['session']->getFlashBag()->add(
                    'message',
                    sprintf(self::SUCCESS_MESSAGE, $contact->getEmail())
                );

                // send email
                $this->mailer->send($this->buildMessage($contact, $app));

                // save submission in the database
                $formSubmission = \ORM::for_table('form_submissions')->create();
                $formSubmission->set('fullName', $contact->getFullName());
                $formSubmission->set('email', $contact->getEmail());
                $formSubmission->set('phone', $contact->getPhone());
                $formSubmission->set('message', $contact->getMessage());
                $formSubmission->save();

                return $app->redirect($app['url_generator']->generate('main_index'));
            }
        }

        return $app['twig']->render(
            'homepage.html.twig',
            [
                'errors' => isset($errors) ? $errors : [],
                'contact' => isset($contact) ? $contact : new Contact(),
            ]
        );
    }


    /**
     * Build the message object for the mailer service
     *
     * @param Contact $contact
     * @param Application $app
     * @return Message
     */
    private function buildMessage(Contact $contact, Application $app)
    {
        $message = new Message();
        $message->setBody(
            $app['twig']->render(
                'mailers/contact.html.twig',
                [
                    'contact' => $contact,
                ]
            )
        );
        $message->setSubject('Dealer Insipre: Contact Form Submission');

        return $message;

    }

}