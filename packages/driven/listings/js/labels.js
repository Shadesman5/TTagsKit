$(function () {
  var vue = new Vue({
    el: "#labels",
    data: { labels: $data, selectedType: "" },
    computed: {
      uniqueLabelTypes() {
        let labelsArray = Array.isArray(this.labels)
          ? this.labels
          : Object.values(this.labels);
        return [...new Set(labelsArray.map((label) => label.group_type))];
      },
      filteredLabels() {
        let labelsArray = Array.isArray(this.labels)
          ? this.labels
          : Object.values(this.labels);
        const filteredByType = labelsArray.filter(
          (label) => label.group_type === this.selectedType
        );

        if (this.search) {
          // Filter die Labels nach dem Suchbegriff
          return filteredByType.filter((label) =>
            label.title.toLowerCase().includes(this.search.toLowerCase())
          );
        }

        return filteredByType;
      },
    },
    methods: {
        selectLabelType(group_type) {
            this.selectedType = group_type;
        },
        toggle: function (label) {
            label.status = !label.status ? 1 : 0;
            this.save(label);
        },
        save: function (label) {
            if (!this.label.group_type || this.label.group_type === "") {
              UIkit.notify("Please choose a valid label type.", {
                  status: "danger",
              });
              return;
            }

            if (this.label.group_type === "new_type" && this.newType === "") {
              UIkit.notify("Please enter a new label type.", {
                status: "danger"
              });
              return;
            }

            if (this.newType && label.group_type === "new_type") {
              label.group_type = this.newType;
            }

            this.$http
              .post("admin/listings/labels/save", { data: label })
              .then(function (res) {
                UIkit.notify("Saved");
              })
              .catch(function () {
                  UIkit.notify("Couldn't Save");
              });
        },
        getLength: function () {
            var size = 0,
                key;
            for (key in this.labels) {
              if (
                  this.labels.hasOwnProperty(key) &&
                  this.labels[key].group_type === this.selectedType
              ) size++;
            }
            return size;
        },
        savePositions: function (positions) {
            if (!positions || !positions.length) return;
            this.$http
            .post("admin/listings/labels/positions", { positions: positions })
            .then(function (res) {
                UIkit.notify("Order Updated");
            })
            .catch(function () {
                UIkit.notify("Couldn't Update Order");
            });
        }
    },
    ready() {
      if (this.uniqueLabelTypes.length) {
        this.selectedType = this.uniqueLabelTypes[0];
      }
    },
    filters: {
      truncate: function (value) {
        if (!value) return;
        var length = 45;
        if (value.length > length) return value.substr(0, 45) + "…";
        else return value;
      },
      timeFromEpoch: function (value) {
        if (!value) return;
        var d = new Date(0);
        d.setUTCSeconds(value);
        return d.toLocaleTimeString([], {
          hour: "2-digit",
          minute: "2-digit",
          timeZone: "UTC",
        });
      },
      dateFromEpoch: function (value) {
        if (!value) return;
        var d = new Date(0);
        d.setUTCSeconds(value);
        return d.toLocaleTimeString([], {
          month: "2-digit",
          day: "2-digit",
          year: "2-digit",
          hour: "2-digit",
          minute: "2-digit",
        });
      },
    },
  });

  $(".sortable-labels").on(
    "change.uk.nestable",
    _.debounce(function (e) {
      var rows = $(e.currentTarget).children(),
        positions = [];
      _.each(rows, function (row, i) {
        positions.push({ id: $(row).data().id, position: i });
      });
      vue.savePositions(positions, "labels");
    }, 1000)
  );
});
