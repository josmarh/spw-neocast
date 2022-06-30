<template>
  <div>
    <new-channel title="Playlist (On demand)"
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
  loop: false,
}

const playlist = [
  {
    name: 'Dreams',
    sources: [{
      src: 'http://localhost:8000/samples/MAeycUoYvY751ZhY.mp4',
      type: 'video/mp4',
    }],
    poster: 'http://localhost:8000/samples/JUqevdbAnwGBhavt.png',
    thumbnail: [
      {
        srcset: 'http://localhost:8000/samples/JUqevdbAnwGBhavt.png',
        type: 'image/jpeg',
        media: '(min-width: 400px;)'
      },
      {
        src: 'http://localhost:8000/samples/JUqevdbAnwGBhavt.png'
      }
    ],
    duration: 91,
  },
  {
    name: 'Moscow',
    sources: [{
      src: 'http://localhost:8000/samples/AefaRpOm7BY3EUZQ.mp4',
      type: 'video/mp4',
    }],
    poster: 'http://localhost:8000/samples/AhNxB3El6Qpbf87m.png',
    thumbnail: [
      {
        srcset: 'http://localhost:8000/samples/AhNxB3El6Qpbf87m.png',
        type: 'image/jpeg',
        media: '(min-width: 400px;)'
      },
      {
        src: 'http://localhost:8000/samples/AhNxB3El6Qpbf87m.png'
      }
    ],
    duration: 132,
  },
];
</script>