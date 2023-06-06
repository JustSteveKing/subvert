<script setup>
import Application from "../Layouts/Application.vue";
import Heading from '../Components/Heading.vue';
import Stepper from "../Components/Stepper.vue";
import {reactive, ref} from "vue";
import {useForm} from "@inertiajs/vue3";

const video = ref(null)
const classes = ref('flex justify-center items-center w-full h-64 border-2 border-dashed mt-12')
const started = ref(false)
const processId = ref(null)
const intervalId = ref(null)
const step = ref(1)
const message = ref('Extracting audio')
const languages = ref([
  'English',
  'Spanish',
  'French',
  'German',
  'Italian',
  'Portuguese',
  'Russian',
  'Chinese',
  'Japanese',
  'Korean',
])
const options = reactive({
  subtitles: true,
  chapters: false,
  summary: false,
  language: 'default',
  chapters_amount: 5
})
const buttonStyles = reactive({
  'inactive': 'mt-4 bg-white border border-purple-500 text-purple-500 font-medium py-1.5 px-4 rounded mx-2',
  'active': 'mt-4 bg-purple-500 border border-purple-500 text-white font-medium py-1.5 px-4 rounded mx-2'
})

const form = useForm({
  file: null,
  options: options,
})

const dragover = (e) => {
  e.preventDefault()
  e.stopPropagation()
  classes.value = 'flex justify-center items-center w-full h-64 border-2 border-dashed mt-12 border-purple-500 bg-gradient-to-br from-indigo-50 to-rose-50'
}

const dragleave = (e) => {
  e.preventDefault()
  e.stopPropagation()
  classes.value = 'flex justify-center items-center w-full h-64 border-2 border-dashed mt-12'
}

const drop = (e) => {
  e.preventDefault()
  e.stopPropagation()
  classes.value = 'w-full py-24 border-2 border-dashed mt-12'

  form.file = e.dataTransfer.files[0]
}

const submit = () => {
  form.post('/process', {
    preserveState: true,
    preserveScroll: true,
  })
};
</script>

<template>
  <Application>
    <Heading/>

    <div>
      <div v-if="!started" :class="classes" @dragover="dragover" @dragleave="dragleave" @drop="drop">
        <input
          type="file"
          name="fileHandler"
          id="fileHandler"
          class="w-px h-px opacity-0 overflow-hidden absolute"
          @input="form.file = $event.target.files[0]"
          accept="video/*, audio/*"
        />
        <div class="mt-2" v-show="form.errors.options">
          <p class="text-sm text-red-600 dark:text-red-400">
            {{ form.errors.email }}
          </p>
        </div>
        <label v-if="!form.file" for="fileHandler" class="block cursor-pointer">
          <p class="text-center text-gray-500 text-lg">Drag + drop a file here or <span
            class="underline hover:text-gray-800">click to choose</span>.</p>
        </label>
        <div v-else>
          <p class="text-center text-gray-500 text-lg">You chose <span class="font-bold">{{ form.file.name }}</span>. Select
            your options then press start.</p>
          <button :class="buttonStyles.active">Subtitles</button>
          <button :class="options.chapters ? buttonStyles.active : buttonStyles.inactive"
                  @click="options.chapters = !options.chapters">Chapters
          </button>
          <button :class="options.summary ? buttonStyles.active : buttonStyles.inactive"
                  @click="options.summary = !options.summary">Summary
          </button>
          <div>
            <select v-model="options.language"
                    class="mt-4 bg-white border border-gray-300 text-gray-500 font-medium py-2 px-4 rounded mx-2">
              <option value="default">Video Language</option>
              <option v-for="language in languages" :value="language" :key="language">{{ language }}</option>
            </select>
            <select v-if="options.chapters" v-model="options.chapters_amount"
                    class="mt-4 bg-white border border-gray-300 text-gray-500 font-medium py-2 px-4 rounded mx-2">
              <option :value="n" v-for="n in 20">{{ n }} Chapter{{ n !== 1 ? 's' : '' }}</option>
            </select>
            <button class="mt-4 bg-purple-500 border border-purple-500 text-white font-medium py-1.5 px-4 rounded mx-2"
                    @click="submit">Start
            </button>
          </div>
        </div>
      </div>
      <div v-else>
        <Stepper :step="step" :message="message"/>
      </div>
      <div v-if="started && step === 98" class="text-center mt-8">
        <a :href="'/process/' + processId"
           class="inline-block bg-purple-500 hover:bg-purple-600 text-white font-semibold py-2 px-4 rounded">
          View + Download Items
        </a>
      </div>
    </div>

  </Application>
</template>
