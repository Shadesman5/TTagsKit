<?php $view->script('edit-allergen', 'driven/listings:js/edit-allergen.js', ['vue', 'editor']) ?>


<section id="edit-allergen">
    <form class="uk-form uk-form-horizontal uk-margin" v-validator="allergen_form" @submit.prevent="save | valid">

        <!--HEADER-->
        <div class="uk-margin uk-flex uk-flex-space-between uk-flex-wrap">
            <div class="uk-margin-small" data-uk-margin>

                <h2 class="uk-margin-remove">
                    {{ (allergen.id ? 'Edit' : 'New Allergen') | trans }}
                    <em v-show="allergen.id" class="uk-text-italic uk-text-muted">{{allergen.title}}</em>
                </h2>

            </div>

            <div data-uk-margin>

                <a class="uk-button uk-margin-small-right" v-if="!allergen.id" :href="'../allergens'">
                    {{ 'Cancel' | trans }}
                </a>
                <a class="uk-button uk-margin-small-right" v-if="allergen.id" :href="'../allergens'">
                    {{ 'Close' | trans }}
                </a>
                <button class="uk-button uk-button-danger uk-margin-small-right" v-if="allergen.id"
                        type="button"
                        @click="remove(allergen.id, allergen.title)">
                    {{ 'Delete' | trans }}
                </button>
                <button class="uk-button uk-button-primary" type="submit">{{ 'Save' | trans }}</button>

            </div>

        </div>

        <!--CONTENT-->
        <div class="uk-grid">
            <div class="uk-width-medium-3-4">

                <div class="uk-form-row uk-flex uk-flex-middle uk-flex-space-between">

                    <div class="uk-flex-item-1">
                        <input name="title" class="uk-width-1-2" type="text" v-model="allergen.title"
                               v-validate:required
                               placeholder="{{ 'Allergen Title' | trans }}"/>
                        <p class="uk-form-help-block uk-text-danger"
                           v-show="allergen_form.title.invalid"><?= __("{{ 'Please provide a title.' | trans }}") ?></p>
                    </div>

                </div>

                <div class="uk-form-row">
                    <textarea class="uk-width-1-1" v-model="allergen.description" rows="3"
                              placeholder="{{ 'Description' | trans}}"></textarea>
                </div>

            </div>

        </div>

        <hr/>

        <div class="uk-panel uk-width-small-5-10 uk-margin">
            <div style="height: 196px;max-height: 196px;" class="uk-panel-box">
                <input-image :source.sync="allergen.image" class="uk-responsive-height"></input-image>
            </div>
        </div>

    </form>

    <!-- <pre>{{allergen|json}}</pre> -->

</section>

