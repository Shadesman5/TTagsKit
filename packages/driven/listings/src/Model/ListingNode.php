<?php

namespace Driven\Listings\Model;

use Pagekit\Site\Model\Node;

/**
 * @Entity(tableClass="@system_node")
 */
class ListingNode extends Node
{
    /** @Column(type="integer") */
    public $listing_id = 0;

}