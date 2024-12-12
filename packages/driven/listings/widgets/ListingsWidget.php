<?php

namespace Driven\Listings\Widget;

use Driven\Listings\Model\GroupType;
use Driven\Listings\Model\Listing;
use Driven\Listings\Model\ListingNode;
use Pagekit\Application as App;

return [

    'name' => 'driven/listings',

    'label' => 'Menucards',

    'events' => [

        'view.scripts' => function ($event, $scripts) use ($app) {
            $scripts->register('widget-listing', 'driven/listings:js/widget-listing.js', ['~widgets']);
        }

    ],

    'render' => function ($widget) use ($app) {

        // Lade die ersten zwei Listings mit aktivierten Nodes oder Pages
        $listings = Listing::query()
            ->where('status = ?', [1])
            ->orderBy('position', 'ASC')
            ->limit(3)
            ->get();

        foreach ($listings as $listing) {
            $listingNode = ListingNode::query()
                ->where('listing_id = ?', [$listing->id])
                ->first();

            if ($listingNode) {
                $listing->path = $listingNode->path;
            } else {
                $listing->path = null; // Kein gültiger Node gefunden
            }
        }

        // Gib nur Listings mit gültigem Pfad zurück
        $listings = array_filter($listings, fn($listing) => !is_null($listing->path));

        // Lade den ersten gültigen GroupNode direkt aus der Node-Tabelle
        $groupNode = ListingNode::query()
            ->where('listing_id = ?', [0])
            ->where('data LIKE ?', ['%"group":"%'])
            ->first();

        if ($groupNode) {
            // Extrahiere den Group-Identifier aus den Node-Daten
            $groupIdentifier = $groupNode->data['group'] ?? null;

            if ($groupIdentifier) {
                // Lade die zugehörigen Daten aus group_types
                $groupTypeData = GroupType::query()
                    ->where('settings LIKE ?', ['%"group":"' . $groupIdentifier . '"%'])
                    ->first();

                // Kombiniere die Informationen
                $groupType = (object) [
                    'title' => $groupNode->title,
                    'image' => $groupTypeData->image ?? null,
                    'path' => $groupNode->path
                ];
            } else {
                $groupType = null;
            }
        } else {
            $groupType = null;
        }

        // Gib das Widget-Template zurück
        return $app->view('driven/listings/widget/widget-listing.php', [
            'groupType' => $groupType,
            'listings' => $listings,
        ]);
    }

];
