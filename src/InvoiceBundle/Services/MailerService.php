<?php

namespace InvoiceBundle\Services;

use InvoiceBundle\Entity\Invoice;
use Symfony\Bundle\TwigBundle\TwigEngine;

use Swift_Mailer;
/**
 * Description of MailerService
 *
 * @author Numan
 */
class MailerService 
{
    private $mailer;
    
    private $render;
    
    public function __construct(Swift_Mailer $mailer, TwigEngine $render) {
        $this->mailer = $mailer;
        $this->render = $render;
    }
    
    public function sendMail(Invoice $invoice)
    {
        $message = \Swift_Message::newInstance()
                ->setSubject('Qbil invoic')
                ->setFrom('naumanelahi@live.in')
                ->setTo('elahinouman.elahi@gmail.com')
                ->setBody(
                    $this->render->render(
                        // app/Resources/views/Emails/registration.html.twig
                        'invoice/ipdf.html.twig',
                        array('invoice' => $invoice)
                    ),
                    'text/html'
                )
                ->attach(\Swift_Attachment::fromPath(__DIR__.'/../../../web/bundles/invoices/invoice'.$invoice->getId().'.pdf', 'application/pdf'))
              ;
                $this->mailer->send($message)
        ;
    }
}
