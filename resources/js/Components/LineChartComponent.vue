<template>
  <div class="line-chart-component">
    <div id="chartdiv" style="width: 100%; height: 400px;"></div>
  </div>
</template>

<script>
import * as am4core from "@amcharts/amcharts4/core";
import * as am4charts from "@amcharts/amcharts4/charts";
import am4themes_animated from "@amcharts/amcharts4/themes/animated";
import axios from 'axios';

export default {
  name: "LineChartComponent",
  data() {
    return {
      chart: null,
    };
  },
  mounted() {
    this.fetchData();
  },
  beforeDestroy() {
    if (this.chart) {
      this.chart.dispose();
    }
  },
  methods: {
    fetchData() {
      axios.get('/transactions')
        .then(response => {
          this.createChart(response.data);
        })
        .catch(error => {
          console.error(error);
        });
    },
    createChart(data) {
      am4core.useTheme(am4themes_animated);

      // Create chart instance
      let chart = am4core.create("chartdiv", am4charts.XYChart);

      // Add data
      chart.data = data.map(item => ({
        date: item.date,
        value: item.amount
      }));

      // Create axes
      let dateAxis = chart.xAxes.push(new am4charts.DateAxis());
      let valueAxis = chart.yAxes.push(new am4charts.ValueAxis());

      // Create series
      let series = chart.series.push(new am4charts.LineSeries());
      series.dataFields.valueY = "value";
      series.dataFields.dateX = "date";
      series.strokeWidth = 2;
      series.tooltipText = "{value}";

      // Add area series
      let areaSeries = chart.series.push(new am4charts.LineSeries());
      areaSeries.dataFields.valueY = "value";
      areaSeries.dataFields.dateX = "date";
      areaSeries.fillOpacity = 0.5;
      areaSeries.defaultState.transitionDuration = 1000;

      this.chart = chart;
    }
  },
  watch: {
    // Watch for changes in props or data that might trigger an update
    '$props': {
      handler: 'fetchData',
      deep: true,
    },
  },
};
</script>

<style scoped>
.line-chart-component {
  display: flex;
  flex-direction: column;
  width: 100%;
}
</style>
