<template>
    <div class="container mx-auto p-4">
      <form @submit.prevent="submitComment" enctype="multipart/form-data">
        <div class="pb-3">
          <h1>Add new Comment</h1>
        </div>
        <div class="mb-3">
          <label for="comment" class="form-label">Comment</label>
          <input v-model="fields.element" id="element" class="form-control" type="hidden" name="element" required value="1">
          <input v-model="fields.task_id" id="task_id" class="form-control" type="text" name="task_id">
          <input v-model="fields.element_id" element_id="element_id" class="form-control" type="hidden" name="element_id" required value="1">
          <input v-model="fields.comment" id="comment" class="form-control" type="text" name="comment" required autofocus autocomplete="comment">
        </div>
        <div class="mb-3">
          <label for="file" class="form-label">File</label>
          <input @change="handleFileUpload" id="file" class="form-control" type="file" name="file" autocomplete="file">
        </div>
        <div class="d-flex justify-content-end mt-4">
          <button type="submit" class="btn btn-primary ms-4">New Comment</button>
        </div>
      </form>
    </div>
  </template>

  <script>
import axios from 'axios';

  export default {
    data() {
      return {
        fields: {},
        element: 'project',
        element_id: '1',
        task_id: '1',
        comment: 'tests',
        file: null
      };
    },
    methods: {
      submitComment() {
            axios.post('/comment',this.fields).then(response => {
                this.fields = {};
            }).catch(error=>{
                console.log('We could not make this comment');
              }
            );
      },
      handleFileUpload(event) {
        this.file = event.target.files[0];
      }
    }
  };
  </script>

