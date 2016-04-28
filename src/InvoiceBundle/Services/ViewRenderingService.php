<?php

namespace InvoiceBundle\Services;

use Knp\Bundle\SnappyBundle\Snappy\LoggableGenerator;
use Symfony\Bundle\TwigBundle\TwigEngine;
use InvoiceBundle\Entity\Invoice;
use Symfony\Component\HttpFoundation\Response;
/**
 * Description of ViewRenderingService
 *
 * @author Numan
 */
class ViewRenderingService {
    private $pdf;
    
    private $render;
    
    public function __construct(LoggableGenerator $pdf, TwigEngine $render)
    {
        $this->pdf = $pdf;
        $this->render = $render;
    }
    
    public function renderPDF(Invoice $invoice)
    {
        $html = $this->render->render('invoice/ipdf.html.twig', array(
            'invoice'  => $invoice
        ));

        return new Response(
            $this->pdf->getOutputFromHtml($html),
            200,
            array(
                'Content-Type'          => 'application/pdf',
                'Content-Disposition'   => 'inline; filename="invoice.pdf"'
            )
        );
    }
    
    public function generatePDF(Invoice $invoice)
    {
        $this->pdf->generateFromHtml(
            $this->render->render(
                'invoice/ipdf.html.twig',
                array(
                    'invoice'  => $invoice
                )
            ),
            __DIR__.'/../../../web/bundles/invoices/invoice'.$invoice->getId().'.pdf'
        );
    }
}
