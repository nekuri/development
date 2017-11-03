<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Anime Entity
 *
 * @property int $id
 * @property string $title
 * @property string $title_short
 * @property string $url
 * @property int $api_id
 * @property int $year
 * @property int $cool
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\Api $api
 * @property \App\Model\Entity\Review[] $reviews
 */
class Anime extends Entity
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
        'id' => true,
        'title' => true,
        'title_short' => true,
        'url' => true,
        'year' => true,
        'cool' => true,
        'photo' => true,
        'photo_dir' => true,
        'created' => true,
        'modified' => true,
        'api_id' => true,
    ];
}
