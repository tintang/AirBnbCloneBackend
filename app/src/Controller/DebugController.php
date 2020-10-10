<?php

namespace App\Controller;

use App\Entity\Listing;
use App\Services\CurrencyConverterService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizableInterface;
use Symfony\Component\Serializer\SerializerInterface;

class DebugController extends AbstractController
{
    /**
     * @var CurrencyConverterService
     */
    private CurrencyConverterService $currencyConverterService;
    /**
     * @var SerializerInterface
     */
    private SerializerInterface $serializer;

    /**
     * DebugController constructor.
     */
    public function __construct(CurrencyConverterService $currencyConverterService, SerializerInterface $serializer)
    {
        $this->currencyConverterService = $currencyConverterService;
        $this->serializer = $serializer;
    }

    /**
     * @Route("/debug", name="debug")
     */
    public function index()
    {

        $this->serializer->serialize(new Listing(), 'json');

        return $this->render('debug/index.html.twig', [
            'controller_name' => 'DebugController',
        ]);
    }
}
