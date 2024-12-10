<?php $view->script('edit-label', 'driven/listings:js/edit-label.js', ['vue', 'editor']) ?>


<section id="edit-label">
    <form class="uk-form uk-form-horizontal uk-margin" v-validator="label_form" @submit.prevent="save | valid">

        <!--HEADER-->
        <div class="uk-margin uk-flex uk-flex-space-between uk-flex-wrap">
            <div class="uk-margin-small" data-uk-margin>

                <h2 class="uk-margin-remove">
                    {{ (label.id ? 'Edit' : 'New Label') | trans }}
                    <em v-show="label.id" class="uk-text-italic uk-text-muted">{{label.title}}</em>
                </h2>

            </div>

            <div data-uk-margin>

                <a class="uk-button uk-margin-small-right" v-if="!label.id" :href="'../labels'">
                    {{ 'Cancel' | trans }}
                </a>
                <a class="uk-button uk-margin-small-right" v-if="label.id" :href="'../labels'">
                    {{ 'Close' | trans }}
                </a>
                <button class="uk-button uk-button-danger uk-margin-small-right" v-if="label.id"
                    type="button"
                    @click="remove(label.id, label.title)">
                    {{ 'Delete' | trans }}
                </button>
                <button class="uk-button uk-button-primary" type="submit">{{ 'Save' | trans }}</button>

            </div>

        </div>

        <!--CONTENT-->
        <div class="uk-grid">
            <div class="uk-width-medium-3-4">

                <div class="uk-form-row">

                    <div class="uk-grid uk-grid-small">
                        <div class="uk-width-small-3-4">
                            <input name="title" class="uk-width-1-1" type="text" v-model="label.title"
                                v-validate:required
                                placeholder="{{ 'Label Title' | trans }}" />
                            <p class="uk-form-help-block uk-text-danger">
                                <span v-show="label_form.title.invalid"><?= __('Please provide a title') ?></span>
                            </p>
                        </div>
                        <div class="selectLabelType uk-width-small-1-4">
                            <select class="uk-width-1-1 uk-text-center uk-text-capitalize" v-model="label.group_type" v-validate:required>
                                <option disabled value>{{ 'Choose Label Type' | trans }}</option>
                                <option v-for="group_type in group_types" :key="group_type" :value="group_type" v-validate:required>{{ group_type }}</option>
                                <option value="new_type">{{ 'New Type' | trans }}</option>
                            </select>
                            <input type="text" v-if="label.group_type === 'new_type'" class="uk-width-1-1 uk-margin-small-top" v-model="newType" placeholder="{{ 'New Type' | trans }}" v-validate:required />
                            <p class="uk-form-help-block uk-text-danger">
                                <span v-show="group_type.invalid"><?= __('Please choose a label type') ?></span>
                                <span v-show="label_form.group_type.invalid"><?= __('Please enter a new label type') ?></span>
                            </p>
                        </div>
                    </div>

                </div>

                <div class="uk-form-row">
                    <textarea class="uk-width-1-1" v-model="label.description" rows="4"
                        placeholder="{{ 'Description' | trans}}"></textarea>
                </div>

                <div class="uk-panel uk-width-small-1-2 uk-margin">
                    <div class="uk-panel-box uk-text-center">
                        <input-image :source.sync="label.image" class="uk-responsive-height"></input-image>
                    </div>
                </div>

            </div>
        </div>

    </form>

    <!-- <pre>{{label|json}}</pre> -->

</section>