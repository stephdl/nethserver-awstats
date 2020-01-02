<template>
<div>
  <h2>{{$t('statistics.title')}}</h2>
  <div v-if="!view.isLoaded" class="spinner spinner-lg"></div>
    <h3 v-if="view.isLoaded">{{$t('statistics.list_of_virtualhosts')}}</h3>
  <div v-if="view.isLoaded" class="list-group list-view-pf list-view-pf-view no-mg-top mg-top-10">
    <div v-bind:key="index" v-for="(vhost,index) in awstats.vhosts" class="list-group-item">
      <div class="list-view-pf-main-info small-list">
        <div class="list-view-pf-left">
        </div>
        <div class="list-view-pf-body">
          <div class="list-view-pf-description">
            <div class="list-group-item-heading">
              <div>
                <span v-if="index === 0" >
                  <a :href="url+vhost" target='_blank'>
                  {{vhost}}
                </a>
                </span>
                <span v-if="index > 0" >
                  <a :href="url+vhost+'.vhost'" target='_blank'>
                  {{vhost}}
                </a>
                </span>
              </div>
            </div>
            <div class="list-group-item-text">
            </div>
          </div>
          <div class="list-view-pf-additional-info">
            <span v-if="index > 0" >
              {{$t('statistics.vhost')}}
            </span>
            <span v-if="index === 0" >
              {{$t('statistics.default_vhost')}}
            </span>
          </div>
        </div>
      </div>
    </div>
    <!-- end item -->
  </div>
  <!-- end list -->
  <br />
  <h3 v-if="view.isLoaded">{{$t('statistics.SMTP')}}</h3>
  <div v-if="view.isLoaded" class="list-group list-view-pf list-view-pf-view no-mg-top mg-top-10">
    <div  class="list-group-item">
      <div class="list-view-pf-main-info small-list">
        <div class="list-view-pf-left">
        </div>
        <div class="list-view-pf-body">
          <div class="list-view-pf-description">
            <div class="list-group-item-heading">
              <div :class="{'big-name' : index === 0}">
                  <a :href="url+'maillog'" target='_blank'>
                  {{awstats.smtp}}
                </a>
              </div>
            </div>
            <div class="list-group-item-text">
            </div>
            </div>
            <div class="list-view-pf-additional-info">
              <span >
                {{$t('statistics.maillog_statistic')}}
              </span>
            </div>
        </div>
      </div>
    </div>
  </div>
</div>
    
    
</template>

<script>
export default {
  name: "Settings",
  components: {
  },
  mounted() {
    this.getSettings();
  },
  beforeRouteLeave(to, from, next) {
    $(".modal").modal("hide");
    next();
  },
  data() {
  return {
    view: {
      isLoaded: false
    },
    awstats: {
      vhosts: [],
      smtp: []
    },
    loaders: false
  };
},
methods: {
  getSettings() {
    var context = this;
    context.view.isLoaded = false;
    context.advanced = false;
    context.url = 'https://'+window.location.hostname+'/awstats/awstats.pl?config=';
    nethserver.exec(
      ["nethserver-awstats/read"],
      {
        action: "statistics"
      },
      null,
      function(success) {
        try {
          success = JSON.parse(success);
        } catch (e) {
          console.error(e);
        }
        context.awstats = success.awstats;
        context.view.isLoaded = true;
      },
      function(error) {
        console.error(error);
          context.view.isLoaded = true;
      }
    );
  }
}
};
</script>

<style>

</style>
