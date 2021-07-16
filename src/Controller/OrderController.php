<?php
declare(strict_types=1);

namespace App\Controller;

use App\Entity\Order;
use App\Entity\OrderAuditLog;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class OrderController extends AbstractController
{
    public function indexAction(Request $request)
    {
        // handle display of orders
        if ($request->getMethod() == 'GET' && $request->get('orderId') == NULL) {
            return $this->render('app/order/index.html.twig', [
                'orders' => $this->getDoctrine()->getRepository(Order::class)->findAll(),
            ]);
        } else if ($request->getMethod() == 'GET' && $request->get('orderId') != NULL) {
            /** @var EntityManager $manager */
            $manager = $this->getDoctrine()->getManager();
            // find doesn't work with order number
            $order = $manager->getConnection()->query('SELECT * from `order` WHERE id = ' . $request->get('orderId'))->fetch();
            $orderAuditLog = new OrderAuditLog();
            $orderAuditLog->setOrderId((int) $request->get('orderId'));
            // Send only year, month, date and exclude hours, seconds
            $orderAuditLog->setCreatedAt((new \DateTimeImmutable())->format('Y-m-d'));
            $orderAuditLog->setUser($order['recipient_name']);
            $manager->persist($orderAuditLog);
            $manager->flush();
            return $this->render('app/order/show.html.twig', [
                'order' => $order,
                'logs' => $manager->getRepository(OrderAuditLog::class)->findBy(['orderId' => $order['id']]),
            ]);
        }
        if ($request->getMethod() == 'POST' && (bool) $_POST['update'] === true) {
            $data = $_POST;
            if (isset($data['orderNumber'])) {
                $id = $data['orderNumber'];
                /** @var EntityManager $manager */
                $manager = $this->getDoctrine()->getManager();
                /** @var Order $order */
                $order = $manager->getRepository(Order::class)->find($id);

                if ($order->getStatus() && $order->getStatus() === 'picked') {
                    $this->addFlash('error', 'Too late.');
                    return $this->render('app/order/index.html.twig', [
                        'orders' => $this->getDoctrine()->getRepository(Order::class)->findAll(),
                    ]);
                } else if ($data['status'] == '') {
                    $this->addFlash('error', 'Empty status not allowed.');
                } else if ($data['status'] == 0) {
                    $this->addFlash('error', 'Invalid status not allowed.');
                }
                if ($order) {
                    // Update recipient name and address as well when needed.
                    $order->setStatus($data['status']);
                    $manager->persist($order);
                    $manager->flush($order);
                    $orderAuditLog = new OrderAuditLog();
                    $orderAuditLog->setOrderId($order->getId());
                    $orderAuditLog->setCreatedAt((new \DateTime())->format('Y-m-d'));
                    $orderAuditLog->setUser($order->getRecipientName());
                    $manager->persist($orderAuditLog);
                    $manager->flush();
                    $this->addFlash('success', 'Order updated');
                    return $this->render('app/order/index.html.twig', [
                        'orders' => $this->getDoctrine()->getRepository(Order::class)->findAll(),
                    ]);
                }
            }
        }
        return $this->render('app/order/index.html.twig', [
            'orders' => $this->getDoctrine()->getRepository(Order::class)->findAll(),
        ]);
    }
}
