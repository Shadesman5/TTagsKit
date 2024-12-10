<!-- Kategorie Bilder -->
<div id="catImage" class="liste uk-margin-small uk-switcher">
    <div v-for="category in list.categories | orderBy 'position'" data-id="{{category.id}}" :class="settings.categoryImage || defaults.categoryImage" data-type="Category Image">
        <a v-if="category.image" :href="'/' + category.image" class="img-box img-top" data-uk-lightbox>
            <img :src="'/' + category.image" title="{{category.title}}" alt="{{category.title}}" />
        </a>
        <a v-else="list.image" data-type="List Image" :href="'/' + list.image" class="img-box img-top" data-uk-lightbox>
            <img :src="'/' + list.image" title="{{list.title}}" alt="{{list.title}}" />
        </a>
    </div>
</div>

<!-- Navigation -->
<ul data-uk-switcher="{connect:'#catImage, #menuList'}" class="uk-child-width-expand uk-flex-center uk-tab uk-grid" uk-tab uk-grid>
    <!-- Alle Kategorien -->
    <li class="uk-padding-remove uk-margin-remove" data-type="All Categories">
        <a href="#" data-id="all">{{ 'All Categories' | trans }}</a>
    </li>

    <!-- Einzelne Kategorien -->
    <li v-for="category in list.categories | orderBy 'position'" data-type="Category Title" class="uk-padding-remove uk-margin-remove">
        <a href="#" data-id="{{category.id}}">{{category.title}}</a>
    </li>
</ul>

<!-- Menulist -->
<div id="menuList" class="liste uk-switcher uk-margin">
    <div :class="settings.categoryContainer || defaults.categoryContainer" v-for="category in list.categories | orderBy 'position'" data-type="Category" data-id="{{category.id}}">
        <div :class="settings.categoryTitleDescription || defaults.categoryTitleDescription">
            <h3 v-if="category.title" :class="settings.categoryTitle || defaults.categoryTitle" data-type="Category Title">{{category.title}}</h3>
            <div v-if="category.description" :class="settings.categoryDescription || defaults.categoryDescription" data-type="Category Description">{{category.description}}</div>
        </div>
        <ul class="uk-list uk-flex uk-flex-column" data-type="Category Items">
            <li :class="settings.itemContainer || defaults.itemContainer" id="{{ item.actions }}" v-for="item in category.items | orderBy 'position'" data-type="Item" data-id="{{item.id}}" data-uk-grid-margin>
                <div class="uk-flex uk-flex-space-between">
                    <div v-if="item.title || item.description" :class="settings.itemTitleDescription || defaults.itemTitleDescription" data-type="Item Title and Description">
                        <dt v-if="item.title" :class="settings.itemTitle || defaults.itemTitle" data-type="Item Title">
                            <div v-else>{{item.title}}</div>
                        </dt>
                        <dd v-if="item.description" :class="settings.itemDescription || defaults.itemDescription" data-type="Item Description" v-html="item.description"></dd>
                        <div v-if="item.tags.length" :class="settings.itemTagsContainer || defaults.itemTagsContainer" data-type="Item Tags">
                            <div v-for="tag in item.tags" :class="settings.itemTag || defaults.itemTag" data-type="Tag">{{tag.title}}</div>
                        </div>
                    </div>
                    <div v-if="item.price || item.volume" :class="settings.itemPriceVolume || defaults.itemPriceVolume">
                        <span v-if="item.volume" :class="settings.itemVolume || defaults.itemVolume" data-type="Item Volume">
                            {{item.volume}}
                        </span>
                        <span v-if="item.price" :class="settings.itemPrice || defaults.itemPrice" data-type="Item Price">
                            {{item.price | currency}}
                        </span>
                    </div>
                    <div v-if="item.image" style="max-width: 100px;" :class="settings.itemImage || defaults.itemImage" data-type="Item Image">
                        <a :href="'/' + item.image" data-caption="{{item.description}}" data-uk-lightbox>
                            <img :src="'/' + item.image" :title="item.title" :alt="item.title" />
                        </a>
                    </div>
                </div>

                <div v-if="item.labels.length" :class="settings.itemLabelsContainer || defaults.itemLabelsContainer" data-type="Item Labels">
                    <a href="#{{item.id}}" data-uk-modal>
                        <p class="uk-margin-xsmall-bottom">{{ 'Allergens & additives' | trans }}</p>
                        <img v-for="label in item.labels | orderBy 'id' | filterBy 'allergen' in 'group_type'" :class="settings.itemLabelImage || defaults.itemLabelImage" :title="label.title" :src="'/' + label.image" :alt="label.title" data-type="Label" />
                        <span style="padding:0 7px;" v-for="label in item.labels | orderBy 'id' | filterBy 'additive' in 'group_type'">{{ label.id - 14 + ')' }}</span>
                    </a>
                    <div id="{{item.id}}" class="uk-modal">
                        <div class="uk-modal-dialog">
                            <a href="" class="uk-modal-close uk-close uk-close-alt"></a>
                            <h4>{{ item.title }}</h4>
                            <div v-if="hasGroupType(item.labels, 'allergen')" class="uk-modal-header">
                                <h5>{{ 'Allergens' | trans }}:</h5>
                            </div>
                            <div class="uk-grid uk-grid-small uk-flex-center uk-text-center uk-grid-width-small-1-2 uk-grid-width-medium-1-3" data-uk-grid-match="{target: '.modalLabel'}" data-uk-grid-margin>
                                <div v-for="label in item.labels | orderBy 'id' | filterBy 'allergen' in 'group_type'">
                                    <div :class="settings.itemModalLabel || defaults.itemModalLabel">
                                        <img :title="label.title" :src="'/' + label.image" width="50px" :alt="label.title" data-type="Allergen" />
                                        <div class="uk-thumbnail-caption">
                                            <p class="labelTitle uk-text-bold uk-margin-xsmall-bottom">{{ label.title }}</p>
                                            <span class="labelDesc">{{ label.description }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr v-if="hasGroupType(item.labels, 'allergen') && hasGroupType(item.labels, 'additive')">
                            <div v-if="hasGroupType(item.labels, 'additive')" class="uk-modal-header">
                                <h5>{{ 'Additives' | trans }}:</h5>
                            </div>
                            <div class="uk-grid uk-grid-small uk-flex-center uk-text-center uk-grid-width-small-1-2 uk-grid-width-medium-1-3" data-uk-grid-match="{target: '.modalLabel'}" data-uk-grid-margin>
                                <div v-for="label in item.labels | orderBy 'id' | filterBy 'additive' in 'group_type'">
                                    <div :class="settings.itemModalLabel || defaults.itemModalLabel">
                                        <!-- <img :title="label.title" :src="'/' + label.image" width="50px" :alt="label.title" data-type="Additive" /> -->
                                        <span class="uk-text-bold">{{ label.id - 14 }}</span>
                                        <div class="uk-thumbnail-caption">
                                            <p v-if="label.description" class="labelTitle uk-text-bold uk-margin-xsmall-bottom">{{ label.title }}</p>
                                            <span v-else class="labelTitle uk-text-bold uk-margin-xsmall-bottom">{{ label.title }}</span>
                                            <span class="labelDesc">{{ label.description }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </li>
        </ul>
    </div>
</div>