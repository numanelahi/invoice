<?php

namespace InvoiceBundle\EventManager;

use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\PostResponseEvent;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use InvoiceBundle\Services\ViewRenderingService;
use InvoiceBundle\Services\MailerService;

class PortRequestActions implements EventSubscriberInterface 
{
	private $mailer;
	
	private $pdf;
	
	private $logger;
	
	public function __construct(MailerService $mailer,ViewRenderingService $pdf,LoggerInterface $logger)
	{
		$this->mailer = $mailer;
		$this->pdf = $pdf; 
		$this->logger = $logger;
	}
	
	public function afterRendering(PostResponseEvent $event)
	{
		$request = $event->getRequest(); 
		$controller = $request->attributes->get('_controller');
		if($controller == "InvoiceBundle\Controller\InvoiceController::newAction" && $request->attributes->get('invoice'))
		{
			$invoice = $request->attributes->get('invoice');
			$request->attributes->set('invoice',false);
			$this->logger->info("Starting async tasks");
			$this->pdf->generatePDF($invoice);
			$this->mailer->sendMail($invoice); 
		}
	}
	
	public static function getSubscribedEvents() 
	{
		return array(
				// kernel.terminate
				KernelEvents::TERMINATE => 'afterRendering'
		);
	}
}