<?php

namespace Driven\Listings\Controller;

use Driven\Listings\Model\ListingCategory as Category;
use Driven\Listings\Model\Item;
use Driven\Listings\Model\Template;
use Driven\Listings\Model\Label;
use Pagekit\Application as App;
use Driven\Listings\Model\GroupType;
use Driven\Listings\Model\Listing;

use Driven\Listings\Utils\NodeManager;
use Driven\Listings\Model\ListingNode;
use Driven\Listings\Model\ListingPage;

/**
 * @Access(admin=true)
 * @Access("listings: manage lists")
 */
class ListingsController
{

    public function indexAction()
    {
        $group_types = GroupType::findAll();

        $data = Listing::query()
            ->related(['editor' => function ($query) {
                return $query->select('id', 'username');
            }])
            ->related('template')->get();

        $payload = [
            '$view' => [
                'title' => 'Listings',
                'name' => 'driven/listings:views/admin/index.php'
            ],
            '$data' => [
                'listings' => $data,
                'group_types' => array_values($group_types)
            ]
        ];

        return $payload;
    }

    /**
     * @Route("/edit", name="/edit")
     * @Request({"id": "int"})
     */
    public function editAction($id = 0)
    {
        try {

            $user = App::user();
            $now = time();

            if (!$user->hasAccess('listings: manage lists')) {
                App::abort(403, __('Insufficient User Rights.'));
            }

            if (!$listing = Listing::query()->where('id = ?', [$id])
                ->related(['categories' => function ($query) {
                    return $query
                        ->related(['items' => function ($query) {
                            return $query;
                        }]);
                }])->first()) {

                if ($id) {
                    App::abort(404, __('Invalid listing id.'));
                }

                $maxPosition = Listing::query()->max('position');

                $listing = [
                    'id' => 0,
                    'group_type_id' => 1,
                    'created_by' => $user->id,
                    'created_on' => $now,
                    'modified_by' => $user->id,
                    'modified_on' => $now,
                    'title' => '',
                    'description' => '',
                    'image' => '',
                    'template_id' => 1,
                    'featured_from' => 1480575600,
                    'featured_to' => 2060288885,
                    'position' => is_null($maxPosition) ? 0 : $maxPosition - 1,
                    'status' => 1
                ];
            }

            $category = [
                'created_by' => $user->id,
                'created_on' => $now,
                'modified_by' => $user->id,
                'modified_on' => $now,
                'title' => '',
                'description' => '',
                'image' => '',
                'position' => 0,
                'status' => 1
            ];

            $item = [
                'created_by' => $user->id,
                'created_on' => $now,
                'modified_by' => $user->id,
                'modified_on' => $now,
                'title' => '',
                'description' => '',
                'volume' => '',
                'labels' => [],
                'image' => '',
                'position' => 0,
                'status' => 1,
                'price' => '',
                'tags' => []
            ];

            $templates = Template::findAll();

            $group_types = GroupType::findAll();

            $labels = Label::findAll();

            //            // Sort Categories and Update Key Index
            //            usort($listing->categories, function ($a, $b) {
            //                return ($a->position < $b->position) ? -1 : (($a->position > $b->position) ? 1 : 0);
            //            });
            //
            //            // Sort Items and Update Key Index
            //            foreach($listing->categories as $sortCategory){
            //                usort($sortCategory->items, function ($a, $b) {
            //                    return ($a->position < $b->position) ? -1 : (($a->position > $b->position) ? 1 : 0);
            //                });
            //            }

            $payload = [
                '$view' => [
                    'title' => $id ? __('Editer Listing') : __('Add Listing'),
                    'name' => 'driven/listings:views/admin/edit-listing.php'
                ],
                '$data' => [
                    'listing' => $listing,
                    'group_types' => $group_types,
                    'templates' => $templates,
                    'category_model' => $category,
                    'item_model' => $item,
                    'labels' => $labels
                ]
            ];

            return $payload;
        } catch (\Exception $e) {

            App::message()->error($e->getMessage());

            return App::redirect('@listings');
        }
    }

