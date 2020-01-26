<?php


namespace application\components;


use application\components\exceptions\RenderException;
use application\components\exceptions\SessionException;
use application\models\Product;
use core\Session;
use core\View;

class Pagination
{
    protected $productsPerPageQuantity = 4;
    public function __construct($productsPerPageQuantity)
    {
        $this->productsPerPageQuantity = $productsPerPageQuantity;
    }

    public function getHtml($pageNum)
    {
        $pagesQuantity = $this->getPagesQuantity();
        $paginationHtml = '<form action="" method="post" class="pagination-container">';
        if ($pageNum > 1) $paginationHtml .= '<input id="previous-page" type="submit" name="page-num" class="hidden" value="'. ($pageNum - 1) .'">
                                                <label for="previous-page" class="pagination-page"><</label>';
        for ($i = 1; $i <= $pagesQuantity; $i++) {
            if ($pageNum != $i) $paginationHtml .= "<input type='submit' name='page-num' class='pagination-page' value='$i'>";
            else $paginationHtml .= "<input type='submit' name='page-num' class='pagination-page pagination-page-active' value='$i'>";
        }

        if ($pageNum < $pagesQuantity) $paginationHtml .= '<input id="next-page" type="submit" name="page-num" class="hidden" value="'. ($pageNum + 1) .'">
                                                            <label for="next-page" class="pagination-page">></label>';
        $paginationHtml .= '</form>';
        return $paginationHtml;
    }

    public function getPagesQuantity()
    {
        $productObject = new Product();
        $productsQuantity = $productObject->getQuantity();
        return ceil($productsQuantity / $this->productsPerPageQuantity);
    }
}