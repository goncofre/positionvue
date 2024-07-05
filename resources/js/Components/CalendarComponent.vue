<template>
    <div class="calendar-component">
      <form id="transaction-form" @submit.prevent="handleSubmit">
        <div>
          <label for="date">Fecha:</label>
          <VueDatePicker v-model="selectedDate" placeholder="Selecciona una fecha" id="date" name="date" required format="yyyy-MM-dd"  />
        </div>
        <div>
          <label for="amount">Monto:</label>
          <input type="number" v-model="amount" placeholder="Ingresa el monto" class="form-control mt-2" id="amount" name="amount" required step="0.01" />
        </div>
        <button type="button" id="btnenviar" class="btn btn-primary mt-2">Guardar</button>
      </form>
      <div id="response-message"></div>
    </div>
  </template>
  
  <script>
  import VueDatePicker from '@vuepic/vue-datepicker';
  import '@vuepic/vue-datepicker/dist/main.css';
  import $ from 'jquery';
  
  export default {
    components: {
      VueDatePicker
    },
    data() {
      return {
        selectedDate: null,
        amount: null
      };
    },
    mounted() {
      this.setupFormSubmit();
    },
    methods: {
      setupFormSubmit() {
        const self = this;
        $('#btnenviar').on('click', function(event) {
          event.preventDefault();
  
          const date = $('[name=date]').val()
          const amount = $("#amount").val();
  
          $.ajax({
            url: '/transactions',
            type: 'POST',
            data: {
                "date": date,
              "amount": amount,
              "_token": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            success: function(response) {
              $('#response-message').html('<p>' + response.message + '</p>');
              $('#transaction-form')[0].reset();
              self.selectedDate = null;
              self.amount = null;
              self.$emit('transaction-added');
            },
            error: function(xhr) {
              const err = JSON.parse(xhr.responseText);
              $('#response-message').html('<p class="text-danger">' + err.message + '</p>');
            }
          });
        });
      },
      handleSubmit() {
        // Trigger jQuery form submission handler
        $('#transaction-form').submit();
      }
    }
  };
  </script>
  
  <style scoped>
  .calendar-component {
    display: flex;
    flex-direction: column;
  }
  </style>
  