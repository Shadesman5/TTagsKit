<?php

namespace Driven\Listings\Model;

use Pagekit\Site\Model\Page;

/**
 * @Entity(tableClass="@system_page")
 */
class ListingPage extends Page
{
    /** @Column(type="integer") */
    public $listing_id = 0;

}
