<?php

namespace App\Controller;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use App\Entity\Order;
class CartController extends AbstractController
{
    /**
     * @Route("/cart", name="cart_index")
     */
    public function index(SessionInterface $session, ProductRepository $productRepository)
    {
        
        $cart = $session->get('cart', []);
        $cartData = [];

        foreach($cart as $id => $quantity) {
            $cartData[] = [
                'product'=> $productRepository->find($id),
                'quantity'=>$quantity
            ];
        }

        $total = 0;
        $final = 0;
        foreach($cartData as $item) {
            $totalItem = $item['product']->getPrice() * $item['quantity'];
            $final = $total += $totalItem;
            $final+=7.99;
        }
        return $this->render('cart/index.html.twig', [
            'items' => $cartData,
            'total' => $final
        ]);
    }

    /**
     * @Route("/cart/add/{id}", name="cart_add")
     */
    public function add($id, SessionInterface  $session) {
        $cart = $session->get('cart', []);
        if(!empty($cart[$id])) {
            $cart[$id]++;
        } else {
            $cart[$id] = 1;
        }
        $session->set('cart', $cart);
        $session->get('cart');
        return $this->redirectToRoute('cart_index');
    }



    /**
     * @Route("/cart/less/{id}", name="cart_less")
     */
    public function less($id, SessionInterface $session) {
        $cart = $session->get('cart', []);
        if(!empty($cart[$id])) {
            $cart[$id]--;
        }
        if($cart[$id] == 0) {
            unset($cart[$id]);
        }
        $session->set('cart', $cart);
        $session->get('cart');
        return $this->redirectToRoute('cart_index');
    }

    /**
     * @Route("/cart/remove/{id}", name="cart_remove")
     */
    public function remove($id, SessionInterface  $session) {
        $cart = $session->get('cart', []);

        if(!empty($cart[$id])) {
            unset($cart[$id]);
        }

        $session->set('cart', $cart);
        return $this->redirectToRoute('cart_index');
    }

    /**
     * @Route("/cart/save", name="save_order")
     */
    public function saveOrder(SessionInterface  $session) {
        $order = new Order;
        $user_id =  $this->getUser();
        $UserId = $user_id->email;
    
        $order->setValid(1);
        $maDate = new \DateTime();
        $order->setDateTime($maDate);
      

        $doctrine = $this->getDoctrine();
        $entityManager = $doctrine->getManager();
        $entityManager->persist($order);
        $entityManager->flush();
        return $this->redirectToRoute('cart_index',[
            'order' => ' Your order have been saved',
         ]);
    }
}
