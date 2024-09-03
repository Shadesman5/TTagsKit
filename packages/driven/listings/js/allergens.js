$(function () {
    new Vue({
        el: '#allergens',
        data: {allergens: $data},
        methods: {
            toggle: function (allergen) {
                allergen.status = !allergen.status ? 1 : 0;
                this.save(allergen)
            },
            save: function(allergen){
                UIkit.notify('Saving...');

                this.$http.post('admin/listings/allergens/save', {data: allergen}).then(
                    function (res) {
                        UIkit.notify('Saved');
                    }).catch(function () {
                    UIkit.notify('Couldn\'t Save');
                })
            },
            getLength: function () {
                var size = 0, key;
                for (key in this.allergens) {
                    if (this.allergens.hasOwnProperty(key)) size++;
                }
                return size;
            }
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
});