    /**
     * @Request({"data": "array"}, csrf=true)
     **/
    public function saveAction($data)
    {
        $user = App::user();
        $id = $data['id'];
        $now = time();

        $t_from = $data['featured_from'];
        $t_to = $data['featured_to'];

        // Set epoch to human time if necessary
        $featured_from = (is_numeric($t_from) && (int)$t_from == $t_from) ? $t_from : strtotime($t_from);
        $featured_to = (is_numeric($t_to) && (int)$t_to == $t_to) ? $t_to : strtotime($t_to);

        if (!$id || !$listing = Listing::find($id)) {

            $listing = Listing::create([
                'group_type_id' => $data['group_type_id'],
                'created_by' => $user->id,
                'created_on' => $now,
                'modified_by' => $user->id,
                'modified_on' => $now,
                'title' => $data['title'],
                'description' => $data['description'],
                'image' => $data['image'],
                'template_id' => $data['template_id'],
                'featured_from' => $featured_from,
                'featured_to' => $featured_to,
                'position' => $data['position'],
                'status' => 1
            ]);
        } else {
            $listing->group_type_id = $data['group_type_id'];
            $listing->modified_by = $user->id;
            $listing->modified_on = $now;
            $listing->title = $data['title'];
            $listing->description = $data['description'];
            $listing->image = $data['image'];
            $listing->template_id = $data['template_id'];
            $listing->featured_from = $featured_from;
            $listing->featured_to = $featured_to;
            $listing->position = $data['position'];
            $listing->status = $data['status'];
        }

        $listing->save();

        // Update Nodes and Pages
        $groupType = GroupType::find($listing->group_type_id);
        $groupIdentifier = $groupType->settings['group'] ?? '';
        $allowPages = !empty($groupType->settings['allow_pages']);
        $allowNodes = !empty($groupType->settings['allow_nodes']);

        $listingNode = ListingNode::query()->where('listing_id = ?', [$listing->id])->first();
        $listingPage = ListingPage::query()->where('listing_id = ?', [$listing->id])->first();

        if ($allowNodes || $allowPages) {
            NodeManager::updateNodePage($listing, $groupType, $groupIdentifier, $allowPages, $allowNodes, $listingNode, $listingPage);
        } else {
            NodeManager::removeNodePage($listing, $groupIdentifier, $listingNode, $listingPage);
        }

        return ['message' => 'success', 'listing' => $listing];
    }

    /**
     * @Request({"positions": "array", "type":"string"}, csrf=true)
     **/
    public function positionsAction($positions, $type)
    {
        $user = App::user();
        $now = time();
        $listing_id = [];

        if ($type == 'listings') {
            foreach ($positions as &$position) {
                $listing = Listing::find($position['id']);
                $listing->position = $position['position'];
                $listing->modified_by = $user->id;
                $listing->modified_on = $now;
                $listing->save();
            }
        }

        if ($type == 'categories') {
            foreach ($positions as &$position) {
                $category = Category::find($position['id']);
                $category->position = $position['position'];
                $category->save();
            }
            $listing_id = $category->listing_id;
        }

        if ($type == 'items') {
            foreach ($positions as &$position) {
                $item = Item::find($position['id']);
                $item->position = $position['position'];
                $item->category_id = $position['category_id'];
                $item->save();
            }
            $listing_id = $item->listing_id;
        }

        if ($listing_id) {
            $listing = Listing::query()->related('categories')->related('categories.items')->where('id = ?', [$listing_id])->first();
            $listing->modified_by = $user->id;
            $listing->modified_on = $now;
            $listing->save();
        }

        return ['message' => 'success', 'listing' => $listing];
    }

    /**
     * @Request({"id": "integer", "type": "string"}, csrf=true)
     **/
    public function deleteAction($id, $type = 'listing')
    {
        $user = App::user();
        $now = time();
        $cached = [];

        if ($type == 'listing') {
            if (!$id || !$listing = Listing::find($id)) {

                // Can't Find Listing

            } else {

                $categories = Category::query()->where('listing_id = ?', [$id])->get();
                $items = Item::query()->where('listing_id = ?', [$id])->get();

                foreach ($items as $item) {
                    $item->delete();
                }

                foreach ($categories as $category) {
                    $category->delete();
                }

                // Load group type and settings
                $groupType = GroupType::find($listing->group_type_id);
                $groupIdentifier = $groupType->settings['group'] ?? '';

                // Fetch nodes and pages
                $listingNode = ListingNode::query()->where('listing_id = ?', [$listing->id])->first();
                $listingPage = ListingPage::query()->where('listing_id = ?', [$listing->id])->first();

                // Remove nodes and pages for listings and groups if conditions are not met.
                NodeManager::removeNodePage($listing, $groupIdentifier, $listingNode, $listingPage);

                $cached = $listing;
                $listing->delete();
            }

            return ['message' => 'success', 'listing' => $cached];
        } elseif ($type == 'category') {

            if (!$id || !$category = Category::find($id)) {

                // Can't Find Category

            } else {

                $listing = Listing::query()->related('categories')->related('categories.items')->where('id = ?', [$category->listing_id])->first();
                $listing->modified_by = $user->id;
                $listing->modified_on = $now;
                $listing->save();

                $items = Item::query()->where('category_id = ?', [$category->id])->get();
                foreach ($items as $item) {
                    $item->delete();
                }

                $cached = $category;
                $category->delete();
            }

            return ['message' => 'success', 'category' => $cached];
        } elseif ($type == 'item') {

            if (!$id || !$item = Item::find($id)) {

                // Can't Find Category

            } else {
                $listing = Listing::query()->related('categories')->related('categories.items')->where('id = ?', [$item->listing_id])->first();
                $listing->modified_by = $user->id;
                $listing->modified_on = $now;
                $listing->save();
                $cached = $item;
                $item->delete();
            }

            return ['message' => 'success', 'item' => $cached];
        }
    }
}
