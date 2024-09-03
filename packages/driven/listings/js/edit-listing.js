$(function () {

    _.extend($data, {
        item_form: {},
        list_form: {},
        new_tag: {title: ''},
        // allergens: Array.isArray($data.allergens) ? $data.allergens : [],
        selectedAllergenIds: []
    });

    var vue = new Vue({
        el: '#edit-listing',
        data: $data,
        watch: {
            selectedAllergenIds(newIds) {
                // Umwandeln von allergens in ein echtes Array
                let allergensArray = Array.isArray(this.allergens) ? this.allergens : Object.values(this.allergens);

                if (Array.isArray(allergensArray)) {
                    this.item_model.allergens = allergensArray.filter(allergen => newIds.includes(allergen.id));
                } else {
                    console.error('allergens could not be converted to an array:', this.allergens);
                }
            }
        },
        created() {
            // Sicherstellen, dass allergens in ein echtes Array umgewandelt wird
            let allergensArray = Array.isArray(this.allergens) ? this.allergens : Object.values(this.allergens);

            console.log('allergensArray:', allergensArray); // Ausgabe des Arrays zur Überprüfung

            this.selectedAllergenIds = allergensArray.map(allergen => allergen.id);
        },
        methods: {
            toggle: function (coll, type) {
                coll.status = !coll.status ? 1 : 0;
                if (type === 'category') {
                    setModel('categories', coll);
                    this.saveCategory();
                } else if (type === 'item') {
                    setModel('items', coll);
                    this.saveItem();
                }
            },
            getLength: function (coll) {
                var size = 0, key;
                for (key in coll) {
                    if (coll.hasOwnProperty(key)) size++;
                }
                return size;
            },
            getItems: function (category) {
                var items = [];
                for (var item in category.items) {
                    if (item) items.push(category.items[item]);
                }
                return items;
            },
            save: function () {
                this.$http.post('admin/listings/save', {data: this.listing}).then(
                    function (res) {
                        UIkit.notify('Saved');
                        if (this.listing.id !== res.data.listing.id) window.location.href = 'edit?id=' + res.data.listing.id;
                    }).catch(function () {
                    UIkit.notify('Couldn\'t Save');
                })
            },
            remove: function (id, type, title) {
                var vm = this;
                UIkit.modal.confirm("Delete " + this.$options.filters.capitalize(type) + "? <em>" + title + "</em><br><span class='uk-text-small uk-text-bold uk-text-warning'><i class='uk-icon-warning uk-text-warning'></i> This cannot be undone</span>", function () {


                    vue.$http.post('admin/listings/delete', {id: id, type: type}).then(
                        function (res) {

                            UIkit.notify(this.$options.filters.capitalize(type) + ' Deleted');

                            if ((type === 'listing') && (_.last(window.location.href.split('/')).substr(0, 4))) {

                                window.location.href = '.';
                                Vue.delete(vm.listing, id);

                            } else if (type === 'category') {

                                Vue.delete(vm.listing.categories, id);

                            } else if (type === 'item') {

                                Vue.delete(vm.listing.categories[res.data.item.category_id].items, id);

                            }
                        }).catch(function () {
                        UIkit.notify('Couldn\'t Delete');
                    });

                });
            },


            openCategoryModal: function (data) {
                setModel('categories', data);
                this.$refs.categorymodal.open();
            },

            openItemModal: function (id, data) {
                if (!id) {
                    return;
                }
                data = data || {category_id: id};
                setModel('items', data);

                // Allergene ID's initialisieren
                this.selectedAllergenIds = this.item_model.allergens.map(allergen => allergen.id);

                this.$refs.itemmodal.open();
            },

            openHeadlineModal: function (id, data) {
                if (!id) {
                    return;
                }
                data = data || {category_id: id};
                setModel('items', data);
                this.$refs.headlinemodal.open();
            },

            savePositions: function (positions, type) {

                if (!positions || !positions.length) return;

                this.$http.post('admin/listings/positions', {positions: positions, type: type}).then(
                    function (res) {
                        UIkit.notify('Order Updated');
                        //this.listing.categories = res.data.listing.categories;
                    }).catch(function () {
                    UIkit.notify('Couldn\'t Update Order');
                })
            },

            saveCategory: function () {

                this.category = this.category_model;

                this.$http.post('admin/listings/category/save', {
                    data: this.category,
                    listing_id: this.listing.id
                }).then(
                    function (res) {
                        if (this.listing.categories.length === 0) {
                            this.listing.categories = {};
                        }
                        Vue.set(this.listing.categories, res.data.category.id.toString(), res.data.category);
                        this.$refs.categorymodal.close();
                        UIkit.notify('Category Saved');

                    }).catch(function (e) {
                    UIkit.notify('Couldn\'t Save Category');
                    console.log('Error: Saving Category ', e);
                })
            },

            saveItem: function () {

                this.item = this.item_model;

                // save the selected allergens
                this.item.allergens = this.item.allergens.map(allergen => {
                    return {
                        id: allergen.id,
                        title: allergen.title,
                        description: allergen.description,
                        image: allergen.image
                    };
                });

                this.$http.post('admin/listings/category/item/save', {
                    data: this.item,
                    listing_id: this.listing.id,
                    category_id: this.item.category_id
                }).then(
                    function (res) {
                        if (!this.listing.categories[res.data.item.category_id].items) {
                            this.listing.categories[res.data.item.category_id].items = {};
                        }
                        Vue.set(this.listing.categories[res.data.item.category_id].items, res.data.item.id.toString(), res.data.item);

                        this.$refs.itemmodal.close();
                        this.$refs.headlinemodal.close();

                        $('#sortable-categories').trigger('change.uk.sortable');
                        UIkit.notify('Item Saved');

                    }).catch(function (e) {
                    UIkit.notify('Couldn\'t Save Item');
                    console.log('Error: Saving Item ', e);
                })
            },

            addTag: function (item) {
                if (!item.tags) {
                    item.tags = [];
                }
                item.tags.push(this.new_tag);
                this.new_tag = {title: ''}
            },
            removeTag: function (item, index) {
                item.tags.splice(index, 1);
            }
        },
        filters: {
            fromEpoch: function (value) {
                if (!value) return;
                var d = new Date(0);
                d.setUTCSeconds(value);
                return d.toLocaleTimeString([], {hour: '2-digit', minute: '2-digit', timeZone: 'UTC'});
            }
        }
    });

    var setModel = function (type, model) {
        model = model || {};
        if (type === 'categories') {
            Vue.set(this.$data.category_model, 'id', model.id || 0);
            Vue.set(this.$data.category_model, 'title', model.title || '');
            Vue.set(this.$data.category_model, 'description', model.description || '');
            Vue.set(this.$data.category_model, 'image', model.image || '');
            Vue.set(this.$data.category_model, 'position', ((typeof(model.position) !== 'undefined') ? String(model.position) : false) || _.size(this.$data.listing.categories));
            Vue.set(this.$data.category_model, 'status', model.status || 0);
        } else if (type === 'items') {
            Vue.set(this.$data.item_model, 'category_id', model.category_id || 0);
            Vue.set(this.$data.item_model, 'id', model.id || 0);
            Vue.set(this.$data.item_model, 'title', model.title || '');
            Vue.set(this.$data.item_model, 'description', model.description || '');
            Vue.set(this.$data.item_model, 'volume', model.volume || '');
            Vue.set(this.$data.item_model, 'allergens', model.allergens || []);
            Vue.set(this.$data.item_model, 'actions', model.actions || '');
            Vue.set(this.$data.item_model, 'image', model.image || '');
            Vue.set(this.$data.item_model, 'position', ((typeof(model.position) !== 'undefined') ? String(model.position) : false) || +1 * _.size(this.$data.listing.categories[this.$data.item_model.category_id].items));
            Vue.set(this.$data.item_model, 'status', model.status || 0);
            Vue.set(this.$data.item_model, 'price', model.price || '');
            Vue.set(this.$data.item_model, 'tags', model.tags || []);
        }
    };

    $('#sortable-categories').on('change.uk.sortable', _.debounce(function (e) {
        var rows = $(e.currentTarget).children(), positions = [];
        _.each(rows, function (row, i) {
            positions.push({id: $(row).data().id, position: i});
        });
        vue.savePositions(positions, 'categories')
    }, 1000));

    $('.sortable-items').on('change.uk.nestable', _.debounce(function (e, s, el, a) {

        var positions = [];
        var categories = $('#sortable-categories').find('.sortable-category');

        _.each(categories, function (category, i) {
            var items = $(category).find('.sortable-item');

            _.each(items, function (item, ii) {
                positions.push({
                    id: $(item).data().id,
                    position: ii,
                    category_id: $(category).data().id
                })
            });

        });
        vue.savePositions(positions, 'items');
    }, 1000));

});