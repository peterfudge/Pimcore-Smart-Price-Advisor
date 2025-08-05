<?php
namespace SmartPriceAdvisorBundle\Controller;

use Pimcore\Model\DataObject\Product;
use SmartPriceAdvisorBundle\Service\GPTPricingAdvisor;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    private GPTPricingAdvisor $advisor;

    public function __construct(GPTPricingAdvisor $advisor)
    {
        $this->advisor = $advisor;
    }

    /**
     * @Route("/admin/smartprice/run", name="smartprice_run")
     */
    public function run(Request $request): JsonResponse
    {
        $id = $request->get('id');
        $product = Product::getById($id);

        if (!$product) {
            return new JsonResponse(['error' => 'Product not found'], 404);
        }

        $data = [
            'brand' => $product->getBrand(),
            'model' => $product->getModelNumber(),
            'upc' => $product->getUpc(),
            'category' => $product->getCategory(),
            'price' => $product->getPrice()
        ];

        $result = $this->advisor->getAdvice($data);

        return new JsonResponse($result);
    }
}
