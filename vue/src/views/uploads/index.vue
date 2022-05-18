<template>
  <div>
    <page-component title="Uploads">
      <form @submit="uploadFiles" enctype="multipart/form-data">
        <div class="flex justify-center items-center w-full">
          <label for="dropzone-file" class="flex flex-col justify-center items-center w-96 h-64 bg-gray-50 rounded-lg border-2 border-gray-300 border-dashed cursor-pointer dark:hover:bg-bray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
              <div class="flex flex-col justify-center items-center pt-5 pb-6">
                  <svg class="mb-3 w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                  </svg>
                  <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Click to upload</span> or drag and drop</p>
                  <p class="text-xs text-gray-500 dark:text-gray-400">MP4, MOV, M4V, WEBM, OGV, MP3</p>
              </div>
              <input id="dropzone-file" type="file" @change="onFileChoose" class="hidden" 
                accept=".mp4,.mov,.m4v,.webm,.ogv,.mp3" multiple />
          </label>
        </div>
        <!-- display upload items in loop -->
        <div v-for="vid in upload.files" :key="vid.name" class="flex justify-center items-center w-full mt-3">
            <div id="toast-default" class="flex items-center w-full w-96 p-4 text-gray-500 bg-white rounded-lg shadow dark:text-gray-400 dark:bg-gray-800" role="alert">
              <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-blue-500 bg-blue-100 rounded-lg dark:bg-blue-800 dark:text-blue-200">
                <svg v-if="vid.name.includes('.mp3')" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3" />
                </svg>
                <svg v-else xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                </svg>
              </div>
              <div class="ml-3 text-sm font-normal" data-tooltip-target="tooltip-default" 
                :title="vid.name">{{(vid.name).replace(/(.{35})..+/, "$1…")}} <br>{{vid.calSize}}
              </div>
              <div id="tooltip-default" role="tooltip" 
                class="inline-block absolute invisible z-10 py-2 px-3 text-sm font-medium 
                  text-white bg-gray-900 rounded-lg shadow-sm opacity-0 transition-opacity 
                  duration-300 tooltip dark:bg-gray-700"
                >
                Tooltip content
                <div class="tooltip-arrow" data-popper-arrow></div>
              </div>
              <button type="button" @click="removeFile(vid.name)"
                class="ml-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 
                focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex h-8 w-8 dark:text-gray-500 dark:hover:text-white 
                dark:bg-gray-800 dark:hover:bg-gray-700" data-dismiss-target="#toast-default" aria-label="Close">
                  <span class="sr-only">Close</span>
                  <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
              </button>
            </div>
        </div>
        <div v-if="upload.files.length > 0" class="flex justify-center items-center w-full mt-3">
          <button type="submit" 
            class="group relative w-96 flex justify-center py-2 px-4 border 
            border-transparent text-sm font-medium text-white 
            bg-indigo-600 hover:bg-indigo-700 focus:outline-none">
            Upload {{upload.files.length == 1 ? upload.files.length +' file' : upload.files.length +' files'}} 
          </button>
        </div>
      </form>
    </page-component>
  </div>
</template>

<script setup>
import PageComponent from '../../components/PageComponent.vue'
import { ref } from 'vue'

const upload = ref({
  files: [],
})

function onFileChoose(ev) {
  const file = ev.target.files;
  
  if (file){
    for (let f of file){
      const reader = new FileReader();
      reader.fileName = f.name
      reader.fileSize = f.size
      reader.onload = (res) => {
        // The field to send to send to the backend and apply validation
        let fileNam = res.target.fileName;
        let fileSize = res.target.fileSize;
        let fileUrl = reader.result;
        let fsize;

        // converting file size 
        if(fileSize <= 1024 ) {
          fsize = Math.round((fileSize / 1024),1)+'KB';
        }else if(fileSize > 1024 && fileSize < (1024 * 1024 * 1024)){
          fsize = Math.round((fileSize / (1024 * 1024)),1)+'MB';
        }
        // add to array 
        upload.value.files.push({
          url: fileUrl, 
          name: fileNam,
          size: fileSize, 
          calSize: fsize
        });
      }
      reader.readAsDataURL(f)
    }
  }
}

const removeFile = (fname) => {
  let filtered = upload['_rawValue'].files.filter(data => data.name != fname)

  upload.value.files = [];

  for (let f of filtered) {
    upload.value.files.push(f)
  }
}

const uploadFiles = (ev) => {
  ev.preventDefault();

}

const startDrag = (evt, item) => {
  evt.dataTransfer.dropEffect = 'move'
  evt.dataTransfer.effectAllowed = 'move'
  evt.dataTransfer.setData('itemID', item.id)
}

const onDrop = (evt, list) => {
  const itemID = evt.dataTransfer.getData('itemID')
  const item = this.items.find(item => item.id == itemID)
  item.list = list
}
</script>

<style>
</style>