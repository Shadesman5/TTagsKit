!(function (t) {
  function e(s) {
    if (i[s]) return i[s].exports;
    var n = (i[s] = { exports: {}, id: s, loaded: !1 });
    return t[s].call(n.exports, n, n.exports, e), (n.loaded = !0), n.exports;
  }
  var i = {};
  return (e.m = t), (e.c = i), (e.p = ""), e(0);
})([
  function (t, e) {
    (t.exports = {
      name: "user-index",
      el: "#users",
      data: function () {
        return _.merge(
          {
            users: !1,
            config: {
              filter: this.$session.get("user.filter", {
                order: "username asc",
              }),
            },
            pages: 0,
            count: "",
            selected: [],
          },
          window.$data
        );
      },
      ready: function () {
        (this.resource = this.$resource("api/user{/id}")),
          this.$watch("config.page", this.load, { immediate: !0 });
      },
      watch: {
        "config.filter": {
          handler: function (t) {
            this.config.page ? (this.config.page = 0) : this.load(),
              this.$session.set("user.filter", t);
          },
          deep: !0,
        },
      },
      computed: {
        statuses: function () {
          var t = [{ text: this.$trans("New"), value: "new" }].concat(
            _.map(this.config.statuses, function (t, e) {
              return { text: t, value: e };
            })
          );
          return [{ label: this.$trans("Filter by"), options: t }];
        },
        roles: function () {
          var t = this.config.roles.map(function (t) {
            return { text: t.name, value: t.id };
          });
          return [{ label: this.$trans("Filter by"), options: t }];
        },
      },
      methods: {
        active: function (t) {
          return this.selected.indexOf(t.id) != -1;
        },
        save: function (t) {
          this.resource.save({ id: t.id }, { user: t }).then(
            function () {
              this.load(), this.$notify("User saved.");
            },
            function (t) {
              this.load(), this.$notify(t.data, "danger");
            }
          );
        },
        status: function (t) {
          var e = this.getSelected();
          e.forEach(function (e) {
            e.status = t;
          }),
            this.resource.save({ id: "bulk" }, { users: e }).then(
              function () {
                this.load(), this.$notify("Users saved.");
              },
              function (t) {
                this.load(), this.$notify(t.data, "danger");
              }
            );
        },
        remove: function () {
          this.resource["delete"]({ id: "bulk" }, { ids: this.selected }).then(
            function () {
              this.load(), this.$notify("Users deleted.");
            },
            function (t) {
              this.load(), this.$notify(t.data, "danger");
            }
          );
        },
        toggleStatus: function (t) {
          (t.status = t.status ? 0 : 1), this.save(t);
        },
        showVerified: function (t) {
          return this.config.emailVerification && t.data.verified;
        },
        showRoles: function (t) {
          return _.reduce(
            t.roles,
            function (t, e) {
              var i = _.find(this.config.roles, "id", e);
              return 2 !== e && i && t.push(i.name), t;
            },
            [],
            this
          ).join(", ");
        },
        load: function () {
          this.resource
            .query({ filter: this.config.filter, page: this.config.page })
            .then(
              function (t) {
                var e = t.data;
                this.$set("users", e.users),
                  this.$set("pages", e.pages),
                  this.$set("count", e.count),
                  this.$set("selected", []);
              },
              function () {
                this.$notify("Loading failed.", "danger");
              }
            );
        },
        getSelected: function () {
          return this.users.filter(function (t) {
            return this.selected.indexOf(t.id) !== -1;
          }, this);
        },
        canManageUsers: function () {
          return this.config && this.config.canManageUsers;
        },
      },
    }),
      Vue.ready(t.exports);
  },
]);
