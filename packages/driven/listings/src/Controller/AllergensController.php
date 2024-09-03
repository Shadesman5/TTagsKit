<?php

namespace Driven\Listings\Controller;

use Pagekit\Application as App;
use Driven\Listings\Model\Allergen;

/**
 * @Access(admin=true)
 * @Access("listings: manage allergens")
 */
class AllergensController
{

    public function indexAction()
    {

        // $data = Allergen::findAll();

        $data = Allergen::query()->related('editor')->get();

        return [
            '$view' => [
                'title' => 'Listings Allergens',
                'name' => 'driven/listings:views/admin/index.allergens.php'
            ],
            '$data' => $data
        ];
    }

    /**
     * @Route("/edit", name="/edit")
     * @Request({"id": "int"})
     */
    public function editAction($id = null)
    {

        try {

            $user = App::user();
            $now = time();

            if (!$allergen = Allergen::query()->where('id = ?', [$id])->first()) {

                if ($id) {
                    App::abort(404, __('Invalid listing id.'));
                }

                $allergen = [
                    'id' => 0,
                    'created_by' => $user->id,
                    'created_on' => $now,
                    'modified_by' => $user->id,
                    'modified_on' => $now,
                    'title' => '',
                    'description' => '',
                    'image' => '',
                    'featured_from'=>1480575600,
                    'featured_to'=>2060288885,
                    'position' => 0,
                    'status' => 1
                ];

            }

            if (!$user->hasAccess('listings: manage allergens')) {
                App::abort(403, __('Insufficient User Rights.'));
            }

            $payload = [
                '$view' => [
                    'title' => $id ? __('Allergen bearbeiten') : __('Allergen hinzufügen'),
                    'name' => 'driven/listings:views/admin/edit-allergen.php'
                ],
                '$data' => [
                    'allergen' => $allergen
                ]
            ];

            return $payload;

        } catch (\Exception $e) {

            App::message()->error($e->getMessage());

            return App::redirect('@listings/allergens');
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

        if (!$id || !$allergen = Allergen::find($id)) {

            $allergen = Allergen::create([
                'created_by' => $user->id,
                'created_on' => $now,
                'modified_by' => $user->id,
                'modified_on' => $now,
                'title' => $data['title'],
                'description' => $data['description'],
                'image' => $data['image'],
                'featured_from' => $data['featured_from'],
                'featured_to' => $data['featured_to'],
                'position' => $data['position'],
                'status' => 1


            ]);
        } else {
            $allergen->modified_by = $user->id;
            $allergen->modified_on = $now;
            $allergen->title = $data['title'];
            $allergen->description = $data['description'];
            $allergen->image = $data['image'];
            $allergen->featured_from = $data['featured_from'];
            $allergen->featured_to = $data['featured_to'];
            $allergen->position = $data['position'];
            $allergen->status = $data['status'];
        }

        $allergen->save();

        return ['message' => 'success', 'allergen' => $allergen];

    }

    /**
     * @Request({"id": "integer", "type": "string"}, csrf=true)
     **/
    public function deleteAction($id)
    {
        $user = App::user();
        $now = time();
        $cached = [];


        if (!$id || !$allergen = Allergen::find($id)) {

            // Can't Find Listing

        } else {

            // if($listings = Listing::query()->where('allergen_id = ?',[$allergen->id])->get()) {
            //    foreach ($listings as $list) {
            //         $list->allergen_id = 0;
            //         $list->save();
            //     }
            // }

            $cached = $allergen;
            $allergen->delete();
        }

        return ['message' => 'success', 'allergen' => $cached];
    }


}