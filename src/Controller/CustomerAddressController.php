<?php

namespace App\Controller;

use App\Entity\CustomerAddress;
use App\Form\CustomerAddressType;
use App\Repository\CustomerAddressRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/customer/address")
 */
class CustomerAddressController extends AbstractController
{
    /**
     * @Route("/", name="customer_address_index", methods={"GET"})
     */
    public function index(CustomerAddressRepository $customerAddressRepository): Response
    {
        return $this->render('customer_address/index.html.twig', [
            'customer_addresses' => $customerAddressRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="customer_address_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $customerAddress = new CustomerAddress();
        $form = $this->createForm(CustomerAddressType::class, $customerAddress);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($customerAddress);
            $entityManager->flush();

            return $this->redirectToRoute('customer_address_new');
        }

        return $this->render('customer_address/new.html.twig', [
            'customer_address' => $customerAddress,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="customer_address_show", methods={"GET"})
     */
    public function show(CustomerAddress $customerAddress): Response
    {
        return $this->render('customer_address/show.html.twig', [
            'customer_address' => $customerAddress,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="customer_address_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, CustomerAddress $customerAddress): Response
    {
        $form = $this->createForm(CustomerAddressType::class, $customerAddress);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('customer_address_index');
        }

        return $this->render('customer_address/edit.html.twig', [
            'customer_address' => $customerAddress,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="customer_address_delete", methods={"DELETE"})
     */
    public function delete(Request $request, CustomerAddress $customerAddress): Response
    {
        if ($this->isCsrfTokenValid('delete'.$customerAddress->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($customerAddress);
            $entityManager->flush();
        }

        return $this->redirectToRoute('customer_address_index');
    }
}
