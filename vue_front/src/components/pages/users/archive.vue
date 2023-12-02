<template>
  <v-container>
    <v-row>
      <v-col sm="2">
        <LeftNavigation />
      </v-col>
      <v-col cols="12" sm="10">
        <div class="userLogin">
          <v-card>
            <v-card-title>
              Search Archives
              <v-spacer></v-spacer>
              <v-text-field
                v-model="search"
                append-icon="search"
                label="Search"
                single-line
                hide-details
              ></v-text-field>
            </v-card-title>
            <v-data-table
              :headers="headers"
              :items="desserts"
              :search="search"
              hide-default-footer
            ></v-data-table>
          </v-card>
        </div>
      </v-col>
    </v-row>
  </v-container>
</template>
<script>
import LeftNavigation from "@/components/shared/leftNavigation";
export default {
  components: {
    LeftNavigation
  },
  data: () => ({
    search: "",
    headers: [
      {
        text: "No",
        value: "number"
      },
      { text: "Title", value: "title" },
      { text: "Published on", value: "publish" }
    ],
    desserts: [
      {
        number: 1,
        title: "Gross Domestic Product (GDP) / April-June 2019-20",
        publish: "August 30, 2019"
      },
      {
        number: 2,
        title: "India Gross Domestic Product (GDP) / July-September 2019",
        publish: "November 29, 2019"
      }
    ]
  })
};
</script>
