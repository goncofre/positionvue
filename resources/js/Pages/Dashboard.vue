<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import 'bootstrap/dist/css/bootstrap.min.css';
</script>

<template>
    <Head title="Formulario Position" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Formulario Position</h2>
        </template>

        <div id="app" class="container">
            <div class="row">
                <div class="col-md-6">
                    <CalendarComponent @transaction-added="handleTransactionAdded" />
                </div>
                <div class="col-md-6">
                    <LineChartComponent ref="lineChart" />
                </div>
            </div>
        </div>
    <!--/div-->
    </AuthenticatedLayout>
</template>
<script>
import CalendarComponent from '@/Components/CalendarComponent.vue';
import LineChartComponent from '@/Components/LineChartComponent.vue';

export default {
  name: 'App',
  components: {
    CalendarComponent,
    LineChartComponent
  },
  methods: {
    handleTransactionAdded() {
      this.$refs.lineChart.fetchData();
    }
  }
};
</script>

<style>
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
  margin-top: 60px;
}

.container {
    margin-top: 20px;
}

.column {
  flex: 1;
  max-width: 45%;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
  padding: 20px;
  background: white;
}

@media (max-width: 768px) {
  .container {
    flex-direction: column;
    align-items: center;
  }

  .column {
    max-width: 100%;
  }
}
</style>