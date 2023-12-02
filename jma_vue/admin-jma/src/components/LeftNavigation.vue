<template>
  <v-navigation-drawer app clipped fixed v-model="drawer" :mini-variant.sync="mini" permanent>
    <v-list>
      <v-list-group
        v-for="item in menuItems"
        :key="item.title"
        :prepend-icon="item.icon"
        v-model="item.active"
        no-action
      >
        <template v-slot:activator>
          <v-list-item-title>{{item.title}}</v-list-item-title>
        </template>
        <v-list-item v-for="subItem in item.submenu" :key="subItem.title">
          <v-list-item-icon>
            <v-icon v-text="subItem.icon"></v-icon>
          </v-list-item-icon>
          <v-list-item-title>
            <router-link :to="subItem.link">{{subItem.title}}</router-link>
          </v-list-item-title>
        </v-list-item>
      </v-list-group>
    </v-list>
  </v-navigation-drawer>
</template>
<script>
export default {
  data() {
    return {
      mini: false,
      drawer: true,
      menuItems: [
        {
          icon: "how_to_vote",
          title: "Post",
          active: true,
          submenu: [
            {
              icon: "format_list_bulleted",
              title: "List Post",
              link: "/postList"
            },
            { icon: "add_box", title: "Add Post", link: "/PostAdd" },
            
          ]
        },
        {
          icon: "category",
          title: "Category",
          submenu: [
            {
              icon: "format_list_bulleted",
              title: "List Category",
              link: "/CategoryList"
            },
            { icon: "add_box", title: "Add Category", link: "/CategoryAdd" }
          ]
        },
        // {
        //   icon: "youtube_searched_for",
        //   title: "Seo",
        //   submenu: [
        //     {
        //       icon: "format_list_bulleted",
        //       title: "List Seo",
        //       link: "/SeoList"
        //     },
        //     { icon: "add_box", title: "Add Seo", link: "/SeoAdd" }
        //   ]
        // },
        {
          icon: "wallpaper",
          title: "Media",
          submenu: [
            {
              icon: "format_list_bulleted",
              title: "List Media",
              link: "/MediaList"
            },
            { icon: "add_box", title: "Add Media", link: "/MediaAdd" }
          ]
        },
        // {
        //   icon: "dns",
        //   title: "Material",
        //   submenu: [
        //     {
        //       icon: "format_list_bulleted",
        //       title: "List Material",
        //       link: "/MaterialList"
        //     },
        //     { icon: "add_box", title: "Add Material", link: "/MaterialAdd" }
        //   ]
        // },
        // // {
        //   icon: "library_books",
        //   title: "BriefSeries",
        //   submenu: [
        //     {
        //       icon: "add_box",
        //       title: "Add BriefSeries",
        //       link: "/BriefSeriesAdd"
        //     },
        //     {
        //       icon: "format_list_bulleted",
        //       title: "List BriefSeries",
        //       link: "/BriefSeriesList"
        //     }
        //   ]
        // },
        //  {
        //    icon: "code",
        //    title: "Meta",
        //    submenu: [
        //      { icon: "add_box", title: "Add Meta", link: "/MetaAdd" },
        //      {
        //        icon: "format_list_bulleted",
        //        title: "List Meta",
        //        link: "/MetaList"
        //      }
        //   ]
        //  },
        {
          icon: "show_chart",
          title: "Graph",
          submenu: [
            {
              icon: "format_list_bulleted",
              title: "List Graph",
              link: "/GraphList"
            },
            { icon: "add_box", title: "Add Graph", link: "/GraphAdd" }
          ]
        },
  

        {
          icon: "perm_identity",
          title: "User",
          submenu: [
            {
              icon: "format_list_bulleted",
              title: "List User",
              link: "/UserList"
            },
            { icon: "add_box", title: "Add User", link: "/UserAdd" },
            {
              icon: "format_list_bulleted",
              title: "List Companies",
              link: "/CompaniesList"
            },
            { icon: "add_box", title: "Add Companies", link: "/CompaniesAdd" }
          ]
        },
        {
          icon: "email",
          title: "Email",
          submenu: [
            {
              icon: "format_list_bulleted",
              title: "List Email",
              link: "/EmailList"
            },
            { icon: "add_box", title: "Add Email", link: "/EmailAdd" }
          ]
        },
        {
          icon: "perm_data_setting",
          title: "More Settings",
          submenu: [
            {
              icon: "all_inbox",
              title: "Cache Settings",
              link: "/CacheSettings"
            },
            {
              icon: "multiline_chart",
              title: "Index Graph",
              link: "/IndexGraph"
            },
            {
              icon: "desktop_access_disabled",
              title: "IP Address",
              link: "/IPAddress"
            }
          ]
        }
      ],
      admins: [["Management", "people_outline"], ["Settings", "settings"]]
    };
  },
  mounted() {
    Event.$on("i-got-clicked", () => {
      this.mini = !this.mini;
    });
  }
};
</script>
<style scoped>
.v-application--is-ltr
  .v-list-group--no-action
  > .v-list-group__items
  > div
  > .v-list-item {
  padding-left: 40px;
}
</style>