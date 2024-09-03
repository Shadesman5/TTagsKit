$(function () {
    var vue = new Vue({
        el: '#edit-allergen',
        data: $data,
        methods: {
            save: function () {

                this.$http.post('admin/listings/allergens/save', {data: this.allergen}).then(
                    function (res) {
                        UIkit.notify('Saved');
                        window.location.href = '.';
                    }).catch(function () {
                    UIkit.notify('Couldn\'t Save');
                })
            },

            remove: function (id, title) {
                var vm = this;
                UIkit.modal.confirm("Delete Allergen? <em>" + title + "</em><br><span class='uk-text-small uk-text-bold uk-text-warning'><i class='uk-icon-warning uk-text-warning'></i> This cannot be undone</span>", function () {

                    vue.$http.post('admin/listings/allergens/delete', {id: id}).then(
                        function (res) {

                            UIkit.notify('Allergen Deleted');

                            window.location.href = '.';

                        }).catch(function () {
                        UIkit.notify('Couldn\'t Delete');
                    });

                });
            }

        },
        filters: {

        }
    });
});