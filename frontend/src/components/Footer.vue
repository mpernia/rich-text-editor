<template>
  <v-footer app class="footer">
    <v-container class="footer-container">
      <v-row justify="center" align="center">
        <v-col cols="12" class="text-center py-1">
          <div class="text-body-2">
            © {{ currentYear }} - Post Editor. Todos los derechos reservados.
          </div>
          <div class="mt-1 text-caption text-medium-emphasis">
            Versión 1.0.0
          </div>
        </v-col>
      </v-row>
    </v-container>
  </v-footer>
</template>

<script setup>
import { computed } from 'vue'

const currentYear = computed(() => new Date().getFullYear())
</script>

<style scoped>
.footer-container {
  padding: 8px 16px;
}
.footer {
  border-top: 1px solid rgba(0, 0, 0, 0.12);
  background-color: #f5f5f5 !important;
}
</style>
