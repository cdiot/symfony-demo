<?php

namespace App\Controller;

use App\Repository\OrderRepository;
use App\Service\Mailer;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

class OrderCancelController extends AbstractController
{
    #[Route(path: [
        'en' => '/order/error/{stripeSessionId}',
        'fr' => '/commande/erreur/{stripeSessionId}'
    ], name: 'order_cancel')]
    #[IsGranted('ORDER_VIEW', subject: 'orderRepository')]
    public function index(OrderRepository $orderRepository, Mailer $mailer, $stripeSessionId, TranslatorInterface $translator): Response
    {
        $order = $orderRepository->findOneByStripeSessionId($stripeSessionId);

        if (!$order || $order->getUser() != $this->getUser()) {
            return $this->redirectToRoute('/');
        }

        $mailer->send(
            $translator->trans('email.subject.order_cancel', ['reference' => $order->getReference()]),
            'bar@ecommerce.com',
            $order->getUser()->getEmail(),
            'emails/order_cancel.html.twig',
            [
                'order' => $order,
            ]
        );

        return $this->render('order_cancel/index.html.twig', [
            'order' => $order
        ]);
    }
}
