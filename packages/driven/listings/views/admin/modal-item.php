<v-modal v-ref:itemmodal large>

    <form class="uk-form" v-validator="item_form" @submit.prevent="saveItem(category_model.id) | valid" uk-grid-margin>
        <div class="uk-modal-header uk-flex uk-flex-wrap uk-flex-space-between uk-flex-middle">

            <h2>{{ (item_model.id ? 'Edit Item' : 'New Item') | trans }}
                <em v-show="item_model.id"
                    class="uk-text-italic uk-text-muted">{{item_model.title}}</em>
            </h2>

            <label>
                <input type="checkbox" v-model="item_model.status" v-bind:true-value="1" v-bind:false-value="0">
                {{'Active' | trans }}
            </label>

        </div>


        <div class="uk-form-row">
            <div class="uk-grid uk-grid-small">

                <div class="uk-width-1-1 uk-width-small-1-2 uk-width-medium-2-3">
                    <input name="title" placeholder="{{ 'Title' | trans }}"
                        class="uk-width-1-1" type="text" v-model="item_model.title"
                        v-validate:required />
                    <p class="uk-form-help-block uk-text-danger">
                        <span v-show="item_form && item_form.title.invalid"><?= __('Please provide a title') ?></span>
                    </p>
                </div>
                <div class="uk-width-1-1 uk-width-small-1-2 uk-width-medium-1-3">
                    <div class="uk-grid uk-grid-small">
                        <div class="uk-width-1-2">
                            <input name="volume" type="text" placeholder="{{ 'Unit' | trans }} (ml,cl,etc.)" class="uk-width-1-1" v-model="item_model.volume" />
                        </div>
                        <div class="uk-width-1-2 uk-form-icon">
                            <i class="uk-icon-euro"></i>
                            <input type="number" step="0.01" class="uk-width-1-1" placeholder="{{ 'Price' | trans }}"
                                v-model="item_model.price">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="uk-form-row">

            <div class="uk-grid">
                <div class="uk-width-1-1">
                    <!-- <v-editor :value.sync="item_model.description"
                              :options="{markdown : false, height: 100}"></v-editor> -->

                    <textarea class="uk-width-1-1 uk-height-small" v-model="item_model.description" style="height: 100px;" placeholder="{{ 'Description' | trans }}"></textarea>
                </div>
            </div>

        </div>

        <div class="item-labels uk-form-row">
            <div class="uk-grid uk-grid-small" data-uk-grid-margin>
                <div class="uk-width-medium-1-2 uk-accordion" data-uk-accordion="{showfirst: true}">
                    <section class="uk-panel-box uk-padding-remove">
                        <h3 class="uk-form-label uk-text-center uk-margin-remove uk-accordion-title">
                            {{ 'Allergens' | trans }}
                        </h3>

                        <div class="uk-accordion-content uk-accordion-content-small uk-grid uk-grid-small uk-flex-wrap uk-margin-small-top" v-cloak data-uk-grid-margin data-uk-grid-match="{target:'.labelMatch'}">
                            <div v-for="allergen in label.allergens | orderBy 'position'" class="uk-width-small-1-2 uk-width-medium-1-1 uk-width-large-1-2">
                                <label class="labelMatch uk-flex uk-flex-middle uk-link" :class="{'selected': selectedLabel.includes(allergen.id)}">
                                    <input class="uk-hidden" type="checkbox" :value="allergen.id" v-model="selectedLabel">
                                    <img style="width: 50px;" class="uk-panel uk-border-rounded" :src="'/' + allergen.image" width="100%" :title="allergen.title" :alt="allergen.title">
                                    <span>{{ allergen.title }}</span>
                                </label>
                            </div>
                        </div>
                    </section>
                </div>
                <div class="uk-width-medium-1-2 uk-accordion" data-uk-accordion="{showfirst: true}">
                    <section class="uk-panel-box uk-padding-remove">
                        <h3 class="uk-form-label uk-text-center uk-margin-remove uk-accordion-title">
                            {{ 'Additives' | trans }}
                        </h3>

                        <div class="uk-accordion-content uk-accordion-content-small uk-grid uk-grid-small uk-flex-wrap uk-margin-small-top" v-cloak data-uk-grid-margin data-uk-grid-match="{target:'.labelMatch'}">
                            <div v-for="additive in label.additives | orderBy 'position'" class="uk-width-small-1-2 uk-width-medium-1-1 uk-width-large-1-2">
                                <label class="labelMatch uk-flex uk-flex-middle uk-link" :class="{'selected': selectedLabel.includes(additive.id)}">
                                    <input class="uk-hidden" type="checkbox" :value="additive.id" v-model="selectedLabel">
                                    <!-- <img style="width: 50px;" class="uk-panel uk-border-rounded" :src="'/' + additive.image" width="100%" :title="additive.title" :alt="additive.title"> -->
                                    <span>{{ $index + 1 + ')&nbsp;' }}</span>
                                    <span>{{ additive.title }}</span>
                                </label>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>

        <div class="uk-form-row">

            <section class="uk-form uk-grid uk-grid-small" data-uk-grid-margin>

                <div class="uk-panel uk-width-1-1 uk-width-small-1-2">
                    <div class="uk-panel-box uk-panel-box-small">
                        <input-image :source.sync="item_model.image" class="uk-responsive-height"></input-image>
                    </div>
                </div>

                <div class="uk-panel uk-width-1-1 uk-width-small-1-2">
                    <div class="uk-panel-box uk-panel-box-small">
                        <div class="uk-flex">
                            <input v-model="new_tag.title" placeholder="{{ 'Feature' | trans }}" validate:required
                                class="uk-width-1-1">
                            <button class="uk-button uk-button-primary uk-margin-small-left"
                                @click.stop.prevent="(new_tag && new_tag.title) ? addTag(item_model) : ''">
                                <i class="uk-icon-plus"></i></button>
                        </div>

                        <ul v-if="item_model.tags.length"
                            class="uk-list uk-list-striped uk-margin-bottom-remove uk-scrollable-box uk-padding-remove"
                            style="height: 100px;">
                            <li v-for="tag in item_model.tags">
                                <div class="uk-flex uk-flex-middle uk-flex-space-between uk-visible-hover">

                                    <!--<input class="uk-form-blank uk-form-width-large" v-model="tag.title"/>-->
                                    <div class="uk-text-small uk-width-9-10">{{tag.title}}</div>
                                    <a href=""
                                        class=" uk-width-1-10 uk-hidden uk-animation-slide-right uk-icon-hover uk-icon-trash-o uk-text-muted"
                                        data-uk-tooltip title="{{ 'Remove Feature' | trans}}"
                                        @click.stop.prevent="removeTag(item_model, $index)"></a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </section>
        </div>

        <div class="uk-modal-footer">
            <div class="uk-text-right">
                <button class="uk-button uk-button uk-modal-close">{{ 'Close' | trans }}</button>
                <button class="uk-button uk-button-primary" type="submit">{{ 'Save' | trans }}</button>
            </div>
        </div>
    </form>
</v-modal>
