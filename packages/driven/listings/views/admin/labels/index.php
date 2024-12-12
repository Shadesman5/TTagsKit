<?php $view->script('labels', 'driven/listings:js/labels.js', ['vue', 'uikit-tooltip', 'uikit-nestable']) ?>

<div id="labels" v-cloak>

    <div class="uk-grid">
        <div class="uk-width-medium-1-4">
            <ul class="uk-tab uk-tab-left" data-uk-tab="{connect:'#labelSwitcher'}">
                <li v-for="(index, group_type) in uniqueLabelTypes" :key="index" :class="{'uk-active': selectedType === group_type}" @click="selectLabelType(group_type)">
                    <a>
                        <i class="uk-icon-folder-open uk-icon-medium uk-margin-right"></i>
                        {{ group_type + 's' }}
                    </a>
                </li>
            </ul>
        </div>
        
        <div class="uk-width-medium-3-4">
            <div class="uk-margin uk-flex uk-flex-space-between uk-flex-wrap" data-uk-margin>
                <div class="uk-flex uk-flex-middle uk-flex-wrap" data-uk-margin>

                    <h2 class="uk-margin-remove">{{ getLength() }} {{ selectedType + 's' | trans }}</h2>

                    <div class="pk-search">
                        <div class="uk-search">
                            <input class="uk-search-field" type="text" v-model="search">
                        </div>
                    </div>

                </div>
                <div data-uk-margin>

                    <a class="uk-button uk-button-primary" :href="'labels/edit'"><i class="uk-icon-plus"></i> {{ selectedType | trans }}</a>

                </div>
            </div>

            <div class="uk-overflow-container">
                <div class="pk-table-fake pk-table-fake-header">
                    <div class="pk-table-min-width-150">{{ 'Title' | trans }}</div>
                    <div class="pk-table-width-100 uk-text-center">{{ 'Status' | trans }}</div>
                    <div class="pk-table-width-150">{{ 'Last Updated' | trans }}</div>
                </div>
                <ul class="uk-nestable uk-margin-remove sortable-labels"
                    :class="{'uk-nestable-empty': !getLength(listing.labels)}"
                    data-uk-nestable="{maxDepth:1, handleClass:'uk-nestable-handle'}">
                    <li :key="label.id" v-for="label in filteredLabels | orderBy 'position'"
                        class="uk-nestable-item sortable-item"
                        data-id="{{label.id}}" data-index="{{$index}}">
                        <div class="uk-nestable-panel pk-table-fake uk-form uk-visible-hover">
                            <div class="pk-table-min-width-150">
                                <div class="uk-flex uk-flex-middle">
                                    <div class="uk-nestable-handle uk-margin-right" data-uk-tooltip
                                        title="{{ 'Change Order' | trans}}">
                                        <i class="uk-icon-hover uk-icon-sort"></i>
                                    </div>
                                    <a :href="'labels/edit?id='+label.id">{{label.title}}</a>
                                </div>
                            </div>
                            <div class="pk-table-width-100 uk-text-center">
                                <a class="pk-icon-circle-success"
                                    :title="label.status ? 'Active': 'Inactive' | lians"
                                    :class="label.status ? 'pk-icon-circle-success': 'pk-icon-circle-danger'"
                                    @click="toggle(label)"
                                    data-uk-tooltip></a>
                            </div>
                            <div class="pk-table-width-150 pk-table-max-width-150 uk-text-nowrap">
                                <div v-show="label.modified_on && label.modified_by">{{ label.modified_on | dateFromEpoch }} by <a :href="'user/edit?id='+label.editor.id" title="{{label.editor.username}}" data-uk-tooltip><i class="uk-icon-user"></i></a></div>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>

    </div>

</div>