<?php $view->script('dashboard', 'system/dashboard:app/bundle/index.js', ['vue', 'uikit-autocomplete']) ?>

<div id="dashboard" v-cloak>

    <div class="uk-hidden" id="greets" style="background:url(https://png.pngtree.com/thumb_back/fw800/back_our/20190621/ourmid/pngtree-christmas-black-christmas-tree-banner-image_183904.jpg) no-repeat top center / cover;box-shadow: 0 1px 4px rgba(0,0,0,0.09);margin-bottom: 20px;">
      <div style="background: rgba(0, 0, 0, .4);padding: 5em 2em 2em;font-size: 16px;line-height: 150%;text-align: center;color: #fff;text-shadow: 0px 0px 1px #ccc;">
        <h2 style="color: #fff;">Frohes und besinnliches Weihnachtsfest!</h2>
        <p>Im Namen des gesamten TTAGS-Teams wünschen wir euch ein fröhliches und besinnliches Weihnachtsfest sowie einen gelungenen Start ins Jahr 2024. Möge diese festliche Zeit mit Freude und Harmonie erfüllt sein!</p>
      </div>
    </div>

    <div class="uk-margin uk-flex uk-flex-space-between uk-flex-wrap uk-flex-middle">
        <div>

            <div v-show="hasUpdate">
                <span class="pk-icon-bell uk-margin-small-right"></span>
                {{ 'Pagekit %version% is available.' | trans update }} <a href="admin/system/update">{{ 'Update now!' | trans }}</a>
            </div>

        </div>
        <div>

            <div v-show="isAdmin" class="uk-button-dropdown" data-uk-dropdown="{ mode: 'click' }">
                <a class="uk-button uk-button-primary" @click.prevent>{{ 'Add Widget' | trans }}</a>
                <div class="uk-dropdown uk-dropdown-small uk-dropdown-flip">
                    <ul class="uk-nav uk-nav-dropdown">
                        <li v-for="type in getTypes()">
                            <a class="uk-dropdown-close" @click="add(type)">{{ type.label }}</a>
                        </li>
                    </ul>
                </div>
            </div>

        </div>
    </div>

    <div class="uk-grid uk-grid-medium uk-grid-match" data-uk-grid-margin>
        <div class="uk-width-medium-1-3" v-for="i in [0,1,2]">

            <ul class="uk-sortable pk-sortable" :data-column="i">
                <li v-for="widget in widgets | column i" :data-id="widget.id" :data-idx="widget.idx">
                    <panel class="uk-panel uk-panel-box uk-visible-hover-inline" :widget="widget" :editing.sync="editing[widget.id]"></panel>
                </li>
            </ul>

        </div>

    </div>

</div>
