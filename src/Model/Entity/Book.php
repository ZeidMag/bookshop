<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Book Entity
 *
 * @property int $id
 * @property string $title
 * @property int|null $pages
 * @property int|null $publish_year
 * @property int $author_id
 *
 * @property \App\Model\Entity\Author $author
 * @property \App\Model\Entity\Rent[] $rents
 */
class Book extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'title' => true,
        'pages' => true,
        'publish_year' => true,
        'author_id' => true,
        'author' => true,
        'rents' => true,
    ];
}
