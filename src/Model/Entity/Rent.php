<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Rent Entity
 *
 * @property int $user_id
 * @property int $book_id
 * @property \Cake\I18n\FrozenTime|null $created
 * @property int|null $duration_days
 *
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\Book $book
 */
class Rent extends Entity
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
        '*' => true,
        'created' => true,
        'duration_days' => true,
        'user' => true,
        'book' => true,
    ];
}
