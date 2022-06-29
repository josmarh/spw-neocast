
<template>
  <div class="grid grid-cols-12 gap-1">
    <div class="col-span-9">
      <div class="container">
        <video ref="videoPlayer" class="video-js vjs-big-play-centered">
          <p class='vjs-no-js'>
            To view this video, please enable JavaScript and consider upgrading to a web browser that
            <a href='https://videojs.com/html5-video-support/' target='_blank'>supports HTML5 video</a>
          </p>
        </video>
        <div class="overlay">
          {{ videoName }}
        </div>
      </div>
    </div>
    <div class="vjs-playlist col-span-3 overflow-x-scroll scroll-smooth scroller"
      :class="[playlistOptions.length <= 2 ? 'player-default-height' : 'player-custom-height']"
    ></div>
  </div>
</template>
<script>
import videojs from 'video.js';
import videocss from 'video.js/dist/video-js.css';
import playlist from 'videojs-playlist/dist/videojs-playlist.js';
import playlistUi from 'videojs-playlist-ui';
import playlistUicss from 'videojs-playlist-ui/dist/videojs-playlist-ui.vertical.css';
import share from 'videojs-share';
import sharecss from 'videojs-share/dist/videojs-share.css';
import eventTracking from 'videojs-event-tracking';
import seekButtons from 'videojs-seek-buttons';
import seekButtonscss from 'videojs-seek-buttons/dist/videojs-seek-buttons.css';
import store from '../store';
import awesomeWatermark from 'videojs-awesome-watermark';
import imacss from 'videojs-ima/dist/videojs.ima.css'
import 'videojs-contrib-ads';
import 'videojs-ima';
// import vast from '@filmgardi/videojs-vast';
// import logo from 'videojs-logo';

export default {
  name: 'VideoPlayer',
  props: {
    options: {
      type: Object,
      default() {
        return {};
      }
    },
    playlistOptions: {
      type: Array,
      default() {
        return [];
      }
    },
    shareOptions: {
      type: Object,
      default() {
        return {};
      }
    },
    showShare: {
      type: Boolean
    },
    showTitle: {
      type: Boolean
    },
    logoOptions: {
      type: Object,
      default() {
        return {};
      }
    },
    playerColor: {
      type: String
    },
    adsTag: {
      type: String
    }
  },
  data() {
    return {
      player: null,
      videoTitle: null,
      videoName: null
    }
  },
  methods: {
    getVideoTitle(tempName){
      store
        .dispatch('getVideoTitle', tempName)
        .then((res) => {
          this.videoName = res.data[0].file_name;
        })
    },
    playerCustomization(playBtn, playerId, pregressBar, sliderBar) {      
      playBtn.style.border = '0';
      playBtn.style.borderRadius = '0';

      playerId.addEventListener('mouseover',function(){
        playBtn.style.backgroundColor = this.playerColor;
      })
      playerId.addEventListener('mouseleave',function(){
        playBtn.style.backgroundColor = '';
      })
      playBtn.addEventListener('mouseover',function(){
        playBtn.style.backgroundColor = this.playerColor;
      })
      playBtn.addEventListener('mouseleave',function(){
        playBtn.style.backgroundColor = '';
      })
      pregressBar.style.backgroundColor = this.playerColor;
      sliderBar.style.color = this.playerColor;
    }
  },
  mounted() {
    this.player = videojs(this.$refs.videoPlayer, this.options, () => {
      this.player.log('onPlayerReady', this);
    });

    this.player.fluid(true)
    this.player.playlist(this.playlistOptions);
    this.player.playlist.autoadvance(0);
    this.player.playlistUi();
    this.player.seekButtons({
      forward: 15,
      back: 10
    });

    if(this.showShare == true){
      this.player.share(this.shareOptions);
    }

    // video event tracking
    let playerId = document.getElementsByTagName('video')[0];
    this.player.eventTracking(true)
    this.player.on('tracking:firstplay', (e, data) => {
      this.videoTitle = playerId.getAttribute('src');
      this.$emit('playedVideo', this.videoTitle)

      let arr = this.videoTitle.split('/');
      let len = arr.length -1;
      let tempName = arr[len].split('#')[0]

      if(this.showTitle == true){
        this.getVideoTitle(tempName)
      }
    })

    this.player.on('pause', () => {
      if(this.showTitle == true){
        document.getElementsByClassName('overlay')[0].style.opacity = 1;
      }
    })
    this.player.on('play', () => {
       document.getElementsByClassName('overlay')[0].style.opacity = 0;
    });
    this.player.on('ended', () => {
       document.getElementsByClassName('overlay')[0].style.opacity = 1;
    });

    // big play button customization
    let playBtn = document.getElementsByClassName('vjs-big-play-button')[0];
    let pregressBar = document.getElementsByClassName('vjs-play-progress')[0];
    let sliderBar = document.getElementsByClassName('vjs-progress-holder')[0];
    
    this.playerCustomization(playBtn, playerId, pregressBar, sliderBar);

    // playlist customization
    let videoList = document.getElementsByClassName('vjs-playlist-item-list')[0];
    videoList.style.paddingLeft = '4px';
    videoList.style.paddingTop = '4px';

    // water mark customization
    if(this.logoOptions.show == true) {
      this.player.awesomeWatermark(this.logoOptions);
      setTimeout(() => {
        document.getElementsByClassName('vjs-watermark-content')[0].style.position = 'absolute';
        document.getElementsByClassName('vjs-watermark-content')[0].style.top = 0;
      }, 1500)
    }

    // ads setup
    let imaOptions = {
      adTagUrl: this.adsTag
    };
    this.player.ima(imaOptions);

    // let viblast = document.createElement("script");
    // viblast.setAttribute("type", "text/javascript");
    // viblast.setAttribute("src", "https://imasdk.googleapis.com/js/sdkloader/ima3.js");
    // document.head.appendChild(viblast);
  },
  beforeDestroy() {
    if (this.player) {
      this.player.dispose();
    }
  }
}
</script>
<style scoped>
  .scroller{
    overflow-x: hidden;
    overflow-y:scroll;
    transition: 0.5s;
  }
  .scroller::-webkit-scrollbar {
    width: 5px;               /* width of the entire scrollbar */
  }
  .scroller::-webkit-scrollbar-track {
    background: #000000;        /* color of the tracking area */
  }
  .scroller:hover::-webkit-scrollbar-thumb {
    background-color: #6366F1;    /* color of the scroll thumb */
    border-radius: 20px;       /* roundness of the scroll thumb */
    /*border: 3px solid #0A66C2;  /* creates padding around scroll thumb */
  }
  .container{
    position: relative;
  }
  .overlay {
    position: absolute; 
    top: 0; 
    background: rgb(0, 0, 0);
    background: rgba(0, 0, 0, 0.3); /* Black see-through */
    color: #f1f1f1; 
    width: 100%;
    transition: .5s ease;
    opacity:0;
    color: white;
    font-size: 20px;
    padding: 10px;
    text-align: left;
  }

  .player-default-height {
    height: 100%
  }
  .player-custom-height {
    height: 75%;
  }
</style>