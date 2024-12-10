<?php
$view->script('panel-finder', 'system/finder:app/bundle/panel-finder.js', ['vue', 'uikit-upload']);
?>

<div id="userstorage" v-cloak>
    <div class="uk-grid pk-grid-large" data-uk-grid-margin>
        <!-- select user -->
        <div v-if="canUpload()" class="pk-width-sidebar">
            <div class="uk-panel">
                <ul class="uk-nav uk-nav-side pk-nav-large" data-uk-tab="{ connect: '#tab-content' }">
                    <li v-for="user in users" :key="user.id" :class="{'uk-active': selectedUser && selectedUser.id === user.id}" @click.prevent="selectUser(user)">
                        <a>
                            <i class="uk-icon-folder-open uk-icon-medium uk-margin-right"></i>
                            {{ user.username }}
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <!-- show user storage -->
        <div id="tab-content" class="uk-margin uk-width" :class="{'pk-width-content': canUpload()}">
            <component :is="finderComponent" :key="selectedUserRoot" :root="selectedUserRoot" :mode="mode"></component>
        </div>
    </div>
</div>

<script>
    new Vue({
        el: '#userstorage',
        data: {
            users: <?= json_encode(array_values($users)) ?>,
            selectedUser: null,
            selectedUserRoot: null,
            finderComponent: null,
            mode: '<?= $mode ?>'
        },
        methods: {
            selectUser(user) {
                this.selectedUser = user;
                this.selectedUserRoot = '<?= htmlentities($root) ?>/' + user.id;
                this.mode = user.mode || this.mode;

                // Finder-Komponente neu laden
                this.finderComponent = null;
                this.$nextTick(() => {
                    this.finderComponent = 'panel-finder';
                });
            },
            canUpload() {
                return this.mode === 'w';
            }
        },
        created() {
            if (this.users.length > 0) {
                this.selectUser(this.users[0]);
            }
        }
    });
</script>