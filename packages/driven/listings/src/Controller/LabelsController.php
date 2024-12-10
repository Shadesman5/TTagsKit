<?php

namespace Driven\Listings\Controller;

use Pagekit\Application as App;
use Driven\Listings\Model\Label;

/**
 * @Access(admin=true)
 * @Access("listings: manage labels")
 */
class LabelsController
{

    public function indexAction()
    {
        $data = Label::query()->related('editor')->get();

        return [
            '$view' => [
                'title' => 'Listings Labels',
                'name' => 'driven/listings:views/admin/labels/index.php'
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

            if (!$user->hasAccess('listings: manage labels')) {
                App::abort(403, __('Insufficient User Rights.'));
            }

            // Lade alle Labels (um Typen zu extrahieren)
            $allLabels = Label::query()->get();
            $group_types = array_unique(array_column($allLabels, 'group_type'));

            if (!$label = Label::query()->where('id = ?', [$id])->first()) {

                if ($id) {
                    App::abort(404, __('Invalid label id.'));
                }

                $maxPosition = Label::query()->max('position');

                $label = [
                    'id' => 0,
                    'created_by' => $user->id,
                    'created_on' => $now,
                    'modified_by' => $user->id,
                    'modified_on' => $now,
                    'group_type' => '',
                    'title' => '',
                    'description' => '',
                    'image' => '',
                    'featured_from'=>1480575600,
                    'featured_to'=>2060288885,
                    'position' => is_null($maxPosition) ? 0 : $maxPosition + 1,
                    'status' => 1
                ];

            }

            return [
                '$view' => [
                    'title' => $id ? __('Edit Label') : __('New Label'),
                    'name' => 'driven/listings:views/admin/labels/edit-label.php'
                ],
                '$data' => [
                    'label' => $label,
                    'group_types' => $group_types
                ]
            ];

        } catch (\Exception $e) {
            App::message()->error($e->getMessage());
            return App::redirect('@listings/labels');
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

        if (!$id || !$label = Label::find($id)) {

            $label = Label::create([
                'created_by' => $user->id,
                'created_on' => $now,
                'modified_by' => $user->id,
                'modified_on' => $now,
                'group_type' => $data['group_type'],
                'title' => $data['title'],
                'description' => $data['description'],
                'image' => $data['image'],
                'featured_from' => $data['featured_from'],
                'featured_to' => $data['featured_to'],
                'position' => $data['position'],
                'status' => 1


            ]);
        } else {
            $label->modified_by = $user->id;
            $label->modified_on = $now;
            $label->group_type = $data['group_type'];
            $label->title = $data['title'];
            $label->description = $data['description'];
            $label->image = $data['image'];
            $label->featured_from = $data['featured_from'];
            $label->featured_to = $data['featured_to'];
            $label->position = $data['position'];
            $label->status = $data['status'];
        }

        $label->save();

        return ['message' => 'success', 'label' => $label];

    }

    /**
     * @Request({"positions": "array", "type":"string"}, csrf=true)
     **/
    public function positionsAction($positions)
    {
        $user = App::user();
        $now = time();

        // if ($labels) {
            foreach ($positions as &$position) {
                $label = Label::find($position['id']);
                $label->position = $position['position'];
                $label->modified_by = $user->id;
                $label->modified_on = $now;
                $label->save();
            }
        // }

        return ['message' => 'success', 'label' => $label];
    }

    /**
     * @Request({"id": "integer", "type": "string"}, csrf=true)
     **/
    public function deleteAction($id)
    {
        $cached = [];

        if (!$id || !$label = Label::find($id)) {

            // Can't Find Listing

        } else {

            // if($listings = Listing::query()->where('label_id = ?',[$label->id])->get()) {
            //    foreach ($listings as $list) {
            //         $list->label_id = 0;
            //         $list->save();
            //     }
            // }

            $cached = $label;
            $label->delete();
        }

        return ['message' => 'success', 'label' => $cached];
    }

}