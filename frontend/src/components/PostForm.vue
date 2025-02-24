<template>
  <v-dialog v-model="dialog" persistent max-width="800px">
    <v-card>
      <v-card-title>
        <span class="text-h5">{{ isEdit ? 'Editar Post' : 'Nuevo Post' }}</span>
      </v-card-title>
      <v-card-text>
        <v-container>
          <v-row>
            <v-col cols="12">
              <v-text-field
                v-model="form.title"
                label="Título"
                required
                :error-messages="errors.title"
              ></v-text-field>
            </v-col>
            <v-col cols="12">
              <label>Resumen</label>
              <QuillEditor
                v-model:content="form.summary"
                :options="editorConfig"
                contentType="html"
                class="editor-container summary-editor"
                theme="snow"
              />
              <div v-if="errors.summary" class="error-text">{{ errors.summary }}</div>
            </v-col>
            <v-col cols="12">
              <label>Contenido</label>
              <QuillEditor
                v-model:content="form.content"
                :options="editorConfig"
                contentType="html"
                class="editor-container content-editor"
                theme="snow"
              />
              <div v-if="errors.content" class="error-text">{{ errors.content }}</div>
            </v-col>
            <v-col cols="12">
              <v-select
                v-model="form.status_id"
                :items="statuses"
                item-title="name"
                item-value="id"
                label="Estado"
                :loading="postStore.loading"
                :hint="postStore.loading ? 'Cargando estados...' : ''"
                persistent-hint
                required
                :error-messages="errors.status_id"
                @focus="loadStatuses"
              ></v-select>
            </v-col>
          </v-row>
        </v-container>
      </v-card-text>
      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn color="grey" variant="text" @click="closeDialog">Cancelar</v-btn>
        <v-btn 
          color="primary" 
          variant="text" 
          @click="savePost" 
          :loading="postStore.loading"
          :disabled="postStore.loading"
        >
          {{ postStore.loading ? 'Guardando...' : 'Guardar' }}
        </v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<script setup>
import { ref, computed, watch, onMounted } from 'vue'
import { usePostStore } from '../stores/posts'
import { QuillEditor } from '@vueup/vue-quill'
import '@vueup/vue-quill/dist/vue-quill.snow.css'
const props = defineProps({
  post: {
    type: Object,
    default: null
  },
  modelValue: {
    type: Boolean,
    default: false
  }
})

const form = ref({
  title: '',
  summary: '',
  content: '',
  status_id: 1 // Estado 'draft' por defecto
})

// Inicializar el formulario con los datos del post
const initializeForm = (post) => {
  if (post) {
    form.value = {
      title: post.title || '',
      summary: post.summary || '',
      content: post.content || '',
      status_id: post.status?.id || post.status_id || 1
    }
    console.log('Form initialized with status_id:', form.value.status_id)
  } else {
    form.value = {
      title: '',
      summary: '',
      content: '',
      status_id: 1
    }
  }
}

// Computed property para los estados
const statuses = computed(() => {
  console.log('Computing statuses:', postStore.statuses)
  return postStore.statuses
})

