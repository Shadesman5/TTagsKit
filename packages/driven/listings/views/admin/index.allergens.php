<?php $view->script('allergens', 'driven/listings:js/allergens.js', ['vue','uikit-tooltip'])?>

<div id="allergens" v-cloak>

    <div class="uk-margin uk-flex uk-flex-space-between uk-flex-wrap" data-uk-margin>
        <div class="uk-flex uk-flex-middle uk-flex-wrap" data-uk-margin>

            <h2 class="uk-margin-remove">{{getLength()}} {{ 'Allergens' | trans }}</h2>

            <div class="pk-search">
                <div class="uk-search">
                    <input class="uk-search-field" type="text" v-model="search">
                </div>
            </div>

        </div>
        <div data-uk-margin>

            <a class="uk-button uk-button-primary" :href="'allergens/edit'"><i class="uk-icon-plus"></i> {{'Allergen' | trans}}</a>

        </div>
    </div>

    <div class="uk-overflow-container">
        <table class="uk-table uk-table-hover uk-table-middle">
            <thead>
            <tr>
                <th width="40%">{{ 'Title' | trans }}</th>
                <th class="uk-text-center">{{ 'Status' | trans }}</th>
<!--                <th class="uk-text-center">{{ 'Featured Times' | trans }}</th>-->
                <th class="uk-text-center">{{ 'Last Updated' | trans }}</th>
            </tr>
            </thead>
            <tbody>
            <tr class="uk-visible-hover-inline" v-for="allergen in allergens | filterBy search in 'title' orderBy 'position'">
                <td>
                    <a :href="'allergens/edit?id='+allergen.id">{{allergen.title}}</a>
                </td>
                <td class="uk-text-center">
                    <a class="pk-icon-circle-success"
                       :title="allergen.status ? 'Active': 'Inactive' | trans"
                       :class="allergen.status ? 'pk-icon-circle-success': 'pk-icon-circle-danger'"
                       @click="toggle(allergen)"
                       data-uk-tooltip></a>
                </td>
<!--                <td class="uk-text-center">{{ allergen.featured_from | timeFromEpoch }} <i class="uk-icon-long-arrow-right uk-text-primary uk-text-small"></i> {{ allergen.featured_to | timeFromEpoch }}</td>-->
                <td class="uk-text-center">
                    <div v-show="allergen.modified_on && allergen.modified_by">{{ allergen.modified_on | dateFromEpoch }} by <a :href="'user/edit?id='+allergen.editor.id" title="{{allergen.editor.username}}" data-uk-tooltip><i class="uk-icon-user"></i></a></div>
                </td>

            </tr>

            </tbody>
        </table>

    </div>

</div>
