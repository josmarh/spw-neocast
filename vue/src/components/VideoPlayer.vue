<template>
  <div class="grid grid-cols-12">
    <div class="col-span-10">
      <video ref="videoPlayer" class="video-js" height="20"></video>
    </div>
    <div class="vjs-playlist col-span-2 overflow-y-scroll xl:h-[22rem] sm:h-[20.5rem] scroll-smooth scroller"></div>
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
  },
  data() {
    return {
      player: null,
      videoTitle: null
    }
  },
  mounted() {
    this.player = videojs(this.$refs.videoPlayer, this.options, () => {
      this.player.log('onPlayerReady', this);
    });

    this.player.fluid(true)
    this.player.playlist(this.playlistOptions);
    this.player.playlistUi();
    this.player.share(this.shareOptions);
    this.player.eventTracking(true)
    this.player.on('tracking:firstplay', (e, data) => {
      // console.log(data)
      this.videoTitle = document.getElementsByTagName('video')[0].getAttribute('src');
      // console.log(this.videoTitle)
      this.$emit('playedVideo', this.videoTitle)
    })
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
</style>