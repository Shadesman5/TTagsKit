<?php

namespace Driven\Listings\Controller;

use Driven\Listings\Model\GroupType;
use Pagekit\Application as App;
use Driven\Listings\Model\Listing;

use Driven\Listings\Utils\NodeManager;
use Driven\Listings\Model\ListingNode;
use Driven\Listings\Model\ListingPage;

/**
 * @Access(admin=true)
 * @Access("listings: manage lists")
 */
class GroupTypesController
{

    public function indexAction()
    {
        $data = GroupType::query()->related('editor')->get();

        return [
            '$view' => [
                'name' => 'driven/listings:views/admin/index.php'
            ],
            '$data' => [
                'data' => $data
            ]
        ];
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

            if (!$group_type = GroupType::query()->where('id = ?', [$id])->first()) {

                if ($id) {
                    App::abort(404, __('Invalid Group Type.'));
                }

                $maxPosition = GroupType::query()->max('position');

                $group_type = [
                    'id' => 0,
                    'created_by' => $user->id,
                    'created_on' => $now,
                    'modified_by' => $user->id,
                    'modified_on' => $now,
                    'title' => '',
                    'description' => '',
                    'image' => '',
                    'settings' => [],
                    'position' => is_null($maxPosition) ? 0 : $maxPosition + 1,
                    'status' => 1,
                    'featured_from' => 1480575600,
                    'featured_to' => 2060288885
                ];
            }

            $payload = [
                '$view' => [
                    'name' => 'driven/listings:views/admin/index.php'
                ],
                '$data' => [
                    'group_type' => $group_type
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
     */
    public function saveAction($data)
    {
        try {
            $user = App::user();
            $id = $data['id'];
            $now = time();
            $isNew = !$id;

            if (!$id || !$group_type = GroupType::find($id)) {

                $group_type = GroupType::create([
                    'created_by' => $user->id,
                    'created_on' => $now,
                    'modified_by' => $user->id,
                    'modified_on' => $now,
                    'title' => $data['title'],
                    'description' => $data['description'],
                    'image' => $data['image'],
                    'settings' => $data['settings'],
                    'position' => $data['position'],
                    'status' => 1,
                    'featured_from' => $data['featured_from'],
                    'featured_to' => $data['featured_to']
                ]);
            } else {
                $group_type->modified_by = $user->id;
                $group_type->modified_on = $now;
                $group_type->title = $data['title'];
                $group_type->description = $data['description'];
                $group_type->image = $data['image'];
                $group_type->settings = $data['settings'];
                $group_type->position = $data['position'];
                $group_type->status = $data['status'];
                $group_type->featured_from = $data['featured_from'];
                $group_type->featured_to = $data['featured_to'];
            }
            if ($isNew) {
                $group_type->settings = [
                    'group' => "custom" . uniqid(),
                    'allow_nodes' => false,
                    'allow_pages' => false,
                    'system_defaults' => [
                        'max_listings' => 10
                    ],
                    'user_defaults' => [
                        'show_in_menu' => false
                    ]
                ];
            }
            $group_type->save();

            $groupIdentifier = $group_type->settings['group'] ?? '';

            // Update group existing page and node if applicable
            if ($groupPage = ListingPage::query()->where('data LIKE ?', ['%"group":"' . $groupIdentifier . '"%'])->first()) {
                $groupPage->title = $data['title'];
                $groupPage->save();
            }

            if ($groupNode = ListingNode::query()->where('data LIKE ?', ['%"group":"' . $groupIdentifier . '"%'])->first()) {
                $groupNode->title = $data['title'];
                $groupNode->slug = strtolower(str_replace(' ', '-', $data['title']));
                $groupNode->save();

                NodeManager::updateListingsNodes($groupNode, $groupIdentifier);
            }

            return ['message' => 'success', 'group_type' => $group_type];
        } catch (\Exception $e) {
            App::message()->error($e->getMessage());
            error_log("Save GroupType Error: " . $e->getMessage());
            return ['message' => 'error', 'error' => $e->getMessage()];
        }
    }

    /**
     * @Request({"id": "integer", "type": "string"}, csrf=true)
     **/
    public function deleteAction($id)
    {

        $cached = [];

        if (!$id || !$group_type = GroupType::find($id)) {

            // Can't Find Listing

        } else {

            $listings = Listing::query()->where('group_type_id = ?', [$group_type->id])->get();
            foreach ($listings as $listing) {
                $listing->group_type_id = 1;
                $listing->save();
            }

            $cached = $group_type;
            $group_type->delete();
        }

        return ['message' => 'success', 'label' => $cached];
    }
}
