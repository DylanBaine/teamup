<template>
    <v-card v-if="calendar">
        <v-card-title>
            <v-btn flat white icon @click="getMonth('sub')">
                <v-icon>chevron_left</v-icon>
            </v-btn>
            <v-spacer></v-spacer>
            <h2 class="title">
                {{calendar.month}}
            </h2>
            <v-spacer></v-spacer>
            <v-btn flat white icon  @click="getMonth('add')">
                <v-icon>chevron_right</v-icon>
            </v-btn>
        </v-card-title>
        <v-container grid-list-xl>
            <v-layout row wrap>
                <v-flex v-for="(col, key) in calendar.rows" :key="key" class="cal-column">
                    <header class="week-day">
                        {{col.day}}
                    </header>
                    <a @click="see(day)" v-for="(day, key) in col.dates" :key="key">
                        <div v-if="day.month == calendar.month" style="height: 100px;">
                            <v-card :class="`mt-2 elevation-3 fch ${day.is_today ? 'today':''}`">
                                <v-card-text>
                                    <div>
                                        {{day.date}}
                                    </div>
                                    <div v-if="day.tasks.length">
                                        {{day.tasks.length}} Tasks
                                    </div>
                                </v-card-text>
                            </v-card>
                        </div>
                        <div v-else style="height: 100px;" class="mt-2"></div>
                    </a>
                </v-flex>
            </v-layout>
        </v-container>
        <v-dialog v-model="modal" width="400">
            <v-card>
                <v-card-title class="primary white--text">
                    <h2 class="title">
                        {{showing.date_string}}
                    </h2>
                </v-card-title>
                <v-card-text class="scroll-300px">
                    <v-list two-line>
                        <v-list-tile class="mb-2 elevation-3" :to="`/tasks/${task.id}/manage`" v-for="task in showing.tasks" :key="task.id">
                            <v-list-tile-content>
                                <v-list-tile-title>
                                    {{task.name}} ({{task.type.name}})
                                </v-list-tile-title>
                                <v-list-tile-sub-title>
                                    {{task.start_date_string}} -> {{task.end_date_string}}
                                </v-list-tile-sub-title>
                            </v-list-tile-content>
                        </v-list-tile>
                    </v-list>
                </v-card-text>
            </v-card>
        </v-dialog>
    </v-card>
</template>

<script>
export default {
  data() {
    return {
      loading: false,
      modal: false,
      month: new Date().getMonth() + 1,
      calendar: null,
      showing: {
        date: null
      }
    };
  },
  watch: {
    month() {
      this.getMonth();
    }
  },
  props: ["owner", "ownerType"],
  mounted() {
    console.log(new Date().getMonth());
    this.getMonth();
  },
  methods: {
    getMonth(month = null) {
      if (month == null) {
        this.$root.$refs.app.$refs.loader.run("Loading calendar");
        this.loading = true;
        axios
          .get(`${url}/${this.ownerType}s/calendar/${this.owner}/${this.month}`)
          .then(res => {
            this.calendar = res.data;
            this.$root.$refs.app.$refs.loader.run();
            this.loading = false;
          });
      } else {
        console.log(month);
        if (month == "add") {
          this.month++;
        }
        if (month == "sub") {
          this.month--;
        }
      }
    },
    see(date) {
      this.modal = true;
      this.showing = date;
    }
  }
};
</script>

<style>
.today {
  border: solid 1px white;
}
/* .week-day {
  padding: 30px;
  border-top: solid 1px white;
  border-bottom: solid 1px white;
}
.cal-column:first-of-type {
  border-left: solid 1px white;
}
.cal-column {
  border-right: solid 1px white;
} */
</style>

