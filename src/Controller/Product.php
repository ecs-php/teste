<?php

namespace Controller;

use Controller\Exception\InvalidArgumentHttpException;
use Controller\Validation;
use Entity;
use Service\Repository;
use Service\Normalizer;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class Product
{
    /**
     * @var Repository\Product
     */
    private $productRepository;

    /**
     * @var Normalizer\Product
     */
    private $productNormalizer;

    /**
     * @var Validation\Product
     */
    private $productValidation;

    public function __construct(
        Repository\Product $productRepository,
        Normalizer\Product $productNormalizer,
        Validation\Product $productValidation
    ) {
        $this->productRepository = $productRepository;
        $this->productNormalizer = $productNormalizer;
        $this->productValidation = $productValidation;
    }

    /**
     * @return JsonResponse
     */
    public function index()
    {
        $products = $this->productRepository->findAll();
        return new JsonResponse($this->productNormalizer->normalizeCollection($products));
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function show(Request $request)
    {
        /** @var Entity\Product $product */
        $product = $this->productRepository->findById($request->get('id'));
        if (!$product) {
            throw new InvalidArgumentHttpException('Record not found!', JsonResponse::HTTP_NOT_FOUND);
        }
        return new JsonResponse($this->productNormalizer->normalize($product));
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function create(Request $request)
    {
        $data = json_decode($request->getContent());
        $this->productValidation->validate($data);
        /** @var Entity\Product $productNormalized */
        $productNormalized = $this->productNormalizer->denormalize($data, Entity\Product::class);
        $this->productRepository->save($productNormalized);
        return new JsonResponse($this->productNormalizer->normalize($productNormalized), JsonResponse::HTTP_CREATED);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function update(Request $request)
    {
        /** @var Entity\Product $product */
        $product = $this->productRepository->findById($request->get('id'));
        if (!$product) {
            throw new InvalidArgumentHttpException('Record not found!', JsonResponse::HTTP_NOT_FOUND);
        }
        /** @var Entity\Product $productNormalized */
        $productNormalized = $this->productNormalizer->denormalize(
            json_decode($request->getContent()),
            Entity\Product::class
        );
        $product->setName($productNormalized->getName());
        $product->setDescription($productNormalized->getDescription());
        $product->setPrice($productNormalized->getPrice());
        $product->setWeight($productNormalized->getWeight());
        $product->setActive($productNormalized->isActive());
        $this->productRepository->save($product);
        return new JsonResponse($this->productNormalizer->normalize($product), JsonResponse::HTTP_OK);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function delete(Request $request)
    {
        /** @var Entity\Product $product */
        $product = $this->productRepository->findById($request->get('id'));
        if (!$product) {
            throw new InvalidArgumentHttpException('Record not found!', JsonResponse::HTTP_NOT_FOUND);
        }
        $this->productRepository->delete($product);
        return new JsonResponse([], JsonResponse::HTTP_NO_CONTENT);
    }
}
