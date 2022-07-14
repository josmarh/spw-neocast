<template>
  <div>
    <new-channel title="Scheduled (Linear)" 
      :playlist="playlist"
      :videoOptions="videoOptions"
      :loopPlaylist="false"    
    />
  </div>
</template>

<script setup>
import NewChannel from '../../components/ChannelComponent.vue';

const videoOptions = {
  autoplay: false,
  controls: true,
  muted: true,
  loop: true,
  sources: [
    {
      src: `${import.meta.env.VITE_STREAM_URI}/m3u8/linear_demo.m3u8`,
      type: 'application/x-mpegURL',
    }
  ],
  poster: 'https://i.vimeocdn.com/video/325444120-4f3555ff6174ac09e632d1c8d2284f7bee3c875787792d448774ca69e87c97d7-d_640',
  bigPlayButton: true,
  controlBar: {
    fullscreenToggle: false,
    pictureInPictureToggle: false,
    remainingTimeDisplay: false,
    volumePanel: true,
    currentTimeDisplay: true,
    timeDivider: true,
    durationDisplay: true,
    progressControl: false,
    liveControl: true
  }
};
</script>