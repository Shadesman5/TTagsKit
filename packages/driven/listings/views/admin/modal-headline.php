<v-modal v-ref:headlinemodal large>

    <form class="uk-form" v-validator="item_form" @submit.prevent="saveItem(category_model.id) | valid">
        <div class="uk-modal-header uk-flex uk-flex-wrap uk-flex-space-between uk-flex-middle">

            <h2>{{ item_model.id ? 'Edit Headline' : 'New Headline' | trans }}
                <em v-show="item_model.id"
                    class="uk-text-italic uk-text-muted">{{item_model.title}}</em>
            </h2>

            <label>
                <input type="checkbox" v-model="item_model.status" v-bind:true-value="1" v-bind:false-value="0">
                {{'Active' | trans }}
            </label>

        </div>


        <div class="uk-form-row">
            <div class="uk-grid">
                <div class="uk-width-small-1-2">
                    <input name="title" placeholder="{{'Title'|trans}}"
                           class="uk-width-1-1" type="text" v-model="item_model.title"
                           v-validate:required/>
                    <p class="uk-form-help-block uk-text-danger">
                        <span v-show="item_form && item_form.title.invalid"><?= __("{{ 'Please provide a title.' | trans }}") ?></span>
                    </p>
                </div>
            </div>
        </div>

        <div class="uk-form-row">
            <div class="uk-grid">
                <div class="uk-width-1-1">
                    <textarea class="uk-width-1-1 uk-height-small" v-model="item_model.description"
                              style="height: 100px;"></textarea>
                </div>
            </div>
        </div>

        <div class="uk-modal-footer">
            <div class="uk-text-right">
                <button class="uk-button uk-button uk-modal-close">{{ 'Close' | trans }}</button>
                <button class="uk-button uk-button-primary" type="submit">{{ 'Save' | trans }}</button>
            </div>
        </div>
    </form>
</v-modal>
