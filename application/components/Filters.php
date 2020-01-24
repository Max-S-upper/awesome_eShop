<?php


namespace application\components;

use config\Db;

class Filters
{
    protected $db;
    public function __construct()
    {
        $this->db = new Db;
    }

    public function getBySubCategory($subCategoryId)
    {
        $filterBlockAttributeIds = $this->db->connection->query("SELECT filter_block_attributes.filter_block_id, filter_block_attributes.attribute_id
            FROM filter_block_attributes LEFT JOIN filter_blocks ON filter_blocks.id = filter_block_attributes.filter_block_id 
            WHERE filter_blocks.sub_category_id = $subCategoryId")->fetchAll();

        $attributesQuery = "SELECT id, title FROM attributes WHERE id = ";
        $counter = 0;
        foreach ($filterBlockAttributeIds as $filterBlockAttributeId) {
            if ($counter) $attributesQuery .= " OR id = {$filterBlockAttributeId['attribute_id']}";
            else $attributesQuery .= "{$filterBlockAttributeId['attribute_id']}";
            $counter++;
        }

        $stmt = $this->db->connection->query($attributesQuery);
        if ($stmt) $filterAttributesData= $stmt->fetchAll();
        else return '';

        $filterBlockIds = array();
        foreach ($filterBlockAttributeIds as $filterBlockAttributeId) {
            $filterBlockIds[] = $filterBlockAttributeId['filter_block_id'];
        }

        $filterBlockIds = array_unique($filterBlockIds);

        $filterBlocksQuery = "SELECT title FROM filter_blocks WHERE id = ";
        $counter = 0;
        foreach ($filterBlockIds as $filterBlockId) {
            if ($counter) $filterBlocksQuery .= " OR id = $filterBlockId";
            else $filterBlocksQuery .= "$filterBlockId";
            $counter++;
        }

        $filterBlockTitles = $this->db->connection->query($filterBlocksQuery)->fetchAll();

        $filtersData = [];
        $counter = 0;
        foreach ($filterBlockIds as $filterBlockId) {
            $filtersData[$filterBlockId] = [
                'filterBlockData' => [
                    'id' => $filterBlockId,
                    'title' => $filterBlockTitles[$counter]['title']
                ]
            ];

            for ($i = 0; $i < count($filterBlockAttributeIds); $i++) {
                if ($filterBlockId === $filterBlockAttributeIds[$i]['filter_block_id']) {
                    $filtersData[$filterBlockId]['filterBlockData']['attributesData'][] = [
                        'id' => $filterAttributesData[$i]['id'],
                        'title' => $filterAttributesData[$i]['title']
                    ];
                }
            }

            $counter++;
        }

        $filtersHtml = "<div class='filters-container' data-subcategory-id='$subCategoryId'>";
        foreach ($filtersData as $filterData) {
            $filtersHtml .= "<div class='filters-block'>
                                <p>{$filterData['filterBlockData']['title']}:</p>";
            foreach ($filterData['filterBlockData']['attributesData'] as $filterAttributeData) {
                $filtersHtml .= "<div class='filter'>
                                    <input type='checkbox' id='filter{$filterAttributeData['id']}' class='hidden'>
                                    <label for='filter{$filterAttributeData['id']}'>{$filterAttributeData['title']}</label>
                                 </div>";
            }

            $filtersHtml .= "</div>";
        }

        $filtersHtml .= "</div>";
        return $filtersHtml;
    }
}