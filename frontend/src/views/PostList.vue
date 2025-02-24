<template>
  <v-container>
    <!-- Loading overlay -->
    <v-overlay
      :model-value="postStore.loading"
      class="align-center justify-center"
      persistent
    >
      <v-progress-circular
        indeterminate
        color="primary"
      ></v-progress-circular>
    </v-overlay>

    <!-- Error alert -->
    <v-alert
      v-if="postStore.error"
      type="error"
      closable
      class="mb-4"
      @click:close="postStore.clearError()"
    >
      {{ postStore.error }}
    </v-alert>

    <!-- Header with actions -->
    <v-row class="mb-4">
      <v-col cols="12" class="d-flex justify-space-between align-center gap-4">
        <div class="d-flex align-center flex-grow-1 search-container">
          <v-text-field
            v-model="searchQuery"
            placeholder="Buscar posts..."
            variant="outlined"
            hide-details
            class="mr-1 flex-grow-1"
            density="comfortable"
            @keyup.enter="handleSearch"
            clearable
            bg-color="white"
          >
            <template v-slot:append-inner>
              <v-fade-transition leave-absolute>
                <v-progress-circular
                  v-if="searching"
                  size="24"
                  color="primary"
                  indeterminate
                ></v-progress-circular>
              </v-fade-transition>
            </template>
          </v-text-field>
          <v-btn
            color="primary"
            variant="tonal"
            :loading="searching"
            @click="handleSearch"
            height="40"
            min-width="40"
            class="search-btn mr-3"
          >
            <v-icon>mdi-magnify</v-icon>
          </v-btn>
        </div>

        <v-btn
          color="primary"
          prepend-icon="mdi-plus"
          @click="showCreateDialog"
          :loading="postStore.loading"
          height="40"
          class="new-post-btn"
        >
          Nuevo Post
        </v-btn>
      </v-col>
    </v-row>

    <!-- Posts table -->
    <v-card>
      <v-card-title class="d-flex justify-space-between align-center">
        <span>Posts</span>
        <v-btn
          icon="mdi-refresh"
          variant="text"
          @click="loadData"
          :loading="postStore.loading"
        ></v-btn>
      </v-card-title>

      <v-data-table
        v-model:items-per-page="itemsPerPage"
        v-model:page="page"
        :headers="headers"
        :items="postStore.posts"
        :loading="postStore.loading"
        :items-per-page-options="[7, 14, 21, 28]"
        class="elevation-1 posts-table"
        hover
        fixed-header
        height="500"
      >
        <template #[`item.status`]="{ item }">
          <v-chip
            :color="getStatusColor(item.status.name)"
            size="small"
          >
            {{ item.status.name }}
          </v-chip>
        </template>

        <template #[`item.actions`]="{ item }">
          <div class="d-flex justify-center">
            <v-btn
              icon="mdi-pencil"
              variant="flat"
              size="small"
              color="primary"
              class="mr-1 action-btn"
              @click="editPost(item)"
              :loading="postStore.loading"
            ></v-btn>
            <v-btn
              icon="mdi-delete"
              variant="flat"
              size="small"
              color="error"
              class="mr-1 action-btn"
              @click="confirmDelete(item)"
              :loading="postStore.loading"
            ></v-btn>
            <v-btn
              icon="mdi-file-pdf-box"
              variant="flat"
              size="small"
              color="success"
              class="action-btn"
              @click="downloadPdf(item)"
              :loading="postStore.loading"
            ></v-btn>
          </div>
        </template>

        <template #[`item.summary`]="{ item }">
          <span v-html="truncate(stripHtml(item.summary))"></span>
        </template>

        <template #[`item.content`]="{ item }">
          <span v-html="truncate(stripHtml(item.content))"></span>
        </template>

        <template #bottom>
          <div class="d-flex justify-center pt-4">
            <v-pagination
              v-model="page"
              :length="Math.ceil(postStore.posts.length / itemsPerPage)"
              :total-visible="7"
            ></v-pagination>
          </div>
        </template>
      </v-data-table>
    </v-card>

    <!-- Post form dialog -->
    <PostForm
      v-model="showForm"
      :post="selectedPost"
      @saved="handleSaved"
    />

    <!-- Delete confirmation dialog -->
    <v-dialog v-model="showDeleteDialog" max-width="400">
      <v-card>
        <v-card-title>Confirmar Eliminación</v-card-title>
        <v-card-text>
          ¿Estás seguro de que deseas eliminar este post?
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="grey" variant="text" @click="showDeleteDialog = false">Cancelar</v-btn>
          <v-btn
            color="error"
            variant="text"
            @click="deletePost"
            :loading="postStore.loading"
          >
            Eliminar
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-container>
</template>

<script setup>
import { ref, onMounted, watch, nextTick } from 'vue'
import { usePostStore } from '../stores/posts'
import PostForm from '../components/PostForm.vue'

const postStore = usePostStore()
const showForm = ref(false)
const selectedPost = ref(null)
const showDeleteDialog = ref(false)
const postToDelete = ref(null)
const showError = ref(false)

