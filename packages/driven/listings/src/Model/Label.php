<?php

namespace Driven\Listings\Model;

use Pagekit\Application as App;
use Pagekit\Database\ORM\ModelTrait;

/**
 * @Entity(tableClass="@listings_label")
 */
class Label
{
    use ModelTrait;

    const STATUS_INACTIVE = 0;

    const STATUS_ACTIVE = 1;

    /** @Column(type="integer") @Id */
    public $id;

    /** @Column(type="string") */
    public $group_type;

    /** @Column(type="string") */
    public $title;

    /** @Column(type="string") */
    public $description;

    /** @Column(type="string") */
    public $image;

    /** @Column(type="smallint") */
    public $position;

    /** @Column(type="smallint") */
    public $status;

    /** @Column(type="integer") */
    public $created_by;

    /** @Column(type="integer") */
    public $created_on;

    /** @Column(type="integer") */
    public $modified_by;

    /** @Column(type="integer") */
    public $modified_on;

    /** @Column(type="integer") */
    public $featured_from;

    /** @Column(type="integer") */
    public $featured_to;
    
    /**
     * @BelongsTo(targetEntity="Pagekit\User\Model\User", keyFrom="created_by")
     */
    public $creator;

    /**
     * @BelongsTo(targetEntity="Pagekit\User\Model\User", keyFrom="modified_by")
     */
    public $editor;

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
