$(function () {

    _.extend($data, {
        listings: $data.listings,
        group_types: $data.group_types,
        count: 3,
        selectedGroup: {}
    });

    var vue = new Vue({
        el: '#listings',
        data: $data,
        computed: {
            filteredListings() {
                let listingsArray = Array.isArray(this.listings) ? this.listings : Object.values(this.listings);
                return listingsArray.filter(listing => listing.group_type_id === this.selectedGroup.id);
            }
          },
        methods: {
            selectListingGroup(group_id) {
                if (group_id === 'new') {
                    // New group type is created
                    this.selectedGroup = { id: null, title: '', description: '', image: '', position: 0 };
                    window.location.hash = `#new-group-type`;  // Special hash for new type
                } else {
                    // Select existing group type
                    this.selectedGroup = this.group_types.find(group => group.id === group_id) || {};
                    window.location.hash = `#${group_id}`;
                }
            },
            loadSelectedGroupFromHash() {
                // Check the current hash in the URL
                const hash = window.location.hash.slice(1);
                
                if (hash === 'new-group-type') {
                    // Check whether the hash points to new group type
                    this.selectListingGroup('new');
                } else if (hash) {
                    const groupId = parseInt(hash, 10);
                    this.selectListingGroup(groupId);
                } else {
                    // Load the first tab by default
                    this.selectListingGroup(this.group_types[0].id);
                }
            },
            toggle: function (listing) {
                listing.status = !listing.status ? 1 : 0;
                this.save(listing)
            },
            getLength() {
                return this.filteredListings.length;
            },
            save: function(listing){
                UIkit.notify('Saving...');

                this.$http.post('admin/listings/save', {data: listing }).then(
                    function (res) {
                        UIkit.notify('Saved');
                    }).catch(function () {
                    UIkit.notify('Couldn\'t Save');
                })
            },
            saveGroupType: function () {
                const isNew = !this.selectedGroup.id;
            
                // Either use the data from selectedGroup or prepare the data for a new group
                const groupTypeData = isNew
                    ? {
                        id: '',
                        title: this.selectedGroup.title || '',
                        description: this.selectedGroup.description || '',
                        image: this.selectedGroup.image || '',
                        position: this.selectedGroup.position || 0
                    }
                    : this.selectedGroup;
            
                this.$http.post('admin/listings/group_types/save', { data: groupTypeData })
                    .then(res => {
                        if (res.data && res.data.group_type) {
                            if (isNew) {
                                UIkit.notify("New Group Type Created");
                                this.group_types.push(res.data.group_type); // Add new group to the list
                                this.selectListingGroup(res.data.group_type.id); // Switch to the new group
                            } else {
                                UIkit.notify("Group Type Saved");
                            }
                        } else {
                            throw new Error("Server response did not contain a group type.");
                        }
                    })
                    .catch(error => {
                        UIkit.notify("Couldn't Save Group Type", { status: 'danger' });
                    });
            },                                                           
            removeGroupType: function (id, title) {
                var vm = this;
                UIkit.modal.confirm(
                  "Delete Group Type? <em>" +
                    title +
                    "</em><br><span class='uk-h3'>All Listings are moving to Group Type: <em>" +
                    this.group_types[0].title +
                    "</em></span><br><span class='uk-text-small uk-text-bold uk-text-warning'><i class='uk-icon-warning uk-text-warning'></i> This cannot be undone</span>",
                  function () {
                    vue.$http
                      .post("admin/listings/group_types/delete", { id: id })
                      .then(function (res) {
                        UIkit.notify("Group Type Deleted");
        
                        window.location.href = "listings";
                      })
                      .catch(function () {
                        UIkit.notify("Couldn't Delete");
                      });
                  }
                );
            },
            savePositions: function (positions) {
                if (!positions || !positions.length) return;

                this.$http
                .post("admin/listings/positions", { positions: positions, type: 'listings' })
                .then(function (res) {
                    UIkit.notify("Order Updated");
                })
                .catch(function () {
                    UIkit.notify("Couldn't Update Order");
                });
            }
        },
        ready() {
            this.loadSelectedGroupFromHash();
            window.addEventListener("hashchange", this.loadSelectedGroupFromHash);
        },
        filters: {
            truncate: function(value){
                if(!value) return;
                var length = 45;
                if(value.length > length)
                    return value.substr(0,45) + '…';
                else
                    return value;
            },
            timeFromEpoch: function (value) {
                if (!value) return;
                var d = new Date(0);
                d.setUTCSeconds(value);
                return d.toLocaleTimeString([], {hour: '2-digit', minute: '2-digit', timeZone: 'UTC'});
            },
            dateFromEpoch: function (value) {
                if (!value) return;
                var d = new Date(0);
                d.setUTCSeconds(value);
                return d.toLocaleTimeString([], {month:'2-digit', day:'2-digit', year:'2-digit', hour: '2-digit', minute: '2-digit'});
            }

        }
    });

    $(".sortable-listings").on(
        "change.uk.nestable",
        _.debounce(function (e) {
          var rows = $(e.currentTarget).children(),
            positions = [];
          _.each(rows, function (row, i) {
            positions.push({ id: $(row).data().id, position: i });
          });
          vue.savePositions(positions, "listings");
        }, 1000)
    );
});