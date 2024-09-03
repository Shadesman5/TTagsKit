<v-modal v-ref:categorymodal large>
    <form class="uk-form">
        <div class="uk-modal-header uk-flex uk-flex-wrap uk-flex-space-between uk-flex-middle">

            <h2>{{ category_model.id ? 'Edit Category' : 'New Category' | trans }}
                <em v-show="category_model.id"
                    class="uk-text-italic uk-text-muted">{{category_model.title}}</em>
            </h2>

            <label>
                <input type="checkbox" value="center-content" v-model="category_model.status" v-bind:true-value="1"
                       v-bind:false-value="0">
                {{'Active' | trans }}
            </label>

        </div>


        <div class="uk-form-row">
            <div class="uk-margin-right-small">
                <input name="input-category-title" placeholder="{{'Title'|trans}}"
                       class="uk-width-1-1" type="text" v-model="category_model.title"
                       v-validate:required/>
            </div>
        </div>
        <div class="uk-form-row">

            <!-- <v-editor :value.sync="category_model.description" :options="{markdown : false, height: 100, toolbar:[]}"></v-editor> -->


            <textarea style="height: 100px;" class="uk-width-1-1" v-model="category_model.description"></textarea>
        </div>

        </div>
        <div class="uk-form-row">
            <div class="uk-panel">
                <div style="height: 196px;max-height: 196px;" class="uk-width-1-1 uk-panel-box">
                    <input-image :source.sync="category_model.image" class="uk-responsive-height"></input-image>
                </div>
            </div>
        </div>
    </form>

    <div class="uk-modal-footer uk-text-right">
        <button class="uk-button uk-button uk-modal-close">{{ 'Close' | trans }}</button>
        <button class="uk-button uk-button-primary" @click="saveCategory()">{{ 'Save' | trans }}
        </button>
    </div>

</v-modal>