const searchQuery = ref('')
const searching = ref(false)

const page = ref(1)
const itemsPerPage = ref(7)
const sortBy = ref([])
const selected = ref([])

const headers = [
  { title: 'Título', align: 'start', key: 'title', sortable: true },
  { title: 'Resumen', key: 'summary', sortable: false },
  { title: 'Contenido', key: 'content', sortable: false },
  { title: 'Estado', key: 'status', sortable: true },
  { title: 'Acciones', key: 'actions', sortable: false, align: 'center' }
]

const handleTableUpdate = (options) => {
  console.log('Table options updated:', options)
  page.value = options.page
  itemsPerPage.value = options.itemsPerPage
  sortBy.value = options.sortBy
}

watch(() => postStore.error, (newError) => {
  if (newError) {
    showError.value = true
  }
})

onMounted(() => {
  loadData()
})

const loadData = async () => {
  console.log('Starting loadData')
  try {
    await postStore.initialize()
    console.log('Posts in component:', postStore.posts)
    page.value = 1
  } catch (error) {
    console.error('Error loading data:', error)
  }
}

const handleSearch = async () => {
  const query = searchQuery.value.trim()
  searching.value = true

  try {
    if (!query) {
      await loadData()
    } else {
      console.log('Iniciando búsqueda con query:', query)
      await postStore.fetchPosts(query)
    }
  } catch (error) {
    console.error('Error en la búsqueda:', error)
  } finally {
    searching.value = false
  }
}

watch(() => postStore.posts, (newPosts) => {
  console.log('Posts updated:', newPosts)
  if (newPosts.length > 0) {
    nextTick(() => {
      page.value = 1
    })
  }
})

const showCreateDialog = () => {
  if (!postStore.isInitialized) {
    console.log('Store not initialized, initializing...')
    postStore.initialize().then(() => {
      console.log('Store initialized, showing dialog')
      selectedPost.value = null
      showForm.value = true
    }).catch(error => {
      console.error('Error initializing store:', error)
    })
  } else {
    console.log('Store already initialized, showing dialog')
    selectedPost.value = null
    showForm.value = true
  }
}

const editPost = (post) => {
  selectedPost.value = post
  showForm.value = true
}

const handleSaved = async () => {
  await loadData()
}

const confirmDelete = (post) => {
  postToDelete.value = post
  showDeleteDialog.value = true
}

const deletePost = async () => {
  if (postToDelete.value) {
    try {
      await postStore.deletePost(postToDelete.value.id)
      showDeleteDialog.value = false
      postToDelete.value = null
    } catch (error) {
    }
  }
}

const downloadPdf = async (post) => {
  try {
    await postStore.downloadPostPdf(post.id)
  } catch (error) {
  }
}

const truncate = (text) => {
  if (!text) return ''
  return text.length > 100 ? text.substring(0, 100) + '...' : text
}

const stripHtml = (html) => {
  if (!html) return ''
  const doc = new DOMParser().parseFromString(html, 'text/html')
  return doc.body.textContent || ''
}

const getStatusColor = (status) => {
  const colors = {
    draft: 'grey',
    published: 'success',
    protected: 'warning'
  }
  return colors[status] || 'grey'
}
</script>

<style scoped>
.v-data-table {
  width: 100%;
}

.posts-table :deep(.v-data-table__wrapper) {
  min-height: 400px;
}

.posts-table :deep(.v-data-table-footer) {
  border-top: 1px solid rgba(0, 0, 0, 0.12);
  background-color: #f5f5f5;
  padding: 2px 16px;
  min-height: 40px;
}

.posts-table :deep(.v-data-table-footer__items-per-page) {
  margin-right: 16px;
}

.posts-table :deep(.v-data-table-footer__info) {
  margin-right: 16px;
}

.posts-table :deep(.v-data-table-footer__pagination) {
  margin-left: auto;
}

.search-container {
  max-width: 800px;
}

.search-container :deep(.v-field) {
  height: 40px;
}

.search-container :deep(.v-field__input) {
  min-height: 40px !important;
  padding-top: 0 !important;
  padding-bottom: 0 !important;
}

.search-container :deep(.v-field__field) {
  height: 40px !important;
}

.search-container :deep(.v-text-field) {
  margin-top: 0;
  margin-bottom: 0;
}

.search-btn,
.new-post-btn {
  border-radius: 4px !important;
}

.action-btn {
  border-radius: 4px !important;
  padding: 0;
  min-width: 32px;
  width: 32px;
  height: 32px;
}
</style>

<style scoped>
.v-data-table {
  width: 100%;
}

.posts-table {
  width: 100%;
  height: 100%;
  overflow: visible;
}

.posts-table :deep(.v-table__wrapper) {
  overflow: visible;
}

.posts-table :deep(.v-data-table-footer) {
  padding: 8px;
}

.action-btn {
  border-radius: 4px !important;
  padding: 0;
  min-width: 32px;
  width: 32px;
  height: 32px;
}
</style>
