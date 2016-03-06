<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Weeklyhour Entity.
 *
 * @property int $id
 * @property int $weeklyreport_id
 * @property \App\Model\Entity\Weeklyreport $weeklyreport
 * @property int $member_id
 * @property \App\Model\Entity\Member $member
 * @property float $duration
 */
class Weeklyhour extends Entity
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
        'id' => false,
    ];
}
