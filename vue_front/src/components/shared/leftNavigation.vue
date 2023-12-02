<template>
  <v-content v-show="menuData">
    <v-expansion-panels v-model="panel" multiple class="leftNav">
      <v-expansion-panel v-for="(item, i) in items" :key="i">
        <v-expansion-panel-header>
          <v-icon v-text="item.icon"></v-icon>
          {{ item.title }}
        </v-expansion-panel-header>
        <v-expansion-panel-content>
          <v-treeview open-on-click dense :items="item.indicators">
            <template slot="label" slot-scope="props">
              <router-link to="indicator" v-if="props.item.url">
                <span class="lnNew" v-if="props.item.new">{{
                  props.item.new
                }}</span>
                {{ props.item.name }}
              </router-link>
              <span v-else>
                <span class="lnNew" v-if="props.item.new">{{
                  props.item.new
                }}</span>
                {{ props.item.name }}
              </span>
            </template>
          </v-treeview>
        </v-expansion-panel-content>
      </v-expansion-panel>
    </v-expansion-panels>
  </v-content>
</template>
<script>
export default {
  data() {
    return {
      panel: [0, 1],
      items: [],
      items1: [],
      model: 1
    };
  },
  created() {
    this.axios.get(this.nodejsServer + "categoryList").then(response => {
      this.items = response.data;
    });
  },
  computed: {
    menuData() {
      return this.$store.state.mini;
    }
  }
};
</script>
<style lang="scss">
@import "../../assets/_variables.scss";
.v-application--is-ltr .leftNav {
  .v-treeview-node__toggle {
    -webkit-transform: none;
    transform: none;
    width: 15px;
  }
  .v-treeview-node__toggle--open {
    -webkit-transform: rotate(-180deg);
    transform: rotate(-180deg);
  }
  .v-treeview-node {
    margin-left: 7px;
  }
  .v-treeview-node--leaf > .v-treeview-node__root {
    padding-left: 11px;
  }
  .v-treeview {
    > .v-treeview-node--leaf {
      margin-left: 0 !important;
      .v-treeview-node__root {
        padding-left: 0;
      }
    }
  }
}
.leftNav {
  .v-expansion-panel-header {
    min-height: 43px;
    padding: 9px 12px;
    color: $white;
    background-color: $dark-gray;
    border-radius: 0;
    > *:not(.v-expansion-panel-header__icon) {
      -webkit-box-flex: unset;
      -ms-flex: none;
      flex: none;
      font-size: 1.2rem;
      padding-right: 7px;
      color: $white;
    }
    .v-expansion-panel-header__icon {
      display: none;
    }
  }
  &.theme--light.v-expansion-panels
    .v-expansion-panel-header
    .v-expansion-panel-header__icon
    .v-icon {
    color: $white;
  }
  .v-treeview-node__label {
    white-space: normal;
  }
  .v-treeview-node__root {
    padding: 7px 0;
    flex-direction: row-reverse;
    font-size: 14px;
  }
  .v-treeview-node__root::before {
    background-color: transparent;
  }
  .v-expansion-panel--active > .v-expansion-panel-header {
    min-height: 43px;
  }
  .v-expansion-panel-content__wrap {
    padding: 0 5px 16px;
  }
  .v-expansion-panel--active:not(:first-child),
  .v-expansion-panel--active + .v-expansion-panel {
    margin-top: 0;
  }
  &.v-expansion-panels:not(.v-expansion-panels--accordion)
    > .v-expansion-panel--next-active
    .v-expansion-panel-header {
    border-radius: 0;
  }
  .lnNew {
    background: $primari-color;
    color: #fff;
    font-size: 10px;
    padding: 1px 7px;
    margin-right: 5px;
    vertical-align: text-top;
  }
}

.v-application .leftNav {
  a {
    color: $dark-gray;
    text-decoration: none;
  }
  a:hover {
    color: $primari-color;
  }
}
</style>
