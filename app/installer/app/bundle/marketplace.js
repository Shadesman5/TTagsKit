!(function (t) {
  function e(a) {
    if (s[a]) return s[a].exports;
    var i = (s[a] = { exports: {}, id: a, loaded: !1 });
    return t[a].call(i.exports, i, i.exports, e), (i.loaded = !0), i.exports;
  }
  var s = {};
  return (e.m = t), (e.c = s), (e.p = ""), e(0);
})([
  function (t, e, s) {
    (t.exports = {
      el: "#marketplace",
      data: function () {
        return _.extend(
          { search: this.$session.get("marketplace.search", "") },
          window.$data
        );
      },
      watch: {
        search: function (t) {
          this.$session.set("marketplace.search", t);
        },
      },
      components: { marketplace: s(22) },
    }),
      Vue.ready(t.exports);
  },
  function (t, e) {
    t.exports = {
      data: function () {
        return {
          pkg: {},
          updatePkg: {},
          output: "",
          status: "loading",
          options: { bgclose: !1, keyboard: !1 },
        };
      },
      created: function () {
        this.$mount().$appendTo("body");
      },
      methods: {
        init: function () {
          var t = this;
          return (
            this.open(),
            {
              onprogress: function () {
                t.setOutput(this.responseText);
              },
            }
          );
        },
        setOutput: function (t) {
          var e = t.split("\n"),
            s = e[e.length - 1].match(/^status=(success|error)$/);
          s
            ? ((this.status = s[1]),
              delete e[e.length - 1],
              (this.output = e.join("\n")))
            : (this.output = t);
        },
        open: function () {
          this.$refs.output.open(),
            this.$refs.output.modal.on("hide.uk.modal", this.onClose);
        },
        close: function () {
          this.$refs.output.close();
        },
        onClose: function () {
          this.cb && this.cb(this), this.$destroy();
        },
      },
      watch: {
        status: function () {
          "loading" !== this.status &&
            ((this.$refs.output.modal.options.bgclose = !0),
            (this.$refs.output.modal.options.keyboard = !0));
        },
      },
    };
  },
  function (t, e, s) {
    var a = Vue.extend(s(11)),
      i = Vue.extend(s(12)),
      n = Vue.extend(s(13));
    t.exports = {
      methods: {
        queryUpdates: function (t, e) {
          var s = {},
            a = { emulateJSON: !0 };
          return (
            _.each(t, function (t) {
              s[t.name] = t.version;
            }),
            this.$http
              .post(
                this.api + "/api/package/update",
                { packages: JSON.stringify(s) },
                a
              )
              .then(e, this.error)
          );
        },
        enable: function (t) {
          return this.$http
            .post("admin/system/package/enable", { name: t.name })
            .then(function () {
              this.$notify(
                this.$trans('"%title%" enabled.', { title: t.title })
              ),
                Vue.set(t, "enabled", !0),
                document.location.assign(
                  this.$url(
                    "admin/system/package/" +
                      ("pagekit-theme" === t.type ? "themes" : "extensions")
                  )
                );
            }, this.error);
        },
        disable: function (t) {
          return this.$http
            .post("admin/system/package/disable", { name: t.name })
            .then(function () {
              this.$notify(
                this.$trans('"%title%" disabled.', { title: t.title })
              ),
                Vue.set(t, "enabled", !1),
                document.location.reload();
            }, this.error);
        },
        install: function (t, e, s, i) {
          var n = new a({ parent: this });
          return n.install(t, e, s, i);
        },
        update: function (t, e, s, a) {
          var i = new n({ parent: this });
          return i.update(t, e, s, a);
        },
        uninstall: function (t, e) {
          var s = new i({ parent: this });
          return s.uninstall(t, e);
        },
        error: function (t) {
          this.$notify(t.data, "danger");
        },
      },
    };
  },
  ,
  function (t, e, s) {
    "use strict";
    t.exports = {
      mixins: [s(1)],
      methods: {
        install: function (t, e, s, a) {
          return (
            this.$set("pkg", t),
            (this.cb = s),
            this.$http
              .post(
                "admin/system/package/install",
                { package: t, packagist: Boolean(a) },
                null,
                { xhr: this.init() }
              )
              .then(
                function () {
                  if ("success" === this.status && e) {
                    var s = _.findIndex(e, "name", t.name);
                    -1 !== s ? e.splice(s, 1, t) : e.push(t);
                  }
                },
                function (t) {
                  this.$notify(t.data, "danger"), this.close();
                }
              )
          );
        },
        enable: function () {
          this.$parent.enable(this.pkg), this.close();
        },
      },
    };
  },
  function (t, e, s) {
    "use strict";
    t.exports = {
      mixins: [s(1)],
      methods: {
        uninstall: function (t, e) {
          return (
            this.$set("pkg", t),
            this.$http
              .post(
                "admin/system/package/uninstall",
                { name: t.name },
                { xhr: this.init() }
              )
              .then(
                function () {
                  "success" === this.status && e && e.splice(e.indexOf(t), 1);
                },
                function (t) {
                  this.$notify(t.data, "danger"), this.close();
                }
              )
          );
        },
      },
    };
  },
  function (t, e, s) {
    "use strict";
    t.exports = {
      mixins: [s(1)],
      methods: {
        update: function (t, e, s, a) {
          return (
            this.$set("pkg", t),
            this.$set("updatePkg", e[t.name]),
            (this.cb = s),
            this.$http
              .post(
                "admin/system/package/install",
                { package: e[t.name], packagist: Boolean(a) },
                null,
                { xhr: this.init() }
              )
              .then(
                function () {
                  "loading" === this.status && (this.status = "error"),
                    "success" === this.status && Vue["delete"](e, t.name),
                    t.enabled &&
                      this.$parent.enable(t).then(null, function () {
                        this.status = "error";
                      });
                },
                function (t) {
                  this.$notify(t.data, "danger"), this.close();
                }
              )
          );
        },
      },
    };
  },
  function (t, e) {
    t.exports =
      ' <div> <v-modal v-ref:output :options=options> <div class="uk-modal-header uk-flex uk-flex-middle"> <h2>{{ \'Installing %title% %version%\' | trans {title:pkg.title,version:pkg.version} }}</h2> </div> <pre class="pk-pre uk-text-break" v-html=output></pre> <v-loader v-show="status == \'loading\'"></v-loader> <div class="uk-alert uk-alert-success" v-show="status == \'success\'">{{ \'Successfully installed.\' | trans }}</div> <div class="uk-alert uk-alert-danger" v-show="status == \'error\'">{{ \'Error\' | trans}}</div> <div class="uk-modal-footer uk-text-right" v-show="status != \'loading\'"> <a class="uk-button uk-button-link" @click.prevent=close>{{ \'Close\' | trans }}</a> <a class="uk-button uk-button-primary" @click.prevent=enable v-show="status == \'success\'">{{ \'Enable\' | trans }}</a> </div> </v-modal> </div> ';
  },
  function (t, e) {
    t.exports =
      ' <div> <v-modal v-ref:output :options=options> <div class="uk-modal-header uk-flex uk-flex-middle"> <h2>{{ \'Removing %title% %version%\' | trans {title:pkg.title,version:pkg.version} }}</h2> </div> <pre class="pk-pre uk-text-break" v-html=output></pre> <v-loader v-show="status == \'loading\'"></v-loader> <div class="uk-alert uk-alert-success" v-show="status == \'success\'">{{ \'Successfully removed.\' | trans }}</div> <div class="uk-alert uk-alert-danger" v-show="status == \'error\'">{{ \'Error\' | trans}}</div> <div class="uk-modal-footer uk-text-right" v-show="status != \'loading\'"> <a class="uk-button uk-button-link" @click.prevent=close>{{ \'Close\' | trans }}</a> </div> </v-modal> </div> ';
  },
  function (t, e) {
    t.exports =
      ' <div> <v-modal v-ref:output :options=options> <div class="uk-modal-header uk-flex uk-flex-middle"> <h2>{{ \'Updating %title% to %version%\' | trans {title:pkg.title,version:updatePkg.version} }}</h2> </div> <pre class="pk-pre uk-text-break" v-html=output></pre> <v-loader v-show="status == \'loading\'"></v-loader> <div class="uk-alert uk-alert-success" v-show="status == \'success\'">{{ \'Successfully updated.\' | trans }}</div> <div class="uk-alert uk-alert-danger" v-show="status == \'error\'">{{ \'Error\' | trans}}</div> <div class="uk-modal-footer uk-text-right" v-show="status != \'loading\'"> <a class="uk-button uk-button-link" @click.prevent=close>{{ \'Close\' | trans }}</a> </div> </v-modal> </div> ';
  },
  ,
  function (t, e, s) {
    var a, i;
    (a = s(4)),
      (i = s(7)),
      (t.exports = a || {}),
      t.exports.__esModule && (t.exports = t.exports["default"]),
      i &&
        (("function" == typeof t.exports
          ? t.exports.options || (t.exports.options = {})
          : t.exports
        ).template = i);
  },
  function (t, e, s) {
    var a, i;
    (a = s(5)),
      (i = s(8)),
      (t.exports = a || {}),
      t.exports.__esModule && (t.exports = t.exports["default"]),
      i &&
        (("function" == typeof t.exports
          ? t.exports.options || (t.exports.options = {})
          : t.exports
        ).template = i);
  },
  function (t, e, s) {
    var a, i;
    (a = s(6)),
      (i = s(9)),
      (t.exports = a || {}),
      t.exports.__esModule && (t.exports = t.exports["default"]),
      i &&
        (("function" == typeof t.exports
          ? t.exports.options || (t.exports.options = {})
          : t.exports
        ).template = i);
  },
  ,
  ,
  ,
  ,
  ,
  ,
  function (t, e, s) {
    "use strict";
    t.exports = {
      mixins: [s(2)],
      props: {
        api: { type: String, default: "" },
        search: { type: String, default: "" },
        page: { type: Number, default: 0 },
        type: { type: String, default: "pagekit-extension" },
        installed: {
          type: Array,
          default: function () {
            return [];
          },
        },
      },
      data: function () {
        return {
          pkg: null,
          packages: null,
          updates: null,
          pages: 0,
          iframe: "",
          status: "",
        };
      },
      created: function () {
        this.$options.name = this.type;
      },
      ready: function () {
        this.$watch("page", this.query, { immediate: !0 }),
          this.queryUpdates(this.installed, function (t) {
            var e = t.data;
            this.$set("updates", e.packages.length ? e.packages : null);
          });
      },
      watch: {
        search: function () {
          this.page ? (this.page = 0) : this.query();
        },
        type: function () {
          this.page ? (this.page = 0) : this.query();
        },
      },
      methods: {
        query: function () {
          var t = this.api + "/api/package/search",
            e = { emulateJSON: !0 };
          this.$http
            .post(t, { q: this.search, type: this.type, page: this.page }, e)
            .then(
              function (t) {
                var e = t.data;
                this.$set("packages", e.packages), this.$set("pages", e.pages);
              },
              function () {
                this.$set("packages", null), this.$set("status", "error");
              }
            );
        },
        details: function (t) {
          this.modal || (this.modal = UIkit.modal(this.$els.modal)),
            this.$set("pkg", t),
            this.$set("status", ""),
            this.modal.show();
        },
        doInstall: function (t) {
          this.modal.hide(), this.install(t, this.installed);
        },
        isInstalled: function (t) {
          return _.isObject(t)
            ? _.find(this.installed, "name", t.name)
            : void 0;
        },
      },
      filters: { marked: marked },
    };
  },
  function (t, e) {
    t.exports =
      ' <div> <div class="uk-grid uk-grid-medium uk-grid-match uk-grid-width-small-1-2 uk-grid-width-xlarge-1-3" data-uk-grid-margin=observe:true> <div v-for="pkg in packages"> <div class="uk-panel uk-panel-box uk-overlay-hover"> <div class=uk-panel-teaser> <div class="uk-overlay uk-display-block"> <div class="uk-cover-background uk-position-cover" :style="{ \'background-image\': \'url(\' + pkg.extra.image + \')\' }"></div> <canvas class="uk-responsive-width uk-display-block" width=1200 height=800></canvas> <div class="uk-overlay-panel uk-overlay-background pk-overlay-background uk-overlay-fade"></div> </div> </div> <h2 class="uk-panel-title uk-margin-remove">{{ pkg.title }}</h2> <p class="uk-text-muted uk-margin-remove">{{ pkg.author.name }}</p> <a class=uk-position-cover @click=details(pkg)></a> </div> </div> </div> <v-pagination :page.sync=page :pages=pages v-show="pages > 1 || page > 0"></v-pagination> <div class=uk-modal v-el:modal> <div class="uk-modal-dialog uk-modal-dialog-large" v-if=pkg> <div class=pk-modal-dialog-badge> <button class=uk-button disabled=disabled v-show=isInstalled(pkg)>{{ \'Installed\' | trans }}</button> <button class="uk-button uk-button-primary" @click=doInstall(pkg) v-else>{{ \'Install\' | trans }}</button> </div> <div class=uk-modal-header> <h2 class=uk-margin-small-bottom>{{ pkg.title }}</h2> <ul class="uk-subnav uk-subnav-line uk-margin-bottom-remove"> <li v-if=pkg.author.homepage><a class=uk-link-muted :href=pkg.author.homepage target=_blank>{{ pkg.author.name }}</a></li> <li class=uk-text-muted v-else>{{ pkg.author.name }}</li> <li class=uk-text-muted>{{ \'Version %version%\' | trans {version:pkg.version} }}</li> <li class=uk-text-muted v-if=pkg.license>{{ pkg.license }}</li> </ul> </div> <div class=uk-grid> <div class=uk-width-medium-1-2> <img width=1200 height=800 :alt=pkg.title :src=pkg.extra.image> </div> <div class=uk-width-medium-1-2> <div v-html="pkg.description | marked" v-if=pkg.description></div> <ul class="uk-grid uk-grid-small" data-uk-grid-margin> <li v-if=pkg.demo><a class=uk-button :href=pkg.demo target=_blank>{{ \'Demo\' | trans }}</a></li> <li v-if=pkg.support><a class=uk-button :href=pkg.support target=_blank>{{ \'Support\' | trans }}</a></li> <li v-if=pkg.documentation><a class=uk-button :href=pkg.documentation target=_blank>{{ \'Documentation\' | trans }}</a></li> </ul> </div> </div> </div> </div> <h3 class="uk-h1 uk-text-muted uk-text-center" v-show="packages && !packages.length">{{ \'Nothing found.\' | trans }}</h3> <p class="uk-alert uk-alert-warning" v-show="status == \'error\'">{{ \'Cannot connect to the marketplace. Please try again later.\' | trans }}</p> </div> ';
  },
  function (t, e, s) {
    var a, i;
    (a = s(20)),
      (i = s(21)),
      (t.exports = a || {}),
      t.exports.__esModule && (t.exports = t.exports["default"]),
      i &&
        (("function" == typeof t.exports
          ? t.exports.options || (t.exports.options = {})
          : t.exports
        ).template = i);
  },
]);
