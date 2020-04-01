<template>
<div>
  <h2>{{$t('settings.title')}}</h2>
    <div v-if="!view.isLoaded" class="spinner spinner-lg"></div>
    <div v-if="view.isLoaded">
      <form class="form-horizontal" v-on:submit.prevent="saveSettings('status')">
        <div :class="['form-group', errors.status.hasError ? 'has-error' : '']">
              <label
                class="col-sm-2 control-label"
                for="textInput-modal-markup"
              >{{$t('settings.status')}}</label>
              <div class="col-sm-5">
                <toggle-button
                  class="min-toggle"
                  :width="40"
                  :height="20"
                  :color="{checked: '#0088ce', unchecked: '#bbbbbb'}"
                  :value="configuration.status"
                  :sync="true"
                  @change="toggleStatus()"
                />
                <span
                  v-if="errors.status.hasError"
                  class="help-block"
                >{{errors.status.message}}</span>
              </div>
        </div>
        <div
          v-if="configuration.status"
          :class="['form-group', errors.access.hasError ? 'has-error' : '']"
        >
          <label
            class="col-sm-2 control-label"
            for="textInput-modal-markup"
          >{{$t('settings.access')}}</label>
          <div class="col-sm-5">
            <input type="checkbox"   true-value="public" false-value="private" v-model="configuration.access" class="form-control">
            <span
              v-if="errors.access.hasError"
              class="help-block"
            >{{errors.access.message}}</span>
          </div>
        </div>
        <div 
          v-if="configuration.status"
          :class="['form-group', errors.Minute.hasError ? 'has-error' : '']">
          <label
            class="col-sm-2 control-label"
            for="textInput-modal-markup"
          >{{$t('settings.Minute')}}
          </label>
          <div class="col-sm-5">
            <input type="number" min="1" max="60" v-model="configuration.Minute" class="form-control">
            <span v-if="errors.Minute.hasError" class="help-block">
              {{$t('validation.validation_failed')}}:
              {{$t('validation.'+errors.Minute.message)}}
            </span>
          </div>
        </div>
        <div 
          v-if="configuration.status"
          :class="['form-group', errors.Users.hasError ? 'has-error' : '']">
          <label
            class="col-sm-2 control-label"
            for="textInput-modal-markup"
          >{{$t('settings.Users')}}
          </label>
          <div class="col-sm-5">
            <textarea v-model="configuration.Users" class="form-control"></textarea>
            <span v-if="errors.Users.hasError" class="help-block">
              {{$t('validation.validation_failed')}}:
              {{$t('validation.'+errors.Users.message)}}: {{errors.Users.value}}
            </span>
          </div>
        </div>
        <div v-if="configuration.status" class="form-group">
            <legend class=" col-sm-2 control-label fields-section-header-pf" aria-expanded="true">
              <span
                :class="['fa fa-angle-right field-section-toggle-pf', advanced ? 'fa-angle-down' : '']"
              ></span>
              <a
                class="field-section-toggle-pf"
                @click="toggleAdvancedMode()"
              >{{$t('settings.advanced_mode')}}</a>
            </legend>
        </div>
        <div v-if="advanced">
          <div
            v-if="configuration.status"
            :class="['form-group', errors.skipPrivateIp.hasError ? 'has-error' : '']"
          >
            <label
              class="col-sm-2 control-label"
              for="textInput-modal-markup"
            >{{$t('settings.skipPrivateIp')}}</label>
            <div class="col-sm-5">
              <input type="checkbox"   true-value="enabled" false-value="disabled" v-model="configuration.skipPrivateIp" class="form-control">
              <span
                v-if="errors.skipPrivateIp.hasError"
                class="help-block"
              >{{errors.skipPrivateIp.message}}</span>
            </div>
          </div>
          <div
            v-if="configuration.status"
            :class="['form-group', errors.DnsLookup.hasError ? 'has-error' : '']"
          >
            <label
              class="col-sm-2 control-label"
              for="textInput-modal-markup"
            >{{$t('settings.DnsLookup')}}</label>
            <div class="col-sm-5">
              <input type="checkbox"   true-value="enabled" false-value="disabled" v-model="configuration.DnsLookup" class="form-control">
              <span
                v-if="errors.DnsLookup.hasError"
                class="help-block"
              >{{errors.DnsLookup.message}}</span>
            </div>
          </div>
          <div
            v-if="configuration.status"
            :class="['form-group', errors.GeoIP.hasError ? 'has-error' : '']"
          >
            <label
              class="col-sm-2 control-label"
              for="textInput-modal-markup"
            >{{$t('settings.GeoIP')}}</label>
            <div class="col-sm-5">
              <input type="checkbox"   true-value="" false-value="#" v-model="configuration.GeoIP" class="form-control">
              <span
                v-if="errors.GeoIP.hasError"
                class="help-block"
              >{{errors.GeoIP.message}}</span>
            </div>
          </div>
          <div
            v-if="configuration.status"
            :class="['form-group', errors.PdfReport.hasError ? 'has-error' : '']"
          >
            <label
              class="col-sm-2 control-label"
              for="textInput-modal-markup"
            >{{$t('settings.PdfReport')}}</label>
            <div class="col-sm-5">
              <input type="checkbox"   true-value="enabled" false-value="disabled" v-model="configuration.PdfReport" class="form-control">
              <span
                v-if="errors.PdfReport.hasError"
                class="help-block"
              >{{errors.PdfReport.message}}</span>
            </div>
          </div>
          <div
            v-if="configuration.status && configuration.PdfReport ==='enabled'"
            :class="['form-group', errors.SendReport.hasError ? 'has-error' : '']"
          >
            <label
              class="col-sm-2 control-label"
              for="textInput-modal-markup"
            >{{$t('settings.SendReport')}}</label>
            <div class="col-sm-5">
              <input type="checkbox"   true-value="enabled" false-value="disabled" v-model="configuration.SendReport" class="form-control">
              <span
                v-if="errors.SendReport.hasError"
                class="help-block"
              >{{errors.SendReport.message}}</span>
            </div>
          </div>
          <br />
          <div 
            v-if="configuration.status"
            :class="['form-group', errors.MaxNbOfDomain.hasError ? 'has-error' : '']">
            <label
              class="col-sm-2 control-label"
              for="textInput-modal-markup"
            >{{$t('settings.MaxNbOfDomain')}}
            </label>
            <div class="col-sm-5">
              <input type="number" min="1" max="20" v-model="configuration.MaxNbOfDomain" class="form-control">
              <span v-if="errors.MaxNbOfDomain.hasError" class="help-block">
                {{$t('validation.validation_failed')}}:
                {{$t('validation.'+errors.MaxNbOfDomain.message)}}
              </span>
            </div>
          </div>
          <div 
            v-if="configuration.status"
            :class="['form-group', errors.MinHitDomain.hasError ? 'has-error' : '']">
            <label
              class="col-sm-2 control-label"
              for="textInput-modal-markup"
            >{{$t('settings.MinHitDomain')}}
            </label>
            <div class="col-sm-5">
              <input type="number" min="1" max="1000" v-model="configuration.MinHitDomain" class="form-control">
              <span v-if="errors.MinHitDomain.hasError" class="help-block">
                {{$t('validation.validation_failed')}}:
                {{$t('validation.'+errors.MinHitDomain.message)}}
              </span>
            </div>
          </div>
          <br />
          <div 
            v-if="configuration.status"
            :class="['form-group', errors.MaxNbOfHostsShown.hasError ? 'has-error' : '']">
            <label
              class="col-sm-2 control-label"
              for="textInput-modal-markup"
            >{{$t('settings.MaxNbOfHostsShown')}}
            </label>
            <div class="col-sm-5">
              <input type="number" min="1" max="20" v-model="configuration.MaxNbOfHostsShown" class="form-control">
              <span v-if="errors.MaxNbOfHostsShown.hasError" class="help-block">
                {{$t('validation.validation_failed')}}:
                {{$t('validation.'+errors.MaxNbOfHostsShown.message)}}
              </span>
            </div>
          </div>
          <div 
            v-if="configuration.status"
            :class="['form-group', errors.MinHitHost.hasError ? 'has-error' : '']">
            <label
              class="col-sm-2 control-label"
              for="textInput-modal-markup"
            >{{$t('settings.MinHitHost')}}
            </label>
            <div class="col-sm-5">
              <input type="number" min="1" max="1000" v-model="configuration.MinHitHost" class="form-control">
              <span v-if="errors.MinHitHost.hasError" class="help-block">
                {{$t('validation.validation_failed')}}:
                {{$t('validation.'+errors.MinHitHost.message)}}
              </span>
            </div>
          </div>
          <br />
          <div 
            v-if="configuration.status"
            :class="['form-group', errors.MaxNbOfLoginShown.hasError ? 'has-error' : '']">
            <label
              class="col-sm-2 control-label"
              for="textInput-modal-markup"
            >{{$t('settings.MaxNbOfLoginShown')}}
            </label>
            <div class="col-sm-5">
              <input type="number" min="1" max="20" v-model="configuration.MaxNbOfLoginShown" class="form-control">
              <span v-if="errors.MaxNbOfLoginShown.hasError" class="help-block">
                {{$t('validation.validation_failed')}}:
                {{$t('validation.'+errors.MaxNbOfLoginShown.message)}}
              </span>
            </div>
          </div>
          <div 
            v-if="configuration.status"
            :class="['form-group', errors.MinHitLogin.hasError ? 'has-error' : '']">
            <label
              class="col-sm-2 control-label"
              for="textInput-modal-markup"
            >{{$t('settings.MinHitLogin')}}
            </label>
            <div class="col-sm-5">
              <input type="number" min="1" max="1000" v-model="configuration.MinHitLogin" class="form-control">
              <span v-if="errors.MinHitLogin.hasError" class="help-block">
                {{$t('validation.validation_failed')}}:
                {{$t('validation.'+errors.MinHitLogin.message)}}
              </span>
            </div>
          </div>
          <br />
          <div 
            v-if="configuration.status"
            :class="['form-group', errors.MaxNbOfRobotShown.hasError ? 'has-error' : '']">
            <label
              class="col-sm-2 control-label"
              for="textInput-modal-markup"
            >{{$t('settings.MaxNbOfRobotShown')}}
            </label>
            <div class="col-sm-5">
              <input type="number" min="1" max="20" v-model="configuration.MaxNbOfRobotShown" class="form-control">
              <span v-if="errors.MaxNbOfRobotShown.hasError" class="help-block">
                {{$t('validation.validation_failed')}}:
                {{$t('validation.'+errors.MaxNbOfRobotShown.message)}}
              </span>
            </div>
          </div>
          <div 
            v-if="configuration.status"
            :class="['form-group', errors.MinHitRobot.hasError ? 'has-error' : '']">
            <label
              class="col-sm-2 control-label"
              for="textInput-modal-markup"
            >{{$t('settings.MinHitRobot')}}
            </label>
            <div class="col-sm-5">
              <input type="number" min="1" max="1000" v-model="configuration.MinHitRobot" class="form-control">
              <span v-if="errors.MinHitRobot.hasError" class="help-block">
                {{$t('validation.validation_failed')}}:
                {{$t('validation.'+errors.MinHitRobot.message)}}
              </span>
            </div>
          </div>
          <br />
          <div 
            v-if="configuration.status"
            :class="['form-group', errors.MaxNbOfDownloadsShown.hasError ? 'has-error' : '']">
            <label
              class="col-sm-2 control-label"
              for="textInput-modal-markup"
            >{{$t('settings.MaxNbOfDownloadsShown')}}
            </label>
            <div class="col-sm-5">
              <input type="number" min="1" max="20" v-model="configuration.MaxNbOfDownloadsShown" class="form-control">
              <span v-if="errors.MaxNbOfDownloadsShown.hasError" class="help-block">
                {{$t('validation.validation_failed')}}:
                {{$t('validation.'+errors.MaxNbOfDownloadsShown.message)}}
              </span>
            </div>
          </div>
          <div 
            v-if="configuration.status"
            :class="['form-group', errors.MinHitDownloads.hasError ? 'has-error' : '']">
            <label
              class="col-sm-2 control-label"
              for="textInput-modal-markup"
            >{{$t('settings.MinHitDownloads')}}
            </label>
            <div class="col-sm-5">
              <input type="number" min="1" max="1000" v-model="configuration.MinHitDownloads" class="form-control">
              <span v-if="errors.MinHitDownloads.hasError" class="help-block">
                {{$t('validation.validation_failed')}}:
                {{$t('validation.'+errors.MinHitDownloads.message)}}
              </span>
            </div>
          </div>
          <br />
          <div 
            v-if="configuration.status"
            :class="['form-group', errors.MaxNbOfPageShown.hasError ? 'has-error' : '']">
            <label
              class="col-sm-2 control-label"
              for="textInput-modal-markup"
            >{{$t('settings.MaxNbOfPageShown')}}
            </label>
            <div class="col-sm-5">
              <input type="number" min="1" max="20" v-model="configuration.MaxNbOfPageShown" class="form-control">
              <span v-if="errors.MaxNbOfPageShown.hasError" class="help-block">
                {{$t('validation.validation_failed')}}:
                {{$t('validation.'+errors.MaxNbOfPageShown.message)}}
              </span>
            </div>
          </div>
          <div 
            v-if="configuration.status"
            :class="['form-group', errors.MinHitFile.hasError ? 'has-error' : '']">
            <label
              class="col-sm-2 control-label"
              for="textInput-modal-markup"
            >{{$t('settings.MinHitFile')}}
            </label>
            <div class="col-sm-5">
              <input type="number" min="1" max="1000" v-model="configuration.MinHitFile" class="form-control">
              <span v-if="errors.MinHitFile.hasError" class="help-block">
                {{$t('validation.validation_failed')}}:
                {{$t('validation.'+errors.MinHitFile.message)}}
              </span>
            </div>
          </div>
          <br />
          <div 
            v-if="configuration.status"
            :class="['form-group', errors.MaxNbOfOsShown.hasError ? 'has-error' : '']">
            <label
              class="col-sm-2 control-label"
              for="textInput-modal-markup"
            >{{$t('settings.MaxNbOfOsShown')}}
            </label>
            <div class="col-sm-5">
              <input type="number" min="1" max="20" v-model="configuration.MaxNbOfOsShown" class="form-control">
              <span v-if="errors.MaxNbOfOsShown.hasError" class="help-block">
                {{$t('validation.validation_failed')}}:
                {{$t('validation.'+errors.MaxNbOfOsShown.message)}}
              </span>
            </div>
          </div>
          <div 
            v-if="configuration.status"
            :class="['form-group', errors.MinHitOs.hasError ? 'has-error' : '']">
            <label
              class="col-sm-2 control-label"
              for="textInput-modal-markup"
            >{{$t('settings.MinHitOs')}}
            </label>
            <div class="col-sm-5">
              <input type="number" min="1" max="1000" v-model="configuration.MinHitOs" class="form-control">
              <span v-if="errors.MinHitOs.hasError" class="help-block">
                {{$t('validation.validation_failed')}}:
                {{$t('validation.'+errors.MinHitOs.message)}}
              </span>
            </div>
          </div>
          <br />
          <div 
            v-if="configuration.status"
            :class="['form-group', errors.MaxNbOfBrowsersShown.hasError ? 'has-error' : '']">
            <label
              class="col-sm-2 control-label"
              for="textInput-modal-markup"
            >{{$t('settings.MaxNbOfBrowsersShown')}}
            </label>
            <div class="col-sm-5">
              <input type="number" min="1" max="20" v-model="configuration.MaxNbOfBrowsersShown" class="form-control">
              <span v-if="errors.MaxNbOfBrowsersShown.hasError" class="help-block">
                {{$t('validation.validation_failed')}}:
                {{$t('validation.'+errors.MaxNbOfBrowsersShown.message)}}
              </span>
            </div>
          </div>
          <div 
            v-if="configuration.status"
            :class="['form-group', errors.MinHitBrowser.hasError ? 'has-error' : '']">
            <label
              class="col-sm-2 control-label"
              for="textInput-modal-markup"
            >{{$t('settings.MinHitBrowser')}}
            </label>
            <div class="col-sm-5">
              <input type="number" min="1" max="1000" v-model="configuration.MinHitBrowser" class="form-control">
              <span v-if="errors.MinHitBrowser.hasError" class="help-block">
                {{$t('validation.validation_failed')}}:
                {{$t('validation.'+errors.MinHitBrowser.message)}}
              </span>
            </div>
          </div>
          <br />
          <div 
            v-if="configuration.status"
            :class="['form-group', errors.MaxNbOfScreenSizesShown.hasError ? 'has-error' : '']">
            <label
              class="col-sm-2 control-label"
              for="textInput-modal-markup"
            >{{$t('settings.MaxNbOfScreenSizesShown')}}
            </label>
            <div class="col-sm-5">
              <input type="number" min="1" max="20" v-model="configuration.MaxNbOfScreenSizesShown" class="form-control">
              <span v-if="errors.MaxNbOfScreenSizesShown.hasError" class="help-block">
                {{$t('validation.validation_failed')}}:
                {{$t('validation.'+errors.MaxNbOfScreenSizesShown.message)}}
              </span>
            </div>
          </div>
          <div 
            v-if="configuration.status"
            :class="['form-group', errors.MinHitScreenSize.hasError ? 'has-error' : '']">
            <label
              class="col-sm-2 control-label"
              for="textInput-modal-markup"
            >{{$t('settings.MinHitScreenSize')}}
            </label>
            <div class="col-sm-5">
              <input type="number" min="1" max="1000" v-model="configuration.MinHitScreenSize" class="form-control">
              <span v-if="errors.MinHitScreenSize.hasError" class="help-block">
                {{$t('validation.validation_failed')}}:
                {{$t('validation.'+errors.MinHitScreenSize.message)}}
              </span>
            </div>
          </div>
          <br />
          <div 
            v-if="configuration.status"
            :class="['form-group', errors.MaxNbOfRefererShown.hasError ? 'has-error' : '']">
            <label
              class="col-sm-2 control-label"
              for="textInput-modal-markup"
            >{{$t('settings.MaxNbOfRefererShown')}}
            </label>
            <div class="col-sm-5">
              <input type="number" min="1" max="20" v-model="configuration.MaxNbOfRefererShown" class="form-control">
              <span v-if="errors.MaxNbOfRefererShown.hasError" class="help-block">
                {{$t('validation.validation_failed')}}:
                {{$t('validation.'+errors.MaxNbOfRefererShown.message)}}
              </span>
            </div>
          </div>
          <div 
            v-if="configuration.status"
            :class="['form-group', errors.MinHitRefer.hasError ? 'has-error' : '']">
            <label
              class="col-sm-2 control-label"
              for="textInput-modal-markup"
            >{{$t('settings.MinHitRefer')}}
            </label>
            <div class="col-sm-5">
              <input type="number" min="1" max="1000" v-model="configuration.MinHitRefer" class="form-control">
              <span v-if="errors.MinHitRefer.hasError" class="help-block">
                {{$t('validation.validation_failed')}}:
                {{$t('validation.'+errors.MinHitRefer.message)}}
              </span>
            </div>
          </div>
          <br />
          <div 
            v-if="configuration.status"
            :class="['form-group', errors.MaxNbOfKeyphrasesShown.hasError ? 'has-error' : '']">
            <label
              class="col-sm-2 control-label"
              for="textInput-modal-markup"
            >{{$t('settings.MaxNbOfKeyphrasesShown')}}
            </label>
            <div class="col-sm-5">
              <input type="number" min="1" max="20" v-model="configuration.MaxNbOfKeyphrasesShown" class="form-control">
              <span v-if="errors.MaxNbOfKeyphrasesShown.hasError" class="help-block">
                {{$t('validation.validation_failed')}}:
                {{$t('validation.'+errors.MaxNbOfKeyphrasesShown.message)}}
              </span>
            </div>
          </div>
          <div 
            v-if="configuration.status"
            :class="['form-group', errors.MinHitKeyphrase.hasError ? 'has-error' : '']">
            <label
              class="col-sm-2 control-label"
              for="textInput-modal-markup"
            >{{$t('settings.MinHitKeyphrase')}}
            </label>
            <div class="col-sm-5">
              <input type="number" min="1" max="1000" v-model="configuration.MinHitKeyphrase" class="form-control">
              <span v-if="errors.MinHitKeyphrase.hasError" class="help-block">
                {{$t('validation.validation_failed')}}:
                {{$t('validation.'+errors.MinHitKeyphrase.message)}}
              </span>
            </div>
          </div>
          <br />
          <div 
            v-if="configuration.status"
            :class="['form-group', errors.MaxNbOfKeywordsShown.hasError ? 'has-error' : '']">
            <label
              class="col-sm-2 control-label"
              for="textInput-modal-markup"
            >{{$t('settings.MaxNbOfKeywordsShown')}}
            </label>
            <div class="col-sm-5">
              <input type="number" min="1" max="20" v-model="configuration.MaxNbOfKeywordsShown" class="form-control">
              <span v-if="errors.MaxNbOfKeywordsShown.hasError" class="help-block">
                {{$t('validation.validation_failed')}}:
                {{$t('validation.'+errors.MaxNbOfKeywordsShown.message)}}
              </span>
            </div>
          </div>
          <div 
            v-if="configuration.status"
            :class="['form-group', errors.MinHitKeyword.hasError ? 'has-error' : '']">
            <label
              class="col-sm-2 control-label"
              for="textInput-modal-markup"
            >{{$t('settings.MinHitKeyword')}}
            </label>
            <div class="col-sm-5">
              <input type="number" min="1" max="1000" v-model="configuration.MinHitKeyword" class="form-control">
              <span v-if="errors.MinHitKeyword.hasError" class="help-block">
                {{$t('validation.validation_failed')}}:
                {{$t('validation.'+errors.MinHitKeyword.message)}}
              </span>
            </div>
          </div>
        </div>
        <div  class="form-group">
          <label class="col-sm-2 control-label" for="textInput-modal-markup">
            <div v-if="loaders" class="spinner spinner-sm form-spinner-loader adjust-top-loader"></div>
          </label>
          <div class="col-sm-5">
            <button class="btn btn-primary" type="submit">{{$t('save')}}</button>
          </div>
        </div>
    </form>
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
    advanced: false,
    configuration: {
      status: "enabled",
      access: "private",
      Minute: "5",
      Users: [],
      skipPrivateIp: "disabled",
      DnsLookup: "disabled",
      MaxNbOfDomain: "10",
      MinHitDomain: "1",
      MaxNbOfHostsShown: "10",
      MinHitHost: "1",
      MaxNbOfLoginShown: "10",
      MinHitLogin: "1",
      MaxNbOfRobotShown: "10",
      MinHitRobot: "1",
      MaxNbOfDownloadsShown: "10",
      MinHitDownloads: "1",
      MaxNbOfPageShown: "10",
      MinHitFile: "1",
      MaxNbOfOsShown: "10",
      MinHitOs: "1",
      MaxNbOfBrowsersShown: "10",
      MinHitBrowser: "1",
      MaxNbOfScreenSizesShown: "10",
      MinHitScreenSize: "1",
      MaxNbOfRefererShown: "10",
      MinHitRefer: "1",
      MaxNbOfKeyphrasesShown: "10",
      MinHitKeyphrase: "1",
      MaxNbOfKeywordsShown: "10",
      MinHitKeyword: "1",
      GeoIP: "#",
      PdfReport: "disabled",
      SendReport: "disabled"
    },
    loaders: false,
    errors: this.initErrors()
  };
},
methods: {
  initErrors() {
    return {
      status: {
        hasError: false,
        message: ""
      },
      access: {
        hasError: false,
        message: ""
      },
      Minute: {
        hasError: false,
        message: ""
      },
      Users: {
          haserror: false,
          message:""
      },
      skipPrivateIp: {
          haserror: false,
          message:""
      },
      DnsLookup: {
          haserror: false,
          message:""
      },
      Minute: {
          haserror: false,
          message:""
      },
      MaxNbOfDomain: {
          haserror: false,
          message:""
      },
      MinHitDomain: {
          haserror: false,
          message:""
      },
      MaxNbOfHostsShown: {
          haserror: false,
          message:""
      },
      MinHitHost: {
          haserror: false,
          message:""
      },
      MaxNbOfLoginShown: {
          haserror: false,
          message:""
      },
      MinHitLogin: {
          haserror: false,
          message:""
      },
      MaxNbOfRobotShown: {
          haserror: false,
          message:""
      },
      MinHitRobot: {
          haserror: false,
          message:""
      },
      MaxNbOfDownloadsShown: {
          haserror: false,
          message:""
      },
      MinHitDownloads: {
          haserror: false,
          message:""
      },
      MaxNbOfPageShown: {
          haserror: false,
          message:""
      },
      MinHitFile: {
          haserror: false,
          message:""
      },
      MaxNbOfOsShown: {
          haserror: false,
          message:""
      },
      MinHitOs: {
          haserror: false,
          message:""
      },
      MaxNbOfBrowsersShown: {
          haserror: false,
          message:""
      },
      MinHitBrowser: {
          haserror: false,
          message:""
      },
      MaxNbOfScreenSizesShown: {
          haserror: false,
          message:""
      },
      MinHitScreenSize: {
          haserror: false,
          message:""
      },
      MaxNbOfRefererShown: {
          haserror: false,
          message:""
      },
      MinHitRefer: {
          haserror: false,
          message:""
      },
      MaxNbOfKeyphrasesShown: {
          haserror: false,
          message:""
      },
      MinHitKeyphrase: {
          haserror: false,
          message:""
      },
      MaxNbOfKeywordsShown: {
          haserror: false,
          message:""
      },
      MinHitKeyword: {
          haserror: false,
          message:""
      },
      GeoIP: {
          haserror: false,
          message:""
      },
      PdfReport: {
          haserror: false,
          message:""
      },
      SendReport: {
          haserror: false,
          message:""
      }
    };
  },
  getSettings() {
    var context = this;
    context.view.isLoaded = false;
    context.advanced = false;
    
    nethserver.exec(
      ["nethserver-awstats/read"],
      {
        action: "configuration"
      },
      null,
      function(success) {
        try {
          success = JSON.parse(success);
        } catch (e) {
          console.error(e);
        }
        context.configuration = success.configuration;
        context.configuration.status = success.configuration.status == "enabled";
        context.configuration.Users = context.configuration.Users.split(",").join("\n");
        context.view.isLoaded = true;
      },
      function(error) {
        console.error(error);
          context.view.isLoaded = true;
      }
    );
  },
  toggleStatus() {
    this.configuration.status = !this.configuration.status;
    this.$forceUpdate();
  },
  saveSettings(type) {
    var context = this;
    var settingsObj = {
      action: "configuration",
      status: context.configuration.status
        ? "enabled"
        : "disabled",
      access: context.configuration.access,
      Minute: context.configuration.Minute,
      Users: context.configuration.Users.split("\n").join(","),
      skipPrivateIp: context.configuration.skipPrivateIp,
      DnsLookup: context.configuration.DnsLookup,
      MaxNbOfDomain: context.configuration.MaxNbOfDomain,
      MinHitDomain: context.configuration.MinHitDomain,
      MaxNbOfHostsShown: context.configuration.MaxNbOfHostsShown,
      MinHitHost: context.configuration.MinHitHost,
      MaxNbOfLoginShown: context.configuration.MaxNbOfLoginShown,
      MinHitLogin: context.configuration.MinHitLogin,
      MaxNbOfRobotShown: context.configuration.MaxNbOfRobotShown,
      MinHitRobot: context.configuration.MinHitRobot,
      MaxNbOfDownloadsShown: context.configuration.MaxNbOfDownloadsShown,
      MinHitDownloads: context.configuration.MinHitDownloads,
      MaxNbOfPageShown: context.configuration.MaxNbOfPageShown,
      MinHitFile: context.configuration.MinHitFile,
      MaxNbOfOsShown: context.configuration.MaxNbOfOsShown,
      MinHitOs: context.configuration.MinHitOs,
      MaxNbOfBrowsersShown: context.configuration.MaxNbOfBrowsersShown,
      MinHitBrowser: context.configuration.MinHitBrowser,
      MaxNbOfScreenSizesShown: context.configuration.MaxNbOfScreenSizesShown,
      MinHitScreenSize: context.configuration.MinHitScreenSize,
      MaxNbOfRefererShown: context.configuration.MaxNbOfRefererShown,
      MinHitRefer: context.configuration.MinHitRefer,
      MaxNbOfKeyphrasesShown: context.configuration.MaxNbOfKeyphrasesShown,
      MinHitKeyphrase: context.configuration.MinHitKeyphrase,
      MaxNbOfKeywordsShown: context.configuration.MaxNbOfKeywordsShown,
      MinHitKeyword: context.configuration.MinHitKeyword,
      GeoIP: context.configuration.GeoIP,
      PdfReport: context.configuration.PdfReport,
      SendReport: context.configuration.SendReport
    };
    context.loaders = true;
    context.errors = context.initErrors();
    nethserver.exec(
      ["nethserver-awstats/validate"],
      settingsObj,
      null,
      function(success) {
        context.loaders = false;
    
        // notification
        nethserver.notifications.success = context.$i18n.t(
          "settings.settings_updated_ok"
        );
        nethserver.notifications.error = context.$i18n.t(
          "settings.settings_updated_error"
        );
        // update values
        nethserver.exec(
          ["nethserver-awstats/update"],
          settingsObj,
          function(stream) {
            console.info("awstats", stream);
          },
          function(success) {
            context.getSettings();
          },
          function(error, data) {
            console.error(error, data);
          },
          true //sudo
        );
      },
      function(error, data) {
        var errorData = {};
        context.loaders = false;
        context.errors = context.initErrors();
        try {
          errorData = JSON.parse(data);
          for (var e in errorData.attributes) {
            var attr = errorData.attributes[e];
            context.errors[attr.parameter].hasError = true;
            context.errors[attr.parameter].message = attr.error;
            context.errors[attr.parameter].value = attr.value;
          }
        } catch (e) {
          console.error(e);
        }
    },
      true // sudo
  );
  },
  toggleAdvancedMode() {
    this.advanced = !this.advanced;
    this.$forceUpdate();
  }
}
};
</script>

<style>
.divider {
    border-top: 1px solid #d1d1d1;
}
</style>
