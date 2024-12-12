<?php

namespace Driven\Listings\Utils;

use Pagekit\Application as App;
use Driven\Listings\Model\ListingNode;
use Driven\Listings\Model\ListingPage;

class NodeManager
{
    public static function updateNodePage($listing, $groupType, $groupIdentifier, $allowPages, $allowNodes, $listingNode, $listingPage)
    {
        // Handle Group Nodes and Pages
        $groupNode = ListingNode::query()->where('data LIKE ?', ['%"group":"' . $groupIdentifier . '"%'])->first();
        $groupPage = ListingPage::query()->where('data LIKE ?', ['%"group":"' . $groupIdentifier . '"%'])->first();

        // Create or update Group Page
        if ($allowPages && !$groupPage) {
            $groupPage = ListingPage::create([
                'listing_id' => 0,
                'title' => $groupType->title,
                'content' => '',
                'data' => [
                    'title' => true,
                    'group' => $groupIdentifier,
                ],
            ]);
            $groupPage->save();
        }

        if ($allowNodes && !$groupNode) {
            $groupNode = ListingNode::create([
                'listing_id' => 0,
                'title' => $groupType->title,
                'slug' => strtolower(str_replace(' ', '-', $groupType->title)),
                'status' => 1,
                'type' => 'page',
                'path' => '/' . strtolower(str_replace(' ', '-', $groupType->title)),
                'link' => isset($groupPage) ? "@page/{$groupPage->id}" : '',
                'menu' => 'main',
                'data' => [
                    'defaults' => ['id' => $groupPage->id ?? null],
                    'meta' => ['og:title' => $groupType->title],
                    'group' => $groupIdentifier,
                ],
            ]);
            $groupNode->save();
        }

        $parentNodeId = $groupNode->id ?? null;

        // Create or update listing nodes and pages if allowed.
        if ($allowPages) {
            if (!$listingPage) {
                $listingPage = ListingPage::create([
                    'listing_id' => $listing->id,
                    'title' => $listing->title,
                    'content' => "(menu){\"id\":\"{$listing->id}\"}",
                    'data' => [
                        'title' => true,
                        'group' => $groupIdentifier,
                    ],
                ]);
                $listingPage->save();
            } else {
                $listingPage->title = $listing->title;
                $listingPage->save();
            }
        }

        if ($allowNodes) {
            if (!$listingNode) {
                $listingNode = ListingNode::create([
                    'listing_id' => $listing->id,
                    'parent_id' => $parentNodeId,
                    'title' => $listing->title,
                    'slug' => strtolower(str_replace(' ', '-', $listing->title)),
                    'status' => 1,
                    'type' => 'page',
                    'path' => '/' . strtolower(str_replace(' ', '-', $listing->title)),
                    'link' => isset($listingPage) ? "@page/{$listingPage->id}" : '',
                    'menu' => 'main',

                    'data' => [
                        'defaults' => ['id' => $listingPage->id ?? null],
                        'meta' => ['og:title' => $listing->title],
                        'group' => $groupIdentifier,
                    ],
                ]);
                $listingNode->save();
            } else {
                $listingNode->title = $listing->title;
                $listingNode->parent_id = $parentNodeId;
                $listingNode->slug = strtolower(str_replace(' ', '-', $listing->title));
                $listingNode->save();
            }
        }

        // Update theme configuration for Nodes and Pages
        $activeTheme = App::config('system')->get('site.theme');
        if ($allowNodes && isset($listingNode->id)) {
            self::updateThemeConfig($listingNode->id, $activeTheme);
        }
        if ($allowPages && isset($groupNode->id)) {
            self::updateThemeConfig($groupNode->id, $activeTheme);
        }

        // Store Parent Group ID for Session Reference
        if ($listingNode && $listingNode->parent_id > 0) {
            App::session()->remove("parent_group_id_{$listing->id}");
            App::session()->set("parent_group_id_{$listing->id}", $listingNode->parent_id);
        }
    }

    public static function updateListingsNodes($groupNode, $groupIdentifier)
    {
        // Hole alle Child-Nodes (Listings), die zu dieser Gruppe gehören
        $listings = ListingNode::query()
            ->where('parent_id = ?', [$groupNode->id])
            ->where('data LIKE ?', ['%"group":"' . $groupIdentifier . '"%'])
            ->get();

        if (!$listings) {
            error_log("No Listings-Nodes found for Group ID: {$groupNode->id}, Identifier: {$groupIdentifier}");
        }

        foreach ($listings as $node) {
            $node->save();
        }
    }

    public static function updateThemeConfig($nodeId, $themeName)
    {
        $themeConfig = App::config($themeName)->get('_nodes', []);
        $themeConfig[$nodeId] = array_merge($themeConfig[$nodeId] ?? [], [
            'title_hide' => true,
            'content_top_padding' => true,
            'content_bottom_padding' => true
        ]);
        App::config($themeName)->set('_nodes', $themeConfig);
    }

    public static function removeNodePage($listing, $groupIdentifier, $listingNode, $listingPage)
    {
        if ($listingNode) {
            $activeTheme = App::config('system')->get('site.theme');
            self::removeThemeConfig($listingNode->id, $activeTheme);
            $listingNode->delete();
        }

        if ($listingPage) {
            $listingPage->delete();
        }

        $parentGroupId = App::session()->get("parent_group_id_{$listing->id}");
        if ($parentGroupId) {
            $remainingNodes = ListingNode::query()->where('parent_id = ?', [$parentGroupId])->count();
            if ($remainingNodes === 0) {
                $groupNode = ListingNode::query()->where('id = ?', [$parentGroupId])->first();
                if ($groupNode) {
                    $activeTheme = App::config('system')->get('site.theme');
                    self::removeThemeConfig($groupNode->id, $activeTheme);

                    $groupIdentifier = $groupNode->data['group'] ?? null;
                    if ($groupIdentifier) {
                        $groupPage = ListingPage::query()->where('data LIKE ?', ['%"group":"' . $groupIdentifier . '"%'])->first();
                        if ($groupPage) {
                            $groupPage->delete();
                        }
                    }
                    $groupNode->delete();
                }
            }
        }
    }

    public static function removeThemeConfig($nodeId, $themeName)
    {
        $themeConfig = App::config($themeName)->get('_nodes', []);
        if (isset($themeConfig[$nodeId])) {
            unset($themeConfig[$nodeId]);
            App::config($themeName)->set('_nodes', $themeConfig);
        }
    }
}
