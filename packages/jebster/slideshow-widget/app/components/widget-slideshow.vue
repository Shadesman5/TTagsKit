<template>
    <div class="uk-grid pk-grid-large" data-uk-grid-margin>
        <div class="uk-flex-item-1 uk-form-horizontal">

            <div class="uk-form-row">
                <label for="form-title" class="uk-form-label">{{ 'Title' | trans }}</label>
                <div class="uk-form-controls">
                    <input id="form-title" class="uk-form-width-large" type="text" name="title" v-model="widget.title" v-validate:required>
                    <p class="uk-form-help-block uk-text-danger" v-show="form.title.invalid">{{ 'Title cannot be blank.' | trans }}</p>
                </div>
            </div>

            <div class="uk-form-row">
                <h1 class="uk-margin-remove">{{ 'Images' | trans }}</h1>
            </div>
            <hr>
            <div v-for="image in widget.data.images">
                <div class="uk-form-row">
                    <label class="uk-form-label">{{ 'Image' | trans }}</label>

                    <div class="uk-form-controls">
                        <input-image-meta :image.sync="image" class="pk-image-max-height"></input-image-meta>
                    </div>
                </div>
                <div class="uk-form-row">
                    <label class="uk-form-label">{{ 'Header' | trans }}</label>
                    <div class="uk-form-controls">
                        <input type="text" class="uk-form-width-large" v-model="image.header">&nbsp;&nbsp;
                        <input type="text" class="uk-form-width-small" v-model="image.color" placeholder="#FFFFFF">
                    </div>
                </div>
                <div class="uk-form-row">
                    <label class="uk-form-label">{{ 'Text' | trans}}</label>
                    <div class="uk-form-controls">
                        <v-editor :value.sync="image.text" :options="{markdown : post.data.markdown, height: 250}"></v-editor>
                    </div>
                </div>
                <div class="uk-form-row">
                    <button @click="removeImage(image)" type="button" class="uk-button uk-button-danger">
                        {{ 'Remove image' | trans}}
                    </button>
                </div>
                <hr>
            </div>

            <div class="uk-form-row">
                <div class="uk-form-controls">
                    <button @click="addImage()" type="button" class="uk-button uk-button-primary">{{ 'Add image' | trans}}</button>
                </div>
            </div>
        </div>

        <div class="pk-width-sidebar pk-width-sidebar-large">
            <div class="uk-form-row">
                <label for="form-height" class="uk-form-label">{{ 'Height' | trans }}</label>
                <div class="uk-form-controls">
                    <input id="form-height" class="uk-width-1-1" type="text" v-model="widget.data.config.height">
                </div>
            </div>
            <hr>
            <div class="uk-form-row">
                <label for="form-animation" class="uk-form-label">{{ 'Animation' | trans }}</label>
                <div class="uk-form-controls">
                    <select id="form-animation" v-model="widget.data.config.animation" class="uk-width-1-1">
                        <option v-for="animation in animationOptions">
                            {{ animation }}
                        </option>
                    </select>
                </div>
            </div>
            <div class="uk-form-row">
                <label for="form-speed" class="uk-form-label">{{ 'Speed' | trans }}</label>
                <div class="uk-form-controls">
                    <select id="form-speed" v-model="widget.data.config.animation_speed" class="uk-width-1-1">
                        <option v-for="speed in speedOptions">
                            {{ speed }}
                        </option>
                    </select>
                </div>
            </div>
            <div class="uk-form-row">
                <label for="form-time-interval" class="uk-form-label">{{ 'Time interval' | trans }}</label>
                <div class="uk-form-controls">
                    <input id="form-time-interval" class="uk-width-1-1" type="number" v-model="widget.data.config.time_interval">
                </div>
            </div>

            <hr>

            <partial name="settings"></partial>

        </div>
    </div>

</template>

<script>
    module.exports = {
        section: {
            label: 'Settings'
        },
        replace: false,
        props: ['widget', 'config', 'form'],
        data() {
            return {
                animationOptions: ['slide','fade'],
                speedOptions: ['slow','normal','fast']
            }
        },
        created() {
            this.$options.partials = this.$parent.$options.partials;
            if(!this.widget.data.config) {
                this.$set('widget.data.config', []);
            }
            if(!this.widget.data.images) {
                this.$set('widget.data.images', []);
            }
            this.widget.data.config = _.merge({
                height: 290,
                animation: 'slide',
                animation_speed: 'normal',
                time_interval: 2500,
                pagination: true
            }, this.widget.data.config);
        },

        methods: {
            addImage: function () {
                if(!this.widget.data.images) this.widget.data.images = [];
                this.widget.data.images.push({});
            },
            removeImage: function(image){
                this.widget.data.images.$remove(image);
            }
        },
    };
    window.Widgets.components['jebster-slideshow-widget:settings'] = module.exports;
</script>