const editorConfig = {
  modules: {
    toolbar: [
      [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
      ['bold', 'italic', 'underline', 'strike'],
      [{ 'color': [] }, { 'background': [] }],
      [{ 'align': [] }],
      [{ 'list': 'ordered'}, { 'list': 'bullet' }],
      [{ 'indent': '-1'}, { 'indent': '+1' }],
      [{ 'size': ['small', false, 'large', 'huge'] }],
      ['blockquote', 'code-block'],
      ['link', 'image', 'video'],
      ['clean']
    ],
    clipboard: {
      matchVisual: false
    },
    keyboard: {
      bindings: {
        tab: {
          key: 9,
          handler: function() {
            return true;
          }
        }
      }
    }
  },
  placeholder: 'Escribe aquí...',
  theme: 'snow',
  bounds: document.body,
  scrollingContainer: 'body'
}

// Actualizar el contenido del editor cuando cambian los props
// Función para cargar los estados
const loadStatuses = async () => {
  try {
    console.log('Fetching statuses...')
    await postStore.fetchStatuses()
    console.log('Statuses loaded:', postStore.statuses)
  } catch (error) {
    console.error('Error cargando estados:', error)
  }
}

// Cargar estados cuando se monta el componente
onMounted(loadStatuses)

watch(() => props.post, (newPost) => {
  initializeForm(newPost)
}, { immediate: true })

const emit = defineEmits(['update:modelValue', 'saved'])

const postStore = usePostStore()
const dialog = computed({
  get: () => props.modelValue,
  set: (value) => emit('update:modelValue', value)
})

const isEdit = computed(() => !!props.post)

const errors = ref({
  title: '',
  summary: '',
  content: '',
  status_id: ''
})

watch(() => props.post, (newPost) => {
  if (newPost) {
    form.value = { ...newPost }
  } else {
    form.value = {
      title: '',
      summary: '',
      content: '',
      status_id: null
    }
  }
}, { immediate: true })

const validateForm = () => {
  let isValid = true
  errors.value = {}

  if (!form.value.title) {
    errors.value.title = 'El título es requerido'
    isValid = false
  }

  if (!form.value.summary) {
    errors.value.summary = 'El resumen es requerido'
    isValid = false
  }

  if (!form.value.content) {
    errors.value.content = 'El contenido es requerido'
    isValid = false
  }

  if (!form.value.status_id) {
    errors.value.status_id = 'El estado es requerido'
    isValid = false
  }

  return isValid
}

const closeDialog = () => {
  // Asegurarse de que no haya operaciones pendientes
  if (!postStore.loading) {
    emit('update:modelValue', false)
    form.value = {
      title: '',
      summary: '',
      content: '',
      status_id: 1
    }
    errors.value = {}
  }
}

const savePost = async () => {
  if (!validateForm()) return

  try {
    const postData = {
      ...form.value,
      summary: form.value.summary || '',
      content: form.value.content || '',
      status_id: parseInt(form.value.status_id) // Asegurarse de que status_id sea un número
    }

    if (isEdit.value && props.post) {
      // Para edición, incluir el ID del post existente
      postData.id = props.post.id
      console.log('Updating post with data:', postData)
      await postStore.updatePost(postData)
    } else {
      console.log('Creating new post with data:', postData)
      await postStore.createPost(postData)
    }
    
    emit('saved')
    closeDialog()
  } catch (error) {
    console.error('Error saving post:', error)
    errors.value = error.response?.data?.errors || {
      general: 'Error al guardar el post'
    }
  }
}
</script>

<style>
/* Estilos básicos */
.error-text {
  color: #ff5252;
  font-size: 0.8em;
  margin-top: 5px;
}

label {
  font-size: 14px;
  color: rgba(0, 0, 0, 0.6);
  margin-bottom: 8px;
  display: block;
  font-weight: 500;
}

/* Estructura del modal */
.v-dialog {
  display: flex;
  flex-direction: column;
}

.v-card {
  display: flex;
  flex-direction: column;
  max-height: 90vh;
}

.v-card-title {
  padding: 20px 24px;
  border-bottom: 1px solid rgba(0, 0, 0, 0.12);
  flex-shrink: 0;
}

.v-card-text {
  flex: 1;
  overflow-y: auto;
  padding: 24px;
}

.v-card-actions {
  padding: 16px 24px;
  border-top: 1px solid rgba(0, 0, 0, 0.12);
  flex-shrink: 0;
}

/* Contenedor y columnas */
.v-container {
  padding: 0;
}

.v-col {
  padding: 16px 0;
}

/* Editores */
.editor-container {
  position: relative;
  margin-bottom: 1rem;
}

.summary-editor {
  min-height: 150px;
}

.content-editor {
  min-height: 400px;
}

/* Estilos personalizados para Quill */
:deep(.ql-editor) {
  font-size: 14px;
  line-height: 1.6;
  min-height: inherit;
  padding: 12px 15px;
}

:deep(.ql-toolbar.ql-snow) {
  border-top-left-radius: 4px;
  border-top-right-radius: 4px;
  background-color: #f5f5f5;
  padding: 8px;
  border: 1px solid #ddd;
  position: sticky;
  top: 0;
  z-index: 2;
}

:deep(.ql-container.ql-snow) {
  border-bottom-left-radius: 4px;
  border-bottom-right-radius: 4px;
  border: 1px solid #ddd;
  border-top: none;
}

:deep(.ql-toolbar .ql-stroke) {
  stroke: #666;
}

:deep(.ql-toolbar .ql-fill) {
  fill: #666;
}

:deep(.ql-toolbar .ql-picker) {
  color: #666;
}

:deep(.ql-snow.ql-toolbar button:hover),
:deep(.ql-snow .ql-toolbar button:hover),
:deep(.ql-snow.ql-toolbar button.ql-active),
:deep(.ql-snow .ql-toolbar button.ql-active),
:deep(.ql-snow.ql-toolbar .ql-picker-label:hover),
:deep(.ql-snow .ql-toolbar .ql-picker-label:hover),
:deep(.ql-snow.ql-toolbar .ql-picker-label.ql-active),
:deep(.ql-snow .ql-toolbar .ql-picker-label.ql-active) {
  color: #1976d2;
}

:deep(.ql-snow.ql-toolbar button:hover .ql-stroke),
:deep(.ql-snow .ql-toolbar button:hover .ql-stroke),
:deep(.ql-snow.ql-toolbar button.ql-active .ql-stroke),
:deep(.ql-snow .ql-toolbar button.ql-active .ql-stroke) {
  stroke: #1976d2;
}

:deep(.ql-snow.ql-toolbar button:hover .ql-fill),
:deep(.ql-snow .ql-toolbar button:hover .ql-fill),
:deep(.ql-snow.ql-toolbar button.ql-active .ql-fill),
:deep(.ql-snow .ql-toolbar button.ql-active .ql-fill) {
  fill: #1976d2;
}

:deep(.ql-toolbar.ql-snow .ql-formats) {
  margin-right: 12px;
}

:deep(.ql-snow .ql-tooltip) {
  border: 1px solid #ddd;
  box-shadow: 0 2px 8px rgba(0,0,0,0.1);
  border-radius: 4px;
}

.editor-container :deep(.ql-container) {
  height: calc(100% - 42px) !important;
  font-family: -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
}

.editor-container :deep(.ql-editor) {
  font-size: 14px;
  min-height: 100%;
  padding: 12px;
}

/* Otros elementos */
.v-text-field {
  margin-bottom: 8px;
}
</style>
