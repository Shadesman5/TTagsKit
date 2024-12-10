$(function () {
  var vue = new Vue({
    el: "#edit-label",
    data: {
      label: $data.label,
      group_types: $data.group_types,
      newType: ""
    },
    methods: {
      selectType(group_type) {
        if (group_type === 'new_type') {
          this.label.group_type = 'new_type';
        } else {
          this.label.group_type = group_type;
          this.newType = '';
        }
      },
      save: function () {

        if (!this.label.group_type || this.label.group_type === '') {
          UIkit.notify("Please choose a valid label type.", {status: 'danger'});
          return;
        }

        if (this.label.group_type === 'new_type' && this.newType === '') {
          UIkit.notify("Please enter a new label type.", {status: 'danger'});
          return;
        }

        if (this.newType && this.label.group_type === 'new_type') {
          this.label.group_type = this.newType;
        }

        this.$http
          .post("admin/listings/labels/save", { data: this.label })
          .then(function (res) {
            UIkit.notify("Saved");
            window.location.href = ".";
          })
          .catch(function () {
            UIkit.notify("Couldn't Save");
          });
      },
      remove: function (id, title) {
        var vm = this;
        UIkit.modal.confirm(
          "Delete Label? <em>" +
            title +
            "</em><br><span class='uk-text-small uk-text-bold uk-text-warning'><i class='uk-icon-warning uk-text-warning'></i> This cannot be undone</span>",
          function () {
            vue.$http
              .post("admin/listings/labels/delete", { id: id })
              .then(function (res) {
                UIkit.notify("Label Deleted");

                window.location.href = ".";
              })
              .catch(function () {
                UIkit.notify("Couldn't Delete");
              });
          }
        );
      },
    },
    filters: {
      fromEpoch: function (value) {
        if (!value) return;
        var d = new Date(0);
        d.setUTCSeconds(value);
        return d.toLocaleTimeString([], {
          hour: "2-digit",
          minute: "2-digit",
          timeZone: "UTC",
        });
      },
    },
  });
});
