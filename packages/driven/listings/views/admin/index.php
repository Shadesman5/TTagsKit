<?php $view->script('listings', 'driven/listings:js/listings.js', ['vue', 'editor', 'uikit-sortable', 'uikit-nestable', 'uikit-tooltip'])?>

<div id="listings" v-cloak>

    <div class="uk-grid" data-uk-grid-margin>
        <div class="uk-width-medium-1-4">
            <ul class="uk-tab uk-tab-left" data-uk-tab data-uk-margin>
                <li class="uk-flex uk-flex-middle uk-overflow-hidden uk-margin-small-top uk-visible-hover" v-for="group in group_types" :key="group.id" :class="{'uk-active': selectedGroup.id === group.id}" @click="selectListingGroup(group.id)">
                        <a class="uk-width-1-1 uk-margin-remove">
                            <i class="uk-icon-folder-open uk-icon-small uk-margin-small-right"></i>
                            {{ group.title }}
                        </a>
                        <span v-if="group.id !== 1 && group.id !== 2 && group.id !== 3" style="position:absolute;right:0;" class="uk-width-1-10 uk-overlay-right uk-hidden uk-animation-slide-right">
                            <a href="" class="uk-icon-hover uk-icon-trash-o uk-text-danger"
                                    data-uk-tooltip title="{{ 'Remove Listings Group Type' | trans}}"
                                    @click.stop.prevent="removeGroupType(group.id, group.title)"></a>
                        </span>
                </li>
                <li :key="selectedGroup.id" :class="{'uk-active': selectedGroup.id === null}" @click="selectListingGroup('new')">
                        <a class="uk-width-1-1 uk-margin-remove">
                            <i class="uk-icon-folder-open uk-icon-small uk-margin-small-right"></i>
                            New Group Type
                        </a>
                </li>
            </ul>
        </div>

        <div class="uk-width-medium-3-4">
            <form v-if="selectedGroup.id !== 1" class="uk-form uk-margin" @submit.prevent="save | valid">
                
                <div class="uk-margin uk-grid" data-uk-margin>
                    <div class="uk-form-row uk-width-small-4-5">
                        <section class="uk-form uk-grid uk-grid-small" data-uk-grid-margin>
                            <div class="uk-panel uk-width-1-1 uk-width-small-1-2" data-uk-margin>
                                <input name="title" class="uk-width-1-1" type="text" v-model="selectedGroup.title" v-validate:required
                                    placeholder="{{ 'Group Type Title' | trans }}"/>

                                <p class="uk-form-help-block uk-text-danger"
                        v-show="list_form && list_form.title.invalid"><?= __('Please provide a title.') ?></p>

                                <div class="uk-panel uk-width-1-1">
                                    <textarea class="uk-width-1-1 uk-height-small" v-model="selectedGroup.description" style="height: 100px;" placeholder="{{ 'Description' | trans }}"></textarea>
                                </div>
                            </div>

                            <div class="uk-panel uk-width-1-1 uk-width-small-1-2">
                                <div class="uk-panel-box uk-panel-box-small">
                                    <input-image :source.sync="selectedGroup.image" class="uk-responsive-height"></input-image>
                                </div>
                            </div>
                        </section>
                    </div>

                    <div class="uk-width-small-1-5">
                        <button class="uk-button uk-button-primary" @click.prevent="saveGroupType" type="submit">{{ 'Save' | trans }}</button>
                    </div>
                </div>

                <hr>

            </form>

            <div class="uk-margin uk-flex uk-flex-space-between uk-flex-wrap" data-uk-margin>
                <div class="uk-flex uk-flex-middle uk-flex-wrap" data-uk-margin>

                    <h2 class="uk-margin-remove">{{ getLength() }} x {{ selectedGroup.title | trans }}</h2>

                    <div class="pk-search">
                        <div class="uk-search">
                            <input class="uk-search-field" type="text" v-model="search">
                        </div>
                    </div>

                </div>
                <div data-uk-margin>

                    <a class="uk-button uk-button-primary" :href="'listings/edit?group_type_id=' + selectedGroup.id"><i class="uk-icon-plus"></i> {{ selectedGroup.title | trans }}</a>

                </div>
            </div>

            <div class="uk-overflow-container">
                <div class="pk-table-fake pk-table-fake-header">
                    <div class="pk-table-min-width-150">{{ 'Title' | trans }}</div>
                        <div class="pk-table-min-max-width-75 uk-text-center">{{ 'Status' | trans }}</div>
                        <!-- <div class="uk-text-center">{{ 'Featured Times' | trans }}</div> -->
                        <div class="pk-table-min-max-width-125 uk-text-center">{{ 'Plugin Code' | trans }}</div>
                        <div class="pk-table-min-max-width-125 uk-text-center">{{ 'Active Template' | trans }}</div>
                        <div class="pk-table-min-max-width-150 uk-text-nowrap uk-text-center">{{ 'Last Updated' | trans }}</div>
                    </div>
                    <ul class="uk-nestable uk-margin-remove sortable-listings"
                        :class="{'uk-nestable-empty': !getLength(listings)}"
                        data-uk-nestable="{maxDepth:1, handleClass:'uk-nestable-handle'}">
                        <li :key="listing.id" v-for="listing in filteredListings | filterBy search in 'title' | orderBy 'position'"
                            class="uk-nestable-item sortable-item"
                            data-id="{{listing.id}}" data-index="{{listing.id}}">
                            <div class="uk-nestable-panel pk-table-fake uk-form uk-visible-hover">
                                <div class="pk-table-min-width-150">
                                    <div class="uk-flex uk-flex-middle">
                                        <div class="uk-nestable-handle uk-margin-right" data-uk-tooltip
                                            title="{{ 'Change Order' | trans}}">
                                            <i class="uk-icon-hover uk-icon-sort"></i>
                                        </div>
                                        <a :href="'listings/edit?id='+listing.id">{{listing.title}}</a>
                                    </div>
                                </div>
                                <div class="pk-table-min-max-width-75 uk-text-center">
                                    <a class="pk-icon-circle-success"
                                        :title="listing.status ? 'Active': 'Inactive' | trans"
                                        :class="listing.status ? 'pk-icon-circle-success': 'pk-icon-circle-danger'"
                                        @click="toggle(listing)"
                                        data-uk-tooltip></a>
                                </div>
                                <!-- <div class="uk-text-center">{{ listing.featured_from | timeFromEpoch }} <i class="uk-icon-long-arrow-right uk-text-primary uk-text-small"></i> {{ listing.featured_to | timeFromEpoch }}</div> -->
                                <div class="pk-table-min-max-width-125 uk-text-center"><code title="{{ 'Place this on a Page' | trans}}" data-uk-tooltip>(menu){"id":"{{listing.id}}"}</code></div>
                                <div class="pk-table-min-max-width-125 uk-text-center">
                                    <a v-if="listing.template" :href="'listings/templates/edit?id='+listing.template.id" title="{{'Edit Template' | trans}}" data-uk-tooltip>{{listing.template.title}}</a>
                                    <!-- <a v-else :href="'listings/templates'" title="{{'View Templates' | trans}}" data-uk-tooltip>Main Template</a> -->
                                </div>
                                <div class="pk-table-min-max-width-150 uk-text-nowrap uk-text-center">
                                    <div v-show="listing.modified_on && listing.modified_by">{{ listing.modified_on | dateFromEpoch }} by <a :href="'user/edit?id='+listing.editor.id" title="{{listing.editor.username}}" data-uk-tooltip><i class="uk-icon-user"></i></a></div>
                                </div>
                            </div>
                        </li>

                    </ul>

                    </tbody>
                </table>

            </div>
        </div>
    </div>

</div>