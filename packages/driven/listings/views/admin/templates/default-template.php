<!-- Kategorie Bilder -->
<div id="catImage" class="liste uk-switcher">
    <div v-for="category in list.categories | orderBy 'position'" data-id="{{category.id}}" :class="settings.categoryImage || defaults.categoryImage" data-type="Category Image">
        <a v-if="category.image" :href="category.image" class="img-box img-top" data-uk-lightbox>
            <img :src="category.image" title="{{category.title}}" alt="{{category.title}}"/>
        </a>
        <a v-else="list.image" data-type="List Image" :href="list.image" class="img-box img-top" data-uk-lightbox>
            <img :src="list.image" title="{{list.title}}" alt="{{list.title}}"/>
        </a>
    </div>
</div>

<!-- Navigation -->
<ul data-uk-switcher="{connect:'#catImage, #menuList'}" class="uk-child-width-expand uk-flex-center uk-grid" uk-tab uk-grid>
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
        <div class="uk-list uk-flex uk-flex-column" :class="settings.itemContainer || defaults.itemContainer" data-type="Category Items">
            <div class="uk-grid" :class="settings.itemContainer || defaults.itemContainer" v-for="item in category.items | orderBy 'position'" data-type="Item" data-id="{{item.id}}" data-uk-grid-margin>
                <dl v-if="item.title || item.description" :class="settings.itemTitleDescription || defaults.itemTitleDescription" data-type="Item Title and Description">
                    <dt v-if="item.title" :class="settings.itemTitle || defaults.itemTitle" data-type="Item Title">
                        <div v-else>{{item.title}}</div>
                    </dt>
                    <dd v-if="item.description" :class="settings.itemDescription || defaults.itemDescription" data-type="Item Description" v-html="item.description"></dd>
                    <div v-if="item.tags.length" :class="settings.itemTagsContainer || defaults.itemTagsContainer" data-type="Item Tags">
                        <div v-for="tag in item.tags" :class="settings.itemTag || defaults.itemTag" data-type="Tag">{{tag.title}}</div>
                    </div>
                    <div v-if="item.allergens.length" :class="settings.itemAllergensContainer || defaults.itemAllergensContainer" data-type="Item Allergens">
                        <a href="#{{item.id}}" data-uk-modal>
                            <span>Allergene:</span><br>
                            <span v-for="allergen in item.allergens | orderBy 'id'">
                                <img :class="settings.itemAllergen || defaults.itemAllergen" :title="allergen.title" :src="allergen.image" width="35px" :alt="allergen.title" data-type="Allergen" />
                            </span>
                        </a>
                        <div id="{{item.id}}" class="uk-modal">
                            <div class="uk-modal-dialog">
                                <a href="" class="uk-modal-close uk-close uk-close-alt"></a>
                                <div class="uk-modal-header">
                                    <h2>Allergene von {{ item.title }}:</h2>
                                </div>
                                <div class="uk-grid uk-grid-small uk-flex-center uk-text-center uk-grid-width-small-1-3" data-uk-grid-match="{target: '.uk-thumbnail'}" data-uk-grid-margin>
                                    <div v-for="allergen in item.allergens | orderBy 'id'">
                                        <div class="uk-width uk-thumbnail">
                                            <img :class="settings.itemAllergen || defaults.itemAllergen" :title="allergen.title" :src="allergen.image" width="100px" :alt="allergen.title" data-type="Allergen" />
                                            <div class="uk-thumbnail-caption">
                                                <span class="allergenTitle">{{ allergen.title }}:</span>
                                                <span class="allergenDesc">{{ allergen.description }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </dl>
                <div v-if="item.volume" :class="settings.itemVolume || defaults.itemVolume" data-type="Item Volume">{{item.volume}}</div>
                <div v-if="item.price" :class="settings.itemPrice || defaults.itemPrice" data-type="Item Price">{{item.price | currency}}</div>
                <div v-if="item.image" :class="settings.itemImage || defaults.itemImage" data-type="Item Image">
                    <a :href="item.image" data-caption="{{item.description}}" data-uk-lightbox>
                        <img :src="item.image" :title="item.title" :alt="item.title" />
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>