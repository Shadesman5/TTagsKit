<?php

namespace Driven\Listings\Model;

use Pagekit\Application as App;
use Pagekit\Database\ORM\ModelTrait;

/**
 * @Entity(tableClass="@listings_group_type")
 */
class GroupType
{
    use ModelTrait;

    const STATUS_INACTIVE = 0;

    const STATUS_ACTIVE = 1;

    /** @Column(type="integer") @Id */
    public $id;

    /** @Column(type="integer") */
    public $created_by;

    /** @Column(type="integer") */
    public $created_on;

    /** @Column(type="integer") */
    public $modified_by;

    /** @Column(type="integer") */
    public $modified_on;

    /** @Column(type="string") */
    public $title;

    /** @Column(type="string") */
    public $description;

    /** @Column(type="string") */
    public $image;

    /** @Column(type="json_array") */
    public $settings;

    /** @Column(type="smallint") */
    public $position;

    /** @Column(type="smallint") */
    public $status;

    /** @Column(type="integer") */
    public $featured_from;

    /** @Column(type="integer") */
    public $featured_to;

    /**
     * @BelongsTo(targetEntity="Pagekit\User\Model\User", keyFrom="created_by")
     */
    public $creator;

    /**
     * @HasMany(targetEntity="Driven\Listings\Model\Listing", keyFrom="id", keyTo="group_type_id")
     */
    public $listings;

    /** @var array */
    protected static $properties = [
        'status' => 'isActive'
    ];

    public static function getStatuses()
    {
        return [
            self::STATUS_ACTIVE => __('Active'),
            self::STATUS_INACTIVE => __('Inactive')
        ];
    }

    public function isActive()
    {
        return $this->status === self::STATUS_ACTIVE && $this->date < new \DateTime;
    }
}
