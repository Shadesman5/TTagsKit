var Finder=function(e){function t(s){if(i[s])return i[s].exports;var a=i[s]={exports:{},id:s,loaded:!1};return e[s].call(a.exports,a,a.exports,t),a.loaded=!0,a.exports}var i={};return t.m=e,t.c=i,t.p="",t(0)}([function(e,t,i){var s,a;s=i(2),a=i(6),e.exports=s||{},e.exports.__esModule&&(e.exports=e.exports.default),a&&(("function"==typeof e.exports?e.exports.options||(e.exports.options={}):e.exports).template=a)},,function(e,t,i){"use strict";e.exports={props:{root:{type:String,default:"/"},mode:{type:String,default:"write"},path:{type:String},view:{type:String},modal:Boolean},data:function(){return{upload:{},selected:[],items:!1,search:""}},created:function(){this.path||(this.path=this.$session.get("finder."+this.root+".path","/")),this.view||(this.view=this.$session.get("finder."+this.root+".view","table")),this.$watch("path",(function(e){this.load(),this.$session.set("finder."+this.root+".path",e)}))},ready:function(){this.resource=this.$resource("system/finder{/cmd}"),this.load().then((function(){this.$dispatch("ready.finder",this)}))},watch:{view:function(e){this.$session.set("finder."+this.root+".view",e)},selected:function(){this.$dispatch("select.finder",this.getSelected(),this)},search:function(){this.$set("selected",_.filter(this.selected,(function(e){return _.find(this.searched,"name",e)}),this))}},computed:{breadcrumbs:function(){var e="",t=[{path:"/",title:this.$trans("Home")}].concat(this.path.substr(1).split("/").filter((function(e){return e.length})).map((function(t){return{path:e+="/"+t,title:t}})));return t[t.length-1].current=!0,t},searched:function(){return _.filter(this.items,(function(e){return!this.search||-1!==e.name.toLowerCase().indexOf(this.search.toLowerCase())}),this)},count:function(){return this.searched.length}},methods:{setPath:function(e){this.$set("path",e)},getPath:function(){return this.path},getFullPath:function(){return(this.getRoot()+this.getPath()).replace(/^\/+|\/+$/g,"")+"/"},getRoot:function(){return this.root.replace(/^\/+|\/+$/g,"")},getSelected:function(){return this.selected.map((function(e){return _.find(this.items,"name",e).url}),this)},removeSelection:function(){this.selected=[]},toggleSelect:function(e){var t=this.selected.indexOf(e);-1===t?this.selected.push(e):this.selected.splice(t,1)},isSelected:function(e){return-1!=this.selected.indexOf(e.toString())},createFolder:function(){UIkit.modal.prompt(this.$trans("Folder Name"),"",function(e){e&&this.command("createfolder",{name:e})}.bind(this))},rename:function(e){e.target&&(e=this.selected[0]),e&&UIkit.modal.prompt(this.$trans("Name"),e,function(t){t&&this.command("rename",{oldname:e,newname:t})}.bind(this),{title:this.$trans("Rename")})},remove:function(e){e.target&&(e=this.selected),e&&this.command("removefiles",{names:e})},encodeURI:function(e){function t(t){return e.apply(this,arguments)}return t.toString=function(){return e.toString()},t}((function(e){return encodeURI(e).replace(/'/g,"%27")})),isWritable:function(){return"w"===this.mode||"r"===this.mode},canUpload:function(){return"w"===this.mode},isImage:function(e){return e.match(/\.(?:gif|jpe?g|png|svg|ico|webp)$/i)},isVideo:function(e){return e.match(/\.(mpeg|ogv|mp4|webm|wmv)$/i)},command:function(e,t){return this.resource.save({cmd:e},$.extend({path:this.path,root:this.getRoot()},t)).then((function(e){this.load(),this.$notify(e.data.message,e.data.error?"danger":"")}),(function(e){this.$notify(500==e.status?"Unknown error.":e.data,"danger")}))},load:function(){return this.resource.get({path:this.path,root:this.getRoot()}).then((function(e){this.$set("items",e.data.items||[]),this.$set("selected",[]),this.$dispatch("path.finder",this.getFullPath(),this)}),(function(){this.$notify("Unable to access directory.","danger")}))}},events:{"hook:ready":function(){var e=this,t={action:this.$url.route("system/finder/upload"),before:function(t){$.extend(t.params,{path:e.path,root:e.getRoot(),_csrf:$pagekit.csrf})},loadstart:function(){e.$set("upload.running",!0),e.$set("upload.progress",0)},progress:function(t){e.$set("upload.progress",Math.ceil(t))},allcomplete:function(t){var i=$.parseJSON(t);e.load(),e.$notify(i.message,i.error?"danger":""),e.$set("upload.progress",100),setTimeout((function(){e.$set("upload.running",!1)}),1500)}};UIkit.uploadSelect(this.$el.querySelector(".uk-form-file > input"),t),UIkit.uploadDrop($(this.$el).parents(".uk-modal").length?this.$el:$("html"),t)}},partials:{table:i(3),thumbnail:i(4)}},Vue.component("panel-finder",(function(t){t(e.exports)}))},function(e,t){e.exports='<table class="uk-table uk-table-hover uk-table-middle"> <thead> <th class=pk-table-width-minimum><input type=checkbox v-check-all:selected.literal="input[name=name]"></th> <th colspan=2>{{ \'Name\' | trans }}</th> <th class="pk-table-width-minimum uk-text-center">{{ \'Size\' | trans }}</th> <th class=pk-table-width-minimum>{{ \'Modified\' | trans }}</th> </thead> <tbody> <tr v-for="folder in searched | filterBy \'application/folder\' in \'mime\'" class=uk-visible-hover :class="{\'uk-active\': isSelected(folder.name)}" @click.prevent=toggleSelect(folder.name)> <td><input type=checkbox name=name :value=folder.name v-model=selected @click.stop></td> <td class=pk-table-width-minimum> <i class=pk-icon-folder-circle></i> </td> <td class="pk-table-text-break pk-table-min-width-200"><a @click.stop=setPath(folder.path)>{{ folder.name }}</a></td> <td></td> <td></td> </tr> <tr v-for="file in searched | filterBy \'application/file\' in \'mime\'" class=uk-visible-hover :class="{\'uk-active\': isSelected(file.name)}" @click.prevent=toggleSelect(file.name)> <td><input type=checkbox name=name :value=file.name v-model=selected @click.stop></td> <td class=pk-table-width-minimum> <i v-if=isImage(file.url) class=pk-icon-contain v-lazy-background=$url(file.url)></i> <i v-else class=pk-icon-file-circle></i> </td> <td class="pk-table-text-break pk-table-min-width-200">{{ file.name }}</td> <td class="uk-text-right uk-text-nowrap">{{ file.size }}</td> <td class=uk-text-nowrap>{{ file.lastmodified | relativeDate }}</td> </tr> </tbody> </table> '},function(e,t){e.exports='<ul v-if=items.length class="uk-grid uk-grid-medium uk-grid-match uk-grid-width-small-1-2 uk-grid-width-large-1-3 uk-grid-width-xlarge-1-4" data-uk-grid-margin=observe:true> <li v-for="folder in searched | filterBy \'application/folder\' in \'mime\'"> <div class="uk-panel uk-panel-box uk-text-center" @click.prevent=toggleSelect(folder.name)> <div class="uk-panel-teaser uk-position-relative"> <div class="uk-cover-background uk-position-cover pk-thumbnail-folder"></div> <canvas class="uk-responsive-width uk-display-block" width=1200 height=800></canvas> </div> <div class=uk-text-truncate> <input type=checkbox :value=folder.name v-model=selected @click.stop> <a @click.stop="setPath(folder.path, $event)">{{ folder.name }}</a> </div> </div> </li> <li v-for="file in searched | filterBy \'application/file\' in \'mime\'"> <div class="uk-panel uk-panel-box uk-text-center" @click.prevent=toggleSelect(file.name)> <div class="uk-panel-teaser uk-position-relative"> <div class="pk-background-contain uk-position-cover" v-if=isImage(file.path) v-lazy-background=$url(file.url)></div> <div class="uk-cover-background uk-position-cover pk-thumbnail-file" v-else></div> <canvas class="uk-responsive-width uk-display-block" width=1200 height=800></canvas> </div> <div class="uk-text-nowrap uk-text-truncate"> <input type=checkbox :value=file.name v-model=selected @click.stop> {{ file.name }} </div> </div> </li> </ul> '},,function(e,t){e.exports=' <div class=uk-form v-show=items> <div class="uk-margin uk-flex uk-flex-space-between uk-flex-wrap" data-uk-margin> <div class="uk-flex uk-flex-middle uk-flex-wrap" data-uk-margin> <h2 class=uk-margin-remove v-show=!selected.length>{{ \'{0} %count% Files|{1} %count% File|]1,Inf[ %count% Files\' | transChoice count {count:count} }}</h2> <h2 class=uk-margin-remove v-else>{{ \'{1} %count% File selected|]1,Inf[ %count% Files selected\' | transChoice selected.length {count:selected.length} }}</h2> <div class=uk-margin-left v-if=isWritable v-show=selected.length> <ul class="uk-subnav pk-subnav-icon"> <li v-show="selected.length === 1"><a class="pk-icon-edit pk-icon-hover" :title="\'Rename\' | trans" data-uk-tooltip="{delay: 500}" @click.prevent=rename></a></li> <li><a class="pk-icon-delete pk-icon-hover" :title="\'Delete\' | trans" data-uk-tooltip="{delay: 500}" @click.prevent=remove v-confirm="\'Delete files?\'"></a></li> </ul> </div> <div class=pk-search> <div class=uk-search> <input class=uk-search-field type=text v-model=search> </div> </div> </div> <div class="uk-flex uk-flex-middle uk-flex-wrap" data-uk-margin> <div class=uk-margin-right> <ul class="uk-subnav pk-subnav-icon"> <li :class="{\'uk-active\': view == \'table\'}"> <a class="pk-icon-table pk-icon-hover" :title="\'Table View\' | trans" data-uk-tooltip="{delay: 500}" @click.prevent="view = \'table\'"></a> </li> <li class="{\'uk-active\': view == \'thumbnail\'}"> <a class="pk-icon-thumbnails pk-icon-hover" :title="\'Thumbnails View\' | trans" data-uk-tooltip="{delay: 500}" @click.prevent="view = \'thumbnail\'"></a> </li> </ul> </div> <div v-if="canUpload()"> <button class="uk-button uk-margin-small-right" @click.prevent=createFolder()>{{ \'Add Folder\' | trans }}</button> <div class=uk-form-file> <button class=uk-button :class="{\'uk-button-primary\': !modal}">{{ \'Upload\' | trans }}</button> <input type=file name=files[] multiple=multiple> </div> </div> </div> </div> <ul class="uk-breadcrumb uk-margin-large-top"> <li v-for="bc in breadcrumbs" :class="{\'uk-active\': bc.current}"> <span v-show=bc.current>{{ bc.title }}</span> <a v-else @click.prevent=setPath(bc.path)>{{ bc.title }}</a> </li> </ul> <div class="uk-progress uk-progress-mini uk-margin-remove" v-show=upload.running> <div class=uk-progress-bar :style="{width: upload.progress + \'%\'}"></div> </div> <div class="uk-overflow-container tm-overflow-container"> <partial :name=view></partial> <h3 class="uk-h1 uk-text-muted uk-text-center" v-show=!count>{{ \'No files found.\' | trans }}</h3> </div> </div> '}]);