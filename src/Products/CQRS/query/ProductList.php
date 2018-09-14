<?php
/**
 * Created by PhpStorm.
 * User: bpawluczuk
 * Date: 14.09.2018
 * Time: 16:26
 */

namespace App\Products\CQRS\query;

use App\Products\CQRS\Query;
use App\Products\Entity\Product;
use App\Products\Repository\ProductRepository;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class ProductList
 * @package App\Products\CQRS\query
 * @author Borys Pawluczuk
 */
class ProductList extends Query
{
    /**
     * @var ProductRepository $repo
     */
    private $repo;

    function getList()
    {
        $result = [];

        $this->repo = $this->getRepository();

        /**
         * @var Product $item
         */
        foreach ($this->repo->findAll() as $item) {
            $result[] = [
                'id' => $item->getId(),
                '_locale' => $item->getLocale(),
                'code' => $item->getCode(),
                'name' => $item->getName(),
                'price' => $item->getPrice(),
                'currency' => $item->getCurrency(),
            ];
        }
        return $result;
    }
}